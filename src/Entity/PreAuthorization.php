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

class PreAuthorization
{
    /** @var bool */
    protected $hasError = false;

    /** @var string */
    protected $resultCode;

    /** @var string */
    protected $resultDescription;

    /** @var string|null */
    protected $resultDetailExtendedDescription;

    /** @var string|null */
    protected $resultDetailConnectorTxID1;

    /** @var string|null */
    protected $redirectUrl;

    /** @var string|null */
    protected $redirectMethode;

    /** @var []|null */
    protected $redirectParameters;

    /**
     * @return bool
     */
    public function isHasError(): bool
    {
        return $this->hasError;
    }

    /**
     * @param bool $hasError
     * @return PreAuthorization
     */
    public function setHasError(bool $hasError): PreAuthorization
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
     * @return PreAuthorization
     */
    public function setResultCode(string $resultCode): PreAuthorization
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
     * @return PreAuthorization
     */
    public function setResultDescription(string $resultDescription): PreAuthorization
    {
        $this->resultDescription = $resultDescription;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getResultDetailExtendedDescription(): ?string
    {
        return $this->resultDetailExtendedDescription;
    }

    /**
     * @param string|null $resultDetailExtendedDescription
     * @return PreAuthorization
     */
    public function setResultDetailExtendedDescription(?string $resultDetailExtendedDescription): PreAuthorization
    {
        $this->resultDetailExtendedDescription = $resultDetailExtendedDescription;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getResultDetailConnectorTxID1(): ?string
    {
        return $this->resultDetailConnectorTxID1;
    }

    /**
     * @param string|null $resultDetailConnectorTxID1
     * @return PreAuthorization
     */
    public function setResultDetailConnectorTxID1(?string $resultDetailConnectorTxID1): PreAuthorization
    {
        $this->resultDetailConnectorTxID1 = $resultDetailConnectorTxID1;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRedirectUrl(): ?string
    {
        return $this->redirectUrl;
    }

    /**
     * @param string|null $redirectUrl
     * @return PreAuthorization
     */
    public function setRedirectUrl(?string $redirectUrl): PreAuthorization
    {
        $this->redirectUrl = $redirectUrl;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRedirectMethode(): ?string
    {
        return $this->redirectMethode;
    }

    /**
     * @param string|null $redirectMethode
     * @return PreAuthorization
     */
    public function setRedirectMethode(?string $redirectMethode): PreAuthorization
    {
        $this->redirectMethode = $redirectMethode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRedirectParameters()
    {
        return $this->redirectParameters;
    }

    /**
     * @param mixed $redirectParameters
     * @return PreAuthorization
     */
    public function setRedirectParameters($redirectParameters)
    {
        $this->redirectParameters = $redirectParameters;
        return $this;
    }


    /**
     * @param array $result
     * @return PreAuthorization
     */
    public static function buildFromResultArray(array $result)
    {
        $pa = new self();
        $pa->setHasError((StaticResponseResultValidator::isSuccessfullyPendingTransaction($result))? false: true);
        $pa->setRedirectMethode($result['redirect']['method']);
        $pa->setRedirectParameters($result['redirect']['parameters']);
        $pa->setRedirectUrl($result['redirect']['url']);
        $pa->setResultCode($result['result']['code']);
        $pa->setResultDescription($result['result']['description']);
        $pa->setResultDetailExtendedDescription($result['resultDetails']['ExtendedDescription']);
        $pa->setResultDetailConnectorTxID1($result['resultDetails']['ConnectorTxID1']);

        return $pa;

    }
}
