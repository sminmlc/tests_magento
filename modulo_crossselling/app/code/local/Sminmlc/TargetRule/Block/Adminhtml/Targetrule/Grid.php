<?php
/**
 * @author    Marc López - Sminmlc
 * @package     Sminmlc_TargetRule
 */

/**
 * Admin Targer Rules Grid
 */
class Sminmlc_TargetRule_Block_Adminhtml_Targetrule_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('TargetRuleGrid');
        $this->setDefaultSort('sort_order');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * Prepare grid collection object
     *
     * @return Sminmlc_TargetRule_Block_Adminhtml_Targetrule_Grid
     */
    protected function _prepareCollection()
    {
        /* @var $collection Sminmlc_TargetRule_Model_Mysql4_Rule_Collection */
        $collection = Mage::getModel('sminmlc_targetrule/rule')
            ->getCollection();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * Get grid URL
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }

    /**
     * Retrieve URL for Row click
     *
     * @param Varien_Object $row
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array(
            'id'    => $row->getId()
        ));
    }

    /**
     * Define grid columns
     *
     * @return Sminmlc_TargetRule_Block_Adminhtml_Targetrule_Grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn('rule_id', array(
            'header'    => Mage::helper('sminmlc_targetrule')->__('ID'),
            'index'     => 'rule_id',
            'type'      => 'text',
            'width'     => 20,
        ));

        $this->addColumn('name', array(
            'header'    => Mage::helper('sminmlc_targetrule')->__('Rule Name'),
            'index'     => 'name',
            'type'      => 'text',
            'escape'    => true
        ));

        $this->addColumn('from_date', array(
            'header'    => Mage::helper('sminmlc_targetrule')->__('Date Start'),
            'index'     => 'from_date',
            'type'      => 'date',
            'default'   => '--',
            'width'     => 160,
        ));

        $this->addColumn('to_date', array(
            'header'    => Mage::helper('sminmlc_targetrule')->__('Date Expire'),
            'index'     => 'to_date',
            'type'      => 'date',
            'default'   => '--',
            'width'     => 160,
        ));

        $this->addColumn('sort_order', array(
            'header'    => Mage::helper('sminmlc_targetrule')->__('Priority'),
            'index'     => 'sort_order',
            'type'      => 'text',
            'width'     => 1,
        ));

        $this->addColumn('apply_to', array(
            'header'    => Mage::helper('sminmlc_targetrule')->__('Applies To'),
            'align'     => 'left',
            'index'     => 'apply_to',
            'type'      => 'options',
            'options'   => Mage::getSingleton('sminmlc_targetrule/rule')->getAppliesToOptions(),
            'width'     => 150,
        ));

        $this->addColumn('is_active', array(
            'header'    => Mage::helper('sminmlc_targetrule')->__('Status'),
            'align'     => 'left',
            'index'     => 'is_active',
            'type'      => 'options',
            'options'   => array(
                1 => Mage::helper('sminmlc_targetrule')->__('Active'),
                0 => Mage::helper('sminmlc_targetrule')->__('Inactive'),
            ),
            'width'     => 1,
        ));

        return $this;
    }
}
