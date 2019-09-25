<?php

/*
 * VR Payment GmbH Contao Isotope Bundle
 *
 * @copyright  Copyright (c) 2019-2019, VR Payment GmbH
 * @author     VR Payment GmbH <info@vr-payment.de>
 *
 * @license LGPL-3.0-or-later
 */

namespace Vrpayment\ContaoIsotopeBundle;

use Contao\PageModel;
use Isotope\Interfaces\IsotopeOrderableCollection;
use Isotope\Model\ProductCollectionItem;
use Isotope\Model\ProductCollectionSurcharge\Shipping;
use Isotope\Model\TaxRate;

class Order
{
    /** @var IsotopeOrderableCollection */
    protected $orderableCollection;

    /**
     * Order constructor.
     *
     * @param IsotopeOrderableCollection $orderableCollection
     */
    public function __construct(IsotopeOrderableCollection $orderableCollection)
    {
        $this->orderableCollection = $orderableCollection;
    }

    /**
     * @return string
     */
    public function getPaymentAuthorizationToken()
    {
        return $this->orderableCollection->getPaymentMethod()->vrpayment_token;
    }

    /**
     * @return int
     */
    public function getOrderId()
    {
        return $this->orderableCollection->getId();
    }

    /**
     * @return string
     */
    public function getPaymentEntityId()
    {
        return $this->orderableCollection->getPaymentMethod()->vrpayment_entityid;
    }

    /**
     * @return string
     */
    public function getPaymentBrand()
    {
        return $this->orderableCollection->getPaymentMethod()->vrpayment_brand;
    }

    /**
     * @return string
     */
    public function getPaymentType()
    {
        return $this->orderableCollection->getPaymentMethod()->vrpayment_type;
    }

    /***
     * @param bool $id
     * @return string|int
     */
    public function getPaymentShopperResultUrl($id = false)
    {
        if (!$id) {
            return \Environment::get('url').'/'.PageModel::findByPk($this->orderableCollection->getPaymentMethod()->vrpayment_shopperResultUrl)->alias.'/process.html';
        }

        return $this->orderableCollection->getPaymentMethod()->vrpayment_shopperResultUrl;
    }

    /**
     * @return string
     */
    public function getPaymentMerchantId()
    {
        return $this->orderableCollection->getPaymentMethod()->vrpayment_merchantId;
    }

    /**
     * @return string
     */
    public function getOrderCustomerGivenName()
    {
        return $this->orderableCollection->getMember()->firstname;
    }

    /**
     * @return string
     */
    public function getOrderCustomerSurname()
    {
        return $this->orderableCollection->getMember()->lastname;
    }

    public function getOrderCustomerCompanyName()
    {
        return $this->orderableCollection->getMember()->company;
    }

    /**
     * @return string
     */
    public function getOrderCustomerEmail()
    {
        return $this->orderableCollection->getMember()->email;
    }

    /**
     * @return \Isotope\Model\Address|null
     */
    public function getOrderBillingAddress()
    {
        return $this->orderableCollection->getBillingAddress();
    }

    /**
     * @return \Isotope\Model\Address|null
     */
    public function getOrderShippingAddress()
    {
        return $this->orderableCollection->getShippingAddress();
    }

    /**
     * @return float
     */
    public function getOrderAmount()
    {
        return number_format($this->orderableCollection->getTotal(), 2);
    }

    public function getOrderCurrency()
    {
        return $this->orderableCollection->getCurrency();
    }

    public function getOrderCartItems($addShipping = false)
    {
        $cartItems = '';

        $count = 0;

        /** @var ProductCollectionItem $item */
        foreach ($this->orderableCollection->getItems() as $key => $item) {
            $cartItems .= '&cart.items['.$count.'].name='.$item->getName().
                '&cart.items['.$count.'].merchantItemId='.$item->getSku().
                '&cart.items['.$count.'].price='.$this->getPrice($item).
                '&cart.items['.$count.'].quantity='.$item->quantity.
                '&cart.items['.$count.'].totalAmount='.$this->getTotalAmount($item).
                '&cart.items['.$count.'].tax='.$this->getOrderTaxRatePerCartItemFormatted($item).
                '&cart.items['.$count.'].totalTaxAmount='.$this->getOrderTotalTaxAmount($item);

            ++$count;
        }

        if (!$addShipping) {
            return $cartItems;
        }

        $cartItems .= '&cart.items['.$count.'].name='.$this->orderableCollection->getShippingSurcharge()->label.
            '&cart.items['.$count.'].merchantItemId=S'.$this->orderableCollection->getShippingSurcharge()->source_id.
            '&cart.items['.$count.'].price='.$this->getTotalAmmountShippingSurcharge($this->orderableCollection->getShippingSurcharge()).
            '&cart.items['.$count.'].quantity=1&cart.items['.$count.'].totalAmount='.$this->getTotalAmmountShippingSurcharge($this->orderableCollection->getShippingSurcharge()).
            '&cart.items['.$count.'].tax='.$this->getTaxShippingSurcharge().'&cart.items['.$count.'].totalTaxAmount='.$this->getTotalTaxAmountShippingSurcharge($this->orderableCollection->getShippingSurcharge());

        return $cartItems;
    }

    /**
     * @return bool
     */
    public function getTestmode()
    {
        if ('1' === $this->orderableCollection->getPaymentMethod()->debug) {
            return true;
        }

        false;
    }

    private function getTaxShippingSurcharge()
    {
        // Price net
        if ('net' === $this->orderableCollection->getConfig()->priceDisplay) {
            return 0.19;
        }

        // Price gross
        if ('gross' === $this->orderableCollection->getConfig()->priceDisplay) {
            return 0.0;
        }
    }

    private function getTotalAmmountShippingSurcharge(Shipping $shipping)
    {
        // Price net
        if ('net' === $this->orderableCollection->getConfig()->priceDisplay) {
            return number_format(($shipping->total_price * 1.19), 2);
        }

        // Price gross
        if ('gross' === $this->orderableCollection->getConfig()->priceDisplay) {
            return number_format($shipping->total_price, 2);
        }
    }

    private function getTotalTaxAmountShippingSurcharge(Shipping $shipping)
    {
        $bPrice = $this->getTotalAmmountShippingSurcharge($shipping);
        $nPrice = number_format($bPrice / 1.19, 2);

        return $bPrice - $nPrice;
    }

    /**
     * @param ProductCollectionItem $item
     * @param mixed                 $notFormatted
     *
     * @return float
     */
    private function getOrderTaxRatePerCartItemFormatted(ProductCollectionItem $item, $notFormatted = false)
    {
        if (!$item->hasProduct()) {
            return 0.0;
        }

        $objProduct = $item->getProduct();
        $price = $objProduct->getPrice();
        $objTaxClass = $price->getRelated('tax_class');

        /** @var TaxRate $taxRate */
        $taxRate = $objTaxClass->getRelated('includes');

        if ($notFormatted) {
            return $taxRate->getAmount();
        }

        $rate = explode('.', $taxRate->getAmount());

        return '0.'.$rate[0];
    }

    /**
     * @param ProductCollectionItem $item
     *
     * @return float
     */
    private function getOrderTotalTaxAmount(ProductCollectionItem $item)
    {
        $calcMwSt = explode('.', $this->getOrderTaxRatePerCartItemFormatted($item));
        $calcMwSt = '1.'.$calcMwSt[1];

        $bPrice = $this->getPrice($item);
        $nPrice = number_format($this->getPrice($item) / (float) $calcMwSt, 2);

        return number_format($bPrice - $nPrice, 2);
    }

    private function getPrice(ProductCollectionItem $item)
    {
        // Price net
        if ('net' === $this->orderableCollection->getConfig()->priceDisplay) {
            $num = number_format($item->getTotalPrice(), 2);
            $percentage = $this->getOrderTaxRatePerCartItemFormatted($item, true);

            $num += number_format($num * ($percentage / 100), 4);

            return number_format($num, '2');
        }

        // Price gross (Brutto)
        if ('gross' === $this->orderableCollection->getConfig()->priceDisplay) {
            return number_format($item->getTotalPrice(), '2');
        }
    }

    /**
     * @param ProductCollectionItem $item
     *
     * @return string
     */
    private function getTotalAmount(ProductCollectionItem $item)
    {
        // Price net
        if ('net' === $this->orderableCollection->getConfig()->priceDisplay) {
            $num = $item->getTotalPrice();
            $percentage = $this->getOrderTaxRatePerCartItemFormatted($item, true);
            $num += $num * ($percentage / 100);

            return number_format($num, '2');
        }

        // Price gross
        if ('gross' === $this->orderableCollection->getConfig()->priceDisplay) {
            return number_format($item->getTotalPrice(), '2');
        }
    }
}
