<?php

namespace App\Contracts;

interface Order
{
    /**
     * Status when order is recently stored and yet to be processed
     * @var string
     */
    const STATUS_PENDING = 'PENDING';

    /**
     * Status when order has been received
     * @var string
     */
    const STATUS_RECEIVED = 'RECEIVED';

    /**
     * Status when order has been dispatched
     * @var string
     */
    const STATUS_DISPATCHED = 'DISPATCHED';

    /**
     * Status when order has been delivered
     * @var string
     */
    const STATUS_DELIVERED = 'DELIVERED';
}
