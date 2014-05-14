<?php

class OpportunitiesHooks {
	protected $previous_validated_c = 0;
	protected $previous_audited_c 	= 0;
	
	public function before_save ( $bean, $event, $arguments ) {
		$opportunity = BeanFactory::getBean ( 'Opportunities', $bean->id );
		
		if ( !empty ( $opportunity ) ) {
			$bean->on_edit = true;
		}
		
		$bean->previous_validated_c = $bean->validated_c;
		$bean->previous_audited_c 	= $bean->audited_c;
	}
	
	public function after_save ( $bean, $event, $arguments ) {
		if ( !$bean->on_edit )
			return;
		
		/**
		 * If validated_c is checked
		 */
		if ( $bean->previous_validated_c == 0 && $bean->validated_c == 1 ) {
			$mail_to 		= 'ljayk@nsclick.cl';
			$mail_subject	= 'Validado';
			$mail_body 		= $this->validated_email ( $bean );
			
			$this->sendEmail ( $mail_to, $mail_subject, $mail_body );	
		}
		
		/**
		 * If audited is checked
		 */
		if ( $bean->previous_audited_c == 0 && $bean->audited_c == 1 ) {
			$user 			= BeanFactory::getBean ( 'Users', $bean->assigned_user_id );
			$primary_email 	= $user->emailAddress->getPrimaryAddress ( $user );
			$primary_email = 'fpawlik@nsclick.cl';
			
			$mail_to 		= 'ljayk@nsclick.cl';
			$mail_bcc 		= array(
				'ljayk@nsclick.cl',
				$primary_email
				
			);
			$mail_subject	= 'Validado';
			$mail_body 		= $this->audited_email ( $bean );
			
			$this->sendEmail ( $mail_to, $mail_subject, $mail_body, $mail_bcc );	
		}
		
	}
	
	protected function validated_email ( $bean = null ) {
		ob_start();
?>
	<div>Oportunidad <?php echo $bean->name; ?> Validada</div>		
<?php
		$output = ob_get_contents();
		ob_clean();
		ob_flush();
		
		return $output;
	}
	
	protected function audited_email ( $bean = null ) {
		ob_start();
?>
	<div>Oportunidad <?php echo $bean->name; ?> Auditada</div>		
<?php
		$output = ob_get_contents();
		ob_clean();
		ob_flush();
		
		return $output;
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
		 $mail->From = $defaults['email'];
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