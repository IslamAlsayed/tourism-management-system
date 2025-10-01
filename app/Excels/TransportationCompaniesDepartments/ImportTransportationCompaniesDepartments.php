<?php

namespace App\Excels\TransportationCompaniesDepartments;

use App\Jobs\ImportDataToDBJob;
use Illuminate\Support\Collection;
use App\Models\TransportationCompany;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\TransportationCompanyDepartment;

class ImportTransportationCompaniesDepartments implements ToCollection
{
    public $rowCount = 0;

    public function collection(Collection $rows)
    {
        if ($rows->isEmpty())
            return;

        // Get fillable columns after removing relations
        $companyModel = new TransportationCompany();
        $companyFillable = array_filter(
            $companyModel->getFillable(),
            fn($col) => !in_array($col, method_exists($companyModel, 'getRelationshipNames') ? $companyModel->getRelationshipNames() : [])
        );

        $departmentModel = new TransportationCompanyDepartment();
        $departmentFillable = array_filter(
            $departmentModel->getFillable(),
            fn($col) => !in_array($col, method_exists($departmentModel, 'getRelationshipNames') ? $departmentModel->getRelationshipNames() : [])
        );

        // Build header map once
        $headers = $rows->first()->toArray();
        $headerMap = [];
        foreach ($headers as $index => $header) {
            $headerMap[$header] = $index;
        }

        $batchSize = 1000;
        $batchData = [];

        foreach ($rows as $index => $row) {
            if ($index === 0)
                continue;

            $rowArray = $row->toArray();
            $dataCompany = [];
            $dataDepartment = [];

            // Prepare company data
            foreach ($companyFillable as $column) {
                if (isset($headerMap[$column])) {
                    $excelKey = $headerMap[$column];
                    $dataCompany[$column] = $rowArray[$excelKey] ?? null;
                }
            }

            // Prepare department data
            foreach ($departmentFillable as $column) {
                if (isset($headerMap[$column])) {
                    $excelKey = $headerMap[$column];
                    $dataDepartment[$column] = $rowArray[$excelKey] ?? null;
                }
            }

            $batchData[] = ['company' => $dataCompany, 'department' => $dataDepartment];

            if (count($batchData) >= $batchSize) {
                $this->insertBatchTransportationData($batchData);
                $batchData = [];
            }
        }

        if (count($batchData) > 0) {
            $this->insertBatchTransportationData($batchData);
        }
    }

    private function insertBatchTransportationData(array $batchData)
    {
        foreach ($batchData as $item) {
            $companyData = $item['company'];
            $departmentData = $item['department'];

            if (empty($companyData['name'])) {
                continue;
            }

            $company = TransportationCompany::updateOrCreate(['name' => $companyData['name']], $companyData);

            $departmentData['company_id'] = $company->id;

            // if (!empty($departmentData['name'])) {
            TransportationCompanyDepartment::create($departmentData);
            // }

            $this->rowCount++;
        }
    }
}