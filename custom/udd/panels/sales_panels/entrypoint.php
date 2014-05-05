<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

global $current_user;

require_once ( 'model.php' );
$model = new SalesPanel_Model ();

// View Variables
$assets	= 'custom/udd/assets/';
$title 	= 'Administraci&oacute;n de Vendedores';

$ngQuery = json_decode ( file_get_contents( 'php://input' ), true );

if ( !empty ( $ngQuery ) ) {
	/**
	 * AJAX request handling
	 */
	header('Content-Type: application/json');
	$response = array();
	$response['success'] = false;
	
	if ( isset ( $ngQuery['action'] ) ) {
		switch ( $ngQuery['action'] ) {
			case 'save_vendor':
				$response = $model->save_vendor ( $ngQuery['vendor'] );
				// $response = array(
				// 	'twelve'	=> 12,
				// 	'v'			=> $ngQuery['vendor'],
				// 	'm'			=> $model->save_vendor ( $ngQuery['vendor'] )
				// );
				break;
			case 'list_vendors':
				$response = $model->get_vendors();
				break;
			case 'get_vendor':

				break;
			case 'list_courses':
				$response = $model->get_courses();
				break;
		}
	}

	echo json_encode($response);
} else {
	$vendors = $model->get_vendors( $current_user );
	$courses = $model->get_courses( $current_user );

	ob_start();
	require_once ( 'view.php' );

	$view = ob_get_contents();
	ob_end_flush();
	ob_end_clean();

	echo $view;
}
die;
?>