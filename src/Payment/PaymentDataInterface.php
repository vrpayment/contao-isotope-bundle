<?php


namespace Vrpayment\ContaoIsotopeBundle\Payment;


use Vrpayment\ContaoIsotopeBundle\Entity\PaymentData;

interface PaymentDataInterface
{
    public function getPaymentData(): PaymentData;
}
