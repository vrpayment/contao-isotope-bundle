<?php
/**
 * contao-isotope-bundle for Contao Open Source CMS
 *
 * Copyright (C) 2019 47GradNord - Agentur für Internetlösungen
 *
 * @license    commercial
 * @author     Holger Neuner
 */


namespace Vrpayment\ContaoIsotopeBundle;


class ResultCodeHandler
{
    protected $resultCode;

    /**
     * @return mixed
     */
    public function getResultCode()
    {
        return $this->resultCode;
    }

    /**
     * @param mixed $resultCode
     * @return ResultCodeHandler
     */
    private function setResultCode($resultCode)
    {
        $this->resultCode = $resultCode;
        return $this;
    }

    public function proceedResponseJson(array $json)
    {
        if(!$json['result']['code'])
        {
            return;
        }

        $this->setResultCode($json['result']['code']);
    }

    /**
     * @return bool
     */
    public function isSuccessfullyProcessedTransaction()
    {
        if(preg_match('/^(000\.000\.|000\.100\.1|000\.[36])/', $this->getResultCode()))
        {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isSuccessfullyPendingTransaction()
    {
        if(preg_match('/^(000\.200)/', $this->getResultCode()))
        {
            return true;
        }

        return false;
    }
}
