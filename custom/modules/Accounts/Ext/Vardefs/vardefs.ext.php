<?php 
 //WARNING: The contents of this file are auto-generated



$dictionary['Account']['fields']['SecurityGroups'] = array (
  	'name' => 'SecurityGroups',
    'type' => 'link',
	'relationship' => 'securitygroups_accounts',
	'module'=>'SecurityGroups',
	'bean_name'=>'SecurityGroup',
    'source'=>'non-db',
	'vname'=>'LBL_SECURITYGROUPS',
);






 // created: 2014-05-06 19:34:10
$dictionary['Account']['fields']['city_c']['labelValue']='Ciudad:';

 

 // created: 2014-05-06 15:18:18

 

 // created: 2014-05-06 19:36:24
$dictionary['Account']['fields']['profession_c']['labelValue']='Profesión:';

 

$dictionary["Account"]["fields"]["aos_quotes"] = array (
  'name' => 'aos_quotes',
    'type' => 'link',
    'relationship' => 'account_aos_quotes',
    'module'=>'AOS_Quotes',
    'bean_name'=>'AOS_Quotes',
    'source'=>'non-db',
);

$dictionary["Account"]["relationships"]["account_aos_quotes"] = array (
	'lhs_module'=> 'Accounts', 
	'lhs_table'=> 'accounts', 
	'lhs_key' => 'id',
	'rhs_module'=> 'AOS_Quotes', 
	'rhs_table'=> 'aos_quotes', 
	'rhs_key' => 'billing_account_id',
	'relationship_type'=>'one-to-many',
);

$dictionary["Account"]["fields"]["aos_invoices"] = array (
  'name' => 'aos_invoices',
    'type' => 'link',
    'relationship' => 'account_aos_invoices',
    'module'=>'AOS_Invoices',
    'bean_name'=>'AOS_Invoices',
    'source'=>'non-db',
);

$dictionary["Account"]["relationships"]["account_aos_invoices"] = array (
	'lhs_module'=> 'Accounts', 
	'lhs_table'=> 'accounts', 
	'lhs_key' => 'id',
	'rhs_module'=> 'AOS_Invoices', 
	'rhs_table'=> 'aos_invoices', 
	'rhs_key' => 'billing_account_id',
	'relationship_type'=>'one-to-many',
);

$dictionary["Account"]["fields"]["aos_contracts"] = array (
  'name' => 'aos_contracts',
    'type' => 'link',
    'relationship' => 'account_aos_contracts',
    'module'=>'AOS_Contracts',
    'bean_name'=>'AOS_Contracts',
    'source'=>'non-db',
);

$dictionary["Account"]["relationships"]["account_aos_contracts"] = array (
	'lhs_module'=> 'Accounts', 
	'lhs_table'=> 'accounts', 
	'lhs_key' => 'id',
	'rhs_module'=> 'AOS_Contracts', 
	'rhs_table'=> 'aos_contracts', 
	'rhs_key' => 'contract_account_id',
	'relationship_type'=>'one-to-many',
);



 // created: 2014-05-06 19:35:58
$dictionary['Account']['fields']['account_diplomaed_seller_c']['labelValue']='Vendedor Diplomado';

 

 // created: 2014-05-06 15:18:18

 

 // created: 2014-05-06 19:36:48
$dictionary['Account']['fields']['university_c']['labelValue']='Universidad';

 

 // created: 2014-05-06 19:38:28
$dictionary['Account']['fields']['own_buiseness_c']['labelValue']='Empresario';

 

 // created: 2014-05-06 19:37:06
$dictionary['Account']['fields']['rut_c']['labelValue']='Rut';

 

 // created: 2014-05-06 15:18:18

 

 // created: 2014-05-06 19:35:57

 

 // created: 2014-05-06 19:37:32
$dictionary['Account']['fields']['company_c']['labelValue']='Compañía';

 

 // created: 2014-05-06 19:35:12

 

 // created: 2014-05-06 19:37:56
$dictionary['Account']['fields']['alumnus_c']['labelValue']='Ex Alumno';

 

 // created: 2014-05-06 15:18:18

 

 // created: 2014-05-06 19:35:12
$dictionary['Account']['fields']['account_postgraduate_seller__c']['labelValue']='Vendedor Postgrado';

 

 // created: 2014-05-06 19:48:05
$dictionary['Account']['fields']['job_c']['labelValue']='Cargo';

 
?>