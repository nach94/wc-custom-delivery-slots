<?php
/**
 * Funciones utilitarias para el plugin WC Custom Delivery Slots
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if ( ! function_exists( 'wc_cds_list_shipping_methods_checkboxes' ) ) {
    /**
     * Imprime los métodos de envío de WooCommerce como checkboxes
     *
     * @param array $selected_methods Métodos seleccionados (opcional)
     */
    function wc_cds_list_shipping_methods_checkboxes( $selected_methods = array() ) {
        if ( ! class_exists( 'WC_Shipping_Zones' ) ) {
            echo '<p>No se encontró WooCommerce o la clase WC_Shipping_Zones.</p>';
            return;
        }
        $all_methods = array();
        // Obtener métodos de todas las zonas
        $zones = WC_Shipping_Zones::get_zones();
        foreach ( $zones as $zone ) {
            $zone_obj = new WC_Shipping_Zone( $zone['id'] );
            foreach ( $zone_obj->get_shipping_methods() as $method ) {
                $all_methods[ $method->id ] = $method->get_method_title();
            }
        }
        // Métodos de la zona "Rest of the World"
        $default_zone = new WC_Shipping_Zone( 0 );
        foreach ( $default_zone->get_shipping_methods() as $method ) {
            $all_methods[ $method->id ] = $method->get_method_title();
        }
        if ( empty( $all_methods ) ) {
            echo '<p>No hay métodos de envío configurados.</p>';
            return;
        }
        // Checkbox para todos los métodos de envío
        $checked_all = in_array('__all__', (array) $selected_methods) ? 'checked' : '';
        echo 
        '<div>
            <input type="checkbox" name="wc_custom_delivery_slots[_wc_cds_shipping_methods][]" value="__all__" ' . $checked_all . '>
            <label> Todos los métodos de envío</label>            
        </div>';
        foreach ( $all_methods as $method_id => $method_title ) {
            $checked = in_array( $method_id, (array) $selected_methods ) ? 'checked' : '';
            echo '
            <div>
                <input type="checkbox" name="wc_custom_delivery_slots[_wc_cds_shipping_methods][]" value="' . esc_attr( $method_id ) . '" ' . $checked . '>
                <label>' . esc_html( $method_title ) . ' <small>(' . esc_html( $method_id ) . ')</small></label>                
            </div>';
        }
    }
}

if ( ! function_exists( 'wc_cds_get_wp_date_formats' ) ) {
    /**
     * Devuelve los formatos de fecha estándar de WordPress, incluyendo el personalizado del usuario.
     * @return array
     */
    function wc_cds_get_wp_date_formats() {
        $formats = array(
            'F j, Y', // 1 de enero de 2024
            'Y-m-d',  // 2024-01-01
            'm/d/Y',  // 01/01/2024
            'd/m/Y',  // 01/01/2024
            'd.m.Y',  // 01.01.2024
        );
        $custom = get_option('date_format');
        if ( $custom && !in_array($custom, $formats) ) {
            $formats[] = $custom;
        }
        return $formats;
    }
}

if ( ! function_exists( 'wc_cds_get_wp_time_formats' ) ) {
    /**
     * Devuelve los formatos de hora estándar de WordPress, incluyendo el personalizado del usuario.
     * @return array
     */
    function wc_cds_get_wp_time_formats() {
        $formats = array(
            'g:i a', // 1:30 pm
            'g:i A', // 1:30 PM
            'H:i',   // 13:30
        );
        $custom = get_option('time_format');
        if ( $custom && !in_array($custom, $formats) ) {
            $formats[] = $custom;
        }
        return $formats;
    }
}

if ( ! function_exists( 'wc_cds_render_special_dates_field' ) ) {
    /**
     * Renderiza el campo repetible de fechas especiales
     * @param array $special_dates
     */
    function wc_cds_render_special_dates_field( $special_dates = array() ) {
        if ( empty($special_dates) ) {
            $special_dates[] = array('date' => '', 'fee' => '', 'every_year' => '');
        }
        echo '<div id="wc-cds-special-dates-wrapper">';
        foreach ($special_dates as $i => $row) {
            ?>
            <div class="wc-cds-special-date-row" style="display: flex; flex-direction: column; gap: 8px; position: relative; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background-color: #f9f9f9; margin-bottom: 10px;">
                <div>
                    <label for="_special_date_<?php echo $i; ?>">Selecciona una fecha especial</label><br>
                    <input id="_special_date_<?php echo $i; ?>" type="date" name="wc_custom_delivery_slots[_wc_cds_special_dates][<?php echo $i; ?>][date]" value="<?php echo esc_attr($row['date']); ?>" required>
                </div>
                <div>
                    <label for="_special_fee_<?php echo $i; ?>">Selecciona una tarifa extra</label><br>
                    <input id="_special_fee_<?php echo $i; ?>" type="number" name="wc_custom_delivery_slots[_wc_cds_special_dates][<?php echo $i; ?>][fee]" value="<?php echo esc_attr($row['fee']); ?>" min="0" step="0.01" placeholder="Tarifa extra" style="width:100px;" required>
                </div>
                <div>
                    <input id="_special_every_year_<?php echo $i; ?>" type="checkbox" name="wc_custom_delivery_slots[_wc_cds_special_dates][<?php echo $i; ?>][every_year]" value="1" <?php checked($row['every_year'], '1'); ?>>
                    <label for="_special_every_year_<?php echo $i; ?>">Usar cada año</label>
                </div>
                <button type="button" class="button wc-cds-remove-special-date" title="Eliminar" style="position: absolute; top: 50%; right: 5px; transform: translateY(-50%);">&times;</button>
            </div>
            <?php
        }
        echo '</div>';
        echo '<button type="button" class="button" id="wc-cds-add-special-date">Agregar fecha especial</button>';
    }
}