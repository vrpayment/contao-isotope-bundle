<?php
/**
 * contao-isotope-bundle for Contao Open Source CMS
 *
 * Copyright (C) 2019 47GradNord - Agentur für Internetlösungen
 *
 * @license    commercial
 * @author     Holger Neuner
 */


namespace Vrpayment\ContaoIsotopeBundle\Api;


use Doctrine\DBAL\Connection;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Vrpayment\ContaoIsotopeBundle\Http\Guzzle;

class ApiManager
{
    use LoggerAwareTrait;

    /**
     * @var Connection
     */
    protected $connection;

    /** @var string */
    protected $token;

    /** @var LoggerInterface */
    protected $logger;


    public function __construct(Connection $connection, LoggerInterface $logger)
    {
        $this->connection = $connection;

        if ($logger) {
            $this->setLogger($logger);
        }
        $this->logger = $logger;
    }

    public function initializeWithToken(string $token, bool $debugmode = false)
    {
        $this->setToken($token);
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return ApiManager
     */
    public function setToken(string $token): ApiManager
    {
        $this->token = $token;
        return $this;
    }

    /**
     * Log message.
     *
     * @param string $message
     * @param array  $data
     * @param string $type
     */
    protected function log(string $message, array $data = [], $type = LogLevel::INFO)
    {
        if ($this->logger) {
            $this->logger->$type($message, $data);
        }
    }

    protected function sendRequest(string $url, string $data, string $token)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer '.$token));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);

        return $responseData;
    }
}
