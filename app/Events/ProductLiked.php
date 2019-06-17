<?php

namespace App\Events;

use App\Models\Like;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductLiked
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Created or deleted like
     * @var \App\Models\Like
     */
    public $like;

    /**
     * Create a new event instance.
     * @param  \App\Models\Like  $like
     * @return void
     */
    public function __construct(Like $like)
    {
        $this->like = $like;
    }
}
