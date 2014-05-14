<?php
$viewdefs ['Opportunities'] = 
array (
  'EditView' => 
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
      'javascript' => '{$PROBABILITY_SCRIPT}',
      'useTabs' => false,
      'tabDefs' => 
      array (
        'DEFAULT' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_PANEL_ASSIGNMENT' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_EDITVIEW_PANEL1' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_EDITVIEW_PANEL3' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
    ),
    'panels' => 
    array (
      'default' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'name',
          ),
          1 => 'account_name',
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'email_opp_c',
            'label' => 'LBL_EMAIL_OPP',
          ),
          1 => 
          array (
            'name' => 'telefono_opp_c',
            'label' => 'LBL_TELEFONO_OPP',
          ),
        ),
        2 => 
        array (
          0 => 'campaign_name',
          1 => 'opportunity_type',
        ),
        3 => 
        array (
          0 => 'lead_source',
          1 => 
          array (
            'name' => 'opp_product_c',
            'studio' => 'visible',
            'label' => 'LBL_OPP_PRODUCT',
          ),
        ),
        4 => 
        array (
          0 => 'description',
        ),
      ),
      'LBL_PANEL_ASSIGNMENT' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'amount',
          ),
          1 => 
          array (
            'name' => 'date_closed',
          ),
        ),
        1 => 
        array (
          0 => 'sales_stage',
          1 => 
          array (
            'name' => 'vendor_actions_c',
            'studio' => 'visible',
            'label' => 'LBL_VENDOR_ACTIONS',
          ),
        ),
        2 => 
        array (
          0 => 'probability',
          1 => '',
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'lost_reason_c',
            'studio' => 'visible',
            'label' => 'LBL_LOST_REASON',
          ),
          1 => 
          array (
            'name' => 'lost_reason_description_c',
            'studio' => 'visible',
            'label' => 'LBL_LOST_REASON_DESCRIPTION',
          ),
        ),
      ),
      'lbl_editview_panel1' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'validated_c',
            'label' => 'LBL_VALIDATED_C',
          ),
          1 => 
          array (
            'name' => 'audited_c',
            'label' => 'LBL_AUDITED_C',
          ),
        ),
      ),
      'lbl_editview_panel3' => 
      array (
        0 => 
        array (
          0 => 'assigned_user_name',
        ),
      ),
    ),
  ),
);
?>
