<?php
/**
 * contao-isotope-bundle for Contao Open Source CMS
 *
 * Copyright (C) 2019 47GradNord - Agentur für Internetlösungen
 *
 * @license    commercial
 * @author     Holger Neuner
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
     * @return CardItem
     */
    public function setName(string $name): CardItem
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
     * @return CardItem
     */
    public function setMerchantItemId(string $merchantItemId): CardItem
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
     * @return CardItem
     */
    public function setPrice(float $price): CardItem
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
     * @return CardItem
     */
    public function setQuantity(int $quantity): CardItem
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
     * @return CardItem
     */
    public function setTotalAmount(float $totalAmount): CardItem
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
     * @return CardItem
     */
    public function setTax(float $tax): CardItem
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
     * @return CardItem
     */
    public function setTotalTaxAmount(float $totalTaxAmount): CardItem
    {
        $this->totalTaxAmount = $totalTaxAmount;
        return $this;
    }
}
