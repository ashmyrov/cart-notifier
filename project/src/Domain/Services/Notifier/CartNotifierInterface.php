<?php

namespace App\Domain\Services\Notifier;

interface CartNotifierInterface
{
    /**
     * Notify customers with old cart
     * @param array $customers
     */
    public function notify(array $customers): void;
}
