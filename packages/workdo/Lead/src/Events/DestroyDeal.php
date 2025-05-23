<?php

namespace Workdo\Lead\Events;

use Illuminate\Queue\SerializesModels;

class DestroyDeal
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $deal;

    public function __construct($deal)
    {
        $this->deal = $deal;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
