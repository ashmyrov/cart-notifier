<?php

namespace App\Domain\Services\Carts;

interface CartNotifierServiceInterface
{
    /**
     * Find and notify customers with old carts
     */
    public function notifyOldCart(): void;
}
