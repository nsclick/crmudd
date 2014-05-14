<?php 
if ( !defined ( 'sugarEntry' ) || !sugarEntry ) die ( 'Not a valid entry point' );

require_once ( 'include/MVC/View/views/view.edit.php' );

class OpportunitiesViewEdit extends ViewEdit {

	function OpportunitiesViewEdit () {
		parent::ViewEdit();
	}

	function display () {
		echo $this->ss->fetch ( 'custom/udd/assets/css/modules/Opportunities/view.edit.css.tpl' );
		echo $this->ss->fetch ( 'custom/udd/assets/js/modules/Opportunities/view.edit.js.tpl' );
		parent::display();
	}

}

?>