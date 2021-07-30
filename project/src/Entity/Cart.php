<?php


namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="carts")
 * @ORM\Entity
 */
class Cart
{
    public const STATUS_PENDING = 0;
    public const STATUS_FINISHED = 1;

    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;

    /**
     * @var DateTime
     * @ORM\Column(name="create_at", type="datetime")
     */
    private DateTime $create_at;

    /**
     * @var int
     * @ORM\Column(name="status", type="integer")
     */
    private int $status;

    /**
     * @var Customer
     *
     * @ORM\OneToOne(targetEntity="Customer", mappedBy="Customer")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id",
     *      nullable=false)
     */
    private Customer $customer;

    /**
     * @var Collection|Product[]
     *
     * @ORM\ManyToMany(targetEntity="Product")
     */
    private Collection $products;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getCreateAt(): DateTime
    {
        return $this->create_at;
    }

    /**
     * @param DateTime $create_at
     */
    public function setCreateAt(DateTime $create_at): void
    {
        $this->create_at = $create_at;
    }

    /**
     * @return Customer
     */
    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    /**
     * @param Customer $customer
     */
    public function setCustomer(Customer $customer): void
    {
        $this->customer = $customer;
    }

    /**
     * @return Product[]|Collection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param Product[]|Collection $products
     */
    public function setProducts($products): void
    {
        $this->products = $products;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }
}
