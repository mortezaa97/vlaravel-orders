<?php

namespace Mortezaa97\Orders;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mortezaa97\Orders\Skeleton\SkeletonClass
 */
class OrdersFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'orders';
    }
}
