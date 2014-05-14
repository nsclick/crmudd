<?php 
 //WARNING: The contents of this file are auto-generated


global $mod_strings, $app_strings, $sugar_config;

if(ACLController::checkAccess('Opportunities','edit',true)) {
	$module_menu[]=  array(
		"index.php?entryPoint=executivePanel",
		"Panel de Asignaci&oacute;n de Oportunidades",
		"Import"
	);

}

if(ACLController::checkAccess('Opportunities','delete',true)) {
	$module_menu[]=  array(
		"index.php?entryPoint=administracion",
		"Panel de Administraci&oacute;n",
		"Import"
	);

}


?>