$target = "g:\MixJo Top downlode mains by dats\for edit\tourism-management-system  13 FEB 2026 0221AM\tourism-management-system"
cd $target

# Ensure target directories exist
New-Item -ItemType Directory -Force -Path "Modules\Definitions\Entities" | Out-Null
New-Item -ItemType Directory -Force -Path "Modules\Definitions\Http\Controllers" | Out-Null
New-Item -ItemType Directory -Force -Path "Modules\Definitions\Livewire" | Out-Null
New-Item -ItemType Directory -Force -Path "Modules\Definitions\Policies" | Out-Null
New-Item -ItemType Directory -Force -Path "Modules\Definitions\Resources\views" | Out-Null
New-Item -ItemType Directory -Force -Path "Modules\Definitions\Database\Migrations" | Out-Null

# Models
if (Test-Path "Modules\Core\Entities\PricingDefinition.php") {
    Move-Item "Modules\Core\Entities\PricingDefinition.php" "Modules\Definitions\Entities\PricingDefinition.php" -Force
}
if (Test-Path "Modules\Core\Entities\PricingDefinitionModule.php") {
    Move-Item "Modules\Core\Entities\PricingDefinitionModule.php" "Modules\Definitions\Entities\PricingDefinitionModule.php" -Force
}

# Controller
if (Test-Path "Modules\Core\Http\Controllers\PricingDefinitionController.php") {
    Move-Item "Modules\Core\Http\Controllers\PricingDefinitionController.php" "Modules\Definitions\Http\Controllers\PricingDefinitionController.php" -Force
}

# Livewire
if (Test-Path "Modules\Core\Livewire\PricingDefinitions") {
    Move-Item "Modules\Core\Livewire\PricingDefinitions" "Modules\Definitions\Livewire\PricingDefinitions" -Recurse -Force
}

# Views
if (Test-Path "Modules\Core\Resources\views\pricing-definitions") {
    Move-Item "Modules\Core\Resources\views\pricing-definitions" "Modules\Definitions\Resources\views\pricing-definitions" -Recurse -Force
}

# Policy
if (Test-Path "Modules\Core\Policies\PricingDefinitionPolicy.php") {
    Move-Item "Modules\Core\Policies\PricingDefinitionPolicy.php" "Modules\Definitions\Policies\PricingDefinitionPolicy.php" -Force
}

# Migrations
Get-ChildItem -Path "Modules\Core\Database\Migrations\*pricing_definition*" | Move-Item -Destination "Modules\Definitions\Database\Migrations\" -Force

# Run refactor
php refactor.php
