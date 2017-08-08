<?php
class Sminmlc_Webservices_Block_Adminhtml_Errors_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
         
        // Set some defaults for our grid
        $this->setDefaultSort('id');
        $this->setId('sminmlc_webservices_errors_grid');
        $this->setDefaultDir('desc');
        $this->setSaveParametersInSession(true);
    }
     
    protected function _getCollectionClass()
    {
        // This is the model we are using for the grid
        return 'sminmlc_webservices/webservices_collection';
    }
     
    protected function _prepareCollection()
    {
        // Get and set our collection for the grid
        $collection = Mage::getResourceModel($this->_getCollectionClass());
        $this->setCollection($collection);
         
        return parent::_prepareCollection();
    }
     
    protected function _prepareColumns()
    {
        // Add the columns that should appear in the grid
        $this->addColumn('id',
            array(
                'header'=> $this->__('ID'),
                'align' =>'right',
                'width' => '50px',
                'index' => 'id'
            )
        );
        $this->addColumn('increment_id',
            array(
                'header'=> $this->__('Order id'),
                'index' => 'increment_id',
                'renderer'=> 'Sminmlc_Webservices_Block_Adminhtml_Errors_Grid_Renderer_Orderidcolumn',
            )
        );
        
        $this->addColumn('date',
            array(
                'header'=> $this->__('Date'),
                'index' => 'date'
            )
        );
        $this->addColumn('priority',
            array(
                'header'=> $this->__('Priority'),
                'index' => 'priority',
                'renderer'=> 'Sminmlc_Webservices_Block_Adminhtml_Errors_Grid_Renderer_Prioritycolumn',
            )
        );
        $this->addColumn('ws_method',
            array(
                'header'=> $this->__('WS Method'),
                'index' => 'ws_method'
            )
        );
        $this->addColumn('customer',
            array(
                'header'=> $this->__('Customer'),
                'index' => 'customer'
            )
        );
        $this->addColumn('desc_error',
            array(
                'header'=> $this->__('Description'),
                'index' => 'desc_error'
            )
        );
         
        return parent::_prepareColumns();
    }
     
    public function getRowUrl($row)
    {
        // This is where our row data will link to
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}
