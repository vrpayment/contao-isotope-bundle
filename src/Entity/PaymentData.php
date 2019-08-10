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

class PaymentData
{
    /** @var string */
    protected $customParametersMerchantId;

    /** @var string */
    protected $entityId;

    /** @var float */
    protected $amount;

    /** @var string */
    protected $currenty;

    /** @var string */
    protected $paymentBrand;

    /** @var string */
    protected $paymentType;

    /** @var string */
    protected $billingCity;

    /** @var string */
    protected $billingPostcode;

    /** @var string */
    protected $billingStreet1;

    /** @var string */
    protected $shippingCity;

    /** @var string */
    protected $shippingPostcode;

    protected $shippingStreet1;

    /** @var string */
    protected $shopperResultUrl;

    /** @var [] */
    protected $cardItems;

    /**
     * @return string
     */
    public function getCustomParametersMerchantId(): string
    {
        return $this->customParametersMerchantId;
    }

    /**
     * @param string $customParametersMerchantId
     *
     * @return PaymentData
     */
    public function setCustomParametersMerchantId(string $customParametersMerchantId): self
    {
        $this->customParametersMerchantId = $customParametersMerchantId;

        return $this;
    }

    /**
     * @return string
     */
    public function getEntityId(): string
    {
        return $this->entityId;
    }

    /**
     * @param string $entityId
     *
     * @return PaymentData
     */
    public function setEntityId(string $entityId): self
    {
        $this->entityId = $entityId;

        return $this;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     *
     * @return PaymentData
     */
    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrenty(): string
    {
        return $this->currenty;
    }

    /**
     * @param string $currenty
     *
     * @return PaymentData
     */
    public function setCurrenty(string $currenty): self
    {
        $this->currenty = $currenty;

        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentBrand(): string
    {
        return $this->paymentBrand;
    }

    /**
     * @param string $paymentBrand
     *
     * @return PaymentData
     */
    public function setPaymentBrand(string $paymentBrand): self
    {
        $this->paymentBrand = $paymentBrand;

        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentType(): string
    {
        return $this->paymentType;
    }

    /**
     * @param string $paymentType
     *
     * @return PaymentData
     */
    public function setPaymentType(string $paymentType): self
    {
        $this->paymentType = $paymentType;

        return $this;
    }

    /**
     * @return string
     */
    public function getBillingCity(): string
    {
        return $this->billingCity;
    }

    /**
     * @param string $billingCity
     *
     * @return PaymentData
     */
    public function setBillingCity(string $billingCity): self
    {
        $this->billingCity = $billingCity;

        return $this;
    }

    /**
     * @return string
     */
    public function getBillingPostcode(): string
    {
        return $this->billingPostcode;
    }

    /**
     * @param string $billingPostcode
     *
     * @return PaymentData
     */
    public function setBillingPostcode(string $billingPostcode): self
    {
        $this->billingPostcode = $billingPostcode;

        return $this;
    }

    /**
     * @return string
     */
    public function getBillingStreet1(): string
    {
        return $this->billingStreet1;
    }

    /**
     * @param string $billingStreet1
     *
     * @return PaymentData
     */
    public function setBillingStreet1(string $billingStreet1): self
    {
        $this->billingStreet1 = $billingStreet1;

        return $this;
    }

    /**
     * @return string
     */
    public function getShippingCity(): string
    {
        return $this->shippingCity;
    }

    /**
     * @param string $shippingCity
     *
     * @return PaymentData
     */
    public function setShippingCity(string $shippingCity): self
    {
        $this->shippingCity = $shippingCity;

        return $this;
    }

    /**
     * @return string
     */
    public function getShippingPostcode(): string
    {
        return $this->shippingPostcode;
    }

    /**
     * @param string $shippingPostcode
     *
     * @return PaymentData
     */
    public function setShippingPostcode(string $shippingPostcode): self
    {
        $this->shippingPostcode = $shippingPostcode;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getShippingStreet1()
    {
        return $this->shippingStreet1;
    }

    /**
     * @param mixed $shippingStreet1
     *
     * @return PaymentData
     */
    public function setShippingStreet1($shippingStreet1)
    {
        $this->shippingStreet1 = $shippingStreet1;

        return $this;
    }

    /**
     * @return string
     */
    public function getShopperResultUrl(): string
    {
        return $this->shopperResultUrl;
    }

    /**
     * @param string $shopperResultUrl
     *
     * @return PaymentData
     */
    public function setShopperResultUrl(string $shopperResultUrl): self
    {
        $this->shopperResultUrl = $shopperResultUrl;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCardItems()
    {
        return $this->cardItems;
    }

    /**
     * @param mixed $cardItems
     *
     * @return PaymentData
     */
    public function setCardItems($cardItems)
    {
        $this->cardItems = $cardItems;

        return $this;
    }
}
