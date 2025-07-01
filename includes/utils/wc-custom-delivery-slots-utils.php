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
        echo '<label style="display:block;margin-bottom:4px;font-weight:bold;">';
        echo '<input type="checkbox" name="wc_cds[_wc_cds_shipping_methods][]" value="__all__" ' . $checked_all . '> Todos los métodos de envío';
        echo '</label>';
        foreach ( $all_methods as $method_id => $method_title ) {
            $checked = in_array( $method_id, (array) $selected_methods ) ? 'checked' : '';
            echo '<label style="display:block;margin-bottom:4px;">';
            echo '<input type="checkbox" name="wc_cds[_wc_cds_shipping_methods][]" value="' . esc_attr( $method_id ) . '" ' . $checked . '> ';
            echo esc_html( $method_title ) . ' <small>(' . esc_html( $method_id ) . ')</small>';
            echo '</label>';
        }
    }
} 