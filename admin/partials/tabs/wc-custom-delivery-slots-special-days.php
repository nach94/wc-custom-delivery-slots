<?php
require_once dirname(__FILE__) . '/../../../includes/utils/wc-cds-special-dates-field.php';
?>

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
                    <td style="padding-left: 10px; width: 50%;">
                        <input required type="checkbox" name="wc_cds[_wc_cds_monday]" id="_wc_cds_monday" value="1" <?php checked(isset($options['_wc_cds_monday_days']), 1); ?>>
                        <label for="_wc_cds_monday">Lunes</label><br>
                        <input type="checkbox" name="wc_cds[_wc_cds_tuesday]" id="_wc_cds_tuesday" value="1" <?php checked(isset($options['_wc_cds_tuesday']), 1); ?>>
                        <label for="_wc_cds_tuesday">Martes</label><br>
                        <input type="checkbox" name="wc_cds[_wc_cds_wednesday]" id="_wc_cds_wednesday" value="1" <?php checked(isset($options['_wc_cds_wednesday']), 1); ?>>
                        <label for="_wc_cds_wednesday">Miercoles</label><br>
                        <input type="checkbox" name="wc_cds[_wc_cds_thursday]" id="_wc_cds_thursday" value="1" <?php checked(isset($options['_wc_cds_thursday']), 1); ?>>
                        <label for="_wc_cds_thursday">Jueves</label><br>
                        <input type="checkbox" name="wc_cds[_wc_cds_friday]" id="_wc_cds_friday" value="1" <?php checked(isset($options['_wc_cds_friday']), 1); ?>>
                        <label for="_wc_cds_friday">Viernes</label><br>
                        <input type="checkbox" name="wc_cds[_wc_cds_saturday]" id="_wc_cds_saturday" value="1" <?php checked(isset($options['_wc_cds_saturday']), 1); ?>>
                        <label for="_wc_cds_saturday">Sabado</label><br>
                        <input type="checkbox" name="wc_cds[_wc_cds_sunday]" id="_wc_cds_sunday" value="1" <?php checked(isset($options['_wc_cds_sunday']), 1); ?>>
                        <label for="_wc_cds_sunday">Domingo</label><br>
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