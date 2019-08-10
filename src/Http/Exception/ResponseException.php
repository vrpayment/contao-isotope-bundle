<?php
/**
 * contao-isotope-bundle for Contao Open Source CMS
 *
 * Copyright (C) 2019 47GradNord - Agentur für Internetlösungen
 *
 * @license    commercial
 * @author     Holger Neuner
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
        return array(
            'code' => $this->code,
            'message' => $this->message,
            'http-status' => $this->httpStatus,
            'response' => $this->response,
        );
    }

}
