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


class StaticResponseResultValidator
{
    /**
     * @return bool
     */
    public static function isSuccessfullyPendingTransaction(array $json)
    {
        if(preg_match('/^(000\.200)/', $json['result']['code']))
        {
            return true;
        }

        return false;
    }

    /**
     * @param array $json
     * @return bool
     */
    public static function isSuccessfullyProceedTransaction(array $json)
    {
        if(preg_match('/^(000\.000\.|000\.100\.1|000\.[36])/', $json['result']['code']))
        {
            return true;
        }

        return false;
    }

}
