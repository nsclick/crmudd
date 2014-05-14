<?php
$viewdefs ['Users'] = 
array (
  'DetailView' => 
  array (
    'templateMeta' => 
    array (
      'maxColumns' => '2',
      'widths' => 
      array (
        0 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
        1 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
      ),
      'form' => 
      array (
        'headerTpl' => 'modules/Users/tpls/DetailViewHeader.tpl',
        'footerTpl' => 'modules/Users/tpls/DetailViewFooter.tpl',
      ),
      'useTabs' => false,
      'tabDefs' => 
      array (
        'LBL_USER_INFORMATION' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_EMPLOYEE_INFORMATION' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
    ),
    'panels' => 
    array (
      'LBL_USER_INFORMATION' => 
      array (
        0 => 
        array (
          0 => 'user_name',
          1 => 
          array (
            'name' => 'first_name',
            'label' => 'LBL_FIRST_NAME',
          ),
        ),
        1 => 
        array (
          0 => 'status',
          1 => 
          array (
            'name' => 'last_name',
            'label' => 'LBL_LAST_NAME',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'UserType',
            'customCode' => '{$USER_TYPE_READONLY}',
          ),
          1 => 'picture',
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'sede_c',
            'studio' => 'visible',
            'label' => 'LBL_SEDE',
          ),
          1 => 
          array (
            'name' => 'receive_sales_c',
            'label' => 'LBL_RECEIVE_SALES',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'sales_qty_c',
            'label' => 'LBL_SALES_QTY',
          ),
          1 => '',
        ),
      ),
      'LBL_EMPLOYEE_INFORMATION' => 
      array (
        0 => 
        array (
          0 => 'employee_status',
          1 => 'show_on_employees',
        ),
        1 => 
        array (
          0 => 'title',
          1 => 'phone_work',
        ),
        2 => 
        array (
          0 => 'department',
          1 => 'phone_mobile',
        ),
        3 => 
        array (
          0 => 'reports_to_name',
          1 => 'phone_other',
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'tipo_producto_c',
            'studio' => 'visible',
            'label' => 'LBL_TIPO_PRODUCTO',
          ),
          1 => 'phone_fax',
        ),
      ),
    ),
  ),
);
?>
