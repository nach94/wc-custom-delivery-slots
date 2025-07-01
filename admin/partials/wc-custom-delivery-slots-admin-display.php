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

$options = get_option('wc_cds', []);
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
            <div id="tab-1">
                <?php include 'tabs/wc-custom-delivery-slots-general-configuration.php'; ?>
            </div>

            <!--Tab días especiales--> 
                <div id="tab-2">
                    <?php include 'tabs/wc-custom-delivery-slots-special-days.php'; ?>
                </div>

            <!--Tab horarios de entrega-->
            <div id="tab-3">
                <?php include 'tabs/wc-custom-delivery-slots-delivery-slots.php'; ?>
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
    }

    .notice {
        margin: var(--space-m) 0 var(--space-m);
    }
</style>