<?php
/**
 * contao-isotope-bundle for Contao Open Source CMS
 *
 * Copyright (C) 2019 47GradNord - Agentur für Internetlösungen
 *
 * @license    commercial
 * @author     Holger Neuner
 */


namespace Vrpayment\ContaoIsotopeBundle\Brand;


class BrandFactory
{
    /**
     * @param $type
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

            default:

                return null;
        }
    }

}
