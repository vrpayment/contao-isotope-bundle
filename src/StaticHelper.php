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


use Contao\Environment;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class StaticHelper
{
    /**
     * @param int $length
     * @return string
     * @throws \Exception
     */
    public static function getUniqueIdentifier(int $length = 20)
    {
        return md5(random_bytes($length));
    }
}
