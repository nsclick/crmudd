<?php
// created: 2014-05-07 19:17:38
$viewdefs = array (
  'Accounts' => 
  array (
    'DetailView' => 
    array (
      'templateMeta' => 
      array (
        'form' => 
        array (
          'buttons' => 
          array (
            0 => 'EDIT',
            1 => 'DUPLICATE',
            2 => 'DELETE',
            3 => 'FIND_DUPLICATES',
            'AOS_GENLET' => 
            array (
              'customCode' => '<input type="button" class="button" onClick="showPopup();" value="{$APP.LBL_GENERATE_LETTER}">',
            ),
          ),
        ),
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
        'includes' => 
        array (
          0 => 
          array (
            'file' => 'modules/Accounts/Account.js',
          ),
        ),
        'useTabs' => false,
        'tabDefs' => 
        array (
          'LBL_ACCOUNT_INFORMATION' => 
          array (
            'newTab' => false,
            'panelDefault' => 'expanded',
          ),
          'LBL_EDITVIEW_PANEL1' => 
          array (
            'newTab' => false,
            'panelDefault' => 'expanded',
          ),
          'LBL_EDITVIEW_PANEL2' => 
          array (
            'newTab' => false,
            'panelDefault' => 'expanded',
          ),
          'LBL_EDITVIEW_PANEL3' => 
          array (
            'newTab' => false,
            'panelDefault' => 'expanded',
          ),
          'LBL_EDITVIEW_PANEL4' => 
          array (
            'newTab' => false,
            'panelDefault' => 'expanded',
          ),
        ),
      ),
      'panels' => 
      array (
        'lbl_account_information' => 
        array (
          0 => 
          array (
            0 => 
            array (
              'name' => 'name',
              'comment' => 'Name of the Company',
              'label' => 'LBL_NAME',
              'displayParams' => 
              array (
              ),
            ),
          ),
          1 => 
          array (
            0 => 
            array (
              'name' => 'jjwg_maps_address_c',
              'label' => 'LBL_JJWG_MAPS_ADDRESS',
            ),
            1 => 
            array (
              'name' => 'phone_office',
              'comment' => 'The office phone number',
              'label' => 'LBL_PHONE_OFFICE',
            ),
          ),
          2 => 
          array (
            0 => 
            array (
              'name' => 'email1',
              'studio' => 'false',
              'label' => 'LBL_EMAIL',
            ),
            1 => 
            array (
              'name' => 'city_c',
              'label' => 'LBL_CITY',
            ),
          ),
          3 => 
          array (
            0 => 
            array (
              'name' => 'rut_c',
              'label' => 'LBL_RUT',
            ),
          ),
          4 => 
          array (
            0 => 
            array (
              'name' => 'description',
              'comment' => 'Full text of the note',
              'label' => 'LBL_DESCRIPTION',
            ),
          ),
        ),
        'lbl_editview_panel1' => 
        array (
          0 => 
          array (
            0 => 
            array (
              'name' => 'account_diplomaed_seller_c',
              'studio' => 'visible',
              'label' => 'LBL_ACCOUNT_DIPLOMAED_SELLER_C ',
            ),
            1 => 
            array (
              'name' => 'account_postgraduate_seller__c',
              'studio' => 'visible',
              'label' => 'LBL_ACCOUNT_POSTGRADUATE_SELLER_',
            ),
          ),
        ),
        'lbl_editview_panel2' => 
        array (
          0 => 
          array (
            0 => 
            array (
              'name' => 'profession_c',
              'label' => 'LBL_PROFESSION',
            ),
            1 => 
            array (
              'name' => 'alumnus_c',
              'label' => 'LBL_ALUMNUS',
            ),
          ),
          1 => 
          array (
            0 => 
            array (
              'name' => 'university_c',
              'label' => 'LBL_UNIVERSITY',
            ),
            1 => '',
          ),
        ),
        'lbl_editview_panel3' => 
        array (
          0 => 
          array (
            0 => 
            array (
              'name' => 'company_c',
              'label' => 'LBL_COMPANY',
            ),
            1 => '',
          ),
          1 => 
          array (
            0 => 
            array (
              'name' => 'job_c',
              'label' => 'LBL_JOB',
            ),
            1 => 
            array (
              'name' => 'employees',
              'comment' => 'Number of employees, varchar to accomodate for both number (100) or range (50-100)',
              'label' => 'LBL_EMPLOYEES',
            ),
          ),
          2 => 
          array (
            0 => 
            array (
              'name' => 'account_type',
              'comment' => 'The Company is of this type',
              'label' => 'LBL_TYPE',
            ),
            1 => 
            array (
              'name' => 'industry',
              'comment' => 'The company belongs in this industry',
              'label' => 'LBL_INDUSTRY',
            ),
          ),
          3 => 
          array (
            0 => 
            array (
              'name' => 'own_buiseness_c',
              'label' => 'LBL_OWN_BUISENESS',
            ),
            1 => 
            array (
              'name' => 'ownership',
              'comment' => '',
              'label' => 'LBL_OWNERSHIP',
            ),
          ),
          4 => 
          array (
            0 => 
            array (
              'name' => 'parent_name',
              'label' => 'LBL_MEMBER_OF',
            ),
            1 => 
            array (
              'name' => 'annual_revenue',
              'comment' => 'Annual revenue for this company',
              'label' => 'LBL_ANNUAL_REVENUE',
            ),
          ),
        ),
        'lbl_editview_panel4' => 
        array (
          0 => 
          array (
            0 => 
            array (
              'name' => 'assigned_user_name',
              'label' => 'LBL_ASSIGNED_TO',
            ),
          ),
        ),
      ),
    ),
  ),
);