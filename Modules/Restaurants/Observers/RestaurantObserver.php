<?php

namespace Modules\Restaurants\Observers;

use Modules\Restaurants\Entities\Restaurant;
use Modules\Automation\Services\WebhookService;

class RestaurantObserver
{
    protected $webhookService;

    public function __construct(WebhookService $webhookService)
    {
        $this->webhookService = $webhookService;
    }

    /**
     * Handle the Restaurant "created" event.
     *
     * @param  \Modules\Restaurants\Entities\Restaurant  $restaurant
     * @return void
     */
    public function created(Restaurant $restaurant)
    {
        $this->webhookService->dispatch('restaurant.stored', $restaurant->toArray());
    }

    /**
     * Handle the Restaurant "updated" event.
     *
     * @param  \Modules\Restaurants\Entities\Restaurant  $restaurant
     * @return void
     */
    public function updated(Restaurant $restaurant)
    {
        $this->webhookService->dispatch('restaurant.updated', $restaurant->toArray());
    }

    /**
     * Handle the Restaurant "deleted" event.
     *
     * @param  \Modules\Restaurants\Entities\Restaurant  $restaurant
     * @return void
     */
    public function deleted(Restaurant $restaurant)
    {
        $this->webhookService->dispatch('restaurant.deleted', ['id' => $restaurant->id, 'name' => $restaurant->name]);
    }
}
