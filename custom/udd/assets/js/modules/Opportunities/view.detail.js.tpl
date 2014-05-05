{literal}
<script>
(function() {
	$(document).ready(function() {
		
		/**
		 * Conditional Sales Stage Messages
		 */
		var sales_stage_el = $('#sales_stage');
		
		$('.vendor_action').each(function(index, el) {
			var show_on 	= $(el).data('show-on').split(',')
				in_show_on	= false;

			$.each(show_on, function(i, val) {
				if ( val == sales_stage_el.val() ) {
					in_show_on = true;
				}
			});

			if ( in_show_on ) {
				$(el).fadeIn();
			} else {
				$(el).hide();
			}

		});
		
	});
})();
</script>
{/literal}