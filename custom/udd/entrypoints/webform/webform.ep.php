<?php
if ( !defined ( 'sugarEntry' ) || !sugarEntry ) die ( 'Not a valid entry point.' );

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
$campaign_id	= $_GET['campaign_id'];

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
	|| empty ( $campaign_id )
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
$account = $helper->getAccountByEmail ( $email );
$product = $helper->getProductByCodeAndSede ( $product_code, $sede );

// $helper->debug ( $_GET );	
// $helper->debug ( $product->id );
// $helper->debug ( $product->name );
// $helper->debug ( $product->sede_c );
// die;

/**
 * If account doesn't exist create a new one
 */
if ( empty ( $account ) ) {
	
	// Create Account
	$accountData = array(
		'name'			=> $first_name . ' ' . $last_name,
		'email1'		=> $email,
		'phone_office'	=> $phone
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

	// $helper->debug ( 'Creation done' );
}

// $helper->debug ( $account, 'A' );
// die;

if ( !empty ( $account ) ) {
	/*
	 * Now that Account exists (found or created),
	 * look for an opened Opportunity for this Account.
	 * If there isn't one, create it.
	 */
	$opportunity 	= $helper->getOpenedOpportunityByAccountId ( $account->id );

	/**
	 * Now, let's search for the most appropiate executive for this request(Opportunity).
	 */
	$executive = $helper->getExecutiveByProductAndSede ( $account, $product, $sede );
	
	// Assign executive to contact and lead if created
	if ( isset ( $lead ) ) {
		$lead->assigned_user_id = $executive->id;
		$lead->save();
	}

	if ( isset ( $contact ) ) {
		$contact->assigned_user_id = $executive->id;
		$contact->save();
	}


	// $helper->debug ( $contact );

	// If there isn't an opened Opportunity, then create one and related it to the account
	if ( empty ( $opportunity ) ) {
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
			'aos_products_id_c'	=> $product->id
		);

		$opportunity 		= $helper->createOpportunity ( $opportunityData );
	}

	/**
	 * Let's find if this opportunity doesn't have any quote,
	 * if so, then this will be the first quote to create
	 * and should be marked as 'destacado'.	
	 */
	$opportunity->load_relationship ( 'aos_quotes' );
	$opportunity_quotes = $opportunity->aos_quotes->getBeans();

	// $helper->debug ( $opportunity_quotes );

	$quoteData = array(
		'name'					=> 'COT [' . $product->codigo_c . '] ' . $first_name . ' ' . $last_name,
		'billing_account_id'  	=> $account->id,
		'assigned_user_id' 		=> $executive->id,
		'opportunity_id'		=> $opportunity->id,
		'total_amt'				=> number_format ( $product->price, 0, '.', '' ),
		'subtotal_amount'		=> number_format ( $product->price, 0, '.', '' ),
		'total_amount'			=> number_format ( $product->price, 0, '.', '' ),
		'email_cot_c'			=> $email,
		'telefono_cot_c'		=> $phone
	);

	// Isn't there any other quote related to this opportunity
	$quoteData['destaque_cot_c'] = empty ( $opportunity_quotes ) ? 'destacado' : 'no_destacado';

	$quote = $helper->createProductQuote ( $quoteData, $product );
	// die;

	// Increment executive sales counter
	if ( !empty ( $quote->id ) ) {
		$executive->sales_qty_c = is_numeric ( $executive->sales_qty_c) ? $executive->sales_qty_c + 1 : 1;
		$executive->save();
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

echo json_encode(
	array (
		'success'	=> false
	)
);

die;

?>