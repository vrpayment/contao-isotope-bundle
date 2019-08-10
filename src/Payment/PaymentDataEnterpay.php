<?php

/*
 * VR Payment GmbH Contao Isotope Bundle
 *
 * @copyright  Copyright (c) 2019-2019, VR Payment GmbH
 * @author     VR Payment GmbH <info@vr-payment.de>
 *
 * @license LGPL-3.0-or-later
 */

namespace Vrpayment\ContaoIsotopeBundle\Payment;

use Isotope\Interfaces\IsotopeOrderableCollection;
use Isotope\Model\ProductCollection\Order;
use Isotope\Model\ProductCollectionItem;
use Vrpayment\ContaoIsotopeBundle\Entity\CardItem;
use Vrpayment\ContaoIsotopeBundle\Entity\PaymentData;

class PaymentDataEnterpay extends AbstractPaymentData implements PaymentDataInterface
{
    /** @var PaymentData */
    protected $paymentData;
    /**
     * @var Order
     */
    private $order;

    public function __construct(IsotopeOrderableCollection $order)
    {
        $this->order = $order;
        $this->setPaymentData();
    }

    /**
     * @return PaymentData
     */
    public function getPaymentData(): PaymentData
    {
        return $this->paymentData;
    }

    /**
     * @return PaymentData
     */
    public function setPaymentData(): self
    {
        /** @var PaymentData $paymentData */
        $paymentData = new PaymentData();
        $paymentData->setCustomParametersMerchantId($this->order->getUniqueId());
        $paymentData->setEntityId($this->order->getPaymentMethod()->vrpayment_entityid);
        $paymentData->setCurrenty($this->order->getCurrency());
        $paymentData->setPaymentBrand('ENTERPAY');
        $paymentData->setPaymentType('PA');
        $paymentData->setBillingCity($this->order->getBillingAddress()->city);
        $paymentData->setBillingPostcode($this->order->getBillingAddress()->postal);
        $paymentData->setBillingStreet1($this->order->getBillingAddress()->street_1);
        $paymentData->setShippingCity($this->order->getShippingAddress()->city);
        $paymentData->setShippingPostcode($this->order->getShippingAddress()->postal);
        $paymentData->setShippingStreet1($this->order->getShippingAddress()->street_1);
        $paymentData->setShopperResultUrl('url');

        $cardItems = [];

        foreach ($this->order->getItems() as $productCollectionItem) {
            $cardItems[] = $this->getItem($productCollectionItem);
        }

        $paymentData->setCardItems($cardItems);

        $this->paymentData = $paymentData;

        return $this;
    }

    public function getRequestString()
    {
        return '';
    }

    protected function getItem(ProductCollectionItem $item)
    {
        $cartItem = new CardItem();
        $cartItem->setName($item->getName());
        $cartItem->setName($item->id);
        $cartItem->setPrice($item->getPrice());
        $cartItem->setQuantity($item->quantity);
        $cartItem->setTotalAmount($item->getTaxFreeTotalPrice());
        $cartItem->setTax('0.19');
        $cartItem->setTotalTaxAmount($item->getTotalPrice());

        return $cartItem;
    }
}
