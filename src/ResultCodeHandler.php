<?php

/*
 * VR Payment GmbH Contao Isotope Bundle
 *
 * @copyright  Copyright (c) 2019-2019, VR Payment GmbH
 * @author     VR Payment GmbH <info@vr-payment.de>
 *
 * @license LGPL-3.0-or-later
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

    public function proceedResponseJson(array $json)
    {
        if (!$json['result']['code']) {
            return;
        }

        $this->setResultCode($json['result']['code']);
    }

    /**
     * @return bool
     */
    public function isSuccessfullyProcessedTransaction()
    {
        if (preg_match('/^(000\.000\.|000\.100\.1|000\.[36])/', $this->getResultCode())) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isSuccessfullyPendingTransaction()
    {
        if (preg_match('/^(000\.200)/', $this->getResultCode())) {
            return true;
        }

        return false;
    }

    /**
     * @param mixed $resultCode
     *
     * @return ResultCodeHandler
     */
    private function setResultCode($resultCode)
    {
        $this->resultCode = $resultCode;

        return $this;
    }
}
