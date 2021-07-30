<?php

namespace App\Commands;

use App\Domain\Services\Carts\CartNotifierServiceInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NotifyCustomersWithOldCarts extends Command
{
    protected static $defaultName = 'app:cart:notify';
    private CartNotifierServiceInterface $cartService;
    private LoggerInterface $logger;

    public function __construct(CartNotifierServiceInterface $cartService, LoggerInterface $logger, string $name = null)
    {
        $this->cartService = $cartService;
        $this->logger = $logger;
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->cartService->notifyOldCart();
        } catch (\Throwable $exception) {
            $this->logger->error('Cron app:cart:notify error', [
                'error' => $exception->getMessage()
            ]);
        }
        return 0;
    }
}
