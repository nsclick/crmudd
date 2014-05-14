<?php
$listViewDefs ['AOS_Products'] = 
array (
  'NAME' => 
  array (
    'width' => '15%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'CODIGO_C' => 
  array (
    'type' => 'varchar',
    'default' => true,
    'label' => 'LBL_CODIGO',
    'width' => '10%',
  ),
  'SEDE_C' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_SEDE_C',
    'width' => '10%',
  ),
  'TYPE' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_TYPE',
    'width' => '10%',
  ),
  'PRICE' => 
  array (
    'width' => '10%',
    'label' => 'LBL_PRICE',
    'currency_format' => true,
    'default' => true,
  ),
  'AOS_PRODUCT_CATEGORY_NAME' => 
  array (
    'type' => 'relate',
    'studio' => 'visible',
    'label' => 'LBL_AOS_PRODUCT_CATEGORYS_NAME',
    'id' => 'AOS_PRODUCT_CATEGORY_ID',
    'link' => true,
    'width' => '10%',
    'default' => true,
    'related_fields' => 
    array (
      0 => 'aos_product_category_id',
    ),
  ),
  'DATE_ENTERED' => 
  array (
    'width' => '5%',
    'label' => 'LBL_DATE_ENTERED',
    'default' => true,
  ),
  'CREATED_BY_NAME' => 
  array (
    'width' => '10%',
    'label' => 'LBL_CREATED',
    'default' => false,
    'module' => 'Users',
    'link' => true,
    'id' => 'CREATED_BY',
  ),
  'COST' => 
  array (
    'width' => '10%',
    'label' => 'LBL_COST',
    'currency_format' => true,
    'default' => false,
  ),
);
?>
