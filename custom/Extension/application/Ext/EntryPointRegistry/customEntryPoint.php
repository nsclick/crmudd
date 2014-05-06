<?php

$entry_point_registry['webFormEntryPoint'] = array(
	'file'	=> 'custom/modules/Opportunities/entrypoints/ep_web_form.php',
	'auth' 	=> false
);

$entry_point_registry['administracion'] = array(
	'file'	=> 'custom/udd/panels/sales_panels/entrypoint.php',
	'auth'	=> true
);

$entry_point_registry['webForm'] = array(
	'file'	=> 'custom/udd/entrypoints/webform/webform.ep.php',
	'auth'	=> false
);

$entry_point_registry['webForm2'] = array(
	'file'	=> 'custom/udd/entrypoints/webform2/webform.ep.php',
	'auth'	=> false
);

$entry_point_registry['executivePanel'] = array(
	'file'	=> 'custom/udd/panels/executivepanel/entrypoint.ep.php',
	'auth'	=> true
);

?>