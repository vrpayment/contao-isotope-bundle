<?php

/*
 * VR Payment GmbH Contao Isotope Bundle
 *
 * @copyright  Copyright (c) 2019-2019, VR Payment GmbH
 * @author     VR Payment GmbH <info@vr-payment.de>
 *
 * @license LGPL-3.0-or-later
 */

namespace Vrpayment\ContaoIsotopeBundle\Http\Exception;

class ResponseException extends \Exception
{
    /**
     * @var mixed
     */
    private $httpStatus;

    /**
     * @var mixed
     */
    private $response;

    /**
     * @param mixed $httpStatus
     *
     * @return ResponseException
     */
    public function setHttpStatus($httpStatus)
    {
        $this->httpStatus = $httpStatus;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getHttpStatus()
    {
        return $this->httpStatus;
    }

    /**
     * @param mixed $response
     *
     * @return ResponseException
     */
    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'code' => $this->code,
            'message' => $this->message,
            'http-status' => $this->httpStatus,
            'response' => $this->response,
        ];
    }
}
