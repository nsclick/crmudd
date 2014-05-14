<?php

class QuotesHooks {
	
	public function before_save ( $bean, $event, $arguments ) {
		$quote = BeanFactory::getBean ( 'AOS_Quotes', $bean->id );
		
		if ( !empty ( $quote ) ) {
			$bean->on_edit = true;
		}
		
		$opportunity_id 	= $bean->opportunity_id;
		$opportunity 		= BeanFactory::getBean ( 'Opportunities', $opportunity_id );
		
	}
	
	/**
	 * before_save
	 */
	function after_save ( $bean, $event, $arguments ) {
		if ( !$bean->on_edit )
			return;
		
		// If dates are empty, then leave
		if (
			empty ( $opportunity->date_closed ) ||
			empty ( $opportunity->date_entered ) ||
			empty ( $opportunity->date_modified )
		)
			return;
		
		// Quote Opportunity
		$opportunity_id 	= $bean->opportunity_id;
		$opportunity 		= BeanFactory::getBean ( 'Opportunities', $opportunity_id );
		
		// Time and Date handling
		$userDateFormat 	= TimeDate::getInstance()->get_date_format();
		$userTimeFormat 	= TimeDate::getInstance()->get_time_format();
		$userDateTimeFormat 	= TimeDate::getInstance()->get_date_time_format();
		
		$opportunity_dateClosed 	= !empty ( $opportunity->date_closed ) ? $opportunity->date_closed : '01-05-2014';
		$opportunity_dateCreated 	= !empty ( $opportunity->date_entered ) ? $opportunity->date_entered : '01-05-2014';
		$opportunity_dateModified 	= !empty ( $opportunity->date_modified ) ? $opportunity->date_modified : '01-05-2014';
		
		$OpportunityDateClosed 		= SugarDateTime::createFromFormat ( $userDateFormat, $opportunity_dateClosed )->asDbDate();
		$OpportunityDateCreated 	= SugarDateTime::createFromFormat ( $userDateTimeFormat, $opportunity_dateCreated )->asDb();
		$OpportunityDateModified 	= SugarDateTime::createFromFormat ( $userDateTimeFormat, $opportunity_dateModified )->asDb();
//		$OpportunityDateClosed 		= TimeDate::getInstance()->fromDbDate ( $opportunity_dateClosed );
//		$OpportunityDateCreated 	= TimeDate::getInstance()->fromDb ( $opportunity_dateCreated );
//		$OpportunityDateModified 	= TimeDate::getInstance()->fromDb ( $opportunity_dateModified );
		
//		$this->debug ( $OpportunityDateClosed );
//		$this->debug ( $OpportunityDateCreated );
//		$this->debug ( $OpportunityDateModified );
//		die;
		
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
				
				// Change the Opportunity product to the new outstanding Quote product
				$db->query (
					"UPDATE " . $opportunity->table_name . "_cstm Set aos_products_id_c='" . $product->product_id . "' Where id_c='" . $opportunity_id . "'"
				);
				
				// Restore Opportunity dates(closed, created and modified) fields :: for some strange reason it gets empty
				$dates_query = "UPDATE " . $opportunity->table_name . " Set date_closed='" . $OpportunityDateClosed .
					"', date_entered='" . $OpportunityDateCreated .
					"', date_modified='" . $OpportunityDateModified .
					"' Where id ='" . $opportunity_id . "'";
				
				$db->query ( $dates_query );
				
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