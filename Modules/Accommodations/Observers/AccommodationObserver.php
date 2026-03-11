<?php

namespace Modules\Accommodations\Observers;

use Modules\Accommodations\Entities\Accommodation;
use Modules\Automation\Services\WebhookService;

class AccommodationObserver
{
    protected $webhookService;

    public function __construct(WebhookService $webhookService)
    {
        $this->webhookService = $webhookService;
    }

    /**
     * Handle the Accommodation "created" event.
     *
     * @param  \Modules\Accommodations\Entities\Accommodation  $accommodation
     * @return void
     */
    public function created(Accommodation $accommodation)
    {
        $this->webhookService->dispatch('accommodation.stored', $accommodation->toArray());
    }

    /**
     * Handle the Accommodation "updated" event.
     *
     * @param  \Modules\Accommodations\Entities\Accommodation  $accommodation
     * @return void
     */
    public function updated(Accommodation $accommodation)
    {
        $this->webhookService->dispatch('accommodation.updated', $accommodation->toArray());
    }

    /**
     * Handle the Accommodation "deleted" event.
     *
     * @param  \Modules\Accommodations\Entities\Accommodation  $accommodation
     * @return void
     */
    public function deleted(Accommodation $accommodation)
    {
        $this->webhookService->dispatch('accommodation.deleted', ['id' => $accommodation->id, 'name' => $accommodation->name]);
    }
}
