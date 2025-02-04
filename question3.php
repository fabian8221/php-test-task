<?php

class Address {
    private string $line1;
    private ?string $line2;
    private string $city;
    private string $state;
    private string $zip;

    public function __construct(
        string $line1,
        ?string $line2,
        string $city,
        string $state,
        string $zip
    ) {
        $this->line1 = $line1;
        $this->line2 = $line2;
        $this->city = $city;
        $this->state = $state;
        $this->zip = $zip;
    }

    public function getFullAddress(): string {
        $address = $this->line1;
        if ($this->line2) {
            $address .= "\n" . $this->line2;
        }
        $address .= "\n{$this->city}, {$this->state} {$this->zip}";
        return $address;
    }

    // Getters
    public function getZip(): string {
        return $this->zip;
    }

    public function getState(): string {
        return $this->state;
    }
}

class Item {
    private int $id;
    private string $name;
    private int $quantity;
    private float $price;

    public function __construct(
        int $id,
        string $name,
        int $quantity,
        float $price
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->quantity = $quantity;
        $this->price = $price;
    }

    public function getSubtotal(): float {
        return $this->price * $this->quantity;
    }

    // Getters
    public function getName(): string {
        return $this->name;
    }

    public function getQuantity(): int {
        return $this->quantity;
    }

    public function getPrice(): float {
        return $this->price;
    }
}

class Customer {
    private string $firstName;
    private string $lastName;
    private array $addresses = [];
    private ?Address $shippingAddress = null;

    public function __construct(string $firstName, string $lastName) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function addAddress(Address $address): void {
        $this->addresses[] = $address;
    }

    public function setShippingAddress(Address $address): void {
        $this->shippingAddress = $address;
    }

    public function getFullName(): string {
        return "{$this->firstName} {$this->lastName}";
    }

    public function getAddresses(): array {
        return $this->addresses;
    }

    public function getShippingAddress(): ?Address {
        return $this->shippingAddress;
    }
}

class Cart {
    private const TAX_RATE = 0.07;
    private ?Customer $customer = null;
    private array $items = [];
    private ?Address $shippingAddress = null;

    public function setCustomer(Customer $customer): void {
        $this->customer = $customer;
    }

    public function addItem(Item $item): void {
        $this->items[] = $item;
    }

    public function setShippingAddress(Address $address): void {
        $this->shippingAddress = $address;
        if ($this->customer) {
            $this->customer->setShippingAddress($address);
        }
    }

    public function getCustomerName(): ?string {
        return $this->customer ? $this->customer->getFullName() : null;
    }

    public function getCustomerAddresses(): array {
        return $this->customer ? $this->customer->getAddresses() : [];
    }

    public function getItems(): array {
        return $this->items;
    }

    public function getShippingAddress(): ?Address {
        return $this->shippingAddress;
    }

    public function getSubtotal(): float {
        return array_reduce($this->items, function($sum, Item $item) {
            return $sum + $item->getSubtotal();
        }, 0.0);
    }

    public function getTax(): float {
        return $this->getSubtotal() * self::TAX_RATE;
    }

    public function getShippingCost(): float {
        if (!$this->shippingAddress) {
            return 0.0;
        }

        // Assuming ShippingRateService exists elsewhere in the system
        return ShippingRateService::calculateRate(
            $this->shippingAddress->getState(),
            $this->shippingAddress->getZip(),
            $this->getSubtotal()
        );
    }

    public function getTotal(): float {
        return $this->getSubtotal() + $this->getTax() + $this->getShippingCost();
    }
}
