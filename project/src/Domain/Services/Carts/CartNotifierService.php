<?php

namespace App\Domain\Services\Carts;

use App\Domain\Repositories\Carts\CartsRepositoryInterface;
use App\Domain\Services\Notifier\CartNotifierInterface;
use Psr\Log\LoggerInterface;

class CartNotifierService implements CartNotifierServiceInterface
{
    private CartsRepositoryInterface $cartsRepository;
    private LoggerInterface $logger;
    private CartNotifierInterface $cartNotifier;

    public function __construct(
        CartsRepositoryInterface $cartsRepository,
        CartNotifierInterface $cartNotifier,
        LoggerInterface $logger
    ) {
        $this->cartsRepository = $cartsRepository;
        $this->logger = $logger;
        $this->cartNotifier = $cartNotifier;
    }

    /**
     * @inheritDoc
     */
    public function notifyOldCart(): void
    {
        try {
            $carts = $this->cartsRepository->getOld();
            if (empty($carts)) {
                return;
            }

            $this->cartNotifier->notify($carts);
        } catch (\Throwable $exception) {
            $this->logger->error('Notify customers error', [
                'error' => $exception->getMessage()
            ]);
        }
    }
}
