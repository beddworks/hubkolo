<?php

namespace Workdo\Lead\Events;

use Illuminate\Queue\SerializesModels;

class LeadAddNote
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public $request;
    public $lead;

    public function __construct($request,$lead)
    {
        $this->request = $request;
        $this->lead = $lead;
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
