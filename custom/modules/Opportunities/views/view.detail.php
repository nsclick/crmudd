<?php 
if ( !defined ( 'sugarEntry' ) || !sugarEntry ) die ( 'Not a valid entry point' );

require_once ( 'include/MVC/View/views/view.detail.php' );

class OpportunitiesViewDetail extends ViewDetail {

	function OpportunitiesViewDetail () {
		parent::ViewDetail();
	}

	function display () {
		echo $this->ss->fetch ( 'custom/udd/assets/css/modules/Opportunities/view.detail.css.tpl' );
		echo $this->ss->fetch ( 'custom/udd/assets/js/modules/Opportunities/view.detail.js.tpl' );
		parent::display();
	}

}

?>