<?php 
 //WARNING: The contents of this file are auto-generated



$dictionary['Meeting']['fields']['name']['name'] = 'name';
$dictionary['Meeting']['fields']['name']['type'] = 'enum';
$dictionary['Meeting']['fields']['name']['options'] = 'meetings_name_list_c';

 


 // created: 2014-05-06 15:18:20

 

 // created: 2014-05-06 15:18:20

 

 // created: 2014-05-06 15:18:20

 


$dictionary['Meeting']['fields']['SecurityGroups'] = array (
  	'name' => 'SecurityGroups',
    'type' => 'link',
	'relationship' => 'securitygroups_meetings',
	'module'=>'SecurityGroups',
	'bean_name'=>'SecurityGroup',
    'source'=>'non-db',
	'vname'=>'LBL_SECURITYGROUPS',
);






 // created: 2014-05-06 15:18:20

 
?>