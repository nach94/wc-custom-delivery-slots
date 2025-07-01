<?php
if ( ! defined( 'ABSPATH' ) ) exit;

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
                    <input id="_special_date_<?php echo $i; ?>" type="date" name="wc_cds[_wc_cds_special_dates][<?php echo $i; ?>][date]" value="<?php echo esc_attr($row['date']); ?>" required>
                </div>
                <div>
                    <label for="_special_fee_<?php echo $i; ?>">Selecciona una tarifa extra</label><br>
                    <input id="_special_fee_<?php echo $i; ?>" type="number" name="wc_cds[_wc_cds_special_dates][<?php echo $i; ?>][fee]" value="<?php echo esc_attr($row['fee']); ?>" min="0" step="0.01" placeholder="Tarifa extra" style="width:100px;" required>
                </div>
                <div>
                    <input id="_special_every_year_<?php echo $i; ?>" type="checkbox" name="wc_cds[_wc_cds_special_dates][<?php echo $i; ?>][every_year]" value="1" <?php checked($row['every_year'], '1'); ?>>
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