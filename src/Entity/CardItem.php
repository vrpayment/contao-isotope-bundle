<?php

/*
 * VR Payment GmbH Contao Isotope Bundle
 *
 * @copyright  Copyright (c) 2019-2019, VR Payment GmbH
 * @author     VR Payment GmbH <info@vr-payment.de>
 *
 * @license LGPL-3.0-or-later
 */

namespace Vrpayment\ContaoIsotopeBundle\Entity;

class CardItem
{
    /** @var string */
    protected $name;

    /** @var string */
    protected $merchantItemId;

    /** @var float */
    protected $price;

    /** @var int */
    protected $quantity;

    /** @var float */
    protected $totalAmount;

    /** @var float */
    protected $tax;

    /** @var float */
    protected $totalTaxAmount;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return CardItem
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getMerchantItemId(): string
    {
        return $this->merchantItemId;
    }

    /**
     * @param string $merchantItemId
     *
     * @return CardItem
     */
    public function setMerchantItemId(string $merchantItemId): self
    {
        $this->merchantItemId = $merchantItemId;

        return $this;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     *
     * @return CardItem
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     *
     * @return CardItem
     */
    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return float
     */
    public function getTotalAmount(): float
    {
        return $this->totalAmount;
    }

    /**
     * @param float $totalAmount
     *
     * @return CardItem
     */
    public function setTotalAmount(float $totalAmount): self
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    /**
     * @return float
     */
    public function getTax(): float
    {
        return $this->tax;
    }

    /**
     * @param float $tax
     *
     * @return CardItem
     */
    public function setTax(float $tax): self
    {
        $this->tax = $tax;

        return $this;
    }

    /**
     * @return float
     */
    public function getTotalTaxAmount(): float
    {
        return $this->totalTaxAmount;
    }

    /**
     * @param float $totalTaxAmount
     *
     * @return CardItem
     */
    public function setTotalTaxAmount(float $totalTaxAmount): self
    {
        $this->totalTaxAmount = $totalTaxAmount;

        return $this;
    }
}
