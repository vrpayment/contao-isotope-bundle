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

class StaticHelper
{
    /**
     * @param int $length
     *
     * @throws \Exception
     *
     * @return string
     */
    public static function getUniqueIdentifier(int $length = 20)
    {
        return md5(random_bytes($length));
    }
}
