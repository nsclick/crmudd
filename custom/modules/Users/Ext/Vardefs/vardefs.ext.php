<?php 
 //WARNING: The contents of this file are auto-generated


 // created: 2014-05-06 19:59:20
$dictionary['User']['fields']['sales_qty_c']['labelValue']='Cantidad de Ventas';

 

 // created: 2014-05-06 20:01:55
$dictionary['User']['fields']['sede_c']['labelValue']='Sede';

 

 // created: 2014-05-06 20:02:37
$dictionary['User']['fields']['tipo_producto_c']['labelValue']='TIpo producto';

 


$dictionary["User"]["fields"]["SecurityGroups"] = array (
    'name' => 'SecurityGroups',
    'type' => 'link',
    'relationship' => 'securitygroups_users',
    'source' => 'non-db',
    'module' => 'SecurityGroups',
    'bean_name' => 'SecurityGroup',
    'vname' => 'LBL_SECURITYGROUPS',
);  
        
$dictionary["User"]["fields"]['securitygroup_noninher_fields'] = array (
    'name' => 'securitygroup_noninher_fields',
    'rname' => 'id',
    'relationship_fields'=>array('id' => 'securitygroup_noninherit_id', 'noninheritable' => 'securitygroup_noninheritable', 'primary_group' => 'securitygroup_primary_group'),
    'vname' => 'LBL_USER_NAME',
    'type' => 'relate',
    'link' => 'SecurityGroups',         
    'link_type' => 'relationship_info',
    'source' => 'non-db',
    'Importable' => false,
    'duplicate_merge'=> 'disabled',

);
        
        
$dictionary["User"]["fields"]['securitygroup_noninherit_id'] = array(
    'name' => 'securitygroup_noninherit_id',
    'type' => 'varchar',
    'source' => 'non-db',
    'vname' => 'LBL_securitygroup_noninherit_id',
);

$dictionary["User"]["fields"]['securitygroup_noninheritable'] = array(
    'name' => 'securitygroup_noninheritable',
    'type' => 'bool',
    'source' => 'non-db',
    'vname' => 'LBL_SECURITYGROUP_NONINHERITABLE',
);

$dictionary["User"]["fields"]['securitygroup_primary_group'] = array(
    'name' => 'securitygroup_primary_group',
    'type' => 'bool',
    'source' => 'non-db',
    'vname' => 'LBL_PRIMARY_GROUP',
);




// created: 2014-05-06 20:09:42
$dictionary["User"]["fields"]["users_aos_products_1"] = array (
  'name' => 'users_aos_products_1',
  'type' => 'link',
  'relationship' => 'users_aos_products_1',
  'source' => 'non-db',
  'module' => 'AOS_Products',
  'bean_name' => 'AOS_Products',
  'vname' => 'LBL_USERS_AOS_PRODUCTS_1_FROM_AOS_PRODUCTS_TITLE',
);


 // created: 2014-05-06 20:08:49
$dictionary['User']['fields']['receive_sales_c']['labelValue']='Recibe Cotización';

 
?>