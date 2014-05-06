<?php

class QuotesHooks {
	protected $on_create = false;
	
	public function before_save ( $bean, $event, $arguments ) {
		$quote = BeanFactory::getBean ( 'AOS_Quotes', $bean->id );
		if ( empty ( $quote ) ) {
			$this->on_create = true;
		}
	}
	
	/**
	 * before_save
	 */
	function after_save ( $bean, $event, $arguments ) {
		if ( !$this->on_create )
			return;
		
		// Quote Opportunity
		$opportunity_id 	= $bean->opportunity_id;
		$opportunity 		= BeanFactory::getBean ( 'Opportunities', $opportunity_id ); 
		
		// Time and Date handling
		$opportunity_date 	= !empty ( $opportunity->date_closed ) ? $opportunity->date_closed : '01-05-2014';
		$userTimeFormat 	= TimeDate::getInstance()->get_date_format();
		$sugarDate 			= SugarDateTime::createFromFormat ( $userTimeFormat, $opportunity_date )->asDbDate();
				
		// loop prevention check
        if ( !isset ( $bean->ignore_update_c ) || $bean->ignore_update_c === false ) {
			$quote_id 				= $bean->id;
			$outstanding_value		= 'destacado';
			$nonoutstanding_value	= 'no_destacado';
			
			preg_match ( '/\[(.*)\]/i', $bean->name, $codigo_c );
			
			/**
			 * If this quote is marked as outsating 'destacado'
			 * then it should ensure other quotes of same Opportunity
			 * ar marked as not outstanding or 'no_destacado'.
			 */
			if ( $bean->destaque_cot_c == $outstanding_value ) {
				$quote_products 	= $bean->get_linked_beans ( 'aos_products_quotes', 'AOS_Products' );
				$product 			= $quote_products[0];
				
				/**
				 * Update Opportunity with new Outstanding quote
				 */
				
				$opportunity->amount 			= $bean->total_amount;
				$new_opportunity_name 			= preg_replace('/\[(.*)\]/i', '[' . $codigo_c[1] . ']', $opportunity->name);
				$opportunity->name 				= $new_opportunity_name;
				$opportunity_quotes				= $opportunity->get_linked_beans ( 'aos_quotes', 'AOS_Quotes' );
				
				foreach ( $opportunity_quotes as $opportunity_quote ) {
					if ( $opportunity_quote->id != $quote_id
						&& !isset ( $opportunity_quotes->ignore_update_c ) || $opportunity_quotes->ignore_update_c === false ) {
						
						$opportunity_quote->ignore_update_c = true;
						$opportunity_quote->destaque_cot_c 	= $nonoutstanding_value;
						$opportunity_quote->save();
					}
				}
				
				// Update Opportunity			
				$opportunity->db->update ( $opportunity );
				
				// Update Custom Fields
				$db = DBManagerFactory::getInstance();
				$db->query (
					"UPDATE " . $opportunity->table_name . "_cstm Set aos_products_id_c='" . $product->product_id . "' Where id_c='" . $opportunity_id . "'"
				);
				
				// Restore Opportunity date_closed field :: for some strange reason it gets empty
				$db->query (
					"UPDATE " . $opportunity->table_name . " Set date_closed='" . $sugarDate . "' Where id ='" . $opportunity_id . "'"
				);
				
				$bean->ignore_update_c = true;
			}
			
        }
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
	
}

?>