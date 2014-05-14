<?php
 // created: 2014-05-06 20:09:42
$layout_defs["Users"]["subpanel_setup"]['users_aos_products_1'] = array (
  'order' => 100,
  'module' => 'AOS_Products',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_USERS_AOS_PRODUCTS_1_FROM_AOS_PRODUCTS_TITLE',
  'get_subpanel_data' => 'users_aos_products_1',
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopButtonQuickCreate',
    ),
    1 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'mode' => 'MultiSelect',
    ),
  ),
);
