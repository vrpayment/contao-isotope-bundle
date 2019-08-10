<?php

/*
 * VR Payment GmbH Contao Isotope Bundle
 *
 * @copyright  Copyright (c) 2019-2019, VR Payment GmbH
 * @author     VR Payment GmbH <info@vr-payment.de>
 *
 * @license LGPL-3.0-or-later
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
