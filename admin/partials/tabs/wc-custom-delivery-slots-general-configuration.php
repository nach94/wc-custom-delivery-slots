<?php

require_once dirname( __FILE__ ) . '/../../../includes/utils/wc-custom-delivery-slots-utils.php';

?>

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
                        <input required type="checkbox" name="wc_cds[_wc_cds_activate]" id="_wc_cds_activate" value="1" <?php checked(isset($options['_wc_cds_activate']), 1); ?>>
                        <label for="_wc_cds_activate">Activar funcionalidad</label>
                    </td>
                </tr>

                <!--Métodos de envío-->
                <tr>
                    <th style="padding-left: 10px; width: 50%;">
                        <p>¿A qué metodos de envío se aplicarán los horarios de entrega?</p>
                        <small>Selecciona los métodos de envío para los que se aplicarán los horarios de entrega.</small>
                    </th>
                    <td style="padding-left: 10px; width: 50%;">
                        <?php
                        $selected_methods = isset($options['_wc_cds_shipping_methods']) ? $options['_wc_cds_shipping_methods'] : array();
                        wc_cds_list_shipping_methods_checkboxes($selected_methods);
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</section>