<?php
class Sminmlc_Webservices_Block_Adminhtml_Errors_Grid_Renderer_Orderidcolumn extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row) {
        $value =  $row->getData($this->getColumn()->getIndex());
        $order = Mage::getModel('sales/order')->loadByIncrementId($value);
        return '<a href="' . $this->getUrl('adminhtml/sales_order/view', array('order_id' => $order->getId(), 'key' => $this->getCacheKey())) . '" target="_blank" title="' . $value . '" >' . $value . '</a>';
    }
}
