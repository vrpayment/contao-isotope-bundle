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
use Psr\Log\LoggerInterface;


class ApiManagerFactory
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public static function createApiManager(Connection $connection, LoggerInterface $logger)
    {
        $apiManager = new ApiManager($connection, $logger);

        return $apiManager;
    }
}
