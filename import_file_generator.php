<?php

/**
 * Mass Update Import Files Script
 * 
 * This script helps convert all remaining import.blade.php files 
 * to use the new shared components.
 */

// Import files directory structure
$importFiles = [
    // Simple import files (use basic component)
    'regions' => [
        'requirements' => []
    ],
    'nationalities' => [
        'requirements' => [
            ['model' => 'Country', 'route' => 'countries.index', 'label' => 'countries_']
        ]
    ],
    'states' => [
        'requirements' => [
            ['model' => 'Country', 'route' => 'countries.index', 'label' => 'countries_']
        ]
    ],
    'subregions' => [
        'requirements' => [
            ['model' => 'Region', 'route' => 'regions.index', 'label' => 'regions_']
        ]
    ],
    'restaurants' => [
        'requirements' => [
            ['model' => 'Country', 'route' => 'countries.index', 'label' => 'countries_'],
            ['model' => 'City', 'route' => 'cities.index', 'label' => 'cities_']
        ]
    ]
];

function generateSimpleImport($model, $config)
{
    $requirements = '';

    if (!empty($config['requirements'])) {
        $requirements = ":requirements=\"[\n";
        foreach ($config['requirements'] as $req) {
            $requirements .= "            [\n";
            $requirements .= "                'condition' => \\App\\Models\\{$req['model']}::count() > 0,\n";
            $requirements .= "                'route' => route('{$req['route']}'),\n";
            $requirements .= "                'label' => __('main.{$req['label']}')\n";
            $requirements .= "            ],\n";
        }
        $requirements .= "        ]\"";
    } else {
        $requirements = '';
    }

    return "@extends('layouts.master')

@section('content')
    <x-import-form 
        :title=\"\$title\"
        :description=\"\$description\"
        :models=\"\$models\"
        {$requirements}>
        
        <div class=\"mt-4\">
            <a href=\"{{ route('export.data', ['model' => \$models]) }}\" class=\"kt-btn kt-btn-outline\">
                {{ __('main.export') }}
            </a>
        </div>

        {{-- Add your table fields here if needed --}}
        {{-- Example:
        <strong class=\"block mt-6 mb-2\">Required Fields</strong>
        <table class=\"border min-w-full divide-y text-center divide-gray-200\">
            <thead>
                <tr>
                    <th class=\"border px-2\">field_name</th>
                </tr>
            </thead>
            <tbody class=\"bg-white divide-y divide-gray-200\">
                <tr>
                    <td class=\"border px-2\">sample_data</td>
                </tr>
            </tbody>
        </table>
        --}}
    </x-import-form>
@endsection";
}

// Generate template for all models
echo "Import File Templates Generated:\n\n";

foreach ($importFiles as $model => $config) {
    echo "=== {$model} ===\n";
    echo generateSimpleImport($model, $config);
    echo "\n\n";
}

// Instructions for updating
echo "\n=== UPDATE INSTRUCTIONS ===\n";
echo "1. Copy the generated template for each model\n";
echo "2. Replace the content in: resources/views/pages/dashboard/{model}/import.blade.php\n";
echo "3. Add any specific table fields in the commented section\n";
echo "4. Test the import functionality\n";
echo "\n=== BENEFITS ===\n";
echo "- Consistent UI across all import pages\n";
echo "- Centralized styling and behavior\n";
echo "- Easy maintenance and updates\n";
echo "- Reduced code duplication\n";
echo "- Better error handling\n";
echo "- Responsive design\n";

?>