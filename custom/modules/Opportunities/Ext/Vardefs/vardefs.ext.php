<?php 
 //WARNING: The contents of this file are auto-generated


 // created: 2014-05-06 15:18:20

 

 // created: 2014-05-06 15:18:20

 


$dictionary['Opportunity']['fields']['SecurityGroups'] = array (
  	'name' => 'SecurityGroups',
    'type' => 'link',
	'relationship' => 'securitygroups_opportunities',
	'module'=>'SecurityGroups',
	'bean_name'=>'SecurityGroup',
    'source'=>'non-db',
	'vname'=>'LBL_SECURITYGROUPS',
);






 // created: 2014-05-06 19:08:29
$dictionary['Opportunity']['fields']['telefono_opp_c']['labelValue']='Teléfono';

 

 // created: 2014-05-06 19:16:30
$dictionary['Opportunity']['fields']['lost_reason_c']['labelValue']='Razón de Pérdida';

 

 // created: 2014-05-06 15:18:20

 

 // created: 2014-05-06 19:17:28
$dictionary['Opportunity']['fields']['lost_reason_description_c']['labelValue']='Descripción de Razón de Pérdida';

 

 // created: 2014-05-06 19:18:19
$dictionary['Opportunity']['fields']['validated_c']['labelValue']='Validado';

 

 // created: 2014-05-06 19:19:14

 

 // created: 2014-05-06 19:18:44
$dictionary['Opportunity']['fields']['audited_c']['labelValue']='Auditado';

 

$dictionary["Opportunity"]["fields"]["aos_quotes"] = array (
  'name' => 'aos_quotes',
    'type' => 'link',
    'relationship' => 'opportunity_aos_quotes',
    'module'=>'AOS_Quotes',
    'bean_name'=>'AOS_Quotes',
    'source'=>'non-db',
);

$dictionary["Opportunity"]["relationships"]["opportunity_aos_quotes"] = array (
	'lhs_module'=> 'Opportunities', 
	'lhs_table'=> 'opportunities', 
	'lhs_key' => 'id',
	'rhs_module'=> 'AOS_Quotes', 
	'rhs_table'=> 'aos_quotes', 
	'rhs_key' => 'opportunity_id',
	'relationship_type'=>'one-to-many',
);

$dictionary["Opportunity"]["fields"]["aos_contracts"] = array (
  'name' => 'aos_contracts',
    'type' => 'link',
    'relationship' => 'opportunity_aos_contracts',
    'module'=>'AOS_Contracts',
    'bean_name'=>'AOS_Contracts',
    'source'=>'non-db',
);

$dictionary["Opportunity"]["relationships"]["opportunity_aos_contracts"] = array (
	'lhs_module'=> 'Opportunities', 
	'lhs_table'=> 'opportunities', 
	'lhs_key' => 'id',
	'rhs_module'=> 'AOS_Contracts', 
	'rhs_table'=> 'aos_contracts', 
	'rhs_key' => 'opportunity_id',
	'relationship_type'=>'one-to-many',
);



 // created: 2014-05-06 19:19:14
$dictionary['Opportunity']['fields']['opp_product_c']['labelValue']='Producto destacado';

 

 // created: 2014-05-06 19:19:56
$dictionary['Opportunity']['fields']['vendor_actions_c']['labelValue']='Acciones de Venta:';

 

 // created: 2014-05-06 15:18:20

 

 // created: 2014-05-06 19:20:57
$dictionary['Opportunity']['fields']['email_opp_c']['labelValue']='Email';

 
?>