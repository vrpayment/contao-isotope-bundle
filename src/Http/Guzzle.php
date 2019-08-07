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

use GuzzleHttp\Client;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

class Guzzle extends Client implements AdapterInterface
{
    use LoggerAwareTrait;

    const API_ENDPOINT = 'https://vr-pay-ecommerce.de/v1/';
    const API_ENDPOINT_DEBUG = 'https://test.vr-pay-ecommerce.de/v1/';

    const ADAPTER_CONFIG_KEY = 'adapter_config';

    /** @var array */
    private $config;

    public function __construct(LoggerInterface $logger, array $config = [], bool $debugMode = false)
    {
        $adapterConfig = [
            'base_uri' => (!$debugMode) ? self::API_ENDPOINT : self::API_ENDPOINT_DEBUG,
        ];

        if (isset($config[self::ADAPTER_CONFIG_KEY]) && \is_array($config[self::ADAPTER_CONFIG_KEY])) {
            $adapterConfig = array_merge($adapterConfig, $config[self::ADAPTER_CONFIG_KEY]);
        }

        parent::__construct($adapterConfig);

        $this->configure($config);

        if ($logger) {
            $this->setLogger($logger);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function action(string $method, string $path, array $data = [])
    {
        $this->log("Request via \"{$method}\" on \"{$path}\"");

        if (!empty($data)) {
            $this->log('Request data.', ['request' => $data]);
        }

        try {
            $response = $this->request(
                $method,
                $path,
                [
                    'headers' => [
                        'Authorization' => "Bearer {$this->getAccessToken()}",
                        'Accept' => 'application/json',
                    ],
                    'json' => $data,
                ]
            );
            $data = json_decode(
                $response->getBody()->getContents(),
                true
            );
            $this->log('Response data.', ['response' => $data]);
        } catch (ClientException $e) {
            $data = json_decode(
                $e->getResponse()->getBody()->getContents(),
                true
            );
            $this->log(
                'Response data.',
                [
                    'response' => $data,
                ],
                LogLevel::ERROR
            );
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getAccessToken()
    {
        return $this->getConfig('access_token');
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig($key = null)
    {
        if (null !== $key) {
            if (self::ADAPTER_CONFIG_KEY === $key) {
                return parent::getConfig();
            }

            return $this->config[$key] ?? parent::getConfig($key);
        }

        return array_merge(
            $this->config,
            [
                self::ADAPTER_CONFIG_KEY => parent::getConfig(),
            ]
        );
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

    /**
     * Configure defaults.
     *
     * @param array $config
     */
    private function configure(array $config)
    {
        $this->config = [
            'access_token' => $config['access_token'] ?? null,
        ];
    }
}
