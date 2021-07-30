<?php

namespace App\Domain\Services\Notifier;

class EmailCartNotifierInterface implements CartNotifierInterface
{
    /**
     * @inheritDoc
     */
    public function notify(array $carts): void
    {
        // Depends on sender realizations(one by one or mass message)
        foreach ($carts as $cart) {

            /** @var \DateTime $createTime */
            $createTime = $cart['create_at'];
            $message = $this->getBody($createTime->format('Y-m-d H:i:s'), $cart['products']);
            //            Email::send($cart['customer']['email'], $message)
        }
    }

    /**
     * Prepare message text
     * @param string $createTime
     * @param array  $products
     *
     * @return string
     */
    private function getBody(string $createTime, array $products): string
    {
        $message = sprintf(
            'It looks like you forgot to finish the order. We found your shopping cart created %s.',
            $createTime
        );

        if (!empty($products)) {
            $productsMessage = 'Your products: ' . PHP_EOL;
            foreach ($products as $product) {
                $productsMessage .= sprintf('name: %s with price: %d', $product['name'], $product['price']) . PHP_EOL;
            }
            $message .= $productsMessage;
        }
        $message .= 'We hope for your order. With best wishes, your company.';
        return $message;
    }
}
