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

use Vrpayment\ContaoIsotopeBundle\StaticResponseResultValidator;

class PaymentStatus
{
    /** @var bool */
    protected $hasError = false;

    /** @var string */
    protected $resultCode;

    /** @var string */
    protected $resultDescription;

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
     * @return PaymentStatus
     */
    public function setHasError(bool $hasError): self
    {
        $this->hasError = $hasError;

        return $this;
    }

    /**
     * @return string
     */
    public function getResultCode(): string
    {
        return $this->resultCode;
    }

    /**
     * @param string $resultCode
     *
     * @return PaymentStatus
     */
    public function setResultCode(string $resultCode): self
    {
        $this->resultCode = $resultCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getResultDescription(): string
    {
        return $this->resultDescription;
    }

    /**
     * @param string $resultDescription
     *
     * @return PaymentStatus
     */
    public function setResultDescription(string $resultDescription): self
    {
        $this->resultDescription = $resultDescription;

        return $this;
    }

    /**
     * @param array $array
     *
     * @return PaymentStatus
     */
    public static function buildFromResultArray(array $result)
    {
        $ps = new self();
        $ps->setHasError((StaticResponseResultValidator::isSuccessfullyProceedTransaction($result)) ? false : true);
        $ps->setResultCode($result['result']['code']);
        $ps->setResultDescription($result['result']['description']);

        return $ps;
    }
}
