<?php


namespace Ghratzoo\DeliveryTime\viewModel;


use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class DeliveryTime implements ArgumentInterface
{

    private const DELIVERY_TIME_PREFIX = "Delivery time: ";

    /**
     * @var Registry
     */
    protected Registry $registry;

    /**
     * DeliveryTime constructor.
     * @param Registry $registry
     */
    public function __construct(Registry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @return string
     */
    public function getDeliveryTime(): string
    {
        $stock = $this->getStockState();
        if ($stock >= 0 && $stock <= 10) {
            $timeDelivery = "2 weeks";
        } else if ($stock > 10 && $stock <= 20) {
            $timeDelivery = "48 hours";
        } else {
            $timeDelivery = "24 hours";
        }

        return self::DELIVERY_TIME_PREFIX . $timeDelivery;
    }

    /**
     * @return ProductInterface
     */
    private function getProduct(): ProductInterface
    {
        return $this->registry->registry('product');
    }

    /**
     * @return int
     */
    private function getStockState(): int
    {
        return (int) $this->getProduct()->getExtensionAttributes()->getStockItem()->getQty();
    }
}
