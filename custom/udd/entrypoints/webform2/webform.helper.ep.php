<?php
if ( !defined ( 'sugarEntry' ) || !sugarEntry ) die ( 'Not a valid entry point.' );

class WebFormEPHelper {
	/**
	 * db
	 */
	protected $db;

	/**
	 * __construct
	 */
	function __construct() {
		$this->db = DBManagerFactory::getInstance();
	}

	/**
	 * debug
	 */
	function debug ( $data, $title = null ) {
		echo '<pre>';
		if ( !empty ( $title ) && is_string ( $title ) ) {
			echo '<h2>' . $title . '</h2>';
		}
		if ( is_bool ( $data ) ) {
			var_dump ( $data );
		} else {
			print_r ( $data );
		}
		echo '</pre><hr/><br/>';
	}

	/**
	 * getProductByCodeAndSede
	 */
	function getProductByCodeAndSede ( $product_code, $sede ) {
		$sql = "Select
					p.id

				From
					aos_products p,
					aos_products_cstm pcstm

				Where
					p.deleted = 0
					AND p.id = pcstm.id_c
					AND pcstm.codigo_c = '" . $product_code . "'
					AND pcstm.sede_c = '" . $sede . "'";

		$product = $this->query ( $sql );
		if ( !empty ( $product ) ) {
			$product = BeanFactory::getBean ( 'AOS_Products', $product[0]['id'] );
		}

		return $product;
	}

	/**
	 * getAccountByEmail
	 */
	function getAccountByEmail ( $email ) {
		$sql = "Select
					a.id

				From
					accounts a,
					accounts_cstm acstm,
					email_addr_bean_rel ebrel,
					email_addresses emails

				Where
					a.id = acstm.id_c
					AND a.deleted = 0
					AND ebrel.bean_id = a.id
					AND ebrel.bean_module = 'Accounts'
					AND ebrel.deleted = 0
					AND ebrel.email_address_id = emails.id
					AND emails.deleted = 0
					AND emails.email_address = '" . $email . "'";

		$account = $this->query ( $sql );
		if ( !empty ( $account )  ) {
			$account = BeanFactory::getBean( 'Accounts', $account[0]['id'] );
		}

		return $account;
	}

	/**
	 * createAccount
	 */
	function createAccount ( $data ) {
		$account = $this->createBean ( 'Accounts', $data );
		return $account;
	}

	/**
	 * createLead
	 */
	function createLead ( $data ) {
		$lead = $this->createBean ( 'Leads', $data );
		return $lead;
	}

	/**
	 * createOpportunity
	 */
	function createOpportunity ( $data ) {
		$opportunity = $this->createBean ( 'Opportunities', $data );
		return $opportunity;
	}

	/**
	 * createContact
	 */
	function createContact ( $data ) {
		$contact = $this->createBean ( 'Contacts', $data );
		return $contact;
	}

	/**
	 * createBean
	 */
	function createBean ( $moduleName, $data ) {
		$bean = BeanFactory::newBean ( $moduleName );

		foreach ( $data as $k => $d ) {
			$bean->$k = $d;
		}

		$bean->save();
		return $bean;
	}

	/**
	 * getProductById
	 */
	function getProductById ( $product_id ) {
		$sql = "Select
					p.id

				From
					aos_products p

				Where
					p.id = '" . $product_id . "'
					AND p.deleted = 0";

		$product = $this->query ( $sql );
		if ( !empty ( $product )  ) {
			$product = BeanFactory::getBean( 'AOS_Products', $product[0]['id'] );
		}

		return $product;
	}
	
	/**
	 * getAccountOpenedOpportunities
	 */
	 function getAccountOpenedOpportunities ( $account ) {
	 	$account_id = $account->id;
	 	
	 	$sql = "Select
					o.id

				From
					opportunities o,
					accounts a,
					accounts_opportunities ao

				Where
					a.id = '" . $account_id . "'
					AND ao.opportunity_id = o.id
					AND ao.account_id = a.id
					AND o.sales_stage NOT IN ('Closed Won', 'closed_won', 'Closed_Lost', 'closed_lost')
					AND ao.deleted = 0
					AND o.deleted = 0
					AND a.deleted = 0";
		
		$opportunities 	= array();
		$rows 			= $this->query ( $sql );
		foreach ( $rows as $row ) {
			$opportunities[] = BeanFactory::getBean ( 'Opportunities', $row['id'] );
		}
		
		return $opportunities;
	 }
	 
	 /**
	  * getAllowedExecutivesByProductAndSede
	  */
	function getAllowedExecutivesByProductAndSede ( $product_code, $sede ) {
		$sql = "Select
					u.*
				
				From
					users u,
					users_cstm u_cstm,
					users_aos_products_1_c uprods,
					aos_products prods,
					aos_products_cstm prods_cstm
				
				Where
					u.id = uprods.users_aos_products_1users_ida
					AND u.id = u_cstm.id_c
					AND u.deleted = 0
					AND u_cstm.receive_sales_c = 1
					AND prods.id = uprods.users_aos_products_1aos_products_idb
					AND prods.id = prods_cstm.id_c
					AND prods.deleted = 0
					AND prods_cstm.codigo_c = '" . $product_code . "'
					AND prods_cstm.sede_c = '" . $sede . "'
					AND uprods.deleted = 0

				Order By
					u_cstm.sales_qty_c";
		
		$executives = array();
		$rows 		= $this->query ( $sql );
		foreach ( $rows as $row ) {
			$executives[] = BeanFactory::getBean ( 'Users', $row['id'] );
		}
		
		return $executives;
	}

	/**
	 * getOpenedOpportunityByAccountId
	 */
	function getOpenedOpportunityByAccountId ( $account_id ) {
		$sql = "Select
					o.id

				From
					opportunities o,
					accounts a,
					accounts_opportunities ao

				Where
					a.id = '" . $account_id . "'
					AND ao.opportunity_id = o.id
					AND ao.account_id = a.id
					AND o.sales_stage NOT IN ('Closed Won', 'closed_won', 'Closed_Lost', 'closed_lost')
					AND ao.deleted = 0
					AND o.deleted = 0
					AND a.deleted = 0";

		$opportunity = $this->query ( $sql );
		if ( !empty ( $opportunity )  ) {
			$opportunity = BeanFactory::getBean( 'Opportunities', $opportunity[0]['id'] );
		}

		return $opportunity;
	}

	/**
	 * getExecutiveByProductAndSede
	 */
	function getExecutiveByProductAndSede ( &$account, $product, $sede ) {

		$account_diplomaed_seller_c 	= $account->user_id_c;
		$account_postgraduate_seller_c 	= $account->user_id1_c;

		// $this->debug ( $account_postgraduate_seller_c );

		// Retrieve diplomaed executive if exists
		if ( ( $product->type == 'diplomaed' || $product->type == 'course' ) && !empty ( $account_diplomaed_seller_c ) ) {
			// $this->debug ( $account );
			return BeanFactory::getBean ( 'Users', $account_diplomaed_seller_c );
		} 
		// Retrieve postgraduate executive if exists
		else if ( $product->type == 'postgraduate' && !empty ( $account_postgraduate_seller_c ) ) {
			return BeanFactory::getBean ( 'Users', $account_postgraduate_seller_c );
		}

		// If there's not a predefined seller, then look for the most appropiate one
		$sql = "Select
					u.id

				From
					users u,
					users_aos_products_1_c up,
					users_cstm ucstm

				Where
					u.deleted = 0
					AND u.id = up.users_aos_products_1users_ida
					AND up.deleted = 0
					AND up.users_aos_products_1aos_products_idb = '" . $product->id . "'
					AND u.id = ucstm.id_c
					AND ucstm.sede_c = '" . $sede . "'
					AND ucstm.receive_sales_c = 1

				Order By
					ucstm.sales_qty_c ASC
				
				Limit 1";

		$seller = $this->query ( $sql );
		if ( !empty ( $seller ) ) {
			$seller = BeanFactory::getBean ( 'Users', $seller[0]['id'] );

			/**
			 * Now assign the vendor to the account depending the type of product
			 */
			switch ( $product->type ) {
				case 'course':
				case 'diplomaed':
					$account->user_id_c = $seller->id;
					break;
				case 'postgraduate':
					$account->user_id1_c = $seller->id;
					break;
			}

			$account->save();
		}
		
		return $seller;
	}

	/**
	 * createProductQuote
	 */
	function createProductQuote ( $quoteData, $product ) {
		$quote = $this->createBean ( 'AOS_Quotes', $quoteData );
		
		/**
		 *	First quote is marked as 'destacado' and others no.
		 */

		$product_quote_data = array(
			'name'                    => $product->name,
	        'description'             => $product->description,
	        'part_number'             => $product->part_number,
	        'item_description'        => $product->description,
	        'number'                  => 1,
	        'product_cost_price'      => $product->cost,
	        'product_list_price'      => number_format ( $product->price, 0, '.', '' ),
	        'product_discount'        => 0,
	        'product_discount_amount' => 0,
	        'discount'                => 'Percentage',
	        'product_unit_price'      => number_format( $product->price, 0, '.', '' ),
	        'vat_amt'                 => 0,
	        'product_total_price'     => number_format( $product->price, 0, '.', '' ),
	        'vat'                     => 0,
	        'parent_type'             => 'AOS_Quotes',
	        'parent_id'               => $quote->id,
	        'product_id'              => $product->id
		);

		$product_quote_r = $this->createBean ( 'AOS_Products_Quotes', $product_quote_data );

		return $quote;
	}
	
	/**
	 * createOpportunityForExecutive
	 * 
	 * Create Opportunity for an Executive with current request data
	 * fetched Account and Product
	 */
	function createOpportunityForExecutive ( $executive, $product, $opportunityData, $quoteData ) {
		$opportunity 		= $this->createOpportunity ( $opportunityData );
		
		$quoteData['opportunity_id'] 	= $opportunity->id;
		$quote 							= $this->createProductQuote ( $quoteData, $product );
		$executive->sales_qty_c 		= is_numeric ( $ex->sales_qty_c) ? $ex->sales_qty_c + 1 : 1;
		$executive->save();
		
		return $opportunity;
	}

	/**
	 * query
	 */
	protected function query ( $sql ) {
		$result = $this->db->query ( $sql );
		$rows 	= array();
		while ( $row = $this->db->fetchByAssoc ( $result ) ) {
			$rows[] = $row;
		}

		return $rows;
	}

	/**
	 * getUserRolesById
	 */
	function getUserRolesById ( $user_id ) {
		$roles = array();
		$sql =	"Select
					r.id role_id,
                    r.name role_name,
                    CONCAT(IFNULL(u.first_name, ''), ' ', u.last_name) user_name
				From
					acl_roles r,
					acl_roles_users ru,
                    users u
				Where
					r.deleted = 0
					AND ru.deleted = 0
					AND r.id = ru.role_id
                    ANd ru.user_id = u.id 
                    AND u.deleted = 0
					AND ru.user_id = '" . $user_id ."'";

		$result = $this->db->query ( $sql );
		while ( $row = $this->db->fetchByAssoc ( $result ) ) {
			$roles[] = $row;
		}

		return $roles;
	}

	/**
	 * userHasRoleByName
	 */
	function userHasRoleByName ( $user_id, $role_name ) {
		$roles = $this->getUserRolesById ( $user_id );

		$has_role = false;
		foreach ( $roles as $role ) {
			if ( $role['role_name'] == $role_name ) {
				$has_role = true;
				break;	
			}
		}

		return $has_role;
	}

	/**
     * sendMail
     *
     * Read more about this function at: http://developer.sugarcrm.com/2011/08/15/howto-send-and-archive-an-email-in-sugar-via-php
     */
	public function sendEmail ( $emailTo, $emailSubject, $emailBody, $emailBCC = array() ) {
		$emailObj = new Email();
		$defaults = $emailObj->getSystemDefaultEmail();
		$mail = new SugarPHPMailer();
		$mail->setMailerForSystem();
		$mail->CharSet = 'UTF-8';
		// $mail->From = $defaults['email'];
		$mail->From = 'no-responder@inalco.cl'; // No-reply email address
		$mail->FromName = $defaults['name'];
		$mail->ClearAllRecipients();
		$mail->ClearReplyTos();
		$mail->Subject=from_html($emailSubject);
		$mail->Body=$emailBody;
		$mail->AltBody=from_html($emailBody);
		$mail->prepForOutbound();
		$mail->AddAddress($emailTo);

		foreach ( $emailBCC as $bcc ) {
		  $mail->AddBCC( $bcc );
		}

		if (@$mail->Send()) {

		}
	}

}

?>