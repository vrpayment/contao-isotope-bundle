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

use Vrpayment\ContaoIsotopeBundle\Http\Exception\ClientException;

class CurlClient implements ClientInterface
{
    const METHOD_GET = 'get';
    const METHOD_POST = 'post';
    const METHOD_PUT = 'put';

    /**
     * @var array
     */
    protected $additionalHeaders = [];

    /**
     * @var resource
     */
    private $handle;

    /**
     * @var array
     */
    private static $defaultOptions = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
    ];

    public function __construct()
    {
        $this->handle = curl_init();
        $this->setOptionArray(self::$defaultOptions);
    }

    public function __destruct()
    {
        if (\is_resource($this->handle)) {
            curl_close($this->handle);
        }
    }

    /**
     * @param string $option
     * @param mixed  $value
     */
    public static function setDefaultOption($option, $value)
    {
        self::$defaultOptions[$option] = $value;
    }

    /**
     * @param array $options
     */
    public static function setDefaultOptions(array $options)
    {
        self::$defaultOptions = $options;
    }

    /**
     * @param string $option
     * @param mixed  $value
     *
     * @return $this
     */
    public function setOption($option, $value)
    {
        curl_setopt($this->handle, $option, $value);

        return $this;
    }

    /**
     * @param array $options
     *
     * @return $this
     */
    public function setOptionArray(array $options)
    {
        curl_setopt_array($this->handle, $options);

        return $this;
    }

    /**
     * @param string $method
     * @param string $url
     * @param array  $headers
     *
     * @return Response|ResponseInterface
     */
    public function send($method, $url, array $headers = [])
    {
        $this->setOption(CURLOPT_URL, $url);

        $allHeaders = [];
        foreach ($this->mergeHeaders($headers, $this->additionalHeaders) as $k => $v) {
            $allHeaders[] = $k.': '.$v;
        }

        if (!empty($allHeaders)) {
            $this->setOption(CURLOPT_HTTPHEADER, $allHeaders);
        }

        $exec = CurlExec::getInstance($this->handle)->exec();

        $response = new Response(
            $this->getResponseCode(),
            $exec->getHeaders(),
            $exec->getBody(),
            $this->getErrno(),
            $this->getError()
        );

        return $response;
    }

    /**
     * @param string $url
     * @param array  $headers
     *
     * @return Response|ResponseInterface
     */
    public function get($url, array $headers = [])
    {
        $this->setOption(CURLOPT_CUSTOMREQUEST, 'GET');

        return $this->send(self::METHOD_GET, $url, $headers);
    }

    /**
     * @param string $url
     * @param mixed  $body
     * @param array  $headers
     *
     * @throws ClientException
     *
     * @return Response|ResponseInterface
     */
    public function post($url, $body, array $headers = [])
    {
        if ($body && \is_string($body)) {
            // TODO: Check - i think we dont need CustomRequest
            //$this->setOption(CURLOPT_CUSTOMREQUEST, "POST");
            $this->setOption(CURLOPT_POSTFIELDS, $body);
        } elseif ($body && \is_array($body)) {
            $this->setOption(CURLOPT_POST, 1);
            $this->setOption(CURLOPT_POSTFIELDS, http_build_query($body));
        } else {
            throw new ClientException('invalid body datatype allowed: string and array');
        }

        return $this->send(self::METHOD_POST, $url, $headers);
    }

    /**
     * @param string $token
     *
     * @return $this
     */
    public function authorize($token)
    {
        $this->additionalHeaders = [
            'Authorization:Bearer' => $token,
        ];

        return $this;
    }

    /**
     * @return int
     */
    private function getResponseCode()
    {
        return (int) curl_getinfo($this->handle, CURLINFO_HTTP_CODE);
    }

    /**
     * @return int
     */
    private function getErrno()
    {
        return curl_errno($this->handle);
    }

    /**
     * @return string
     */
    private function getError()
    {
        return curl_error($this->handle);
    }

    /**
     * @param array $headers1
     * @param array $headers2
     *
     * @return array
     */
    private function mergeHeaders($headers1, $headers2)
    {
        $ret = [];
        foreach ($headers1 as $k => $v) {
            if (is_numeric($k)) {
                $name = substr($v, 0, strpos($v, ':'));
                $value = trim(substr($v, strpos($v, ':') + 1));
                $ret[$name] = $value;
            } else {
                $ret[$k] = $v;
            }
        }
        foreach ($headers2 as $k => $v) {
            if (is_numeric($k)) {
                $name = substr($v, 0, strpos($v, ':'));
                $value = trim(substr($v, strpos($v, ':') + 1));
                $ret[$name] = $value;
            } else {
                $ret[$k] = $v;
            }
        }

        return $ret;
    }
}
