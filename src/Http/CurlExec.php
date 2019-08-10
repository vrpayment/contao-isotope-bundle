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

class CurlExec
{
    /**
     * @var string
     */
    private $headerString = '';

    /**
     * @var array
     */
    private $headers = [];

    /**
     * @var string
     */
    private $body;

    /**
     * @param resource $handle
     */
    public function __construct($handle)
    {
        $this->handle = $handle;
        curl_setopt($this->handle, CURLOPT_HEADERFUNCTION, [$this, 'readHeaders']);
        $this->reset();
    }

    /**
     * @param resource $handle
     *
     * @return CurlExec
     */
    public static function getInstance($handle)
    {
        return new self($handle);
    }

    /**
     * @return $this
     */
    public function exec()
    {
        $this->reset();

        $this->body = curl_exec($this->handle);
        $this->headers = $this->parseHeaderMessage($this->headerString);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param resource $curl
     * @param string   $headerLine
     *
     * @return int
     */
    private function readHeaders($curl, $headerLine)
    {
        $this->headerString .= $headerLine;

        return \strlen($headerLine);
    }

    /**
     * @param string $headerMessage
     *
     * @return array
     */
    private function parseHeaderMessage($headerMessage)
    {
        $headers = [];

        $lines = preg_split('/(\\r?\\n)/', $headerMessage, -1, PREG_SPLIT_DELIM_CAPTURE);
        foreach ($lines as $line) {
            // Parse message headers
            if (strpos($line, ':')) {
                $parts = explode(':', $line, 2);
                $key = trim($parts[0]);
                $value = isset($parts[1]) ? trim($parts[1]) : '';
                if (!isset($headers[$key])) {
                    $headers[$key] = $value;
                } elseif (!\is_array($headers[$key])) {
                    $headers[$key] = [$headers[$key], $value];
                } else {
                    $headers[$key][] = $value;
                }
            }
        }

        return $headers;
    }

    /**
     * set default values.
     */
    private function reset()
    {
        $this->headerString = '';
        $this->headers = [];
        $this->body = null;
    }
}
