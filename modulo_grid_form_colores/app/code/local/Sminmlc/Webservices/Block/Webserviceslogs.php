<?php
class Sminmlc_Webservices_Block_Webserviceslogs extends Mage_Core_Block_Template
{
	//Return TOTAL last errors in logs from yesterday
    public function getLatestLogs()
    {
    	$model = Mage::getModel('sminmlc_webservices/webservices');
        $collection = $model->getCollection()->addFieldToFilter('date', array('from' => $this->yesterday(), 'to' => date('Y-m-d h:i:s')));
		return $collection;
    }
	//Return last orders from yesterday
	public function getLatestOrders(){
		$orders = Mage::getModel('sales/order')->getCollection()->addAttributeToFilter('created_at', array('from'=> $this->yesterday(), 'to'=> date('Y-m-d h:i:s')));
		return $orders;
	}
	//Return TOTAL size from collection
	public function getSizeCollection($col){
		return $col->getSize();
	}
	//Return yesterday date
	public function yesterday(){
		return date('Y-m-d h:i:s', strtotime('-1 day'));
	}
}
