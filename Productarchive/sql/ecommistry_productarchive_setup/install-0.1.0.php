<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$attr = Mage::getModel('catalog/resource_eav_attribute')
    ->loadByCode('catalog_product', 'archive');

if (!$attr->getId()) {
    $installer->addAttribute('catalog_product', 'archive', array(
        'type' => 'int',
        'label' => 'Archive',
        'input' => 'boolean',
        'class' => '',
        'source' => 'eav/entity_attribute_source_boolean',
        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
        'visible' => 1,
        'required' => 0,
        'user_defined' => 1,
        'default' => null,
        'searchable' => 0,
        'filterable' => 0,
        'comparable' => 0,
        'visible_on_front' => 0,
        'unique' => 0,
        'position' => 0,
        'group' => 'General',
    ));
}

$attr = Mage::getModel('catalog/resource_eav_attribute')
    ->loadByCode('catalog_product', 'url_to_redirect_to');

if (!$attr->getId()) {
    $installer->addAttribute('catalog_product', 'url_to_redirect_to', array(
        'type' => 'varchar',
        'label' => 'URL to redirect',
        'input' => 'text',
        'class' => '',
        'source' => null,
        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
        'visible' => 1,
        'required' => 0,
        'user_defined' => 1,
        'default' => null,
        'searchable' => 0,
        'filterable' => 0,
        'comparable' => 0,
        'visible_on_front' => 0,
        'unique' => 0,
        'position' => 0,
        'group' => 'General',
        'note' => "Please enter either relative or absolute url. Example: 'http://www.domain.com/redirect_to_url' or just 'redirect_to_url'.
    		If there is no value for this field and Archive = Yes, then this will redirect to product's category page."
    ));
}
$installer->endSetup();