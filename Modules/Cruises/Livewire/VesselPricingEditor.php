<?php

namespace Modules\Cruises\Livewire;

use Livewire\Component;
use Modules\Cruises\Entities\Cruise;
use Modules\Cruises\Entities\CruiseCabinCategory;
use Modules\Cruises\Entities\CruiseSeason;
use Modules\Cruises\Entities\CruisePrice;

class VesselPricingEditor extends Component
{
    public $cruise;
    public $prices = []; // [season_id][category_id] => ['buy' => x, 'sell' => y]
    public $seasons;
    public $categories;
    public $currencies = ['USD', 'EUR', 'EGP', 'GBP'];
    public $defaultCurrency = 'USD';
    public $isTaxIncluded = false;

    public function mount(Cruise $cruise)
    {
        $this->cruise = $cruise;
        $this->seasons = CruiseSeason::where('is_active', true)->get();
        $this->categories = CruiseCabinCategory::where('is_active', true)->get();
        
        $existingPrices = CruisePrice::where('cruise_id', $this->cruise->id)->get();
        
        foreach ($existingPrices as $price) {
            $this->prices[$price->season_id][$price->category_id] = [
                'buy' => $price->buy_price,
                'sell' => $price->sell_price,
                'buy_currency' => $price->buy_currency,
                'sell_currency' => $price->sell_currency,
                'is_tax_included' => $price->is_tax_included,
            ];
        }

        // Fill missing with defaults
        foreach ($this->seasons as $season) {
            foreach ($this->categories as $category) {
                if (!isset($this->prices[$season->id][$category->id])) {
                    $this->prices[$season->id][$category->id] = [
                        'buy' => 0,
                        'sell' => 0,
                        'buy_currency' => $this->defaultCurrency,
                        'sell_currency' => $this->defaultCurrency,
                        'is_tax_included' => $this->isTaxIncluded,
                    ];
                }
            }
        }
    }

    public function save()
    {
        foreach ($this->prices as $seasonId => $categories) {
            foreach ($categories as $categoryId => $data) {
                CruisePrice::updateOrCreate(
                    [
                        'cruise_id' => $this->cruise->id,
                        'season_id' => $seasonId,
                        'category_id' => $categoryId,
                        'company_id' => auth()->user()->company_id ?? 1,
                    ],
                    [
                        'buy_price' => $data['buy'],
                        'sell_price' => $data['sell'],
                        'buy_currency' => $data['buy_currency'],
                        'sell_currency' => $data['sell_currency'],
                        'is_tax_included' => $data['is_tax_included'] ?? $this->isTaxIncluded,
                    ]
                );
            }
        }

        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('messages.prices_updated_successfully'),
        ]);
    }

    public function render()
    {
        return view('cruises::livewire.vessel-pricing-editor');
    }
}
