<?php

namespace App\Services;

use App\Models\TransportationCompany;
use App\Models\TransportationCompanyContact;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class TransportationDataImporter
{
    /**
     * Upsert transportation companies by name + country_id
     * Update existing or create new
     * Returns mapping of row UUIDs to final company UUIDs
     */
    public static function upsertCompanies(array $rows, ?array &$uuidMap = null): int
    {
        if (empty($rows)) {
            return 0;
        }

        $count = 0;
        $uuidMap = [];

        try {
            foreach ($rows as $row) {
                $rowUuid = $row['uuid'] ?? null;

                // Build match criteria: name + country_id if country_id exists
                $matchCriteria = ['name' => $row['name'] ?? null];
                if (!empty($row['country_id'])) {
                    $matchCriteria['country_id'] = $row['country_id'];
                }

                // Filter out empty match criteria
                $matchCriteria = array_filter($matchCriteria, function ($v) {
                    return $v !== null && $v !== '';
                });

                if (empty($matchCriteria)) {
                    // If no match criteria, just insert
                    $company = TransportationCompany::create($row);
                    if ($rowUuid) {
                        $uuidMap[$rowUuid] = $company->uuid;
                    }
                    $count++;
                    continue;
                }

                // Check if company already exists
                $existing = TransportationCompany::where($matchCriteria)->first();

                if ($existing) {
                    // Update existing company but keep the original UUID
                    $updateData = array_diff_key($row, $matchCriteria);
                    unset($updateData['uuid']); // Don't update UUID
                    $existing->update($updateData);

                    // Map this row's UUID to the existing company's UUID
                    if ($rowUuid) {
                        $uuidMap[$rowUuid] = $existing->uuid;
                    }

                    Log::debug("Updated transportation company (UUID preserved): " . $existing->uuid);
                } else {
                    // Create new company
                    $company = TransportationCompany::create($row);
                    if ($rowUuid) {
                        $uuidMap[$rowUuid] = $company->uuid;
                    }

                    Log::debug("Created transportation company: " . $company->uuid);
                }

                $count++;
            }
        } catch (\Throwable $e) {
            Log::warning('Failed to upsert transportation companies: ' . $e->getMessage());
            throw $e;
        }

        return $count;
    }

    /**
     * Insert ALL transportation company contacts (always insert, never update)
     * This allows multiple contact records per company
     */
    public static function insertContacts(array $rows): int
    {
        if (empty($rows)) {
            return 0;
        }

        try {
            // Always insert all contacts - never upsert
            // This allows multiple contact methods per company
            TransportationCompanyContact::insert($rows);
            Log::debug('Inserted transportation company contacts: ' . count($rows));
            return count($rows);
        } catch (\Throwable $e) {
            Log::warning('Failed to insert transportation company contacts: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Process pending contacts after companies are inserted
     * Maps company UUIDs to IDs and inserts contacts
     * @param array $pendingContacts Array of contact rows with company_uuid
     * @param array|null $uuidMap Optional mapping of row UUIDs to final company UUIDs
     */
    public static function processPendingContacts(array $pendingContacts, ?array $uuidMap = null): int
    {
        if (empty($pendingContacts)) {
            return 0;
        }

        try {
            // Map row UUIDs to final company UUIDs if mapping provided
            if ($uuidMap) {
                foreach ($pendingContacts as &$contact) {
                    $rowUuid = $contact['company_uuid'] ?? null;
                    if ($rowUuid && isset($uuidMap[$rowUuid])) {
                        $contact['company_uuid'] = $uuidMap[$rowUuid];
                    }
                }
                unset($contact);
            }

            $uuids = array_values(array_filter(array_unique(array_column($pendingContacts, 'company_uuid'))));
            if (empty($uuids)) {
                return 0;
            }

            Log::debug("Processing " . count($pendingContacts) . " pending contacts for " . count($uuids) . " unique companies");

            $idMap = TransportationCompany::whereIn('uuid', $uuids)
                ->pluck('id', 'uuid')
                ->toArray();

            Log::debug("Found " . count($idMap) . " companies in database");

            $rows = [];
            $skipped = 0;
            foreach ($pendingContacts as $contact) {
                $companyUuid = $contact['company_uuid'] ?? null;
                $companyId = $companyUuid && isset($idMap[$companyUuid]) ? $idMap[$companyUuid] : null;
                if (!$companyId) {
                    $skipped++;
                    Log::debug("Skipping contact - company UUID not found: " . $companyUuid);
                    continue;
                }

                $rows[] = [
                    'uuid' => $contact['uuid'] ?? (string) Str::uuid(),
                    'company_id' => $companyId,
                    'department' => $contact['department'] ?? null,
                    'contact_person' => $contact['contact_person'] ?? null,
                    'email' => $contact['email'] ?? null,
                    'phone' => $contact['phone'] ?? null,
                    'mobile' => $contact['mobile'] ?? null,
                    'fax' => $contact['fax'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            Log::debug("Prepared " . count($rows) . " contact rows for insertion (skipped: $skipped)");

            if (!empty($rows)) {
                return self::insertContacts($rows);
            }

            return 0;
        } catch (\Throwable $e) {
            Log::warning('Failed to process pending transportation company contacts: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Extract contact data from a company row
     */
    public static function extractContactData(array $prepared, array $cleaned): ?array
    {
        $companyUuid = $prepared['uuid'] ?? null;

        // Extract all contact fields from $cleaned array since they're not in TransportationCompany's fillable
        $department = self::getValueByNormalizedKeys($cleaned, ['department', 'departmenet', 'department_name', 'dept']);
        $contactPerson = self::getValueByNormalizedKeys($cleaned, ['contact_person', 'contact', 'person']);
        $email = self::getValueByNormalizedKeys($cleaned, ['email', 'e_mail', 'mail']);
        $phone = self::getValueByNormalizedKeys($cleaned, ['phone', 'telephone', 'tel']);
        $mobile = self::getValueByNormalizedKeys($cleaned, ['mobile', 'cell', 'cellphone']);
        $fax = self::getValueByNormalizedKeys($cleaned, ['fax', 'facsimile']);

        $contactRow = [
            'company_uuid' => $companyUuid,
            'department' => $department,
            'contact_person' => $contactPerson,
            'email' => $email,
            'phone' => $phone,
            'mobile' => $mobile,
            'fax' => $fax,
        ];

        $hasData = false;
        foreach (['department', 'contact_person', 'email', 'phone', 'mobile', 'fax'] as $key) {
            if (!empty($contactRow[$key])) {
                $hasData = true;
                break;
            }
        }

        if (!$hasData || empty($companyUuid)) {
            return null;
        }

        $contactRow['uuid'] = $prepared['contact_uuid'] ?? (string) Str::uuid();

        return $contactRow;
    }

    /**
     * Get value from array by normalized key candidates
     */
    private static function getValueByNormalizedKeys(array $row, array $candidates): ?string
    {
        $normalized = [];
        foreach ($row as $key => $value) {
            $normKey = preg_replace('/[\s\.]+/', '_', strtolower(trim((string) $key)));
            $normalized[$normKey] = $value;
        }

        foreach ($candidates as $candidate) {
            $normCandidate = preg_replace('/[\s\.]+/', '_', strtolower(trim((string) $candidate)));
            if (array_key_exists($normCandidate, $normalized)) {
                return $normalized[$normCandidate];
            }
        }

        return null;
    }
}