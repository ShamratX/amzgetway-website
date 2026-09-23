<?php

// namespace AvasElements;

use Elementor\Base_Data_Control;
// use Elementor\Plugin;

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}


class Select2  extends Base_Data_Control
{
    public function get_type()
    {
        return 'tx-select2';
    }

	public function enqueue() {
		wp_register_script( 'tx-select2', TX_PLUGIN_URL . '/assets/js/tx-select2.min.js',
			[ 'jquery-elementor-select2' ], TX_PLUGIN_VERSION, true );
		wp_localize_script(
			'tx-select2',
			'tx_select2_localize',
			[
				'ajaxurl'         =>  admin_url( 'admin-ajax.php' ),
				'search_text'     => esc_html__( 'Search', 'avas-core' ),
				'remove'          => __( 'Remove', 'avas-core' ),
				'thumbnail'       => __( 'Image', 'avas-core' ),
				'name'            => __( 'Title', 'avas-core' ),
				'price'           => __( 'Price', 'avas-core' ),
				'quantity'        => __( 'Quantity', 'avas-core' ),
				'subtotal'        => __( 'Subtotal', 'avas-core' ),
				'cl_login_status' => __( 'User Status', 'avas-core' ),
				'cl_post_type'    => __( 'Post Type', 'avas-core' ),
				'cl_browser'      => __( 'Browser', 'avas-core' ),
				'cl_date_time'    => __( 'Date & Time', 'avas-core' ),
				'cl_recurring_day'=> __( 'Recurring Day', 'avas-core' ),
				'cl_dynamic'      => __( 'Dynamic Field', 'avas-core' ),
				'cl_query_string' => __( 'Query String', 'avas-core' ),
			]
		);
		wp_enqueue_script( 'tx-select2' );
	}

    protected function get_default_settings()
    {
        return [
            'multiple' => false,
            'source_name' => 'post_type',
            'source_type' => 'post',
        ];
    }

    public function content_template()
    {
        $control_uid = $this->get_control_uid();
        ?>
        <# var controlUID = '<?php echo esc_html( $control_uid ); ?>'; #>
        <# var currentID = elementor.panel.currentView.currentPageView.model.attributes.settings.attributes[data.name]; #>
        <div class="elementor-control-field">
            <# if ( data.label ) { #>
            <label for="<?php echo esc_attr( $control_uid ); ?>" class="elementor-control-title">{{{data.label }}}</label>
            <# } #>
            <div class="elementor-control-input-wrapper elementor-control-unit-5">
                <# var multiple = ( data.multiple ) ? 'multiple' : ''; #>
                <select id="<?php echo esc_attr( $control_uid ); ?>" {{ multiple }} class="tx-select2" data-setting="{{ data.name }}"></select>
            </div>
        </div>
        <#
        ( function( $ ) {
        $( document.body ).trigger( 'tx_select2_init',{currentID:data.controlValue,data:data,controlUID:controlUID,multiple:data.multiple} );
        }( jQuery ) );
        #>
        <?php
    }
}
