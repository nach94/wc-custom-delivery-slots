(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	jQuery(document).ready(function($) {
		// Selector para los checkboxes de métodos de envío
		var selector = 'input[name="wc_cds[_wc_cds_shipping_methods][]"]';
		$(document).on('change', selector, function() {
			if ($(this).val() === '__all__') {
				if ($(this).is(':checked')) {
					// Desmarcar todos los demás
					$(selector).not(this).prop('checked', false);
				}
			} else {
				if ($(this).is(':checked')) {
					// Desmarcar la opción "Todos los métodos de envío"
					$(selector + '[value="__all__"]').prop('checked', false);
				}
			}
		});

		function getRowHtml(index) {
			return '<div class="wc-cds-special-date-row" style="display: flex; flex-direction: column; gap: 8px; position: relative; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background-color: #f9f9f9; margin-bottom: 10px;">' +
				'<div>' +
					'<label for="_special_date_' + index + '">Selecciona una fecha especial</label><br>' +
					'<input id="_special_date_' + index + '" type="date" name="wc_cds[_wc_cds_special_dates][' + index + '][date]" required>' +
				'</div>' +
				'<div>' +
					'<label for="_special_fee_' + index + '">Selecciona una tarifa extra</label><br>' +
					'<input id="_special_fee_' + index + '" type="number" name="wc_cds[_wc_cds_special_dates][' + index + '][fee]" min="0" step="0.01" placeholder="Tarifa extra" style="width:100px;" required>' +
				'</div>' +
				'<div>' +
					'<input id="_special_every_year_' + index + '" type="checkbox" name="wc_cds[_wc_cds_special_dates][' + index + '][every_year]" value="1">' +
					'<label for="_special_every_year_' + index + '">Usar cada año</label>' +
				'</div>' +
				'<button type="button" class="button wc-cds-remove-special-date" title="Eliminar" style="position: absolute; top: 50%; right: 5px; transform: translateY(-50%);">&times;</button>' +
			'</div>';
		}
		$(document).on('click', '#wc-cds-add-special-date', function(e) {
			e.preventDefault();
			var wrapper = $('#wc-cds-special-dates-wrapper');
			var index = wrapper.find('.wc-cds-special-date-row').length;
			wrapper.append(getRowHtml(index));
		});
		$(document).on('click', '.wc-cds-remove-special-date', function() {
			if ($('#wc-cds-special-dates-wrapper .wc-cds-special-date-row').length > 1) {
				$(this).closest('.wc-cds-special-date-row').remove();
			} else {
				// Si solo queda una fila, limpiar los campos
				$(this).closest('.wc-cds-special-date-row').find('input').val('');
				$(this).closest('.wc-cds-special-date-row').find('input[type=checkbox]').prop('checked', false);
			}
		});
	});

})( jQuery );
