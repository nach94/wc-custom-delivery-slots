<?php
// Asegurar que las funciones de WordPress y WooCommerce estén disponibles
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');
}
if (!defined('WP_PLUGIN_DIR')) {
    define('WP_PLUGIN_DIR', ABSPATH . 'wp-content/plugins');
}
if (!function_exists('get_option')) {
    require_once(ABSPATH . 'wp-includes/option.php');
}
if (!class_exists('WC_Shipping_Zones') && class_exists('WooCommerce')) {
    // WooCommerce debería estar activo, pero por si acaso
    include_once WP_PLUGIN_DIR . '/woocommerce/includes/class-wc-shipping-zones.php';
    include_once WP_PLUGIN_DIR . '/woocommerce/includes/class-wc-shipping-zone.php';
}

add_action('admin_post_save_wc_cds_time_slots', 'save_wc_cds_time_slots');
function save_wc_cds_time_slots()
{
    if (!current_user_can('manage_options')) {
        wp_die('No tienes permisos suficientes.');
    }
    if (!isset($_POST['wc_cds_time_slots_nonce']) || !wp_verify_nonce($_POST['wc_cds_time_slots_nonce'], 'save_wc_cds_time_slots_nonce')) {
        wp_die('Nonce inválido.');
    }

    $slots = isset($_POST['slots']) ? $_POST['slots'] : [];
    // Limpia y valida los datos aquí si es necesario

    update_option('wc_cds_time_slots', $slots);

    wp_redirect(add_query_arg(['page' => 'wc-custom-delivery-slots', 'settings-updated' => 'true'], admin_url('admin.php')));
    exit;
}

$options = get_option('wc_custom_delivery_slots', []);
$shipping_methods = isset($options['_wc_cds_shipping_methods']) ? $options['_wc_cds_shipping_methods'] : [];
$days_of_week = [
    'monday'    => 'Lunes',
    'tuesday'   => 'Martes',
    'wednesday' => 'Miércoles',
    'thursday'  => 'Jueves',
    'friday'    => 'Viernes',
    'saturday'  => 'Sábado',
    'sunday'    => 'Domingo',
];
$active_days = [];
foreach ($days_of_week as $key => $label) {
    if (!empty($options['_wc_cds_' . $key])) {
        $active_days[$key] = $label;
    }
}
$special_dates = isset($options['_wc_cds_special_dates']) ? $options['_wc_cds_special_dates'] : [];
$time_slots = get_option('wc_cds_time_slots', []);

// Obtener todos los métodos de envío disponibles (ID => Label)
$all_shipping_methods = [];
if (class_exists('WC_Shipping_Zones')) {
    $zones = WC_Shipping_Zones::get_zones();
    foreach ($zones as $zone) {
        $zone_obj = new WC_Shipping_Zone($zone['id']);
        foreach ($zone_obj->get_shipping_methods() as $method) {
            $all_shipping_methods[$method->id] = $method->get_method_title();
        }
    }
    $default_zone = new WC_Shipping_Zone(0);
    foreach ($default_zone->get_shipping_methods() as $method) {
        $all_shipping_methods[$method->id] = $method->get_method_title();
    }
}

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

        <h2 class="text-m font-700">Configuración de slots de entrega</h2>
        <form id="_wc_custom_delivery_slots_form_slots_config" method="post" action="<?php echo admin_url('admin-post.php'); ?>">
            <input type="hidden" name="action" value="save_wc_cds_time_slots">
            <?php wp_nonce_field('save_wc_cds_time_slots_nonce', 'wc_cds_time_slots_nonce'); ?>

            <div id="slots-repeater" class="slots-repeater">
                <?php if (!empty($time_slots)): ?>
                    <?php foreach ($time_slots as $i => $slot): ?>
                        <div class="slot-item margin-bottom-m padding-m bg-light-grey border-radius-s">
                            <div class="flex-row gap-m">
                                <div>
                                    <label>Desde</label>
                                    <input type="time" name="slots[<?php echo $i; ?>][from]" value="<?php echo esc_attr($slot['from']); ?>" required>
                                </div>
                                <div>
                                    <label>Hasta</label>
                                    <input type="time" name="slots[<?php echo $i; ?>][to]" value="<?php echo esc_attr($slot['to']); ?>" required>
                                </div>
                            </div>
                            <div class="margin-top-s">
                                <label>Métodos de envío</label>
                                <div class="flex-row gap-s">
                                    <?php foreach ($all_shipping_methods as $method_id => $method_label): ?>
                                        <label>
                                            <input type="checkbox" name="slots[<?php echo $i; ?>][shipping_methods][]" value="<?php echo esc_attr($method_id); ?>" <?php echo (isset($slot['shipping_methods']) && in_array($method_id, (array)$slot['shipping_methods'])) ? 'checked' : ''; ?>>
                                            <?php echo esc_html($method_label); ?>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="margin-top-s">
                                <label>Días y fechas especiales</label>
                                <div class="flex-row gap-s">
                                    <?php foreach ($active_days as $day_key => $day_label): ?>
                                        <label>
                                            <input type="checkbox" name="slots[<?php echo $i; ?>][days][]" value="<?php echo esc_attr($day_key); ?>" <?php echo (isset($slot['days']) && in_array($day_key, (array)$slot['days'])) ? 'checked' : ''; ?>>
                                            <?php echo esc_html($day_label); ?>
                                        </label>
                                    <?php endforeach; ?>
                                    <?php foreach ($special_dates as $date): ?>
                                        <?php if (!empty($date['date'])): ?>
                                            <label>
                                                <input type="checkbox" name="slots[<?php echo $i; ?>][days][]" value="<?php echo esc_attr($date['date']); ?>" <?php echo (isset($slot['days']) && in_array($date['date'], (array)$slot['days'])) ? 'checked' : ''; ?>>
                                                <?php echo esc_html(date_i18n('Y-m-d', strtotime($date['date']))); ?>
                                            </label>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <button type="button" class="remove-slot margin-top-s">Eliminar</button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <button type="button" id="add-slot" class="button button-secondary margin-top-m">Agregar slot</button>
            <br><br>
            <?php submit_button('Guardar cambios', 'primary', 'submit', true); ?>
        </form>

        <!-- Template oculto para nuevos slots -->
        <div id="slot-template" style="display:none;">
            <div class="slot-item margin-bottom-m padding-m bg-light-grey border-radius-s">
                <div class="flex-row gap-m">
                    <div>
                        <label>Desde</label>
                        <input type="time" name="__name__[from]" required>
                    </div>
                    <div>
                        <label>Hasta</label>
                        <input type="time" name="__name__[to]" required>
                    </div>
                </div>
                <div class="margin-top-s">
                    <label>Métodos de envío</label>
                    <div class="flex-row gap-s">
                        <?php foreach ($all_shipping_methods as $method_id => $method_label): ?>
                            <label>
                                <input type="checkbox" name="__name__[shipping_methods][]" value="<?php echo esc_attr($method_id); ?>">
                                <?php echo esc_html($method_label); ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="margin-top-s">
                    <label>Días y fechas especiales</label>
                    <div class="flex-row gap-s">
                        <?php foreach ($active_days as $day_key => $day_label): ?>
                            <label>
                                <input type="checkbox" name="__name__[days][]" value="<?php echo esc_attr($day_key); ?>">
                                <?php echo esc_html($day_label); ?>
                            </label>
                        <?php endforeach; ?>
                        <?php foreach ($special_dates as $date): ?>
                            <?php if (!empty($date['date'])): ?>
                                <label>
                                    <input type="checkbox" name="__name__[days][]" value="<?php echo esc_attr($date['date']); ?>">
                                    <?php echo esc_html(date_i18n('Y-m-d', strtotime($date['date']))); ?>
                                </label>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <button type="button" class="remove-slot margin-top-s">Eliminar</button>
            </div>
        </div>

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


<script>
    document.addEventListener('DOMContentLoaded', function() {
        let repeater = document.getElementById('slots-repeater');
        let template = document.getElementById('slot-template').innerHTML;
        let addBtn = document.getElementById('add-slot');
        let slotIndex = repeater.children.length;

        function addSlot() {
            let html = template.replace(/__name__/g, 'slots[' + slotIndex + ']');
            let tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;
            repeater.appendChild(tempDiv.firstElementChild);
            slotIndex++;
        }

        addBtn.addEventListener('click', addSlot);

        repeater.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-slot')) {
                e.target.closest('.slot-item').remove();
            }
        });

        // Si no hay slots, agrega uno vacío al cargar
        if (slotIndex === 0) {
            addSlot();
        }
    });
</script>