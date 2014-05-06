<?php
if ( !defined ( 'sugarEntry' ) || !sugarEntry ) die ( 'Not a valid entry point.' );

global $current_user, $app_list_strings, $app_strings;

require_once ( 'helper.php' );
$helper = new ExecutivePanelHelper();

// View Variables
$assets	= 'custom/udd/assets/';
$title 	= 'Panel de Administraci&oacute;n';

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
			case 'save_quote':
				$response = $helper->save_quote ( $ngQuery['quote'] );
				break;
			case 'save_vendor':
				$response = $helper->save_vendor ( $ngQuery['vendor'] );
				// $response = array(
				// 	'twelve'	=> 12,
				// 	'v'			=> $ngQuery['vendor'],
				// 	'm'			=> $helper->save_vendor ( $ngQuery['vendor'] )
				// );
				break;
			case 'list_vendors':
				$response = $helper->get_vendors();
				break;
			case 'get_vendor':

				break;
			case 'list_courses':
				$response = $helper->get_courses();
				break;
		}
	}

	echo json_encode($response);
} else {
	/**
	 * View Drawing
	 */
	 
	 $executives 	= $helper->get_vendors();
	 $courses 		= $helper->get_courses();
	 $sedes 		= $app_list_strings['account_sede_c'];
	 
	 ob_start();
	 require_once ( 'view.php' );
	 $view = ob_get_contents();
	 
	 ob_end_flush();
	 ob_end_clean();
	 
	 echo $view;
}
die;

?>