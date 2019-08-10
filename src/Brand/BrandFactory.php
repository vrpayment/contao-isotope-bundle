<?php

/*
 * VR Payment GmbH Contao Isotope Bundle
 *
 * @copyright  Copyright (c) 2019-2019, VR Payment GmbH
 * @author     VR Payment GmbH <info@vr-payment.de>
 *
 * @license LGPL-3.0-or-later
 */

namespace Vrpayment\ContaoIsotopeBundle\Brand;

class BrandFactory
{
    /**
     * @param $type
     *
     * @return BrandInterface
     */
    public static function getBrandByPaymentType($type)
    {
        switch ($type) {
            case 'ENTERPAY':

                return new Enterpay();

                break;

            case 'VISA':

                return new Visa();

                break;

            case 'DIRECTDEBIT_SEPA':

                return new DirectDebitSepa();

            default:

                return null;
        }
    }
}
