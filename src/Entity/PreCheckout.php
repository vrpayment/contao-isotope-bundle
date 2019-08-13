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

class PreCheckout
{
    /** @var bool */
    protected $hasError = false;

    /** @var string|null */
    protected $errorDescription;

    /** @var string */
    protected $uriWidget;

    /** @var string */
    protected $shopperResultUrl;

    /** @var string+ */
    protected $brand;

    /**
     * @return bool
     */
    public function isHasError(): bool
    {
        return $this->hasError;
    }

    /**
     * @param bool $hasError
     *
     * @return PreCheckout
     */
    public function setHasError(bool $hasError): self
    {
        $this->hasError = $hasError;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getErrorDescription(): ?string
    {
        return $this->errorDescription;
    }

    /**
     * @param string|null $errorDescription
     *
     * @return PreCheckout
     */
    public function setErrorDescription(?string $errorDescription): self
    {
        $this->errorDescription = $errorDescription;

        return $this;
    }

    /**
     * @return string
     */
    public function getUriWidget(): string
    {
        return $this->uriWidget;
    }

    /**
     * @param string $uriWidget
     *
     * @return PreCheckout
     */
    public function setUriWidget(string $uriWidget): self
    {
        $this->uriWidget = $uriWidget;

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
     * @return PreCheckout
     */
    public function setShopperResultUrl(string $shopperResultUrl): self
    {
        $this->shopperResultUrl = $shopperResultUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getBrand(): string
    {
        return $this->brand;
    }

    /**
     * @param string $brand
     *
     * @return PreCheckout
     */
    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }
}
