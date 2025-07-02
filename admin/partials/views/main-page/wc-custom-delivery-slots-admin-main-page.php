<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://helloeveryone.me/
 * @since      1.0.0
 *
 * @package    Wc_Custom_Delivery_Slots
 * @subpackage Wc_Custom_Delivery_Slots/admin/partials
 */

require_once WP_PLUGIN_DIR . '/wc-custom-delivery-slots/includes/utils/wc-custom-delivery-slots-utils.php';

$options = get_option('wc_custom_delivery_slots', []);
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="flex-column gap-s bg-epick text-white padding-l">
    <div class="max-width-10 epick-logo"></div>
</div>

<address class="bg-dark-grey-2 padding-vertical-4xs padding-horizontal-l flex-row items-middle gap-xs text-white">
    <small>Desarrollado por&nbsp;<a class="text-white transition-global" href="https://helloeveryone.me" rel="noreferrer" target="_blank">Hello Everyone</a></small>
</address>



<div class="padding-l text-black">
    <h1 class="text-l font-700"> Opciones de <span class="underline">Custom Delivery Slots</span></h1>
    <p class="margin-top-s text-s">El plugin permite configurar los horarios de entrega para los métodos de envío seleccionados.</p>
    <hr class="margin-vertical-m">

    <?php if (class_exists('WooCommerce')) { ?>

        <?php if (isset($_GET['settings-updated']) && $_GET['settings-updated'] === 'true') : ?>
            <div class="notice notice-success is-dismissible">
                <p><strong><?php _e('Cambios guardados correctamente.', 'epick-shipping'); ?></strong></p>
            </div>
        <?php endif; ?>

        <form id="_wc_custom_delivery_slots_form" method="post" action="options.php">

            <!--Tab general-->
            <section>
                <div>
                    <h2>Configuración general</h2>
                    <p>Configuraciones generales del plugin.</p>
                    <table class="form-table widefat striped">
                        <tbody>
                            <!--Activar funcionalidad del plugin -->
                            <tr>
                                <th style="padding-left: 10px; width: 50%;">
                                    <p>¿Quieres activar la funcionalidad de los horarios de entrega?</p>
                                    <small>Si activas esta opción, los clientes podrán seleccionar un horario de entrega para su pedido.</small>
                                </th>
                                <td style="padding-left: 10px; width: 50%;">
                                    <input type="checkbox" name="wc_custom_delivery_slots[_wc_cds_activate]" id="_wc_cds_activate" value="1" <?php checked(isset($options['_wc_cds_activate']), 1); ?>>
                                    <label for="_wc_cds_activate">Activar funcionalidad</label>
                                </td>
                            </tr>

                            <!--Métodos de envío-->
                            <tr>
                                <th style="padding-left: 10px; width: 50%;">
                                    <p>¿A qué metodos de envíos deseas aplicar franjas horarias?</p>
                                    <small>Selecciona los métodos de envío para los que se aplicarán los horarios de entrega.</small>
                                </th>
                                <td style="padding-left: 10px; width: 50%;" class="flex-column gap-4xs">
                                    <?php
                                    $selected_methods = isset($options['_wc_cds_shipping_methods']) ? $options['_wc_cds_shipping_methods'] : array();
                                    wc_cds_list_shipping_methods_checkboxes($selected_methods);
                                    ?>
                                </td>
                            </tr>

                            <!--Formatos de hora y fecha -->
                            <tr>
                                <th style="padding-left: 10px; width: 50%;">
                                    <p>Elije el formato de hora y fecha que quieres utilizar</p>
                                    <small>Selecciona el formato de hora y fecha que quieres utilizar.</small>
                                </th>
                                <td style="padding-left: 10px; width: 50%;" class="flex-column gap-4xs">
                                    <?php
                                    $selected_time_format = isset($options['_wc_cds_time_format']) ? $options['_wc_cds_time_format'] : get_option('time_format');
                                    $selected_date_format = isset($options['_wc_cds_date_format']) ? $options['_wc_cds_date_format'] : get_option('date_format');
                                    $time_formats = function_exists('wc_cds_get_wp_time_formats') ? wc_cds_get_wp_time_formats() : array('H:i');
                                    $date_formats = function_exists('wc_cds_get_wp_date_formats') ? wc_cds_get_wp_date_formats() : array('Y-m-d');
                                    ?>
                                    <div>
                                        <label for="_wc_cds_time_format">Formato de hora:</label><br>
                                        <select name="wc_custom_delivery_slots[_wc_cds_time_format]" id="_wc_cds_time_format">
                                            <?php foreach ($time_formats as $format): ?>
                                                <option value="<?php echo esc_attr($format); ?>" <?php selected($selected_time_format, $format); ?>>
                                                    <?php echo esc_html(date_i18n($format, strtotime('13:30'))); ?> (<?php echo esc_html($format); ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="_wc_cds_date_format">Formato de fecha:</label><br>
                                        <select name="wc_custom_delivery_slots[_wc_cds_date_format]" id="_wc_cds_date_format">
                                            <?php foreach ($date_formats as $format): ?>
                                                <option value="<?php echo esc_attr($format); ?>" <?php selected($selected_date_format, $format); ?>>
                                                    <?php echo esc_html(date_i18n($format, strtotime('2024-01-01'))); ?> (<?php echo esc_html($format); ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </td>
                            </tr>

                            <!--Métodos de envío-->
                            <tr>
                                <th style="padding-left: 10px; width: 50%;">
                                    <p>Límite de días para la configuración de los horarios de entrega</p>
                                    <small>Esto mantendrá la configuración de los horarios de entrega hasta la cantidad de días que elijas.</small>
                                </th>
                                <td style="padding-left: 10px; width: 50%;">
                                    <label for="_wc_cds_max_days">Ingresa la cantidad de días máximo de entrega</label><br>
                                    <input type="number" name="wc_custom_delivery_slots[_wc_cds_max_days]" id="_wc_cds_max_days" value="<?php echo isset($options['_wc_cds_max_days']) ? $options['_wc_cds_max_days'] : 30; ?>">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <hr class="margin-vertical-m">

            <!--Tab días especiales-->
            <section>
                <div>
                    <h2>Dias en los que aplicar los horarios de entrega</h2>
                    <p>Configuraciones de los días en los que aplicar los horarios de entrega.</p>
                    <table class="form-table widefat striped">
                        <tbody>

                            <!--Dias en los que aplicar los horarios de entrega-->
                            <tr>
                                <th style="padding-left: 10px; width: 50%;">
                                    <p>¿En que días quieres aplicar los horarios de entrega?</p>
                                    <small>Selecciona los días en los que quieres aplicar los horarios de entrega.</small>
                                </th>
                                <td style="padding-left: 10px; width: 50%;" class="flex-column gap-4xs">
                                    <div>
                                        <input type="checkbox" name="wc_custom_delivery_slots[_wc_cds_monday]" id="_wc_cds_monday" value="1" <?php checked(isset($options['_wc_cds_monday_days']), 1); ?>>
                                        <label for="_wc_cds_monday">Lunes</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" name="wc_custom_delivery_slots[_wc_cds_tuesday]" id="_wc_cds_tuesday" value="1" <?php checked(isset($options['_wc_cds_tuesday']), 1); ?>>
                                        <label for="_wc_cds_tuesday">Martes</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" name="wc_custom_delivery_slots[_wc_cds_wednesday]" id="_wc_cds_wednesday" value="1" <?php checked(isset($options['_wc_cds_wednesday']), 1); ?>>
                                        <label for="_wc_cds_wednesday">Miercoles</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" name="wc_custom_delivery_slots[_wc_cds_thursday]" id="_wc_cds_thursday" value="1" <?php checked(isset($options['_wc_cds_thursday']), 1); ?>>
                                        <label for="_wc_cds_thursday">Jueves</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" name="wc_custom_delivery_slots[_wc_cds_friday]" id="_wc_cds_friday" value="1" <?php checked(isset($options['_wc_cds_friday']), 1); ?>>
                                        <label for="_wc_cds_friday">Viernes</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" name="wc_custom_delivery_slots[_wc_cds_saturday]" id="_wc_cds_saturday" value="1" <?php checked(isset($options['_wc_cds_saturday']), 1); ?>>
                                        <label for="_wc_cds_saturday">Sabado</label>
                                    </div>
                                    <div>
                                        <input type="checkbox" name="wwc_custom_delivery_slots[_wc_cds_sunday]" id="_wc_cds_sunday" value="1" <?php checked(isset($options['_wc_cds_sunday']), 1); ?>>
                                        <label for="_wc_cds_sunday">Domingo</label>
                                    </div>
                                </td>
                            </tr>

                            <!--Dias especiales-->
                            <tr>
                                <th style="padding-left: 10px; width: 50%;">
                                    <p>Elige los días especiales en los que te gustaría configurar algunas condiciones adicionales</p>
                                    <small>Agrega los días especiales en los que te gustaría configurar algunas condiciones adicionales.</small>
                                </th>
                                <td style="padding-left: 10px; width: 50%;">
                                    <?php
                                    $special_dates = isset($options['_wc_cds_special_dates']) ? $options['_wc_cds_special_dates'] : array();
                                    wc_cds_render_special_dates_field($special_dates);
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <hr class="margin-vertical-m">

            <div>
                <?php
                settings_fields('wc_custom_delivery_slots_group');
                do_settings_sections('wc-custom-delivery-slots');
                submit_button('Guardar cambios', 'primary', 'submit', true);
                ?>
            </div>

        </form>

    <?php } else { ?>

        <div class="notice notice-warning margin-left-zero margin-top-s">
            <p><strong>Woocommerce está desactivado</strong></p>
            <p>Para poder utiliar el plugin es necesario que actives Woocommerce.</p>
        </div>

    <?php } ?>

</div>

<style>
    #wpcontent {
        padding-left: 0;
    }

    .wp-core-ui select {
        max-width: 100%;
        width: 100%;
    }

    .notice {
        margin: var(--space-m) 0 var(--space-m);
    }
</style>