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

class StaticResponseResultValidator
{
    /**
     * @return bool
     */
    public static function isSuccessfullyPendingTransaction(array $json)
    {
        if (preg_match('/^(000\.200)/', $json['result']['code'])) {
            return true;
        }

        return false;
    }

    /**
     * @param array $json
     *
     * @return bool
     */
    public static function isSuccessfullyProceedTransaction(array $json)
    {
        if (preg_match('/^(000\.000\.|000\.100\.1|000\.[36])/', $json['result']['code'])) {
            return true;
        }

        return false;
    }
}
