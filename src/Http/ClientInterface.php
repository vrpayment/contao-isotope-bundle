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

interface ClientInterface
{
    /**
     * @param string $method
     * @param string $url
     * @param array  $headers
     *
     * @return ResponseInterface
     */
    public function send($method, $url, array $headers = []);

    /**
     * @param string $url
     * @param array  $headers
     *
     * @return ResponseInterface
     */
    public function get($url, array $headers = []);

    /**
     * @param string $url
     * @param mixed  $body
     * @param array  $headers
     *
     * @return ResponseInterface
     */
    public function post($url, $body, array $headers = []);
}
