$target = "g:\MixJo Top downlode mains by dats\for edit\tourism-management-system  13 FEB 2026 0221AM\tourism-management-system"
Set-Location $target

# Models
if (Test-Path "Modules\Core\Entities\FieldDefinition.php") {
    Move-Item "Modules\Core\Entities\FieldDefinition.php" "Modules\Definitions\Entities\FieldDefinition.php" -Force
}
if (Test-Path "Modules\Core\Entities\CustomFieldValue.php") {
    Move-Item "Modules\Core\Entities\CustomFieldValue.php" "Modules\Definitions\Entities\CustomFieldValue.php" -Force
}

# Controller
if (Test-Path "Modules\Core\Http\Controllers\FieldDefinitionController.php") {
    Move-Item "Modules\Core\Http\Controllers\FieldDefinitionController.php" "Modules\Definitions\Http\Controllers\FieldDefinitionController.php" -Force
}

# Livewire components
if (Test-Path "Modules\Core\Livewire\FieldDefinitions.php") {
    Move-Item "Modules\Core\Livewire\FieldDefinitions.php" "Modules\Definitions\Livewire\FieldDefinitions.php" -Force
}

# Views (folder)
if (Test-Path "Modules\Core\Resources\views\field-definitions") {
    Move-Item "Modules\Core\Resources\views\field-definitions" "Modules\Definitions\Resources\views\field-definitions" -Recurse -Force
}

# Views (blade)
if (Test-Path "Modules\Core\Resources\views\livewire\field-definitions.blade.php") {
    Move-Item "Modules\Core\Resources\views\livewire\field-definitions.blade.php" "Modules\Definitions\Resources\views\livewire\field-definitions.blade.php" -Force
}

# Policy
if (Test-Path "Modules\Core\Policies\FieldDefinitionPolicy.php") {
    Move-Item "Modules\Core\Policies\FieldDefinitionPolicy.php" "Modules\Definitions\Policies\FieldDefinitionPolicy.php" -Force
}

# Migrations
Get-ChildItem -Path "Modules\Core\Database\Migrations\*field_definition*" | Move-Item -Destination "Modules\Definitions\Database\Migrations\" -Force
Get-ChildItem -Path "Modules\Core\Database\Migrations\*custom_field_value*" | Move-Item -Destination "Modules\Definitions\Database\Migrations\" -Force

# Run refactor
php refactor.php
