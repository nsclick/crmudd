<?php
if ( !defined ( 'sugarEntry' ) || !sugarEntry ) die ( 'Not a valid entry point.' );
//error_reporting(E_ALL);
/**
 * Variables
 */
global $current_user;
$response 		= array();
$product_code	= $_GET['product_id'];
$first_name		= $_GET['first_name'];
$last_name		= $_GET['last_name'];
$email			= $_GET['email'];
$phone			= $_GET['phone'];
$sede			= $_GET['sede'];
$campaign_id	= isset ( $_GET['campaign_id'] ) ? $_GET['campaign_id'] : null;

/**
 * Validate required fields
 */
if (
	empty ( $product_code ) 
	|| empty ( $first_name ) 
	|| empty ( $last_name )
	|| empty ( $email )
	|| empty ( $phone )
	|| empty ( $sede )
//	|| empty ( $campaign_id )
) {
	echo json_encode (
		array(
			'success'	=> false,
			'message'	=> 'Missing values'
		)
	);
	die;
}

/**
 * Include WebForm EntryPoint Helper
 */
require_once ( 'webform.helper.ep.php' );

/**
 * Instantiate EntryPoint Helper
 */
$helper = new WebFormEPHelper();
/**
 * Identify account and product
 */
$account 			= $helper->getAccountByEmail ( $email );
$product 			= $helper->getProductByCodeAndSede ( $product_code, $sede );
$product_executives	= $helper->getAllowedExecutivesByProductAndSede ( $product_code, $sede );

if ( empty ( $account ) ) {
	
	// Create Account
	$accountData = array(
		'name'				=> $first_name . ' ' . $last_name,
		'email1'			=> $email,
		'phone_office'		=> $phone,
		// Assign 'Alicia Labra Gray' as the Account assigned user
		'assigned_user_id' => 'e2d9068a-6f18-5461-e675-534dc1aa97c1'
	);

	$account = $helper->createAccount ( $accountData );
	
	// It should be created now, then create a Lead, Contact and Opportunity

	// Create Lead
	$leadData = array(
		'first_name'	=> $first_name,
		'last_name'		=> $last_name,
		'account_name'	=> $account->name,
		'account_id'	=> $account->id,
		'email1'		=> $email,
		'phone_mobile'	=> $phone,
		'status'		=> 'Converted'
	);

	$lead = $helper->createLead ( $leadData );

	// Create Contact
	$contactData = array(
		'first_name'	=> $first_name,
		'last_name'		=> $last_name,
		'account_name'	=> $account->name,
		'account_id'	=> $account->id,
		'email1'		=> $email,
		'phone_mobile'	=> $phone
	);

	$contact = $helper->createContact ( $contactData );
	
}

if ( !empty ( $account ) ) {
	
	/*
	 * Now that Account exists (found or created),
	 * look for opened Opportunities for this Account.
	 */
	$opportunities = $helper->getAccountOpenedOpportunities ( $account );
	
	/**
	 * If there aren't any Opportunities for this Account
	 * then create one and assign the executive with
	 * less sales/opportunties.
	 */
	 if ( empty ( $opportunities ) ) {
	 	$executive	= $product_executives[0];
	 	
	 	/**
		 * If there aren't any opportunities for this Account
		 * then create one and assign the executive with
		 * less sales/opportunties.
		 */
		$opportunityData  	= array(
			'name'				=> 'OP [' . $product->codigo_c . ']',
			'account_id'		=> $account->id,
			'account_name'		=> $account->name,
			'assigned_user_id'	=> $executive->id,
			'amount'			=> $product->cost,
			'date_closed'		=> date ( 'Y-m-d', strtotime ( '+1 month' ) ), // A month as expected close date
			'amount'			=> number_format ( $product->price, 0, '.', '' ),
			'campaign_id'		=> !empty ( $campaign_id ) ? $campaign_id : null,
			'telefono_opp_c'	=> $phone,
			'email_opp_c'		=> $email,
			// Outstanding product
			'aos_products_id_c'	=> $product->id
		);
		
		/**
		 * Let's create the quote for this new Opportunity
		 */
		$quoteData = array(
			'name'					=> 'COT [' . $product->codigo_c . '] ' . $first_name . ' ' . $last_name,
			'billing_account_id'  	=> $account->id,
			'assigned_user_id' 		=> $executive->id,
//			'opportunity_id'		=> $opportunity->id,
			'total_amt'				=> number_format ( $product->price, 0, '.', '' ),
			'subtotal_amount'		=> number_format ( $product->price, 0, '.', '' ),
			'total_amount'			=> number_format ( $product->price, 0, '.', '' ),
			'email_cot_c'			=> $email,
			'telefono_cot_c'		=> $phone,
			'destaque_cot_c'		=> 'destacado'
		);
	 	
	 	
	 	$opportunity = $helper->createOpportunityForExecutive ( $executive, $product, $opportunityData, $quoteData );
	 	
	 	// Increment executive sales counter
		if ( !empty ( $opportunity->id ) ) {
			$executive->sales_qty_c = is_numeric ( $executive->sales_qty_c) ? $executive->sales_qty_c + 1 : 1;
			$executive->save();
		}
	 	
	 }
	/**
	 * If there are Opportunities for this Account
	 * then check if any of the Opportunities assigned Executives
	 * belong to those that can sell this product.
	 */
	else {
		
		$matching_executives 	= array();
		$matching_opportunities = array();
		
		foreach ( $product_executives as $product_executive ) {
			foreach ( $opportunities as $opportunity ) {
				if ( $opportunity->assigned_user_id == $product_executive->id ) {
					$matching_executives[] 		= $product_executive;
					$matching_opportunities[]	= $opportunity;
				}
			}
		}
		
//		foreach ( $matching_executives as $matching_executive ) {
//			$helper->debug ( $matching_executive->first_name );
//		}
//		
//		foreach ( $matching_opportunities as $matching_opportunity ) {
//			$helper->debug ( $matching_opportunity->name );
//		}
//		
//		die;
		
		/**
		 * If there aren't any matching executive then
		 * create a new Opportunity for the Product Executive
		 * with less sales/opportunities.
		 */
		if ( empty ( $matching_executives ) ) {
			$executive	= $product_executives[0];
			
		 	/**
			 * If there aren't any opportunities for this Account
			 * then create one and assign the executive with
			 * less sales/opportunties.
			 */
			$opportunityData  	= array(
				'name'				=> 'OP [' . $product->codigo_c . ']',
				'account_id'		=> $account->id,
				'account_name'		=> $account->name,
				'assigned_user_id'	=> $executive->id,
				'amount'			=> $product->cost,
				'date_closed'		=> date ( 'Y-m-d', strtotime ( '+1 month' ) ), // A month as expected close date
				'amount'			=> number_format ( $product->price, 0, '.', '' ),
				'campaign_id'		=> !empty ( $campaign_id ) ? $campaign_id : null,
				'telefono_opp_c'	=> $phone,
				'email_opp_c'		=> $email,
				// Outstanding product
				'aos_products_id_c'	=> $product->id
			);
			
			/**
			 * Let's create the quote for this new Opportunity
			 */
			$quoteData = array(
				'name'					=> 'COT [' . $product->codigo_c . '] ' . $first_name . ' ' . $last_name,
				'billing_account_id'  	=> $account->id,
				'assigned_user_id' 		=> $executive->id,
	//			'opportunity_id'		=> $opportunity->id,
				'total_amt'				=> number_format ( $product->price, 0, '.', '' ),
				'subtotal_amount'		=> number_format ( $product->price, 0, '.', '' ),
				'total_amount'			=> number_format ( $product->price, 0, '.', '' ),
				'email_cot_c'			=> $email,
				'telefono_cot_c'		=> $phone,
				'destaque_cot_c'		=> 'destacado'
			);
	 		
	 		$opportunity = $helper->createOpportunityForExecutive ( $executive, $product, $opportunityData, $quoteData );
	 		
	 		// Increment executive sales counter
			if ( !empty ( $opportunity->id ) ) {
				$executive->sales_qty_c = is_numeric ( $executive->sales_qty_c) ? $executive->sales_qty_c + 1 : 1;
				$executive->save();
			}
			
		} 
		/**
		 * If there are matching executives then
		 * create a quote for the Opportunity
		 * of the matching executive with less sales/opportunities.
		 */
		else {
			$executive 		= $matching_executives[0];
			$opportunity	= $matching_opportunities[0];
			
//			$helper->debug ( $executive );
//			$helper->debug ( $opportunity );
//			die;
			
			/**
			 * Let's create the quote for this Opportunity
			 */
			$quoteData = array(
				'name'					=> 'COT [' . $product->codigo_c . '] ' . $first_name . ' ' . $last_name,
				'billing_account_id'  	=> $account->id,
				'assigned_user_id' 		=> $executive->id,
				'opportunity_id'		=> $opportunity->id,
				'total_amt'				=> number_format ( $product->price, 0, '.', '' ),
				'subtotal_amount'		=> number_format ( $product->price, 0, '.', '' ),
				'total_amount'			=> number_format ( $product->price, 0, '.', '' ),
				'email_cot_c'			=> $email,
				'telefono_cot_c'		=> $phone,
				'destaque_cot_c'		=> 'no_destacado'
			);
			
//			$helper->debug ( $quoteData );
			
			$quote = $helper->createProductQuote ( $quoteData, $product );
			
		}
		
		
	}
	
	// Send email
	$email_body = "
		<h2>Gracias por cotizar con nosotros.</h2>
			";
	$helper->sendEmail ( $email, 'Cotización curso UDD', $email_body );
	
	$response = array (
		'success'	=> true
	);
	echo json_encode ( $response );
	die;
}

echo json_encode (
	array(
		'success'	=> false
	)
);

die;

?>