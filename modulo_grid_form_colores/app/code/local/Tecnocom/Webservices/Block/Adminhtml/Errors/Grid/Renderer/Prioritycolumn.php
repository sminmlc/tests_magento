<?php
class Sminmlc_Webservices_Block_Adminhtml_Errors_Grid_Renderer_Prioritycolumn extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row) {
        $value =  $row->getData($this->getColumn()->getIndex());
        return '<div class="prioritycolumn '.$value.'">'.$value.'</div>';
    }
}
