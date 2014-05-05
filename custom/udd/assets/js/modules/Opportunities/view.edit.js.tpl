{literal}
<script>
(function() {
	$(document).ready(function() {

		/**
		 * Conditional Sales Stage Messages
		 */
		var sales_stage_el = $('#sales_stage');

		sales_stage_el.on('change', function(ev) {
			var value = $(this).val();

			$('.vendor_action').each(function(index, el) {
				var show_on 	= $(el).data('show-on').split(',')
					in_show_on	= false;

				$.each(show_on, function(i, val) {
					if ( val == value ) {
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

		sales_stage_el.trigger('change');

		/**
		 * Lost Reason
		 */
		var lost_reason_list_el = $('#lost_reason_c'),
			lost_reson_desc_el	= $('#lost_reason_description_c'),
			lost 				= (sales_stage_el.val() == 'closed_lost'),
			tr 					= lost_reason_list_el.parents('tr'),
			save_header			= $('#SAVE_HEADER'),
			save_footer			= $('#SAVE_FOOTER');

		tr = tr[0];
		
		$(tr).hide();

		sales_stage_el.on('change', function(ev) {
			var value = $(this).val();

			if (value == 'closed_lost') {
				$(tr).fadeIn();
				save_header.attr('disabled', true);
				save_footer.attr('disabled', true);
			} else {
				$(tr).hide();
				save_header.removeAttr('disabled');
				save_footer.removeAttr('disabled');
			}
		});

		lost_reason_list_el.on('change', function(ev) {
			var v = $(this).val();

			if (v != 'none' && lost_reson_desc_el.val() != '') {
				save_header.removeAttr('disabled');
				save_footer.removeAttr('disabled');
			} else {
				save_header.attr('disabled', true);
				save_footer.attr('disabled', true);
			}
		});

		lost_reson_desc_el.on('keyup', function(ev) {
			var v = $(this).val();

			if (v != 'none' && lost_reson_desc_el.val() != '') {
				save_header.removeAttr('disabled');
				save_footer.removeAttr('disabled');
			} else {
				save_header.attr('disabled', true);
				save_footer.attr('disabled', true);
			}
		});

		if (lost) {
			lost_reason_list_el.trigger('change');
		}

		/**
		 * Special case that shows two checkboxes
		 * when the opportunity is marked as won.
		 */
		var postStatePanel = $('#detailpanel_3');
		
		postStatePanel.hide();
		
		sales_stage_el.on('change', function(ev) {
			var value = $(this).val();

			if(value == 'closed_won') {
				postStatePanel.fadeIn();
			} else {
				postStatePanel.hide();
			}

		});

	});
})();
</script>
{/literal}