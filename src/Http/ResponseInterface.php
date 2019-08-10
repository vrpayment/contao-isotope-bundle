<?php

/*
 * VR Payment GmbH Contao Isotope Bundle
 *
 * @copyright  Copyright (c) 2019-2019, VR Payment GmbH
 * @author     VR Payment GmbH <info@vr-payment.de>
 *
 * @license LGPL-3.0-or-later
 */

namespace Vrpayment\ContaoIsotopeBundle\Http;

interface ResponseInterface
{
    /**
     * @return int
     */
    public function getStatusCode();

    /**
     * @return mixed
     */
    public function getBody();

    /**
     * @return array
     */
    public function getHeaders();

    /**
     * @param array $config
     *
     * @return mixed
     */
    public function json(array $config = []);
}
