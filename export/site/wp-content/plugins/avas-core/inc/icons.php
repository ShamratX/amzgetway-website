<?php
namespace AvasElements;

defined( 'ABSPATH' ) || exit;

class TX_Icons {

	public function __construct() {

		add_filter( 'elementor/icons_manager/additional_tabs', array( $this, 'register_icons' ) );
	}

	public function register_icons( $tabs ) {

        $tabs['font-awesome-light'] = [
            'name'          => 'font-awesome-light',
            'label'         => esc_html__( 'Font Awesome - Light(1852)', 'avas-core' ),
            'prefix'        => 'falight-',
            'displayPrefix' => 'falight',
            'labelIcon'     => 'falight falight-flag',
            'ver'           => TX_PLUGIN_VERSION,
            'url'           => TX_PLUGIN_URL . '/assets/fonts/fa-light/fa-light.min.css?v=' . TX_PLUGIN_VERSION,
            'fetchJson'     => TX_PLUGIN_URL . '/assets/fonts/fa-light/fa-light.json?v=' . TX_PLUGIN_VERSION,
            'native'        => true,
        ];
        $tabs['material-icon'] = [
            'name'          => 'material-icon',
            'label'         => esc_html__( 'Material(1144)', 'avas-core' ),
            'prefix'        => 'material-icon-',
            'displayPrefix' => 'material-icon-',
            'labelIcon'     => 'material-icon-flag',
            'ver'           => TX_PLUGIN_VERSION,
            'url'           => TX_PLUGIN_URL . '/assets/fonts/material/material-icons.min.css?v=' . TX_PLUGIN_VERSION,
            'fetchJson'     => TX_PLUGIN_URL . '/assets/fonts/material/material-icons.json?v=' . TX_PLUGIN_VERSION,
            'native'        => true,
        ];
        $tabs['iconic-fonts'] = [
            'name'          => 'iconic-fonts',
            'label'         => esc_html__( 'Iconic(300)', 'avas-core' ),
            'prefix'        => 'im-',
            'displayPrefix' => 'im',
            'labelIcon'     => 'im im-flag',
            'ver'           => TX_PLUGIN_VERSION,
            'url'           => TX_PLUGIN_URL . '/assets/fonts/iconic/iconic-font.min.css?v=' . TX_PLUGIN_VERSION,
            'fetchJson'     => TX_PLUGIN_URL . '/assets/fonts/iconic/iconic-fonts.json?v=' . TX_PLUGIN_VERSION,
            'native'        => true,
        ];
        $tabs['simple-line-icons'] = [
            'name'          => 'simple-line-icons',
            'label'         => esc_html__( 'Simple Line(189)', 'avas-core' ),
            'prefix'        => 'simple-line-icons-',
            'displayPrefix' => 'simple-line-icons-',
            'labelIcon'     => 'simple-line-icons simple-line-icons-flag',
            'ver'           => TX_PLUGIN_VERSION,
            'url'           => TX_PLUGIN_URL . '/assets/fonts/simple-line/simple-line-icons.min.css?v=' . TX_PLUGIN_VERSION,
            'fetchJson'     => TX_PLUGIN_URL . '/assets/fonts/simple-line/simple-line-icons.json?v=' . TX_PLUGIN_VERSION,
            'native'        => true,
        ];
        $tabs['linear-icons'] = [
            'name'          => 'linear-icons',
            'label'         => esc_html__( 'Linear(170)', 'avas-core' ),
            'prefix'        => 'lnr-',
            'displayPrefix' => 'lnr',
            'labelIcon'     => 'lnr lnr-flag',
            'ver'           => TX_PLUGIN_VERSION,
            'url'           => TX_PLUGIN_URL . '/assets/fonts/linear/linear-icons.min.css?v=' . TX_PLUGIN_VERSION,
            'fetchJson'     => TX_PLUGIN_URL . '/assets/fonts/linear/linear-icons.json?v=' . TX_PLUGIN_VERSION,
            'native'        => true,
        ];
        

        return $tabs;
    }

}

new TX_Icons();