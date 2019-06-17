<?php

namespace App\Events;

use App\Models\LineItem;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductOrdered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Created Line Item
     * @var \App\Models\LineItem
     */
    public $line_item;

    /**
     * Create a new event instance.
     * @param  \App\Models\LineItem  $line_item
     * @return void
     */
    public function __construct(LineItem $line_item)
    {
        $this->line_item = $line_item;
    }
}
