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
     * @return PaymentStatus
     */
    public function setHasError(bool $hasError): PaymentStatus
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
     * @return PaymentStatus
     */
    public function setResultCode(string $resultCode): PaymentStatus
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
     * @return PaymentStatus
     */
    public function setResultDescription(string $resultDescription): PaymentStatus
    {
        $this->resultDescription = $resultDescription;
        return $this;
    }

    /**
     * @param array $array
     * @return PaymentStatus
     */
    public static function buildFromResultArray(array $result)
    {
        $ps = new self();
        $ps->setHasError((StaticResponseResultValidator::isSuccessfullyProceedTransaction($result)));
        $ps->setResultCode($result['result']['code']);
        $ps->setResultDescription($result['result']['description']);

        return $ps;
    }
}
