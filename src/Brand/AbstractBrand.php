<?php

/*
 * VR Payment GmbH Contao Isotope Bundle
 *
 * @copyright  Copyright (c) 2019-2019, VR Payment GmbH
 * @author     VR Payment GmbH <info@vr-payment.de>
 *
 * @license LGPL-3.0-or-later
 */

namespace Vrpayment\ContaoIsotopeBundle\Brand;

use Isotope\Interfaces\IsotopeOrderableCollection;
use Isotope\Model\ProductCollectionItem;
use Isotope\Model\TaxRate;

abstract class AbstractBrand implements BrandInterface
{
    /** @var IsotopeOrderableCollection */
    protected $order;

    /**
     * @return string
     */
    protected function getEntityId()
    {
        return $this->order->getPaymentMethod()->vrpayment_entityid;
    }

    /**
     * @return float
     */
    protected function getAmount()
    {
        return number_format($this->order->getTotal(), 2);
    }

    /**
     * @return string
     */
    protected function getCurrency()
    {
        return $this->order->getCurrency();
    }

    /**
     * @return string
     */
    protected function getPaymentBrand()
    {
        return $this->order->getPaymentMethod()->vrpayment_brand;
    }

    /**
     * @return string
     */
    protected function getPaymentType()
    {
        return $this->order->getPaymentMethod()->vrpayment_type;
    }

    /**
     * @return \Isotope\Model\Address|null
     */
    protected function getBillingAddress()
    {
        return $this->order->getBillingAddress();
    }

    /**
     * @return \Isotope\Model\Address|null
     */
    protected function getShippingAddress()
    {
        return $this->order->getShippingAddress();
    }

    protected function getCartItems()
    {
        $cartItems = '';

        $count = 0;

        /** @var ProductCollectionItem $item */
        foreach ($this->order->getItems() as $key => $item) {
            $cartItems .= '&cart.items['.$count.'].name='.$item->getName().
                '&cart.items['.$count.'].merchantItemId='.$item->getSku().
                '&cart.items['.$count.'].price='.number_format($item->getPrice(), 2).
                '&cart.items['.$count.'].quantity='.$item->quantity.
                '&cart.items['.$count.'].totalAmount='.number_format($item->getTotalPrice(), 2).
                '&cart.items['.$count.'].tax='.$this->getTaxRatePerCartItemFormatted($item).
                '&cart.items['.$count.'].totalTaxAmount='.$this->getTotalTaxAmount($item);

            ++$count;
        }

        return $cartItems;
    }

    /**
     * @param $array
     */
    protected function getPaymentFormCheckoutId($array)
    {
        if ('000.200.100' === $array['result']['code']) {
            return $array['id'];
        }

        return false;
    }

    /**
     * @param ProductCollectionItem $item
     *
     * @return float
     */
    private function getTaxRatePerCartItemFormatted(ProductCollectionItem $item)
    {
        if (!$item->hasProduct()) {
            return 0.0;
        }

        $objProduct = $item->getProduct();
        $price = $objProduct->getPrice();
        $objTaxClass = $price->getRelated('tax_class');

        /** @var TaxRate $taxRate */
        $taxRate = $objTaxClass->getRelated('includes');

        $rate = explode('.', $taxRate->getAmount());

        return '0.'.$rate[0];
    }

    /**
     * @param ProductCollectionItem $item
     *
     * @return float
     */
    private function getTotalTaxAmount(ProductCollectionItem $item)
    {
        return number_format($item->getTotalPrice() - $item->getTaxFreeTotalPrice(), 2);
    }
}
