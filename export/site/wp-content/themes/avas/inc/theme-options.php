<?php
/**
 * 
* @package tx
* @author theme-x
* @link https://theme-x.org/
*
 */

    defined( 'ABSPATH' ) || exit;

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }

    // Used to execept HTML tags in description arguments where esc_html would remove.
    $kses_exceptions = array(
        'a'      => array(
            'href' => array(),
        ),
        'strong' => array(),
        'br'     => array(),
        'code'   => array(),
    );

    /*
     * ---> BEGIN ARGUMENTS
     */

    /**
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://docs.redux.io/core/arguments/
     */
    // This is your option name where all the Redux data is stored.
    $opt_name = "tx";
    $theme = wp_get_theme(); // For use with some settings. Not necessary.
    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => $theme->get( 'Name' ),
        // Name that appears at the top of your panel
        'display_version'      => $theme->get( 'Version' ),
        // Version that appears at the top of your panel
        'menu_type'            => 'menu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => false,
        // Show the sections below the admin menu item or not
        'menu_title'           => esc_html__( 'Theme Options', 'avas' ),
        'page_title'           => esc_html__( 'Theme Options', 'avas' ),
        'async_typography'     => false,
        // Use a asynchronous font on the front end or font string
        'disable_google_fonts_link' => false,  // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => true,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-menu',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 40,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
        // Show the time the page took to load, etc
        'customizer'           => true,
        // Enable basic customizer support
        'open_expanded'     => false,                    // Allow you to start the panel in an expanded way initially.
        'disable_save_warn' => false,                    // Disable the save warning when a user changes a field
        // OPTIONAL -> Give you extra features
        'page_priority'        => 61,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'themes.php',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            =>  TX_IMAGES.'icon.png',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => '',
        // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.
        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.
        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
        'network_admin'             => true,
        'use_cdn'              => true,
        // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.
        // Set the theme of the option panel.  Use 'classic' to revert to the Redux 3 style.
        'admin_theme'               => 'wp',

        // Enable or disable flyout menus when hovering over a menu with submenus.
        'flyout_submenus'           => true,

        // Mode to display fonts (auto|block|swap|fallback|optional)
        // See: https://developer.mozilla.org/en-US/docs/Web/CSS/@font-face/font-display.
        'font_display'              => 'swap',

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'red',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );
    // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
    $args['share_icons'][] = array(
        'url'   => esc_url('https://avas.live/'),
        'title' => esc_html__('Visit our website', 'avas'),
        'icon'  => 'el el-globe-alt'
    );
    $args['share_icons'][] = array(
        'url'   => esc_url('https://avas.live/documentation'),
        'title' => esc_html__('Check our documentation', 'avas'),
        'icon'  => 'el el-file'
    );
    $args['share_icons'][] = array(
        'url'   => esc_url('https://www.youtube.com/c/AvasWordPressTheme'),
        'title' => esc_html__('Watch video tutorials on Youtube', 'avas'),
        'icon'  => 'el el-youtube'
    );
    $args['share_icons'][] = array(
        'url'   => esc_url('https://www.facebook.com/avas.wordpress.theme'),
        'title' => esc_html__('Like us on Facebook', 'avas'),
        'icon'  => 'el el-facebook'
    );
    $args['share_icons'][] = array(
        'url'   => esc_url('https://x.com/AvasTheme'),
        'title' => esc_html__('Follow us on Twitter', 'avas'),
        'icon'  => 'el el-twitter'
    );

    $standard_fonts = array(
        "CustomFont"                                           => "CustomFont",
        "CustomFontTwo"                                        => "CustomFontTwo",
        "Arial, Helvetica, sans-serif"                         => "Arial, Helvetica, sans-serif",
        "'Arial Black', Gadget, sans-serif"                    => "'Arial Black', Gadget, sans-serif",
        "'Bookman Old Style', serif"                           => "'Bookman Old Style', serif",
        "'Comic Sans MS', cursive"                             => "'Comic Sans MS', cursive",
        "Courier, monospace"                                   => "Courier, monospace",
        "Garamond, serif"                                      => "Garamond, serif",
        "Georgia, serif"                                       => "Georgia, serif",
        "Impact, Charcoal, sans-serif"                         => "Impact, Charcoal, sans-serif",
        "'Lucida Console', Monaco, monospace"                  => "'Lucida Console', Monaco, monospace",
        "'Lucida Sans Unicode', 'Lucida Grande', sans-serif"   => "'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
        "'MS Sans Serif', Geneva, sans-serif"                  => "'MS Sans Serif', Geneva, sans-serif",
        "'MS Serif', 'New York', sans-serif"                   => "'MS Serif', 'New York', sans-serif",
        "'Palatino Linotype', 'Book Antiqua', Palatino, serif" => "'Palatino Linotype', 'Book Antiqua', Palatino, serif",
        "Tahoma,Geneva, sans-serif"                            => "Tahoma, Geneva, sans-serif",
        "'Times New Roman', Times,serif"                       => "'Times New Roman', Times, serif",
        "'Trebuchet MS', Helvetica, sans-serif"                => "'Trebuchet MS', Helvetica, sans-serif",
        "Verdana, Geneva, sans-serif"                          => "Verdana, Geneva, sans-serif"
    );

    Redux::setArgs( $opt_name, $args );
    /*
     * ---> END ARGUMENTS
     */
    /*
     *
     * ---> START SECTIONS
     *
     */
    /*
        As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for
     */
    // Global Options
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Global', 'avas' ),
        'id'               => 'global',
        'customizer_width' => '344px',
        'icon'             => 'bi bi-globe'
    ) );
    // General Options
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'General', 'avas' ),
        'id'               => 'general',
        'subsection'       => true,
        'customizer_width' => '344px',
        'fields'           => array(
            array(
                'title'    => esc_html__('Favicon', 'avas'),
                'id'       => 'favicon',
                'type'     => 'media',
                'complier' => true,
                'url'      => true,
                'desc'     => esc_html__( 'You can upload .png, .jpg, .gif and .ico image format for favicon.', 'avas' ),
                'default'  => array(
                    'url'      => TX_IMAGES.'icon.png'
                )
            ),
            array(
                'id'        => 'mob_version',
                'type'      => 'switch',
                'title'     => esc_html__('Mobile Version', 'avas'),
                'desc'     => esc_html__('If you would like to display desktop version in mobile device you can disable mobile version.', 'avas'),
                'default'   => 1,
                'on'        => esc_html__('Enable', 'avas'),
                'off'       => esc_html__('Disable', 'avas')
            ),

            array(
                'id'       => 'selection-bg-color',
                'type'     => 'color',
                'output'   => array('background-color' => '::selection'),
                'title'    => esc_html__( 'Selection Background Color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'selection-text-color',
                'type'     => 'color',
                'output'   => array('color' => '::selection'),
                'title'    => esc_html__( 'Selection Text Color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'page-layout',
                'type'     => 'image_select',
                'title' => esc_html__('Body Layout', 'avas'),
                'options'  => array(
                    'full-width' => array('title' => 'Width', 'img' => TX_IMAGES .'body-full.png'),
                    'boxed'      => array('title' => 'Boxed', 'img' => TX_IMAGES .'body-boxed.png'),
                ),
                'default'  => 'full-width',
            ),
            array(
                'id'    => 'body-background',
                'title' => esc_html__( 'Body Background', 'avas' ),
                'type'  => 'background',
                'output'   => array('background' => 'body'),
                'transparent' => false,
                'default'  => array(
                    'background-color' => '',
                ),
            ),
            array(
                'id'    => 'wrap-background',
                'title' => esc_html__( 'Wrapper Background', 'avas' ),
                'type'  => 'background',
                'output'   => array('background' => '.tx-wrapper'),
                'transparent' => false,
                'default'  => array(
                    'background-color' => '',
                ),
                'required'  => array( 'page-layout', '=', 'boxed' ),
            ),
            array(
                'id'    => 'wrap-margin',
                'type'  => 'spacing',
                'output'         => array('.tx-wrapper'),
                'mode'           => 'margin',
                'units'          => array('px', 'em'),
                'units_extended' => 'false',
                'title'          => esc_html__('Wrapper Margin', 'avas'),
                'desc'          => esc_html__('Plase enter Top and Bottom value only. Left and Right value default "auto". Do not enter Left or Right value otherwise it will break layout. ', 'avas'),
                'default'            => array(
                    'margin-top'     => '0', 
                    'margin-right'   => '', 
                    'margin-bottom'  => '0', 
                    'margin-left'    => '',
                    'units'          => 'px', 
                ),
                'required'  => array( 'page-layout', '=', 'boxed' ),
                ),
            array(
                'id'             => 'wrap-padding',
                'type'           => 'spacing',
                'output'         => array('.tx-wrapper'),
                'mode'           => 'padding',
                'units'          => array('px', 'em'),
                'units_extended' => 'false',
                'title'          => esc_html__('Wrapper Padding', 'avas'),
                'default'            => array(
                    'padding-top'     => '', 
                    'padding-right'   => '', 
                    'padding-bottom'  => '', 
                    'padding-left'    => '',
                    'units'          => 'px', 
                ),
                'required'  => array( 'page-layout', '=', 'boxed' ),
            ),
            array(
                    'id'       => 'wrap-border-top',
                    'type'     => 'border',
                    'title'    => esc_html__('Wrapper Border', 'avas'),
                    'desc'     => esc_html__( 'Enter border width ex: 1, 2, 3 etc to enable border. 0 to disable.', 'avas' ),
                    'output'   => array('.tx-wrapper'),
                    'color'    => true,
                    'all'      => false,
                    'default'  => array(
                        'border-color'  => '', 
                        'border-style'  => 'solid', 
                        'border-top'    => '0',
                        'border-right'    => '0',
                        'border-bottom'    => '0',
                        'border-left'    => '0',
                        ),
                    'required'  => array( 'page-layout', '=', 'boxed' ),
                ),
            // General Color Options
            array(
                    'id'        => 'general-colors',
                    'type'      => 'info',
                    'title'     => esc_html__('Colors Options', 'avas'),
                    'style'     => 'success',
                ),
            array(
                'id'       => 'body',
                'type'     => 'color',
                'output'   => array('body'),
                'title'    => esc_html__( 'Body text color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'link-color',
                'type'     => 'color',
                'output'   => array('a'),
                'title'    => esc_html__( 'Link color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'link-hover-color',
                'type'     => 'color',
                'output'   => array('a:hover'),
                'title'    => esc_html__( 'Link hover color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'link-focus-color',
                'type'     => 'color',
                'output'   => array('a:focus'),
                'title'    => esc_html__( 'Link focus color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'h1-color',
                'type'     => 'color',
                'output'   => array('h1'),
                'title'    => esc_html__( 'H1 color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'h2-color',
                'type'     => 'color',
                'output'   => array('h2'),
                'title'    => esc_html__( 'H2 color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'h3-color',
                'type'     => 'color',
                'output'   => array('h3'),
                'title'    => esc_html__( 'H3 color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'h4-color',
                'type'     => 'color',
                'output'   => array('h4'),
                'title'    => esc_html__( 'H4 color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'h5-color',
                'type'     => 'color',
                'output'   => array('h5'),
                'title'    => esc_html__( 'H5 color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'h6-color',
                'type'     => 'color',
                'output'   => array('h6'),
                'title'    => esc_html__( 'H6 color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            // General Fonts Options
            array(
                    'id'        => 'general-fonts',
                    'type'      => 'info',
                    'title'     => esc_html__('Fonts Options', 'avas'),
                    'style'     => 'success',
                ),
            array(
                'id'       => 'typography-body',
                'type'     => 'typography',
                'title'    => esc_html__( 'Body Fonts', 'avas' ),
                'google'   => true,
                'fonts' => $standard_fonts,
                'font-backup' => false,
                'output'      => array('body'),
                'units'       =>'px',
                'font-style'  => true,
                'all_styles'  => false,
                'color'         => false,
                'text-align'    => false,
                'text-transform'=> true,
                'subsets'       => true,
                'allow_empty_line_height' => true,
            ),
            array(
                'id'       => 'typography-h1',
                'type'     => 'typography',
                'title'    => esc_html__( 'H1 Fonts', 'avas' ),
                'subtitle' => esc_html__( 'Specify the H1 font properties.', 'avas' ),
                'google'   => true,
                'fonts' => $standard_fonts,
                'font-backup' => false,
                'output'      => array('h1'),
                'units'       =>'px',
                'font-style'  => true,
                'all_styles'  => true,
                'word-spacing'  => true,
                'letter-spacing'=> true,
                'text-transform'=> true,
                'color'         => false,
                'text-align'    => false,
                'subsets'       => true,
                'allow_empty_line_height' => true,
            ),
            array(
                'id'       => 'typography-h2',
                'type'     => 'typography',
                'title'    => esc_html__( 'H2 Fonts', 'avas' ),
                'subtitle' => esc_html__( 'Specify the H2 font properties.', 'avas' ),
                'google'   => true,
                'fonts' => $standard_fonts,
                'font-backup' => false,
                'output'      => array('h2'),
                'units'       =>'px',
                'font-style'  => true,
                'all_styles'  => true,
                'word-spacing'  => true,
                'letter-spacing'=> true,
                'text-transform'=> true,
                'color'         => false,
                'text-align'    => false,
                'subsets'       => true,
                'allow_empty_line_height' => true,
            ),
            array(
                'id'       => 'typography-h3',
                'type'     => 'typography',
                'title'    => esc_html__( 'H3 Fonts', 'avas' ),
                'subtitle' => esc_html__( 'Specify the H3 font properties.', 'avas' ),
                'google'   => true,
                'fonts' => $standard_fonts,
                'font-backup' => false,
                'output'      => array('h3'),
                'units'       =>'px',
                'font-style'  => true,
                'all_styles'  => true,
                'word-spacing'  => true,
                'letter-spacing'=> true,
                'text-transform'=> true,
                'color'         => false,
                'text-align'    => false,
                'subsets'       => true,
                'allow_empty_line_height' => true,
            ),
            array(
                'id'       => 'typography-h4',
                'type'     => 'typography',
                'title'    => esc_html__( 'H4 Fonts', 'avas' ),
                'subtitle' => esc_html__( 'Specify the H4 font properties.', 'avas' ),
                'google'   => true,
                'fonts' => $standard_fonts,
                'font-backup' => false,
                'output'      => array('h4'),
                'units'       =>'px',
                'font-style'  => true,
                'all_styles'  => true,
                'word-spacing'  => true,
                'letter-spacing'=> true,
                'text-transform'=> true,
                'color'         => false,
                'text-align'    => false,
                'subsets'       => true,
                'allow_empty_line_height' => true,
            ),
            array(
                'id'       => 'typography-h5',
                'type'     => 'typography',
                'title'    => esc_html__( 'H5 Fonts', 'avas' ),
                'subtitle' => esc_html__( 'Specify the H5 font properties.', 'avas' ),
                'google'   => true,
                'fonts' => $standard_fonts,
                'font-backup' => false,
                'output'      => array('h5'),
                'units'       =>'px',
                'font-style'  => true,
                'all_styles'  => true,
                'word-spacing'  => true,
                'letter-spacing'=> true,
                'text-transform'=> true,
                'color'         => false,
                'text-align'    => false,
                'subsets'       => true,
                'allow_empty_line_height' => true,
            ),
            array(
                'id'       => 'typography-h6',
                'type'     => 'typography',
                'title'    => esc_html__( 'H6 Fonts', 'avas' ),
                'subtitle' => esc_html__( 'Specify the H6 font properties.', 'avas' ),
                'google'   => true,
                'fonts' => $standard_fonts,
                'font-backup' => false,
                'output'      => array('h6'),
                'units'       =>'px',
                'font-style'  => true,
                'all_styles'  => true,
                'word-spacing'  => true,
                'letter-spacing'=> true,
                'color'         => false,
                'text-align'    => false,
                'text-transform'=> true,
                'subsets'       => true,
                'allow_empty_line_height' => true,
            ),
            array(
                'id'        => 'tx_custom_font_ttf',
                'type'     => 'media',
                'url'      => true,
                'compiler' => true,
                // 'url'      => true,
                'title'    => esc_html__( 'Custom Font', 'avas' ),
                'desc' => esc_html__( 'If you get the error message \'Sorry, this file type is not permitted for security reasons\', you can add this line define(\'ALLOW_UNFILTERED_UPLOADS\', true); to the wp-config.php file', 'avas' ),
                'subtitle' => esc_html__( 'Upload the .ttf, .otf, etc font file. To use it, you select CustomFont in the Standard Fonts group', 'avas' ),
                // 'default'  => array( 'url' => '' ),
                'mode'     => 'font',
                'permissions' => 'manage_options'
            ),
            array(
                'id'        => 'tx_custom_font_two',
                'type'     => 'media',
                'url'      => true,
                'compiler' => true,
                // 'url'      => true,
                'title'    => esc_html__( 'Custom Font Two', 'avas' ),
                'desc' => esc_html__( 'If you get the error message \'Sorry, this file type is not permitted for security reasons\', you can add this line define(\'ALLOW_UNFILTERED_UPLOADS\', true); to the wp-config.php file', 'avas' ),
                'subtitle' => esc_html__( 'Upload the .ttf, .otf, etc font file. To use it, you select CustomFontTwo in the Standard Fonts group', 'avas' ),
                // 'default'  => array( 'url' => '' ),
                'mode'     => 'font',
                'permissions' => 'manage_options'
            ),

        )
    ) );

    // Logo Options
    Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Logo', 'avas' ),
        'id'         => 'logo',
        'subsection' => true,
        'fields'     => array(
            array(
                'title'    => esc_html__('Logo', 'avas'),
                'id'       => 'tx_logo',
                'type'     => 'media',
                'complier' => true,
                'url'      => true,
                'desc'     => esc_html__( 'You can upload .png, .jpg, .gif image format.', 'avas' ),
                'default'  => array(
                    'url'=> TX_IMAGES . 'logo.png'
                )
            ),
            array(
                'title'    => esc_html__('Mobile Logo', 'avas'),
                'id'       => 'tx_logo_mobile',
                'type'     => 'media',
                'complier' => true,
                'url'      => true,
                'desc'     => esc_html__( 'You can upload .png, .jpg, .gif image format.', 'avas' ),
                'default'  => array(
                    'url'=> TX_IMAGES . 'logo-mobile.png'
                )
            ),
            array(
                'title'    => esc_html__('Sticky Logo', 'avas'),
                'id'       => 'tx_logo_sticky',
                'type'     => 'media',
                'complier' => true,
                'url'      => true,
                'desc'     => esc_html__( 'You can upload .png, .jpg, .gif image format.', 'avas' ),
                'default'  => array(
                    'url'=> TX_IMAGES . 'logo-sticky.png'
                )
            ),
            array(
                'title'    => esc_html__('Sticky Mobile Logo', 'avas'),
                'id'       => 'tx_logo_mobile_sticky',
                'type'     => 'media',
                'complier' => true,
                'url'      => true,
                'desc'     => esc_html__( 'You can upload .png, .jpg, .gif image format.', 'avas' ),
                'default'  => array(
                    'url'=> TX_IMAGES . 'logo-mobile-sticky.png'
                )
            ),
            array(
                'id'       => 'logo_link_url',
                'type'     => 'text',
                'title'    => esc_html__('Logo Link URL','avas'),
                'desc'    => esc_html__('Enter your custom link URL. Default is home page URL','avas'),
                'default'  => '',
                ),
            array(
                'id'            => 'logo-resize',
                'type'          => 'slider',
                'title'         => esc_html__( 'Logo Resize for Desktop', 'avas' ),
                'min'           => 0,
                'step'          => 1,
                'max'           => 100,
                'display_value' => 'text'
            ),
            array(
                'id'            => 'logo-resize-responsive',
                'type'          => 'slider',
                'title'         => esc_html__( 'Logo Resize for Responsive Device', 'avas' ),
                'min'           => 0,
                'step'          => 1,
                'max'           => 300,
                'display_value' => 'text'
            ),
            array(
                'id'             => 'logo_space',
                'type'           => 'spacing',
                'output'         => array('.tx_logo,.header-style-one .tx_logo,.header-style-two .tx_logo,.header-style-four .tx_logo,.header-style-six .tx_logo,.header-style-seven .tx_logo,.header-style-eight .tx_logo'),
                'mode'           => 'padding',
                'units'          => array('px', 'em'),
                'units_extended' => 'false',
                'title'          => esc_html__('Logo Padding', 'avas'),
                'default'            => array(
                    'units'          => 'px', 
                ),
            ),
            
        )
    ) );
    //Preloader option
    Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Preloader', 'avas' ),
            'id'         => 'preloader-sec',
            'subsection' => true,
            'fields'     => array(
            array(
                'id'        => 'preloader',
                'type'      => 'switch',
                'title'     => esc_html__('Preloader', 'avas'),
                'default'   => 0,
                'on'        => esc_html__('Enable', 'avas'),
                'off'       => esc_html__('Disable', 'avas')
            ),
            array(
                'id'       => 'preloader-bg-color',
                'type'     => 'color',
                'output'   => array('background-color' => '.tx-main-preloader'),
                'title'    => esc_html__( 'Prealoader Background Color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
                'required'  => array( 'preloader', '=', '1' ),
            ),
            array(
                'id'       => 'preloader-color',
                'type'     => 'color',
                'output'   => array('color' => '.tx-main-preloader .tx-preloader-percentage'),
                'title'    => esc_html__( 'Prealoader Percentage Color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
                'required'  => array( 'preloader', '=', '1' ),
            ),
            array(
                'id'       => 'preloader-loader-color',
                'type'     => 'color',
                'output'   => array('background-color' => '.tx-preloader-loader span'),
                'title'    => esc_html__( 'Prealoader Loader Color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
                'required'  => array( 'preloader', '=', '1' ),
            ),
            array(
                'id'       => 'preloader-bar-color',
                'type'     => 'color',
                'output'   => array('background-color' => '.tx-main-preloader .tx-preloader-bar'),
                'title'    => esc_html__( 'Prealoader Progress Bar Color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
                'required'  => array( 'preloader', '=', '1' ),
            ),
            array(
                'id'            => 'preloader-bar-height',
                'type'          => 'slider',
                'title'         => esc_html__( 'Prealoader Bar Height', 'avas' ),
                'max'           => 100,
                'default'       => 7,
                'display_value' => 'text',
                'required'  => array( 'preloader', '=', '1' ),
            ),
            array(
                'id'       => 'preloader-percentage-typo',
                'type'     => 'typography',
                'title'    => esc_html__( 'Preloader Percentage Typography', 'avas' ),
                'google'   => true,
                'font-backup' => false,
                'output'      => array('.tx-main-preloader .tx-preloader-percentage span'),
                'units'       =>'px',
                'fonts' => $standard_fonts,
                'font-style'  => true,
                'all_styles'  => true,
                'word-spacing'  => true,
                'letter-spacing'=> true,
                'text-transform'=> true,
                'color'         => false,
                'text-align'    => false,
                'subsets'       => true,
                'allow_empty_line_height' => true,
                'required'  => array( 'preloader', '=', '1' ),
            ),
        )));
        // Scroll Progress-bar
        Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Scroll Progress Bar', 'avas' ),
            'id'         => 'scroll-progress-bar-sec',
            'subsection' => true,
            'fields'     => array(
            array(
                'id'        => 'scroll-progress-bar',
                'type'      => 'switch',
                'title'     => esc_html__('Scroll Progress Bar Option', 'avas'),
                'default'   => 0,
                'on'        => esc_html__('Enable', 'avas'),
                'off'       => esc_html__('Disable', 'avas')
            ),
            array(
                'id'       => 'scroll-progress-bar-bg-color',
                'type'     => 'color_rgba',
                'output'   => array('background-color' => '.tx-scroll-progress-bar'),
                'title'    => esc_html__( 'Scroll Progress Bar Background Color', 'avas' ),
                'required'  => array( 'scroll-progress-bar', '=', '1' ),
            ),
            array(
                'id'            => 'scroll-progress-bar-height',
                'type'          => 'slider',
                'title'         => esc_html__( 'Scroll Progress Bar Height', 'avas' ),
                'max'           => 100,
                'default'       => 8,
                'display_value' => 'text',
                'required'  => array( 'scroll-progress-bar', '=', '1' ),
            ),
        )));

        // Cursor
        Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Cursor', 'avas' ),
            'id'         => 'tx_cursor',
            'subsection' => true,
            'fields'     => array(
            array(
                'id'        => 'tx_custom_cursor',
                'type'      => 'switch',
                'title'     => esc_html__('Custom Cursor', 'avas'),
                'default'   => 0,
                'on'        => esc_html__('Enable', 'avas'),
                'off'       => esc_html__('Disable', 'avas')
            ),
            array(
                'id'            => 'tx_custom_cursor_ring_size',
                'type'          => 'slider',
                'title'         => esc_html__( 'Cursor Ring Size', 'avas' ),
                'max'           => 200,
                'default'       => array(
                    1 => 45,
                    2 => 45,
                ),
                'display_value' => 'text',
                'handles'       => 2,
                'output'        => array(
                    1 => array( '.tx-cursor-ring' => 'width' ),
                    2 => array( '.tx-cursor-ring' => 'height' ),
                ),
                'required'  => array( 'tx_custom_cursor', '=', '1' ),
            ),
            array(
                'id'            => 'tx_custom_cursor_pointer_size',
                'type'          => 'slider',
                'title'         => esc_html__( 'Cursor Pointer Size', 'avas' ),
                'max'           => 200,
                'default'       => array(
                    1 => 5,
                    2 => 5,
                ),
                'display_value' => 'text',
                'handles'       => 2,
                'output'        => array(
                    1 => array( '.tx-cursor-pointer' => 'width' ),
                    2 => array( '.tx-cursor-pointer' => 'height' ),
                ),
                'required'  => array( 'tx_custom_cursor', '=', '1' ),
            ),
            array(
                'id'            => 'tx_custom_cursor_click_size',
                'type'          => 'slider',
                'title'         => esc_html__( 'Cursor Click Size', 'avas' ),
                'max'           => 200,
                'default'       => array(
                    1 => 45,
                    2 => 45,
                ),
                'display_value' => 'text',
                'handles'       => 2,
                'output'        => array(
                    1 => array( '.tx-cursor-inner' => 'width' ),
                    2 => array( '.tx-cursor-inner' => 'height' ),
                ),
                'required'  => array( 'tx_custom_cursor', '=', '1' ),
            ),
            array( 
                    'id'       => 'tx_custom_cursor_ring_border',
                    'type'     => 'border',
                    'title'    => esc_html__('Cursor Ring Border', 'avas'),
                    'output'   => array('.tx-cursor-ring'),
                    'required'  => array( 'tx_custom_cursor', '=', '1' )
                ),
            array(
                'id'       => 'tx_custom_cursor_ring_color',
                'type'     => 'color_rgba',
                'output'   => array('background-color' => '.tx-cursor-ring'),
                'title'    => esc_html__( 'Cursor Ring Color', 'avas' ),
                'required'  => array( 'tx_custom_cursor', '=', '1' ),
            ),
            array(
                'id'       => 'tx_custom_cursor_pointer_color',
                'type'     => 'color_rgba',
                'output'   => array('background-color' => '.tx-cursor-pointer'),
                'title'    => esc_html__( 'Cursor Pointer Color', 'avas' ),
                'required'  => array( 'tx_custom_cursor', '=', '1' ),
            ),
            array(
                'id'       => 'tx_custom_cursor_click_color',
                'type'     => 'color_rgba',
                'output'   => array('background-color' => '.tx-cursor-inner'),
                'title'    => esc_html__( 'Cursor Click Color', 'avas' ),
                'required'  => array( 'tx_custom_cursor', '=', '1' ),
            ),
        )));

    // Media Options
    if ( ! is_customize_preview() ) :
    Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Media', 'avas' ),
        'desc'      => esc_html__( 'All posts images dimensions', 'avas' ),
        'id'         => 'media_opts',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'        => 'tx-1920x600-thumb_switch',
                'type'      => 'switch',
                'title'    => esc_html__('Full Width (tx-1920x600-thumb)','avas'),
                'subtitle'    => esc_html__('This dimension is used for the Single Portfolio Post.','avas'),
                'default'   => 1,
                'on'        => esc_html__('Enable', 'avas'),
                'off'       => esc_html__('Disable', 'avas')
            ),
            array(
                'id'       => 'tx-1920x600-thumb',
                'type'     => 'dimensions',
                'units'    => 'px',
                'default'  => array(
                    'width'   => '1920', 
                    'height'  => '600'
                ),
                'required'  => array( 'tx-1920x600-thumb_switch', '=', '1' ),
            ),
            array(
                'id'        => 'tx-l-thumb_switch',
                'type'      => 'switch',
                'title'    => esc_html__('Large size (tx-l-thumb)','avas'),
                'subtitle'    => esc_html__('This dimension is used for the Single Service Post, Single Blog Post.','avas'),
                'default'   => 1,
                'on'        => esc_html__('Enable', 'avas'),
                'off'       => esc_html__('Disable', 'avas')
            ),
            array(
                'id'       => 'tx-l-thumb',
                'type'     => 'dimensions',
                'units'    => 'px',

                'default'  => array(
                    'width'   => '750', 
                    'height'  => '420'
                ),
                'required'  => array( 'tx-l-thumb_switch', '=', '1' ),
            ),
            array(
                'id'        => 'tx-xl-thumb_switch',
                'type'      => 'switch',
                'title'    => esc_html__('Extra Large size (tx-xl-thumb)','avas'),
                'subtitle'    => esc_html__('This dimension is used for the Single Service Post.','avas'),
                'default'   => 1,
                'on'        => esc_html__('Enable', 'avas'),
                'off'       => esc_html__('Disable', 'avas')
            ),
            array(
                'id'       => 'tx-xl-thumb',
                'type'     => 'dimensions',
                'units'    => 'px',
                'default'  => array(
                    'width'   => '1140', 
                    'height'  => '500'
                ),
                'required'  => array( 'tx-xl-thumb_switch', '=', '1' ),
            ),
            array(
                'id'        => 'tx-ts-thumb_switch',
                'type'      => 'switch',
                'title'    => esc_html__('Single Team size (tx-ts-thumb)','avas'),
                'subtitle'    => esc_html__('This dimension is used for the Single Team Post.','avas'),
                'default'   => 1,
                'on'        => esc_html__('Enable', 'avas'),
                'off'       => esc_html__('Disable', 'avas')
            ),
            array(
                'id'       => 'tx-ts-thumb',
                'type'     => 'dimensions',
                'units'    => 'px',
                'default'  => array(
                    'width'   => '470', 
                    'height'  => '560'
                ),
                'required'  => array( 'tx-ts-thumb_switch', '=', '1' ),
            ),
            array(
                'id'        => 'tx-t-thumb_switch',
                'type'      => 'switch',
                'title'    => esc_html__('Single Team size (tx-t-thumb)','avas'),
                'subtitle'    => esc_html__('This dimension is used for the Team Template Page.','avas'),
                'default'   => 1,
                'on'        => esc_html__('Enable', 'avas'),
                'off'       => esc_html__('Disable', 'avas')
            ),
            array(
                'id'       => 'tx-t-thumb',
                'type'     => 'dimensions',
                'units'    => 'px',
                'default'  => array(
                    'width'   => '270', 
                    'height'  => '300'
                ),
                'required'  => array( 'tx-t-thumb_switch', '=', '1' ),
            ),
            array(
                'id'        => 'tx-tf-thumb_switch',
                'type'      => 'switch',
                'title'    => esc_html__('Single Team size (tx-tf-thumb)','avas'),
                'subtitle'    => esc_html__('This dimension is used for the Team Template Page full width.','avas'),
                'default'   => 1,
                'on'        => esc_html__('Enable', 'avas'),
                'off'       => esc_html__('Disable', 'avas')
            ),
            array(
                'id'       => 'tx-tf-thumb',
                'type'     => 'dimensions',
                'units'    => 'px',
                'default'  => array(
                    'width'   => '320', 
                    'height'  => '360'
                ),
                'required'  => array( 'tx-tf-thumb_switch', '=', '1' ),
            ),
            array(
                'id'        => 'tx-m-thumb_switch',
                'type'      => 'switch',
                'title'    => esc_html__('Tield Post size (tx-m-thumb)','avas'),
                'subtitle'    => esc_html__('This dimension is used for Avas Tield Post widget.','avas'),
                'default'   => 1,
                'on'        => esc_html__('Enable', 'avas'),
                'off'       => esc_html__('Disable', 'avas')
            ),
            array(
                'id'       => 'tx-m-thumb',
                'type'     => 'dimensions',
                'units'    => 'px',
                'default'  => array(
                    'width'   => '580', 
                    'height'  => '460'
                ),
                'required'  => array( 'tx-m-thumb_switch', '=', '1' ),
            ),
            array(
                'id'        => 'tx-alter-thumb_switch',
                'type'      => 'switch',
                'title'    => esc_html__('Post Alter size (tx-alter-thumb)','avas'),
                'subtitle'    => esc_html__('This dimension is used for Avas Post alter widget.','avas'),
                'default'   => 1,
                'on'        => esc_html__('Enable', 'avas'),
                'off'       => esc_html__('Disable', 'avas')
            ),
            array(
                'id'       => 'tx-alter-thumb',
                'type'     => 'dimensions',
                'units'    => 'px',
                'default'  => array(
                    'width'   => '616', 
                    'height'  => '430'
                ),
                'required'  => array( 'tx-alter-thumb_switch', '=', '1' ),
            ),
            array(
                'id'        => 'tx-team-alter-thumb_switch',
                'type'      => 'switch',
                'title'    => esc_html__('Avas Team Alter size (tx-team-alter-thumb)','avas'),
                'subtitle'    => esc_html__('This dimension is used for Avas Team Alter widget.','avas'),
                'default'   => 1,
                'on'        => esc_html__('Enable', 'avas'),
                'off'       => esc_html__('Disable', 'avas')
            ),
            array(
                'id'       => 'tx-team-alter-thumb',
                'type'     => 'dimensions',
                'units'    => 'px',
                'default'  => array(
                    'width'   => '525', 
                    'height'  => '525'
                ),
                'required'  => array( 'tx-team-alter-thumb_switch', '=', '1' ),
            ),
            array(
                'id'        => 'tx-serv-thumb_switch',
                'type'      => 'switch',
                'title'    => esc_html__('Avas Service size (tx-serv-thumb)','avas'),
                'subtitle'    => esc_html__('This dimension is used for Avas Services widget.','avas'),
                'default'   => 1,
                'on'        => esc_html__('Enable', 'avas'),
                'off'       => esc_html__('Disable', 'avas')
            ),
            array(
                'id'       => 'tx-serv-thumb',
                'type'     => 'dimensions',
                'units'    => 'px',
                'default'  => array(
                    'width'   => '370', 
                    'height'  => '270'
                ),
                'required'  => array( 'tx-serv-thumb_switch', '=', '1' ),
            ),
            array(
                'id'        => 'tx-serv-overlay-thumb_switch',
                'type'      => 'switch',
                'title'    => esc_html__('Avas Service overlay size (tx-serv-overlay-thumb)','avas'),
                'subtitle'    => esc_html__('This dimension is used for Avas services widget overlay.','avas'),
                'default'   => 1,
                'on'        => esc_html__('Enable', 'avas'),
                'off'       => esc_html__('Disable', 'avas')
            ),
            array(
                'id'       => 'tx-serv-overlay-thumb',
                'type'     => 'dimensions',
                'units'    => 'px',
                'default'  => array(
                    'width'   => '370', 
                    'height'  => '470'
                ),
                'required'  => array( 'tx-serv-overlay-thumb_switch', '=', '1' ),
            ),
            array(
                'id'        => 'tx-c-thumb_switch',
                'type'      => 'switch',
                'title'    => esc_html__('Avas Posts Carousel size (tx-c-thumb)','avas'),
                'subtitle'    => esc_html__('This dimension is used for Avas Posts Carousel widget.','avas'),
                'default'   => 1,
                'on'        => esc_html__('Enable', 'avas'),
                'off'       => esc_html__('Disable', 'avas')
            ),
            array(
                'id'       => 'tx-c-thumb',
                'type'     => 'dimensions',
                'units'    => 'px',
                'default'  => array(
                    'width'   => '320', 
                    'height'  => '220'
                ),
                'required'  => array( 'tx-c-thumb_switch', '=', '1' ),
            ),
            array(
                'id'        => 'tx-port-grid-h-thumb_switch',
                'type'      => 'switch',
                'title'    => esc_html__('Avas Porftolio Grid horizontal size (tx-port-grid-h-thumb)','avas'),
                'subtitle'    => esc_html__('This dimension is used for Avas Porftolio Grid widget.','avas'),
                'default'   => 1,
                'on'        => esc_html__('Enable', 'avas'),
                'off'       => esc_html__('Disable', 'avas')
            ),
            array(
                'id'       => 'tx-port-grid-h-thumb',
                'type'     => 'dimensions',
                'units'    => 'px',
                'default'  => array(
                    'width'   => '485', 
                    'height'  => '335'
                ),
                'required'  => array( 'tx-port-grid-h-thumb_switch', '=', '1' ),
            ),
            array(
                'id'        => 'tx-port-grid-v-thumb_switch',
                'type'      => 'switch',
                'title'    => esc_html__('Avas Porftolio Grid vertical size (tx-port-grid-v-thumb)','avas'),
                'subtitle'    => esc_html__('This dimension is used for Avas Porftolio Grid widget.','avas'),
                'default'   => 1,
                'on'        => esc_html__('Enable', 'avas'),
                'off'       => esc_html__('Disable', 'avas')
            ),
            array(
                'id'       => 'tx-port-grid-v-thumb',
                'type'     => 'dimensions',
                'units'    => 'px',
                'default'  => array(
                    'width'   => '390', 
                    'height'  => '438'
                ),
                'required'  => array( 'tx-port-grid-v-thumb_switch', '=', '1' ),
            ),
            array(
                'id'        => 'tx-timeline-thumb_switch',
                'type'      => 'switch',
                'title'    => esc_html__('Avas Timeline size (tx-timeline-thumb)','avas'),
                'subtitle'    => esc_html__('This dimension is used for Avas Timeline widget.','avas'),
                'default'   => 1,
                'on'        => esc_html__('Enable', 'avas'),
                'off'       => esc_html__('Disable', 'avas')
            ),
            array(
                'id'       => 'tx-timeline-thumb',
                'type'     => 'dimensions',
                'units'    => 'px',
                'default'  => array(
                    'width'   => '460', 
                    'height'  => '300'
                ),
                'required'  => array( 'tx-timeline-thumb_switch', '=', '1' ),
            ),
            array(
                'id'        => 'tx-lp-thumb_switch',
                'type'      => 'switch',
                'title'    => esc_html__('Single Course size (tx-lp-thumb)','avas'),
                'subtitle'    => esc_html__('This dimension is used for Single course post thumbnail for LearnPress plugin.','avas'),
                'default'   => 1,
                'on'        => esc_html__('Enable', 'avas'),
                'off'       => esc_html__('Disable', 'avas')
            ),
            array(
                'id'       => 'tx-lp-thumb',
                'type'     => 'dimensions',
                'units'    => 'px',
                 'default'  => array(
                    'width'   => '918', 
                    'height'  => '440'
                ),
                'required'  => array( 'tx-lp-thumb_switch', '=', '1' ),
            ),
            array(
                'id'        => 'tx-ms-size_switch',
                'type'      => 'switch',
                'title'    => esc_html__('Medium Small size (tx-ms-size)','avas'),
                'subtitle'    => esc_html__('This dimension is used for Single Service brochure.','avas'),
                'default'   => 1,
                'on'        => esc_html__('Enable', 'avas'),
                'off'       => esc_html__('Disable', 'avas')
            ),
            array(
                'id'       => 'tx-ms-size',
                'type'     => 'dimensions',
                'units'    => 'px',
                'default'  => array(
                    'width'   => '350', 
                    'height'  => '220'
                ),
                'required'  => array( 'tx-ms-size_switch', '=', '1' ),
            ),
            array(
                'id'        => 'tx-r-thumb_switch',
                'type'      => 'switch',
                'title'    => esc_html__('Related Post size (tx-r-thumb)','avas'),
                'subtitle'    => esc_html__('This dimension is used for Related Post.','avas'),
                'default'   => 1,
                'on'        => esc_html__('Enable', 'avas'),
                'off'       => esc_html__('Disable', 'avas')
            ),
            array(
                'id'       => 'tx-r-thumb',
                'type'     => 'dimensions',
                'units'    => 'px',
                'default'  => array(
                    'width'   => '270', 
                    'height'  => '188'
                ),
                'required'  => array( 'tx-r-thumb_switch', '=', '1' ),
            ),
            array(
                'id'        => 'tx-s-thumb_switch',
                'type'      => 'switch',
                'title'    => esc_html__('Small size (tx-s-thumb)','avas'),
                'subtitle'    => esc_html__('This dimension is used for Sidebar widget.','avas'),
                'default'   => 1,
                'on'        => esc_html__('Enable', 'avas'),
                'off'       => esc_html__('Disable', 'avas')
            ),
            array(
                'id'       => 'tx-s-thumb',
                'type'     => 'dimensions',
                'units'    => 'px',
                'default'  => array(
                    'width'   => '100', 
                    'height'  => '75'
                ),
                'required'  => array( 'tx-s-thumb_switch', '=', '1' ),
            ),
            array(
                'id'        => 'tx-pe-thumb_switch',
                'type'      => 'switch',
                'title'    => esc_html__('Project Experience size (tx-pe-thumb)','avas'),
                'subtitle'    => esc_html__('This dimension is used for Project Experience.','avas'),
                'default'   => 1,
                'on'        => esc_html__('Enable', 'avas'),
                'off'       => esc_html__('Disable', 'avas')
            ),
            array(
                'id'       => 'tx-pe-thumb',
                'type'     => 'dimensions',
                'units'    => 'px',
                'default'  => array(
                    'width'   => '150', 
                    'height'  => '100'
                ),
                'required'  => array( 'tx-pe-thumb_switch', '=', '1' ),
            ),
            array(
                'id'        => 'tx-admin-post-thumb_switch',
                'type'      => 'switch',
                'title'    => esc_html__('Post Thumbnail size (tx-admin-post-thumb)','avas'),
                'subtitle'    => esc_html__('This dimension is used for thumbail on all posts type in backend.','avas'),
                'default'   => 1,
                'on'        => esc_html__('Enable', 'avas'),
                'off'       => esc_html__('Disable', 'avas')
            ),
            array(
                'id'       => 'tx-admin-post-thumb',
                'type'     => 'dimensions',
                'units'    => 'px',
                'default'  => array(
                    'width'   => '80', 
                    'height'  => '80'
                ),
                'required'  => array( 'tx-admin-post-thumb_switch', '=', '1' ),
            ),
            array(
                'id'        => 'tx-bc-thumb_switch',
                'type'      => 'switch',
                'title'    => esc_html__('Blog Template 3 columns size (tx-bc-thumb)','avas'),
                'subtitle' => esc_html__('This dimension is used for Blog template three columns.','avas'),
                'default'   => 1,
                'on'        => esc_html__('Enable', 'avas'),
                'off'       => esc_html__('Disable', 'avas')
            ),
            array(
                'id'       => 'tx-bc-thumb',
                'type'     => 'dimensions',
                'desc'     => esc_html__('Height is auto so the value will not work if you put any.','avas'),
                'units'    => 'px',
                'mode'     => array(
                    'height'  => false
                ),
                'default'  => array(
                    'width'   => '360', 
                ),
                'required'  => array( 'tx-bc-thumb_switch', '=', '1' ),
            ),
            array(
                'id'        => 'tx-gall-grid-cols-3_switch',
                'type'      => 'switch',
                'title'    => esc_html__('Avas Gallery widget for 3 columns (tx-gall-grid-cols-3)','avas'),
                'subtitle' => esc_html__('This dimension is used for Avas Gallery widget for 3 columns.','avas'),
                'default'   => 1,
                'on'        => esc_html__('Enable', 'avas'),
                'off'       => esc_html__('Disable', 'avas')
            ),
            array(
                'id'       => 'tx-gall-grid-cols-3',
                'type'     => 'dimensions',
                'desc'     => esc_html__('Height is auto so the value will not work if you put any.','avas'),
                'units'    => 'px',
                'mode'     => array(
                    'height'  => false
                ),
                'default'  => array(
                    'width'   => '373', 
                ),
                'required'  => array( 'tx-gall-grid-cols-3_switch', '=', '1' ),
            ),
            array(
                'id'        => 'tx-masonry-cols-3_switch',
                'type'      => 'switch',
                'title'    => esc_html__('Avas Post Masonry for 3 columns(tx-masonry-cols-3)','avas'),
                'subtitle' => esc_html__('This dimension is used for Avas Post masonry widget for 3 columns.','avas'),
                'default'   => 1,
                'on'        => esc_html__('Enable', 'avas'),
                'off'       => esc_html__('Disable', 'avas')
            ),
            array(
                'id'       => 'tx-masonry-cols-3',
                'type'     => 'dimensions',
                'desc'     => esc_html__('Height is auto so the value will not work if you put any.','avas'),
                'units'    => 'px',
                'mode'     => array(
                    'height'  => false
                ),
                'default'  => array(
                    'width'   => '620', 
                ),
                'required'  => array( 'tx-masonry-cols-3_switch', '=', '1' ),
            ),
            array(
                'id'        => 'tx-masonry-cols-4_switch',
                'type'      => 'switch',
                'title'    => esc_html__('Avas Post masonry for 4 columns (tx-masonry-cols-4)','avas'),
                'subtitle' => esc_html__('This dimension is used for Avas Post masonry widget for 4 columns.','avas'),
                'default'   => 1,
                'on'        => esc_html__('Enable', 'avas'),
                'off'       => esc_html__('Disable', 'avas')
            ),
            array(
                'id'       => 'tx-masonry-cols-4',
                'type'     => 'dimensions',
                'desc'     => esc_html__('Height is auto so the value will not work if you put any.','avas'),
                'units'    => 'px',
                'mode'     => array(
                    'height'  => false
                ),
                'default'  => array(
                    'width'   => '460', 
                ),
                'required'  => array( 'tx-masonry-cols-4_switch', '=', '1' ),
            ),
            array(
                'id'        => 'tx-masonry-cols-5_switch',
                'type'      => 'switch',
                'title'    => esc_html__('Avas Post masonry for 5 columns (tx-masonry-cols-5)','avas'),
                'subtitle' => esc_html__('This dimension is used for Avas Post masonry widget for 5 columns.','avas'),
                'default'   => 1,
                'on'        => esc_html__('Enable', 'avas'),
                'off'       => esc_html__('Disable', 'avas')
            ),
            array(
                'id'       => 'tx-masonry-cols-5',
                'type'     => 'dimensions',
                'desc'     => esc_html__('Height is auto so the value will not work if you put any.','avas'),
                'units'    => 'px',
                'mode'     => array(
                    'height'  => false
                ),
                'default'  => array(
                    'width'   => '365', 
                ),
                'required'  => array( 'tx-masonry-cols-5_switch', '=', '1' ),
            ),
            array(
                'id'        => 'tx-masonry-cols-6_switch',
                'type'      => 'switch',
                'title'    => esc_html__('Avas Post masonry for 6 columns (tx-masonry-cols-6)','avas'),
                'subtitle' => esc_html__('This dimension is used for Avas Post masonry widget for 6 columns.','avas'),
                'default'   => 1,
                'on'        => esc_html__('Enable', 'avas'),
                'off'       => esc_html__('Disable', 'avas')
            ),
            array(
                'id'       => 'tx-masonry-cols-6',
                'type'     => 'dimensions',
                'desc'     => esc_html__('Height is auto so the value will not work if you put any.','avas'),
                'units'    => 'px',
                'mode'     => array(
                    'height'  => false
                ),
                'default'  => array(
                    'width'   => '300', 
                ),
                'required'  => array( 'tx-masonry-cols-6_switch', '=', '1' ),
            ),

    )));
    endif;

    // Header Options
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Header', 'avas' ),
        'id'               => 'header',
        'customizer_width' => '344px',
        'icon'             => 'el el-website',
        'fields'           =>  array(
            array(
                'id'       => 'header-layout',
                'type'     => 'image_select',
                'title' => esc_html__('Header Layout', 'avas'),
                'options'  => array(
                    'boxed'      => array('title' => 'Boxed', 'img' => TX_IMAGES .'header-boxed.png'),
                    'width' => array('title' => 'Width', 'img' => TX_IMAGES .'header-width.png'),
                    ),
                'default'  => 'boxed',
                'required'  => array('page-layout', '=', 'full-width')
            ),
            array(
                'id'        => 'header_overlay',
                'type'      => 'switch',
                'title'     => esc_html__('Header Overlay for Home Page', 'avas'),
                'default'   => 0,
                'on'        => esc_html__('Yes','avas'),
                'off'       => esc_html__('No','avas'),
            ),
            array(
                'id'        => 'header_overlay_inner',
                'type'      => 'switch',
                'title'     => esc_html__('Header Overlay for Inner Page', 'avas'),
                'default'   => 0,
                'on'        => esc_html__('Yes','avas'),
                'off'       => esc_html__('No','avas'),
            ),
            array(
                'id'        => 'sticky_header',
                'type'      => 'switch',
                'title'     => esc_html__('Sticky Header', 'avas'),
                'default'   => 0,
                'on'        => 'On',
                'off'       => 'Off',
            ),
            array(
                'id'        => 'sticky_main_header',
                'type'      => 'switch',
                'title'     => esc_html__('Sticky Main Header', 'avas'),
                'default'   => 0,
                'on'        => 'On',
                'off'       => 'Off',
                'required'  => array(
                                array( 'sticky_header', '=', '1' ),
                                array( 'header-select', '!=', 'header3' ),
                                array( 'header-select', '!=', 'header5' ),
                                array( 'header-select', '!=', 'header9' ),
                                array( 'header-select', '!=', 'header10' ),
                                array( 'header-select', '!=', 'header11' ),
                            ),
            ),
            array(
                'id'        => 'sticky_header_mob',
                'type'      => 'switch',
                'title'     => esc_html__('Sticky Header for Responsive Device', 'avas'),
                'default'   => 1,
                'on'        => 'On',
                'off'       => 'Off',
                'required'  => array(
                                array( 'sticky_header', '=', '1' ),
                            ),
            ),
            array(
                'id'            => 'sticky-scroll',
                'type'          => 'slider',
                'title'         => esc_html__( 'Sticky Header Start From', 'avas' ),
                'default'       => 100,
                'min'           => 0,
                'step'          => 1,
                'max'           => 1000,
                'display_value' => 'text',
                'required'  => array('sticky_header', '=', '1' ),
            ),
            array(
                'id'        => 'elem_head_switch',
                'type'      => 'switch',
                'default'   => 0,
                'on'        => 'Enable',
                'off'       => 'Disable',
                'title'    => esc_html__( 'Elementor Header', 'avas' ),
            ),
            array(
                'id'       => 'elem_head',
                'type'     => 'select',
                'data'     => 'posts',
                
                'title' => esc_html__( 'Select Elementor Template for Header', 'avas' ),
                'desc'     => esc_html__( 'You need to create custom Header via Elementor Template Library on WP Dashboard > Templates.', 'avas' ),
                'args'  => array(
                        'post_type'      => 'elementor_library',
                        'post_status'    => 'publish',
                        'ignore_sticky_posts' => true,
                        'posts_per_page' => -1,
                        'orderby'        => 'title',
                        'order'          => 'ASC',
                    ),
                'required'  => array( 'elem_head_switch', '=', '1' ),
            ),
        )
    ));   
    // Main Header options
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Main Header', 'avas' ),
        'id'               => 'main-header',
        'subsection'       => true,
        'customizer_width' => '344px',
        'fields'           =>  array(
                array(
                    'id'        => 'header_on_off',
                    'type'      => 'switch',
                    'default'   => 1,
                    'on'        => 'Enable',
                    'off'       => 'Disable',
                ),
                array(
                    'id'       => 'header-select',
                    'type'     => 'select',
                    'title' => esc_html__('Select Main Header Style', 'avas'),
                    'options'  => array(
                        'header1'  => esc_html__('Style 1','avas'),
                        'header2'  => esc_html__('Style 2','avas'),
                        'header3'  => esc_html__('Style 3','avas'),
                        'header4'  => esc_html__('Style 4','avas'),
                        'header5'  => esc_html__('Style 5','avas'),
                        'header6'  => esc_html__('Style 6','avas'),
                        'header7'  => esc_html__('Style 7','avas'),
                        'header8'  => esc_html__('Style 8','avas'),
                        'header9'  => esc_html__('Style 9','avas'),
                        'header10'  => esc_html__('Style 10','avas'),
                        'header11'  => esc_html__('Style 11','avas'),
                    ),
                    'default'  => 'header3',
                    'required'  => array( 'header_on_off', '=', '1' ),
                ),
                array(
                    'id'       => 'header-style1',
                    'type'     => 'image_select',
                    'title'    => esc_html__('Style 1', 'avas'),
                    'required'  => array( 'header-select', '=', 'header1' ),
                    'options'  => array(
                    'header-style1'  => array(
                      'alt' => 'Header Style 1',
                      'img' => TX_IMAGES .'h1.png'
                    ),
                    ),
                ),
                array(
                    'id'       => 'header-style2',
                    'type'     => 'image_select',
                    'title'    => esc_html__('Style 2', 'avas'),
                    'required'  => array( 'header-select', '=', 'header2' ),
                    'options'  => array(
                    'header-style2'  => array(
                      'alt' => 'Header Style 2',
                      'img' => TX_IMAGES .'h2.png'
                    ),
                    ),
                ),
                array(
                    'id'       => 'header-style3',
                    'type'     => 'image_select',
                    'title'    => esc_html__('Style 3', 'avas'),
                    'required'  => array( 'header-select', '=', 'header3' ),
                    'options'  => array(
                    'header-style3'  => array(
                      'alt' => 'Header Style 3',
                      'img' => TX_IMAGES .'h3.png'
                    ),
                    ),
                ),
                array(
                    'id'       => 'header-style4',
                    'type'     => 'image_select',
                    'title'    => esc_html__('Style 4', 'avas'),
                    'required'  => array( 'header-select', '=', 'header4' ),
                    'options'  => array(
                    'header-style4'  => array(
                      'alt' => 'Header Style 4',
                      'img' => TX_IMAGES .'h4.png'
                    ),
                    ),
                ),
                array(
                    'id'       => 'header-style5',
                    'type'     => 'image_select',
                    'title'    => esc_html__('Style 5', 'avas'),
                    'required'  => array( 'header-select', '=', 'header5' ),
                    'options'  => array(
                    'header-style5'  => array(
                      'alt' => 'Header Style 5',
                      'img' => TX_IMAGES .'h5.png'
                    ),
                    ),
                ),
                array(
                    'id'       => 'header-style6',
                    'type'     => 'image_select',
                    'title'    => esc_html__('Style 6', 'avas'),
                    'required'  => array( 'header-select', '=', 'header6' ),
                    'options'  => array(
                    'header-style6'  => array(
                      'alt' => 'Header Style 6',
                      'img' => TX_IMAGES .'h6.png'
                    ),
                    ),
                ),
                array(
                    'id'       => 'header-style7',
                    'type'     => 'image_select',
                    'title'    => esc_html__('Style 7', 'avas'),
                    'required'  => array( 'header-select', '=', 'header7' ),
                    'options'  => array(
                    'header-style7'  => array(
                      'alt' => 'Header Style 7',
                      'img' => TX_IMAGES .'h7.png'
                    ),
                    ),
                ),
                array(
                    'id'       => 'header-style8',
                    'type'     => 'image_select',
                    'title'    => esc_html__('Style 8', 'avas'),
                    'required'  => array( 'header-select', '=', 'header8' ),
                    'options'  => array(
                    'header-style8'  => array(
                      'alt' => 'Header Style 8',
                      'img' => TX_IMAGES .'h8.png'
                    ),
                    ),
                ),
                array(
                    'id'       => 'header-style9',
                    'type'     => 'image_select',
                    'title'    => esc_html__('Style 9', 'avas'),
                    'required'  => array( 'header-select', '=', 'header9' ),
                    'options'  => array(
                    'header-style9'  => array(
                      'alt' => 'Header Style 9',
                      'img' => TX_IMAGES .'h9.png'
                    ),
                    ),
                ),
                array(
                    'id'       => 'header-style-10-position',
                    'type'     => 'select',
                    'title' => esc_html__('Header Style 10 Position', 'avas'),
                    'options'  => array(
                        'left'  => esc_html__('Left','avas'),
                        'right'  => esc_html__('Right','avas'),
                    ),
                    'default'  => 'left',
                    'required'  => array( 'header-select', '=', 'header10' ),
                ),
                array(
                    'id'       => 'header-style10-left',
                    'type'     => 'image_select',
                    'title'    => esc_html__('Style 10 Left', 'avas'),
                    'required'  => array( 'header-style-10-position', '=', 'left' ),
                    'options'  => array(
                    'header-style10'  => array(
                      'alt' => 'Header Style 10 Left',
                      'img' => TX_IMAGES .'h10-l.png'
                    ),
                    ),
                ),
                array(
                    'id'       => 'header-style10-right',
                    'type'     => 'image_select',
                    'title'    => esc_html__('Style 10 Right', 'avas'),
                    'required'  => array( 'header-style-10-position', '=', 'right' ),
                    'options'  => array(
                    'header-style10'  => array(
                      'alt' => 'Header Style 10 Right',
                      'img' => TX_IMAGES .'h10-r.png'
                    ),
                    ),
                ),
                array(
                    'id'            => 'header-style10-width',
                    'type'          => 'slider',
                    'title'         => esc_html__( 'Header Style 10 Width', 'avas' ),
                    'default'       => 250,
                    'min'           => 0,
                    'step'          => 1,
                    'max'           => 2500,
                    'display_value' => 'text',
                    'required'  => array( 'header-select', '=', 'header10' ),
                ),
                array(
                    'id'       => 'header-style11',
                    'type'     => 'image_select',
                    'title'    => esc_html__('Style 11', 'avas'),
                    'required'  => array( 'header-select', '=', 'header11' ),
                    'options'  => array(
                    'header-style11'  => array(
                      'alt' => 'Header Style 11',
                      'img' => TX_IMAGES .'h11.png'
                    ),
                    ),
                ),
                array(
                    'id'            => 'main_header_height',
                    'type'          => 'slider',
                    'title'         => esc_html__( 'Main Header Height', 'avas' ),
                    'min'           => 0,
                    'step'          => 1,
                    'default'       => 75,
                    'max'           => 500,
                    'display_value' => 'text',
                    'required'  => array( 'header-select', '=', array('header1','header2','header3','header4','header5','header6','header7','header8','header9','header11') )
                ),
                array(
                    'id'            => 'sticky_main_header_height',
                    'type'          => 'slider',
                    'title'         => esc_html__( 'Sticky Header Height', 'avas' ),
                    'min'           => 0,
                    'step'          => 1,
                    'default'       => 75,
                    'max'           => 500,
                    'display_value' => 'text',
                    'required'  => array( 'header-select', '=', array('header1','header2','header3','header4','header5','header6','header7','header8','header9','header11') )
                ),
                array(
                    'id'             => 'main_header_margin_home',
                    'type'           => 'spacing',
                    'output'         => array('.home .main-header'),
                    'mode'           => 'margin',
                    'units'          => array('px', 'em'),
                    'units_extended' => 'false',
                    'title'          => esc_html__('Main Header margin for Home page only', 'avas'),
                    'required'  => array( 'header_on_off', '=', '1' ),
                    'default'            => array(
                    'units'          => 'px', 
                    ),
                ),
                array(
                    'id'             => 'main_header_margin_inner',
                    'type'           => 'spacing',
                    'output'         => array('.main-header'),
                    'mode'           => 'margin',
                    'units'          => array('px', 'em'),
                    'units_extended' => 'false',
                    'title'          => esc_html__('Main Header margin for Inner pages', 'avas'),
                    'required'  => array( 'header_on_off', '=', '1' ),
                    'default'            => array(
                    'units'          => 'px', 
                    ),
                ), 
                array(
                    'id'             => 'main_header_padding',
                    'type'           => 'spacing',
                    'output'         => array('.main-header .container,.main-header .container-fluid'),
                    'mode'           => 'padding',
                    'units'          => array('px', 'em'),
                    'units_extended' => 'false',
                    'title'          => esc_html__('Main Header Padding', 'avas'),
                    'required'  => array( 'header_on_off', '=', '1' ),
                    'default'            => array(
                    'units'          => 'px', 
                    ),
                ),
                
                array(
                    'id'       => 'banner-bussiness-switch',
                    'type'     => 'button_set',
                    'title'    => esc_html__('Select', 'avas'),
                    'options' => array(
                        '1' => esc_html__('Banner', 'avas'),
                        '2' => esc_html__('Business Info', 'avas'),
                     ), 
                    'default' => '1',
                    'required'  => array( 'header-select', '=', array('header1','header5','header6','header7','header8') ),
                                
                ), 
                array(
                    'id'        => 'h_ads_switch',
                    'type'      => 'button_set',
                    'title'     => esc_html__('Change Ad Mode', 'avas'),
                    'options' => array(
                        '1' => esc_html__('Banner', 'avas'),
                        '2' => esc_html__('Adsense', 'avas'),
                     ), 
                    'default' => '1',
                    'required'  => array( 'banner-bussiness-switch', '=', '1' ),
                ),
                
                array(
                    'title'    => esc_html__('Ad Banner', 'avas'),
                    'id'       => 'head_ad_banner',
                    'subtitle' => esc_html__('Size 728x90','avas'),
                    'type'     => 'media',
                    'complier' => true,
                    'url'      => true,
                    'desc'     => esc_html__( 'You can upload png, jpg, gif image.', 'avas' ),
                    'default'  => array(
                      'url'=> TX_IMAGES . 'h_a.jpg'
                    ),
                    'required'  => array(
                                   array( 'h_ads_switch', '=', '1' ),
                                   array( 'banner-bussiness-switch', '=', '1' ),
                                ),
                ),
                array(
                    'id'       => 'head_ad_banner_link',
                    'type'     => 'text',
                    'title'    => esc_html__('Banner link', 'avas'),
                    'required'  => array(
                                   array( 'h_ads_switch', '=', '1' ),
                                   array( 'banner-bussiness-switch', '=', '1' ),
                                ),
                ),
                array(
                    'id'       => 'head_ad_banner_link_new_window',
                    'type'     => 'checkbox',
                    'title'    => esc_html__('Open link in new window', 'avas'), 
                    'default'  => '0',
                    'required'  => array( 'h_ads_switch', '=', '1' ),
                ),
                array(
                    'id'       => 'head_ad_js',
                    'title'    => esc_html__( 'Adsense codes here.', 'avas' ),
                    'subtitle' => esc_html__('Size 728x90','avas'),
                    'type'     => 'ace_editor',
                    'mode'     => 'html',
                    'theme'    => 'chrome',
                    'desc'      => esc_html__('Example: Google Adsense etc', 'avas'),
                    'required'  => array(
                                   array( 'h_ads_switch', '=', '2' ),
                                   array( 'banner-bussiness-switch', '=', '1' ),
                                ),
                ),
                array(
                    'id'             => 'head_ads_space',
                    'type'           => 'spacing',
                    'output'         => array('.head_ads'),
                    'mode'           => 'margin',
                    'units'          => array('px', 'em'),
                    'units_extended' => 'false',
                    'title'          => esc_html__('Ad Space', 'avas'),
                    'desc'          => esc_html__('Default 10 0 10 0', 'avas'),
                    'required'  => array('banner-bussiness-switch', '=', '1' ),
                    'default'        => array (
                        'units'      => 'px'
                    )
                ),
                // business information from here
                array(
                    'id'          => 'bs-info',
                    'type'        => 'slides',
                    'title'       => esc_html__('Business information', 'avas'),
                    'subtitle'        => esc_html__('Maximum 3 items allowed. More than 3 items will break the layout.', 'avas'),
                    'required'    => array( 'banner-bussiness-switch', '=', '2' ),
                    'desc'        => esc_html__('Drag and drop sortings.', 'avas'),
                    'placeholder' => array(
                        'title'           => esc_html__('Title', 'avas'),
                        'description'     => esc_html__('Description', 'avas'),
                        'url'             => esc_html__('HTML tag allowed in above two fields.', 'avas'),
                    ),
                ),
                array(
                    'id'             => 'head_binfo_space',
                    'type'           => 'spacing',
                    'output'         => array('.bs-info-area'),
                    'mode'           => 'padding',
                    'units'          => array('px', 'em'),
                    'units_extended' => 'false',
                    'title'          => esc_html__('Business Info Space', 'avas'),
                    'desc'          => esc_html__('Default 30 0 30 0', 'avas'),
                    'required'  => array('banner-bussiness-switch', '=', '2' ),
                    'default'        => array (
                        'units'       => 'px'
                    )
                ),
                array(
                    'id'       => 'bs-info-title-color',
                    'type'     => 'color',
                    'output'   => array('.info-box .c-box .title, .info-box .c-box .title a'),
                    'title'    => esc_html__( 'Business Info Title Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'    => array( 'banner-bussiness-switch', '=', '2' ),
                ),
                array(
                    'id'       => 'bs-info-desc-color',
                    'type'     => 'color',
                    'output'   => array('.info-box .c-box .desc, .info-box .c-box .desc a'),
                    'title'    => esc_html__( 'Business Info Details Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'    => array( 'banner-bussiness-switch', '=', '2' ),
                ),
                array(
                    'id'       => 'bs-info-sep-color',
                    'type'     => 'color',
                    'output'   => array('border-color' => '.bs-info-content'),
                    'title'    => esc_html__( 'Business Info Separator Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'    => array( 'banner-bussiness-switch', '=', '2' ),
                ),
                array(
                    'id'       => 'typography-bs-info-title',
                    'type'     => 'typography',
                    'title'    => esc_html__( 'Business Info Title Font', 'avas' ),
                    'google'   => true,
                    'font-backup' => false,
                    'output'      => array('.info-box .c-box .title'),
                    'units'       =>'px',
                    'fonts' => $standard_fonts,
                    'font-style'  => true,
                    'all_styles'  => true,
                    'word-spacing'  => true,
                    'letter-spacing'=> true,
                    'text-transform' => true,
                    'color'         => false,
                    'subsets'       => true,
                    'allow_empty_line_height' => true,
                    'required'    => array( 'banner-bussiness-switch', '=', '2' ),
                ),
                array(
                    'id'       => 'typography-bs-info-desc',
                    'type'     => 'typography',
                    'title'    => esc_html__( 'Business Info Details Font', 'avas' ),
                    'google'   => true,
                    'font-backup' => false,
                    'output'      => array('.info-box .c-box .desc'),
                    'units'       =>'px',
                    'fonts' => $standard_fonts,
                    'font-style'  => true,
                    'all_styles'  => true,
                    'word-spacing'  => true,
                    'letter-spacing'=> true,
                    'text-transform' => true,
                    'color'         => false,
                    'subsets'       => true,
                    'allow_empty_line_height' => true,
                    'required'    => array( 'banner-bussiness-switch', '=', '2' ),
                ),
                array(
                    'id'        => 'banner-bussiness-switch-responsive',
                    'type'      => 'switch',
                    'title'    => esc_html__( 'Banner / Business Info disable on Responsive device?', 'avas' ),
                    'default'   => 0,
                    'on'        => esc_html__('Yes', 'avas'),
                    'off'       => esc_html__('No', 'avas'),
                    'required'  => array( 'header-select', '=', array('header1','header5','header6','header7','header8') ),
                ),
                
                // Main header color options
                array(
                    'id'        => 'main-header-colors',
                    'type'      => 'info',
                    'title'     => esc_html__('Colors Options', 'avas'),
                    'style'     => 'success',
                    'required'  => array( 'header_on_off', '=', '1' ),
                ),
                // background from here               
                array(
                    'title' => esc_html__( 'Main Header Background Image', 'avas' ),
                    'id'    => 'header-bg',
                    'type'  => 'background',
                    'output'   => array('background'=>'#h-style-1,#h-style-2,#h-style-3,#h-style-4,#h-style-5,#h-style-6,#h-style-7,#h-style-8,#h-style-9,#h-style-10,#h-style-11'),
                    'background-color' => false,
                    'required'  => array( 'header_on_off', '=', '1' ),
                ),
                array(
                    'id'       => 'header-bg-overlay',
                    'type'     => 'color_rgba',
                    'output'   => array( 
                    'background-color' => '.tx-header-overlay' ),
                    'title'    => esc_html__( 'Main Header Background Overlay Color', 'avas' ),
                    'required' => array('header_on_off', '=', '1' ),
                ),
                array(
                    'id'       => 'main_head_bg_color_home',
                    'type'     => 'color_rgba',
                    'output'   => array( 
                    'background-color' => '.home .main-header,.home #h-style-1,.home #h-style-2,.home #h-style-3,.home #h-style-4,.home #h-style-5,.home #h-style-6,.home #h-style-7,.home #h-style-8,.home #h-style-9,.home #h-style-10,.home #h-style-11' ),
                    'title'    => esc_html__( 'Main header background color for Home Page only', 'avas' ),
                    'required'  => array( 'header_on_off', '=', '1' ),
                ),
                array(
                    'id'       => 'sticky_head_bg_color_home',
                    'type'     => 'color_rgba',
                    'output'   => array( 
                    'background-color' => '.home #h-style-1.sticky-header,.home #h-style-2.sticky-header,.home #h-style-3.sticky-header,.home #h-style-4.sticky-header,.home #h-style-5.sticky-header,.home #h-style-6.sticky-header,.home #h-style-7.sticky-header,.home #h-style-8.sticky-header,.home #h-style-9.sticky-header,.home #h-style-10.sticky-header,.home #h-style-11.sticky-header' ),
                    'title'    => esc_html__( 'Sticky header background color for Home Page only', 'avas' ),
                    'default' => array(
                        'color' => '#ffffff',
                    ),
                    'required'  => array( 'header_on_off', '=', '1' ),
                ),
                array(
                    'id'       => 'main_head_cont_bg_color_home',
                    'type'     => 'color_rgba',
                    'output'   => array( 
                    'background-color' => '.home .main-header .container' ),
                    'title'    => esc_html__( 'Main Header Content background color for Home Page only', 'avas' ),
                    'required'  => array( 'header_on_off', '=', '1' ),
                ),
                array(
                    'id'       => 'main_head_bg_color_inner',
                    'type'     => 'color_rgba',
                    'output'   => array( 
                    'background-color' => '.main-header' ),
                    'title'    => esc_html__( 'Main header background color for Inner Pages', 'avas' ),
                    'required'  => array( 'header_on_off', '=', '1' ),
                ),
                array(
                    'id'       => 'sticky_head_bg_color_inner',
                    'type'     => 'color_rgba',
                    'output'   => array( 
                    'background-color' => '#h-style-1.sticky-header,#h-style-2.sticky-header,#h-style-3.sticky-header,#h-style-4.sticky-header,#h-style-5.sticky-header,#h-style-6.sticky-header,#h-style-7.sticky-header,#h-style-8.sticky-header,#h-style-9.sticky-header,#h-style-10.sticky-header,#h-style-11.sticky-header' ),
                    'title'    => esc_html__( 'Sticky header background color for Inner Pages', 'avas' ),
                    'default' => array(
                        'color' => '#ffffff',
                    ),
                    'required'  => array( 'header_on_off', '=', '1' ),
                ),
                array(
                    'id'       => 'main_head_bg_color_container',
                    'type'     => 'color_rgba',
                    'output'   => array( 
                    'background-color' => '.main-header .container' ),
                    'title'    => esc_html__( 'Main header container background color', 'avas' ),
                    'required'  => array( 'header_on_off', '=', '1' ),
                ),
                array(
                    'id'       => 'main_head_border',
                    'type'     => 'border',
                    'title'    => esc_html__('Main header Bottom Border', 'avas'),
                    'desc'     => esc_html__( 'Enter border width, example 1, 2, 3 etc to enable border', 'avas' ),
                    'output'   => array('.main-header'),
                    'top' => false,
                    'right' => false,
                    'left' => false,
                    'color' => false,
                    'required'  => array( 'header_on_off', '=', '1' ),
                ),
                array(
                    'id'       => 'main_head_border_color',
                    'type'     => 'color_rgba',
                    'output'   => array( 
                    'border-color' => '.main-header',
                     ),
                    'title'    => esc_html__( 'Main header Border color', 'avas' ),
                    'required'  => array( 'header_on_off', '=', '1' ),
                ),
                array(
                    'id'       => 'sticky_head_border',
                    'type'     => 'border',
                    'title'    => esc_html__('Sticky Header Bottom Border', 'avas'),
                    'desc'     => esc_html__( 'Enter border width, example 1, 2, 3 etc to enable border', 'avas' ),
                    'output'   => array('.main-header.sticky-header'),
                    'top' => false,
                    'right' => false,
                    'left' => false,
                    'color' => false,
                    'required'  => array( 'header_on_off', '=', '1' ),
                ),
                array(
                    'id'       => 'sticky_head_border_color',
                    'type'     => 'color_rgba',
                    'output'   => array( 
                    'border-color' => '.main-header.sticky-header',
                     ),
                    'title'    => esc_html__( 'Sticky Header Border Color', 'avas' ),
                    'required'  => array( 'header_on_off', '=', '1' ),
                ),
                array(
                    'id'        => 'sticky_head_box_shadow_switch',
                    'type'      => 'switch',
                    'default'   => 1,
                    'on'        => esc_html__('Yes', 'avas'),
                    'off'       => esc_html__('No', 'avas'),
                    'title'    => esc_html__( 'Sticky Header Box Shadow', 'avas' ),
                    'required'  => array( 'header_on_off', '=', '1' ),
                ),
                
    )      
        ) );
    // Top header options
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Top Header', 'avas'),
        'id'               => 'top-header',
        'subsection'       => true,
        'customizer_width' => '344px',
        'fields'           => array(
                array(
                    'id'        => 'top_head',
                    'type'      => 'switch',
                    'default'   => 1,
                    'on'        => esc_html__('Enable', 'avas'),
                    'off'       => esc_html__('Disable', 'avas'),
                ),
                array(
                    'id'            => 'top_header_height',
                    'type'          => 'slider',
                    'title'         => esc_html__( 'Top Header Height', 'avas' ),
                    'min'           => 0,
                    'step'          => 1,
                    'default'       => 30,
                    'max'           => 300,
                    'display_value' => 'text',
                    'required'  => array( 'top_head', '=', '1' ),
                ),
                array(
                    'id'            => 'top_header_height_mobile',
                    'type'          => 'slider',
                    'title'         => esc_html__( 'Top Header Height for Mobile Phone', 'avas' ),
                    'min'           => 0,
                    'step'          => 1,
                    'default'       => 30,
                    'max'           => 300,
                    'display_value' => 'text',
                    'required'  => array( 'top_head', '=', '1' ),
                ),
                array(
                    'id'             => 'top_head_space',
                    'type'           => 'spacing',
                    'output'         => array('#top_head'),
                    'mode'           => 'padding',
                    'units'          => array('px', 'em'),
                    'units_extended' => 'false',
                    'title'          => esc_html__('Top Header Padding', 'avas'),
                    'required'  => array( 'top_head', '=', '1' ),
                    'default'        => array (
                        'units'       => 'px'
                    )
                ),
                array(
                    'id'             => 'top_head_margin',
                    'type'           => 'spacing',
                    'output'         => array('#top_head'),
                    'mode'           => 'margin',
                    'units'          => array('px', 'em'),
                    'units_extended' => 'false',
                    'title'          => esc_html__('Top Header Margin', 'avas'),
                    'required'  => array( 'top_head', '=', '1' ),
                    'default'        => array (
                        'units'       => 'px'
                    )
                ),
                // welcome message
                array(
                    'id'        => 'wm_switch',
                    'type'      => 'switch',
                    'title'    =>  esc_html__('Top Header Welcome Message', 'avas'),
                    'default'   => 0,
                    'on'        => esc_html__('On', 'avas'),
                    'off'       => esc_html__('Off', 'avas'),
                    'required'  => array( 'top_head', '=', '1' )
                ),
                array(
                    'id'        => 'wm_switch_res',
                    'type'      => 'switch',
                    'title'    =>  esc_html__('Top Header Welcome Message Display on Responsive Devices?', 'avas'),
                    'default'   => 1,
                    'on'        => esc_html__('Yes', 'avas'),
                    'off'       => esc_html__('No', 'avas'),
                    'required'  => array( 'wm_switch', '=', '1' )
                ),
                array(
                    'id'       => 'welcome_msg',
                    'type'     => 'textarea',
                    'default'  => esc_html__('Welcome to Avas WordPress Theme.','avas'),
                    'required'  => array( 'wm_switch', '=', '1' )
                ),
                array(
                    'id'       => 'welcome_msg_color',
                    'type'     => 'color',
                    'output'   => array( '.welcome_msg,.welcome_msg a' ),
                    'title'    => esc_html__( 'Top Header Welcome Message Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'wm_switch', '=', '1' )
                ),
                array(
                    'id'       => 'typography-welcome-msg',
                    'type'     => 'typography',
                    'title'    => esc_html__( 'Top Header Welcome Message Fonts', 'avas' ),
                    'google'   => true,
                    'font-backup' => false,
                    'output'      => array('.welcome_msg'),
                    'units'       =>'px',
                    'fonts' => $standard_fonts,
                    'font-style'  => true,
                    'all_styles'  => true,
                    'word-spacing'  => true,
                    'letter-spacing'=> true,
                    'line-height'   => true,
                    'text-transform'=> true,
                    'color'         => false,
                    'subsets'       => true,
                    'allow_empty_line_height' => true,
                    'required'  => array( 'wm_switch', '=', '1' )
                ),
                // date options
                is_customize_preview() ? null : array(
                    'id'        => 'tx-date',
                    'title'     => esc_html__( 'Top Header Date', 'avas' ),
                    'type'      => 'switch',
                    'default'   => 0,
                    'on'        => esc_html__('On', 'avas'),
                    'off'       => esc_html__('Off', 'avas'),
                    'required'  => array( 'top_head', '=', '1' )
                ),
                is_customize_preview() ? null : array(
                    'id'        => 'tx-date_res',
                    'title'     => esc_html__( 'Top Header Date Display on Responsive Devices?', 'avas' ),
                    'type'      => 'switch',
                    'default'   => 1,
                    'on'        => esc_html__('Yes', 'avas'),
                    'off'       => esc_html__('No', 'avas'),
                    'required'  => array( 'tx-date', '=', '1' )
                ),
                // date color
                is_customize_preview() ? null : array(
                    'id'       => 'date-color',
                    'type'     => 'color',
                    'output'   => array( '.tx-date, .tx-date .fa-clock-o' ),
                    'title'    => esc_html__( 'Top Header Date Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'tx-date', '=', '1' )
                ),
                //Phone options
                is_customize_preview() ? null : array(
                    'id'        => 'tx-phone',
                    'title'     => esc_html__( 'Top Header Phone', 'avas' ),
                    'type'      => 'switch',
                    'default'   => 1,
                    'on'        => esc_html__('On', 'avas'),
                    'off'       => esc_html__('Off', 'avas'),
                    'required'  => array( 'top_head', '=', '1' )
                ),
                is_customize_preview() ? null : array(
                    'id'        => 'tx-phone_res',
                    'title'     => esc_html__( 'Top Header Phone Display on Responsive Devices?', 'avas' ),
                    'type'      => 'switch',
                    'default'   => 1,
                    'on'        => esc_html__('Yes', 'avas'),
                    'off'       => esc_html__('No', 'avas'),
                    'required'  => array( 'tx-phone', '=', '1' )
                ),
                is_customize_preview() ? null : array( 
                    'title'     => esc_html__( 'Enter Phone Number', 'avas' ),
                    'id'        => 'phone-number',
                    'default'   => esc_html__('+1 229-226-7070', 'avas'),
                    'type'      => 'text',
                    'required'  => array( 'tx-phone', '=', '1' ),
                ),
                // phone color
                is_customize_preview() ? null : array(
                    'id'       => 'phone-color',
                    'type'     => 'color',
                    'output'   => array( '.phone-number, .phone-number a' ),
                    'title'    => esc_html__( 'Top Header Phone Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'tx-phone', '=', '1' )
                ),
                is_customize_preview() ? null : array(
                    'id'       => 'phone-hov-color',
                    'type'     => 'color',
                    'output'   => array( '.phone-number:hover, .phone-number a:hover' ),
                    'title'    => esc_html__( 'Top Header Phone Hover Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'tx-phone', '=', '1' )
                ),
                // Email options
                is_customize_preview() ? null : array(
                    'id'        => 'tx-email',
                    'title'     => esc_html__( 'Top Header Email', 'avas' ),
                    'type'      => 'switch',
                    'default'   => 1,
                    'on'        => esc_html__('On', 'avas'),
                    'off'       => esc_html__('Off', 'avas'),
                    'required'  => array( 'top_head', '=', '1' )
                ),
               is_customize_preview() ? null : array(
                    'id'        => 'tx-email_res',
                    'title'     => esc_html__( 'Top Header Email Display on Responsive Devices?', 'avas' ),
                    'type'      => 'switch',
                    'default'   => 1,
                    'on'        => esc_html__('Yes', 'avas'),
                    'off'       => esc_html__('No', 'avas'),
                    'required'  => array( 'tx-email', '=', '1' )
                ),
                is_customize_preview() ? null : array( 
                    'title'     => esc_html__( 'Enter Email Address', 'avas' ),
                    'id'        => 'email-address',
                    'default'   => 'info@website.com',
                    'type'      => 'text',
                    'required'  => array( 'tx-email', '=', '1' ),
                ),
                // email color
                is_customize_preview() ? null : array(
                    'id'       => 'email-color',
                    'type'     => 'color',
                    'output'   => array( '.email-address, .email-address a' ),
                    'title'    => esc_html__( 'Top Header Email Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'tx-email', '=', '1' )
                ),
                is_customize_preview() ? null : array(
                    'id'       => 'email-hov-color',
                    'type'     => 'color',
                    'output'   => array( '.email-address:hover, .email-address a:hover' ),
                    'title'    => esc_html__( 'Top Header Email Hover Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'tx-email', '=', '1' )
                ),
                // news ticker options
                array(
                    'id'        => 'news_ticker',
                    'type'      => 'switch',
                    'title'     => esc_html__('Top Header News Ticker', 'avas'),
                    'default'   => 0,
                    'on'        => 'On',
                    'off'       => 'Off',
                    'required'  => array( 'top_head', '=', '1' )
                ),
                array(
                    'id'        => 'news_ticker_res',
                    'type'      => 'switch',
                    'title'     => esc_html__('Top Header News Ticker Display on Responsive Devices?', 'avas'),
                    'default'   => 1,
                    'on'        => esc_html__('Yes','avas'),
                    'off'       => esc_html__('No','avas'),
                    'required'  => array( 'news_ticker', '=', '1' )
                ),
                array(
                    'id'            => 'newsticker_width_res',
                    'type'          => 'slider',
                    'title'         => esc_html__( 'News Ticker width for responsive devices', 'avas' ),
                    'default'       => 222,
                    'min'           => 1,
                    'step'          => 1,
                    'max'           => 700,
                    'display_value' => 'text',
                    'required'  => array('news_ticker_res', '=', '1' ),
                ),
                array(
                    'id'       => 'news_ticker_categories',
                    'type'     => 'select',
                    'data'     => 'categories',
                    'multi'    => true,
                    'title'    => esc_html__( 'News Ticker Select Categories', 'avas' ),
                    'required'  => array('news_ticker', '=', '1' ),
                ),
                array(
                    'id'       => 'news_ticker_orderby',
                    'type'     => 'select',
                    'title' => esc_html__('News Ticker Orderby', 'avas'),
                    'options'  => array(
                        'meta_value_num'  => esc_html__('Most Views','avas'),
                        'date'  => esc_html__('Date','avas'),
                        'rand'  => esc_html__('Random','avas'),
                        'title'  => esc_html__('Title','avas'),
                        'menu_order'  => esc_html__('Menu Order','avas'),
                        'modified'  => esc_html__('Modified Date','avas'),
                        'parent'  => esc_html__('Parent ID','avas'),
                        'comment_count'  => esc_html__('Comment Count','avas'),
                        'id'  => esc_html__('ID','avas'),
                        'name'  => esc_html__('Slug','avas'),
                        'none'  => esc_html__('None','avas'),
                    ),
                    'default'  => 'meta_value_num',
                    'required'  => array('news_ticker', '=', '1' ),
                ),
                array(
                    'id'       => 'news_ticker_order',
                    'type'     => 'select',
                    'title' => esc_html__('News Ticker Order', 'avas'),
                    'options'  => array(
                        'DESC'  => esc_html__('DESC','avas'),
                        'ASC'  => esc_html__('ASC','avas'),
                    ),
                    'default'  => 'DESC',
                    'required'  => array('news_ticker', '=', '1' ),
                ),
                array(
                    'id'            => 'newsticker-posts-per-page',
                    'type'          => 'slider',
                    'title'         => esc_html__( 'News Ticker Count', 'avas' ),
                    'default'       => 5,
                    'min'           => 1,
                    'step'          => 1,
                    'max'           => 99,
                    'display_value' => 'text',
                    'required'  => array('news_ticker', '=', '1' ),
                ),
                array( 
                    'title'     => esc_html__( 'News Ticker Text', 'avas' ),
                    'id'        => 'news_ticker_bar_text',
                    'default'   => esc_html__('Trending', 'avas'),
                    'type'      => 'text',
                    'required'  => array('news_ticker', '=', '1' ),
                ),
                // News ticker color / Tending color options
                array(
                    'id'       => 'news-ticker-title-color',
                    'type'     => 'color',
                    'output'   => array( '.news-ticker-title a' ),
                    'title'    => esc_html__( 'News Ticker Text color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array('news_ticker', '=', '1' ),
                ),
                array(
                    'id'       => 'news-ticker-title-hover',
                    'type'     => 'color',
                    'output'   => array( '.news-ticker-title a:hover' ),
                    'title'    => esc_html__( 'News Ticker Text hover color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array('news_ticker', '=', '1' ),
                ),
                array(
                    'id'       => 'tx_news_ticker_bar',
                    'type'     => 'color',
                    'output'   => array( 'background-color'=>'.tx_news_ticker_bar' ),
                    'title'    => esc_html__( 'News Ticker Label background color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => true,
                    'required'  => array('news_ticker', '=', '1' ),
                ),
                array(
                    'id'       => 'tx_news_ticker_bar_color',
                    'type'     => 'color',
                    'output'   => array( 'color'=>'.tx_news_ticker_bar' ),
                    'title'    => esc_html__( 'News Ticker Label text color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array('news_ticker', '=', '1' ),
                            
                ),
                array(
                    'id'       => 'tx_news_ticker_nav_color',
                    'type'     => 'color',
                    'output'   => array( 'color'=>'#news-ticker button.owl-next, #news-ticker button.owl-prev' ),
                    'title'    => esc_html__( 'News Ticker Nav text color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array('news_ticker', '=', '1' ),
                            
                ),
                array(
                    'id'       => 'tx_news_ticker_nav_hover_color',
                    'type'     => 'color',
                    'output'   => array( 'color'=>'#news-ticker button.owl-next:hover, #news-ticker button.owl-prev:hover' ),
                    'title'    => esc_html__( 'News Ticker Nav Text hover color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array('news_ticker', '=', '1' ),
                            
                ),
                array(
                    'id'       => 'tx_news_ticker_nav_bg_color',
                    'type'     => 'color',
                    'output'   => array( 'background-color'=>'#news-ticker button.owl-next, #news-ticker button.owl-prev' ),
                    'title'    => esc_html__( 'News Ticker Nav background color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array('news_ticker', '=', '1' ),
                            
                ),
                array(
                    'id'       => 'tx_news_ticker_nav_background_hover_color',
                    'type'     => 'color',
                    'output'   => array( 'background-color'=>'#news-ticker button.owl-next:hover,#news-ticker button.owl-prev:hover' ),
                    'title'    => esc_html__( 'News Ticker Nav background hover color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array('news_ticker', '=', '1' ),
                            
                ),
                array(
                    'id'       => 'tx_news_ticker_nav_border_color',
                    'type'     => 'color',
                    'output'   => array( 'border-color'=>'#news-ticker button.owl-next, #news-ticker button.owl-prev' ),
                    'title'    => esc_html__( 'News Ticker Nav border color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array('news_ticker', '=', '1' ),
                            
                ),        
                array(
                    'id'       => 'tx_news_ticker_nav_border_hover_color',
                    'type'     => 'color',
                    'output'   => array( 'border-color'=>'#news-ticker button.owl-next:hover, #news-ticker button.owl-prev:hover' ),
                    'title'    => esc_html__( 'News Ticker Nav border hover color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array('news_ticker', '=', '1' ),
                            
                ),
                // top menu
                array(
                    'id'        => 'top_menu',
                    'title'     => esc_html__( 'Top Menu', 'avas' ),
                    'type'      => 'switch',
                    'default'   => 0,
                    'on'        => esc_html__('On', 'avas'),
                    'off'       => esc_html__('Off', 'avas'),
                    'required'  => array( 'top_head', '=', '1' )
                ),
                array(
                    'id'        => 'top_menu_res',
                    'title'     => esc_html__( 'Top Menu Display on Responsive Devices?', 'avas' ),
                    'type'      => 'switch',
                    'default'   => 1,
                    'on'        => esc_html__('Yes', 'avas'),
                    'off'       => esc_html__('No', 'avas'),
                    'required'  => array( 'top_menu', '=', '1' )
                ),
                array(
                    'id'       => 'top-menu-link-color',
                    'type'     => 'color',
                    'output'   => array( '.top_menu > li > a' ), 
                    'title'    => esc_html__( 'Top Menu link color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'top_menu', '=', '1' )
                ),
                array(
                    'id'       => 'top-menu-link-hover-color',
                    'type'     => 'color',
                    'output'   => array( '.top_menu > li > a:hover, .top_menu > li > a:focus' ),
                    'title'    => esc_html__( 'Top Menu link hover color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'top_menu', '=', '1' )
                ),
                // login register
                array(
                    'id'        => 'login_reg',
                    'title'     => esc_html__( 'Top Header Login', 'avas' ),
                    'type'      => 'switch',
                    'default'   => 0,
                    'on'        => esc_html__('On', 'avas'),
                    'off'       => esc_html__('Off', 'avas'),
                    'required'  => array( 'top_head', '=', '1' )
                ),
                array(
                    'id'        => 'login_reg_res',
                    'title'     => esc_html__( 'Top Header Login Display on Responsive Devices?', 'avas' ),
                    'type'      => 'switch',
                    'default'   => 1,
                    'on'        => esc_html__('Yes', 'avas'),
                    'off'       => esc_html__('No', 'avas'),
                    'required'  => array( 'login_reg', '=', '1' )
                ),
                array(
                    'id'       => 'login-register',
                    'type'     => 'text',
                    'title'    => esc_html__('Enter text for Login','avas'),
                    'default'  => 'Login',
                    'required' => array( 'login_reg', '=', '1' ),
                ),
                array(
                    'id'       => 'signup-text',
                    'type'     => 'text',
                    'title'    => esc_html__('Enter register page name','avas'),
                    // 'default'  => 'my-account',
                    'desc'     => esc_html__('Example: If you use WooCommerce plugin you can enter "http://your-website-name.com/my-account" or if you use Learnpress plugin then enter "http://your-website-name.com/profile".','avas'),
                    'required' => array( 'login_reg', '=', '1' ),
                ),
                array(
                    'id'       => 'login-link-color',
                    'type'     => 'color',
                    'output'   => array( 'color' => '.login_button' ),
                    'title'    => esc_html__( 'Top Header Login link color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required' => array( 'login_reg', '=', '1' ),
                ),
                array(
                    'id'       => 'login-link-hover-color',
                    'type'     => 'color',
                    'output'   => array( 'color' => '.login_button:hover,.login_button:focus' ),
                    'title'    => esc_html__( 'Top Header Login link hover color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required' => array( 'login_reg', '=', '1' ),
                ),
                array(
                    'id'       => 'login-form-btn-color',
                    'type'     => 'color',
                    'output'   => array( 'background-color' => '.tx-login input.submit_button' ),
                    'title'    => esc_html__( 'Top Header Login Form Button color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required' => array( 'login_reg', '=', '1' ),
                ),
                array(
                    'id'       => 'login-form-btn-hov-color',
                    'type'     => 'color',
                    'output'   => array( 'background-color' => '.tx-login input.submit_button:hover' ),
                    'title'    => esc_html__( 'Top Header Login Form Button hover color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required' => array( 'login_reg', '=', '1' ),
                ),
                // social icons top header
                array(
                    'id'        => 'social_buton_top',
                    'title'     => esc_html__( 'Top Header Social Icons', 'avas' ),
                    'type'      => 'switch',
                    'default'   => 1,
                    'on'        => esc_html__('On', 'avas'),
                    'off'       => esc_html__('Off', 'avas'),
                    'required'  => array( 'top_head', '=', '1' )
                ),
                array(
                    'id'        => 'social_buton_top_res',
                    'title'     => esc_html__( 'Top Header Social Icons Display on Responsive Devices?', 'avas' ),
                    'type'      => 'switch',
                    'default'   => 1,
                    'on'        => esc_html__('Yes', 'avas'),
                    'off'       => esc_html__('No', 'avas'),
                    'required'  => array( 'social_buton_top', '=', '1' )
                ),
                array(
                    'id'       => 'social-media-icon-header-color',
                    'type'     => 'color',
                    'output'   => array( 'color' => '#header .top-header-right-area .social li a i' ),
                    'title'    => esc_html__( 'Top Header Social icon color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'social_buton_top', '=', '1' )
                ),
                array(
                    'id'       => 'social-media-icon-header-hover-color',
                    'type'     => 'color',
                    'output'   => array( 'color' => '#header .social li:hover a i' ),
                    'title'    => esc_html__( 'Top Header Social Icons Hover Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'social_buton_top', '=', '1' )
                ),
                array(
                    'id'       => 'social-media-icon-header-bg-color',
                    'type'     => 'color',
                    'output'   => array( 'background-color' => '#header .top-header-right-area .social li' ),
                    'title'    => esc_html__( 'Top Header Social icon background color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'social_buton_top', '=', '1' )
                ),
                array(
                    'id'       => 'social-media-icon-header-bg-hover-color',
                    'type'     => 'color',
                    'output'   => array( 'background-color' => '#header .social li:hover' ),
                    'title'    => esc_html__( 'Top Header Social Icons Background Hover Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'social_buton_top', '=', '1' )
                ),
                array(
                    'id'       => 'social-media-icon-header-border-hover-color',
                    'type'     => 'color',
                    'output'   => array( 'border-color' => '#header .social li:hover' ),
                    'title'    => esc_html__( 'Top Header Social Icons Border Hover Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'social_buton_top', '=', '1' )
                ),
                array(
                    'id'            => 'social-media-icon-header-size',
                    'type'          => 'slider',
                    'title'         => esc_html__( 'Top Header Social Icons Size', 'avas' ),
                    'default'       => 13,
                    'max'           => 30,
                    'display_value' => 'text',
                    'required'  => array( 'social_buton_top', '=', '1' )
                ),
                array(
                    'id'            => 'social-media-icon-header-border-radius',
                    'type'          => 'slider',
                    'title'         => esc_html__( 'Top Header Social Icons border-radius', 'avas' ),
                    'max'           => 100,
                    'display_value' => 'text',
                    'required'  => array( 'social_buton_top', '=', '1' )
                ),
                array( 
                    'id'       => 'social-media-icon-header_border',
                    'type'     => 'border',
                    'title'    => esc_html__('Top Header Social Icons Border', 'avas'),
                    'output'   => array('#header .social li'),
                    'required'  => array( 'social_buton_top', '=', '1' )
                ),
                array(
                    'id'             => 'social-media-icon-header_padding',
                    'type'           => 'spacing',
                    'output'         => array('#header .social li'),
                    'mode'           => 'padding',
                    'units'          => array('px', 'em'),
                    'title'          => esc_html__('Top Header Social Icons Padding', 'avas'),
                    'default'        => array (
                        'units'       => 'px'
                    ),
                    'required'  => array( 'social_buton_top', '=', '1' )
                ),
                array(
                    'id'             => 'social-media-icon-header_margin',
                    'type'           => 'spacing',
                    'output'         => array('#header .social li'),
                    'mode'           => 'margin',
                    'units'          => array('px', 'em'),
                    'title'          => esc_html__('Top Header Social Icons Margin', 'avas'),
                    'default'        => array (
                        'units'       => 'px'
                    ),
                    'required'  => array( 'social_buton_top', '=', '1' )
                ),

                // Top header color options
                array(
                    'id'        => 'top-header-colors',
                    'type'      => 'info',
                    'title'     => esc_html__('Top Header Colors Options', 'avas'),
                    'style'     => 'success',
                    'required'  => array( 'top_head', '=', '1' )
                ),
                array(
                    'id'       => 'top_head_bg_color_home',
                    'type'     => 'color_rgba',
                    'output'   => array( 
                    'background-color' => '.home #top_head',
                     ),
                    'title'    => esc_html__( 'Top header background color for Home Page only', 'avas' ),
                    'required'  => array( 'top_head', '=', '1' )
                ),
                array(
                    'id'       => 'top_head_bg_color_inner',
                    'type'     => 'color_rgba',
                    'output'   => array( 
                    'background-color' => '#top_head, .home .sticky-header #top_head',
                     ),
                    'title'    => esc_html__( 'Top header background color for inner pages', 'avas' ),
                    'required'  => array( 'top_head', '=', '1' )
                ),
                array( 
                    'id'       => 'top_head_border',
                    'type'     => 'border',
                    'title'    => esc_html__('Top Header Bottom Border', 'avas'),
                    'desc'     => esc_html__( 'Enter border width, example 1, 2, 3 etc to enable border', 'avas' ),
                    'output'   => array('#top_head'),
                    'top' => false,
                    'right' => false,
                    'left' => false,
                    'color' => false,
                    'required'  => array( 'top_head', '=', '1' )
                ),
                array(
                    'id'       => 'top_head_border_color',
                    'type'     => 'color_rgba',
                    'output'   => array( 
                    'border-color' => '#top_head',
                     ),
                    'title'    => esc_html__( 'Top Header Border color', 'avas' ),
                    'required'  => array( 'top_head', '=', '1' )
                ),
                // Top header font options
                array(
                    'id'        => 'top-header-fonts',
                    'type'      => 'info',
                    'title'     => esc_html__('Top Header Fonts Options', 'avas'),
                    'style'     => 'success',
                    'required'  => array( 'top_head', '=', '1' )
                ),
                array(
                    'id'       => 'typography-top-header',
                    'type'     => 'typography',
                    'title'    => esc_html__( 'Top header Fonts', 'avas' ),
                    'google'   => true,
                    'font-backup' => false,
                    'output'      => array('#top_head'),
                    'units'       =>'px',
                    'fonts' => $standard_fonts,
                    'font-style'  => true,
                    'all_styles'  => true,
                    'line-height' => true,
                    'word-spacing'  => true,
                    'text-transform'=> true,
                    'letter-spacing'=> true,
                    'color'         => false,
                    'subsets'       => false,
                    'allow_empty_line_height' => true,
                    'required'  => array( 'top_head', '=', '1' )
                ),

            )));    
    // Sub header options / subheader
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Sub Header', 'avas'),
        'id'               => 'sub-header',
        'subsection'       => true,
        'desc'             => esc_html__( 'Sub Header options','avas'),
        'customizer_width' => '344px',
        'fields'           => array(
                array(
                    'title'    => esc_html__( 'Enable / Disable','avas'),
                    'id'       => 'sub-header-switch',
                    'type'     => 'switch',
                    'on'       => esc_html__('Enable', 'avas'),
                    'off'      => esc_html__('Disable', 'avas'),
                    'default'  => 1,
                    ),
                array(
                    'id'            => 'sub_header_height',
                    'type'          => 'slider',
                    'title'         => esc_html__( 'Sub Header Height', 'avas' ),
                    'min'           => 0,
                    'step'          => 1,
                    'default'       => 180,
                    'max'           => 1000,
                    'display_value' => 'text',
                    'required' => array('sub-header-switch', '=', '1' ),
                ),
                array(
                    'id'            => 'sub_header_height_responsive',
                    'type'          => 'slider',
                    'title'         => esc_html__( 'Sub Header Height for Responsive Devices', 'avas' ),
                    'min'           => 0,
                    'step'          => 1,
                    'default'       => 180,
                    'max'           => 1000,
                    'display_value' => 'text',
                    'required' => array('sub-header-switch', '=', '1' ),
                ),
                array(
                    'title'    => esc_html__( 'Sub Header Title','avas'),
                    'id'       => 'sub_h_title',
                    'type'     => 'switch',
                    'on'       => esc_html__('On', 'avas'),
                    'off'      => esc_html__('Off', 'avas'),
                    'required' => array('sub-header-switch', '=', '1' ),
                    'default'  => 1,
                ),
                array(
                    'id'       => 'sub_h_post_title',
                    'type'     => 'checkbox',
                    'required' => array('sub_h_title', '=', '1' ),
                    'options'  => array(
                        'page' => esc_html__('Page', 'avas'),
                        'post' => esc_html__('Post', 'avas'),
                        'service' => esc_html__('Services', 'avas'),
                        'portfolio' => esc_html__('Portfolios', 'avas'),
                        'team' => esc_html__('Team', 'avas'),
                        'lp_course' => esc_html__('LearnPress / Education', 'avas'),
                        'product' => esc_html__('WooCommerce', 'avas'),
                        'properties' => esc_html__('Estatik / Real Estate', 'avas'),
                        'tribe_events' => esc_html__('Events', 'avas'),
                        'bbpress' => esc_html__('BBPress / Forum', 'avas'),
                    ),
                    'default' => array(
                        'page'    => '1', 
                        'post'    => '1', 
                        'service' => '1',
                        'portfolio' => '1',
                        'team' => '1',
                        'lp_course' => '1',
                        'product' => '1',
                        'properties' => '1',
                        'tribe_events' => '1',
                        'bbpress' => '1',
                    )
                ),
                array(
                    'title'    => esc_html__( 'Sub Header Breadcrumbs','avas'),
                    'id'       => 'breadcrumbs',
                    'type'     => 'switch',
                    'on'       => esc_html__('On', 'avas'),
                    'off'      => esc_html__('Off', 'avas'),
                    'required' => array('sub-header-switch', '=', '1' ),
                    'default'  => 1,
                ),
                array(
                    'id'       => 'sub_h_post_breadcrumbs',
                    'type'     => 'checkbox',
                    'required' => array('breadcrumbs', '=', '1' ),
                    'options'  => array(
                        'page' => esc_html__('Page', 'avas'),
                        'post' => esc_html__('Post', 'avas'),
                        'service' => esc_html__('Services', 'avas'),
                        'portfolio' => esc_html__('Portfolios', 'avas'),
                        'team' => esc_html__('Team', 'avas'),
                        'lp_course' => esc_html__('LearnPress / Education', 'avas'),
                        'product' => esc_html__('WooCommerce', 'avas'),
                        'properties' => esc_html__('Estatik / Real Estate', 'avas'),
                        'tribe_events' => esc_html__('Events', 'avas'),
                        'bbpress' => esc_html__('BBPress / Forum', 'avas'),
                    ),
                    'default' => array(
                        'page'    => '1',
                        'post'    => '1',
                        'service' => '1',
                        'portfolio' => '1',
                        'team' => '1',
                        'lp_course' => '1',
                        'product' => '1',
                        'properties' => '1',
                        'tribe_events' => '1',
                        'bbpress' => '1',
                    )
                ),
                array(
                    'id'       => 'tx_breadcrumbs_home_title',
                    'type'     => 'text',
                    'title'    => esc_html__( 'Breadcrumb Home Title', 'avas' ),
                    'default'  => '',
                    'desc'     => esc_html__( 'This will replace the default Home breadcrumb text.', 'avas' ),
                    'required' => array('breadcrumbs', '=', '1' ),
                ),
                array(
                    'id'             => 'sub_h_space',
                    'type'           => 'spacing',
                    'output'         => array('.sub-header, .sub-header-blog'),
                    'mode'           => 'padding',
                    'units'          => array('px', 'em'),
                    'required'  => array( 'sub-header-switch', '=', '1' ),
                    'units_extended' => 'false',
                    'title'          => esc_html__('Sub Header Padding', 'avas'),
                    'default'            => array(
                    'padding-top'     => '', 
                    'padding-right'   => '', 
                    'padding-bottom'  => '', 
                    'padding-left'    => '',
                    'units'          => 'px', 
                    )
                ),
                array(
                    'id'             => 'sub_h_margin',
                    'type'           => 'spacing',
                    'output'         => array('.sub-header, .sub-header-blog'),
                    'mode'           => 'margin',
                    'units'          => array('px', 'em'),
                    'required'  => array( 
                        array('sub-header-switch', '=', '1' ),
                        array('header_overlay_inner', '=', '0' ),
                    ),
                    'units_extended' => 'false',
                    'title'          => esc_html__('Sub Header Margin', 'avas'),
                    'default'            => array(
                    'units'          => 'px', 
                    )
                ),
                array(
                    'title' => esc_html__( 'Sub Header Title color', 'avas' ),
                    'id'    => 'sub-header-title-color',
                    'type'  => 'color',
                    'output'   => array('.sub-header-title'),
                    'required' => array('sub-header-switch', '=', '1' ),
                    'transparent' => false,
                ),
                array(
                    'title' => esc_html__( 'Sub Header Link color', 'avas' ),
                    'id'    => 'sub-header-link-color',
                    'type'  => 'color',
                    'output'   => array('.breadcrumbs span a, .bbp-breadcrumb a'),
                    'required' => array('sub-header-switch', '=', '1' ),
                    'transparent' => false,
                ),
                array(
                    'title' => esc_html__( 'Sub Header Link hover color', 'avas' ),
                    'id'    => 'sub-header-link-hover-color',
                    'type'  => 'color',
                    'output'   => array('.breadcrumbs span a:hover, .bbp-breadcrumb a:hover'),
                    'required' => array('sub-header-switch', '=', '1' ),
                    'transparent' => false,
                ),
                array(
                    'title' => esc_html__( 'Sub Header Separate color', 'avas' ),
                    'id'    => 'sub-header-separate-color',
                    'type'  => 'color',
                    'output'   => array('.breadcrumbs .breadcrumbs__separator, .bbp-breadcrumb-sep'),
                    'required' => array('sub-header-switch', '=', '1' ),
                    'transparent' => false,
                ),
                array(
                    'title' => esc_html__( 'Sub Header Active link color', 'avas' ),
                    'id'    => 'sub-header-active-link-color',
                    'type'  => 'color',
                    'output'   => array('.breadcrumbs .breadcrumbs__current, .bbp-breadcrumb-current'),
                    'required' => array('sub-header-switch', '=', '1' ),
                    'transparent' => false,
                ),
                array(
                    'title' => esc_html__( 'Sub Header Background', 'avas' ),
                    'id'    => 'sub-header-bg',
                    'type'  => 'background',
                    'output'   => array('background-color'=>'.sub-header'),
                    'required' => array('sub-header-switch', '=', '1' ),
                ),
                array(
                    'id'       => 'sub-header-bg-overlay',
                    'type'     => 'color_rgba',
                    'output'   => array( 
                    'background-color' => '.sub-header-overlay' ),
                    'title'    => esc_html__( 'Sub Header Background Overlay Color', 'avas' ),
                    'required' => array('sub-header-switch', '=', '1' ),
                ),
                array(
                    'id'       => 'typography-sub-header',
                    'type'     => 'typography',
                    'title'    => esc_html__( 'Sub Header Title Fonts', 'avas' ),
                    'google'   => true,
                    'font-backup' => false,
                    'output'      => array('h1.sub-header-title'),
                    'units'       =>'px',
                    'fonts' => $standard_fonts,
                    'font-style'  => true,
                    'all_styles'  => true,
                    'word-spacing'  => true,
                    'letter-spacing'=> true,
                    'text-transform' => true,
                    'color'         => false,
                    'subsets'       => true,
                    'allow_empty_line_height' => true,
                    'required' => array('sub-header-switch', '=', '1' ),
                ),
                array(
                    'id'       => 'typography-breadcrumbs',
                    'type'     => 'typography',
                    'title'    => esc_html__( 'Sub Header Breadcrumbs Fonts', 'avas' ),
                    'google'   => true,
                    'font-backup' => false,
                    'output'      => array('.breadcrumbs'),
                    'units'       =>'px',
                    'fonts' => $standard_fonts,
                    'font-style'  => true,
                    'all_styles'  => true,
                    'word-spacing'  => true,
                    'letter-spacing'=> true,
                    'text-transform' => true,
                    'color'         => false,
                    'subsets'       => true,
                    'allow_empty_line_height' => true,
                    'required' => array('sub-header-switch', '=', '1' ),
                ),
            )
        ));
    // search icon option
        Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Search', 'avas'),
        'id'               => 'search_opt',
        'subsection'       => true,
        'customizer_width' => '344px',
        'fields'           => array(
                // 
                array(
                    'id'        => 'search',
                    'type'      => 'switch',
                    'title'     => esc_html__('Header Search Icon', 'avas'),
                    'default'   => 1,
                    'on'        => 'On',
                    'off'       => 'Off',
                ),
                array(
                    'id'             => 'search_space',
                    'type'           => 'spacing',
                    'output'         => array('.search-icon'),
                    'mode'           => 'margin',
                    'units'          => array('px', 'em'),
                    'units_extended' => 'false',
                    'title'          => esc_html__('Header Search Margin', 'avas'),
                    'required'  => array( 'search', '=', '1' ),
                    'default'        => array (
                        'units'       => 'px'
                    )
                ),
                array(
                    'id'             => 'search_space_padding',
                    'type'           => 'spacing',
                    'output'         => array('.search-icon'),
                    'mode'           => 'padding',
                    'units'          => array('px', 'em'),
                    'units_extended' => 'false',
                    'title'          => esc_html__('Header Search Padding', 'avas'),
                    'required'  => array( 'search', '=', '1' ),
                    'default'        => array (
                        'units'       => 'px'
                    )
                ),
                //search icon color
                array(
                    'id'       => 'search-icon-color',
                    'type'     => 'color',
                    'output'   => array( '.search-icon' ),
                    'title'    => esc_html__( 'Header Search icon color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'search', '=', '1' ),
                ),
                array(
                    'id'       => 'search-icon-hover-color',
                    'type'     => 'color',
                    'output'   => array( '.search-icon:hover' ),
                    'title'    => esc_html__( 'Header Search icon hover color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'search', '=', '1' ),
                ),
                array(
                    'id'       => 'search-icon-color-home',
                    'type'     => 'color',
                    'output'   => array( '.home .search-icon' ),
                    'title'    => esc_html__( 'Header Search icon color on Home Page', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'search', '=', '1' ),
                ),
                array(
                    'id'       => 'search-icon-hover-color-home',
                    'type'     => 'color',
                    'output'   => array( '.home .search-icon:hover' ),
                    'title'    => esc_html__( 'Header Search icon hover color on Home Page', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'search', '=', '1' ),
                ),
                array(
                    'id'       => 'search-icon-close-color',
                    'type'     => 'color',
                    'output'   => array( '.search-box > .search-close,.search-box > .search-close i' ),
                    'title'    => esc_html__( 'Header Search close icon color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'search', '=', '1' ),
                ),
                array(
                    'id'       => 'search-icon-close-hover-color',
                    'type'     => 'color',
                    'output'   => array( '.search-box > .search-close:hover,.search-close:hover i,.search-box > .search-close:hover i' ),
                    'title'    => esc_html__( 'Header Search close icon hover color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'search', '=', '1' ),
                ),
                )));
    // Menu options
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Menu', 'avas' ),
        'id'               => 'menu_opt',
        'customizer_width' => '344px',
        'icon'             => 'bi bi-list'
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Main Menu', 'avas'),
        'id'               => 'main_menu_opt',
        'subsection'       => true,
        'customizer_width' => '344px',
        'fields'           => array(
                array(
                    'id'       => 'menu-alignment',
                    'type'     => 'select',
                    'title' => esc_html__('Main Menu Alignment', 'avas'),
                    'options'  => array(
                        'none'  => esc_html__('None','avas'),
                        'left'  => esc_html__('Left','avas'),
                        'right'  => esc_html__('Right','avas'),
                        'center'  => esc_html__('Center','avas'),
                    ),
                    'default'  => 'none',
                    'required'  => array( 'header-select', '=', array('header1','header2','header3','header4','header5','header6','header7','header8','header11') ),
                ),
                array(
                    'id'             => 'menu_margin',
                    'type'           => 'spacing',
                    'output'         => array('.main-menu>li>a,.header-style-eight .main-menu>li>a, .header-style-four .main-menu>li>a, .header-style-one .main-menu>li>a, .header-style-seven .main-menu>li>a, .header-style-six .main-menu>li>a, .header-style-two .main-menu>li>a, #h-style-10 .main-menu>li>a'),
                    'mode'           => 'margin',
                    'units'          => array('px', 'em'),
                    'title'          => esc_html__('Main Menu Item Margin', 'avas'),
                    'default'        => array (
                        'units'       => 'px'
                    )
                ),
                array(
                    'id'             => 'menu_padding',
                    'type'           => 'spacing',
                    'output'         => array('.main-menu>li>a,.header-style-eight .main-menu>li>a, .header-style-four .main-menu>li>a, .header-style-one .main-menu>li>a, .header-style-seven .main-menu>li>a, .header-style-six .main-menu>li>a, .header-style-two .main-menu>li>a, #h-style-10 .main-menu>li>a,#h-style-1 .main-menu>li>a'),
                    'mode'           => 'padding',
                    'units'          => array('px', 'em'),
                    'title'          => esc_html__('Main Menu Item Padding', 'avas'),
                    'default'        => array (
                        'units'       => 'px'
                    )
                ),
                array(
                    'id'       => 'menu_item_borders_all',
                    'type'     => 'border',
                    'title'    => esc_html__('Main Menu Item Border', 'avas'),
                    'desc'     => esc_html__( 'Enter border width ex: 1, 2, 3 etc to enable border. 0 to disable.', 'avas' ),
                    'output'         => array('.main-menu>li>a,.header-style-eight .main-menu>li>a, .header-style-four .main-menu>li>a, .header-style-one .main-menu>li>a, .header-style-seven .main-menu>li>a, .header-style-six .main-menu>li>a, .header-style-two .main-menu>li>a, #h-style-10 .main-menu>li>a'),
                    'color'    => false,
                ),
                array(
                    'id'            => 'menu_item_border_radius',
                    'type'          => 'slider',
                    'title'         => esc_html__( 'Main Menu Item Border Radius', 'avas' ),
                    'min'           => 0,
                    'step'          => 1,
                    'max'           => 100,
                    'display_value' => 'text',
                ),
                array(
                    'id'             => 'menu_bar_padding',
                    'type'           => 'spacing',
                    'output'         => array('.menu-bar'),
                    'mode'           => 'padding',
                    'units'          => array('px', 'em'),
                    'title'          => esc_html__('Main Menu Bar Padding', 'avas'),
                    'default'        => array (
                        'units'       => 'px'
                    ),
                    'required'  => array( 'header-select', '=', array('header1','header2','header4','header6','header7','header8') ),
                ),
                array(
                    'id'       => 'menu-border',
                    'type'     => 'border',
                    'title'    => esc_html__('Main Menu Bar Border', 'avas'),
                    'desc'     => esc_html__( 'Enter border width ex: 1, 2, 3 etc to enable border. 0 to disable.', 'avas' ),
                    'output'   => array('.menu-bar'),
                    'color'    => true,
                    'left'     => false,
                    'right'    => false,
                    'required'  => array( 'header-select', '=', array('header1','header2','header4','header6','header7','header8') ),
                ),
                array(
                    'id'       => 'menu_bar_bg_color_home',
                    'title'    => esc_html__( 'Main Menu Bar background color for Home Page only', 'avas' ),
                    'type'     => 'color_rgba',
                    'mode'     => 'background',
                    'validate' => 'colorrgba',
                    'output'   => array( 'background-color' => '.home .menu-bar' ),
                    'required'  => array( 'header-select', '=', array('header1','header2','header4','header6','header7','header8') ),
                ),
                array(
                    'id'       => 'menu_bar_bg_color_inner',
                    'title'    => esc_html__( 'Main Menu Bar background color for Inner Pages', 'avas' ),
                    'type'     => 'color_rgba',
                    'output'   => array( 
                        'background-color' => '.menu-bar, .home .sticky-header .menu-bar',
                    ),
                    'required'  => array( 'header-select', '=', array('header1','header2','header4','header6','header7','header8') ),
                ),
                array(
                    'id'       => 'menu-link-color',
                    'type'     => 'color',
                    'output'   => array( 'ul.main-menu>li>a,.navbar-collapse > ul > li > a,.navbar-collapse > ul > li > ul > li > a,.navbar-collapse > ul > li > ul > li > ul > li > a,.navbar-collapse > ul > li > span > i, .navbar-collapse > ul > li > ul > li > span > i,.mb-dropdown-icon:before,.tx-res-menu li a' ), 
                    'title'    => esc_html__( 'Main Menu item color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'menu-link-border-color',
                    'type'     => 'color',
                    'output'   => array( 'border-color' => 'ul.main-menu>li>a,.navbar-collapse > ul > li > a,.navbar-collapse > ul > li > ul > li > a,.navbar-collapse > ul > li > ul > li > ul > li > a,.navbar-collapse > ul > li > span > i, .navbar-collapse > ul > li > ul > li > span > i,.mb-dropdown-icon:before,.tx-res-menu li a' ), 
                    'title'    => esc_html__( 'Main Menu item border color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'menu-link-color-home',
                    'type'     => 'color',
                    'output'   => array( '.home ul.main-menu>li>a,.home .navbar-collapse > ul > li > a,.home .navbar-collapse > ul > li > ul > li > a,.home .navbar-collapse > ul > li > ul > li > ul > li > a,.home .navbar-collapse > ul > li > span > i,.home .navbar-collapse > ul > li > ul > li > span > i,.home .mb-dropdown-icon:before,.tx-res-menu li a' ), 
                    'title'    => esc_html__( 'Main Menu item color for Home Page', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'menu-link-border-color-home',
                    'type'     => 'color',
                    'output'   => array( 'border-color' => '.home ul.main-menu>li>a,.home .navbar-collapse > ul > li > a,.home .navbar-collapse > ul > li > ul > li > a,.home .navbar-collapse > ul > li > ul > li > ul > li > a,.home .navbar-collapse > ul > li > span > i,.home .navbar-collapse > ul > li > ul > li > span > i,.home .mb-dropdown-icon:before,.tx-res-menu li a' ), 
                    'title'    => esc_html__( 'Main Menu item border color for Home Page', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'menu-link-hover-color',
                    'type'     => 'color',
                    'output'   => array( 'ul.main-menu>li>a:hover, ul.main-menu>li>a:focus,ul.main-menu>li.menu-item-has-children a:hover,ul.main-menu>li.menu-item-has-children a:focus, .tx-mega-menu .mega-menu-item .depth0 li .depth1.standard.sub-menu li a:hover' ),
                    'title'    => esc_html__( 'Main Menu link hover color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'menu-link-hover-border-color',
                    'type'     => 'color',
                    'output'   => array( 'border-color' => 'ul.main-menu>li>a:hover, ul.main-menu>li>a:focus,ul.main-menu>li.menu-item-has-children a:hover,ul.main-menu>li.menu-item-has-children a:focus, .tx-mega-menu .mega-menu-item .depth0 li .depth1.standard.sub-menu li a:hover' ),
                    'title'    => esc_html__( 'Main Menu item hover border color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'menu-link-hover-color-home',
                    'type'     => 'color',
                    'output'   => array( '.home ul.main-menu>li>a:hover,.home ul.main-menu>li>a:focus,.home ul.main-menu>li.menu-item-has-children a:focus' ),
                    'title'    => esc_html__( 'Main Menu item hover color for Home Page', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'menu-link-hover-border-color-home',
                    'type'     => 'color',
                    'output'   => array( 'border-color' => '.home ul.main-menu>li>a:hover,.home ul.main-menu>li>a:focus,.home ul.main-menu>li.menu-item-has-children a:focus' ),
                    'title'    => esc_html__( 'Main Menu item hover border color for Home Page', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'menu-active-link-color',
                    'type'     => 'color',
                    'output'   => array( 'ul.main-menu>li.current-menu-item > a,ul.main-menu>li.current-page-ancestor > a, ul.main-menu>li.current-menu-ancestor > a, ul.main-menu>li.current-menu-parent > a, ul.main-menu>li.current_page_ancestor > a, ul.main-menu.active>a:hover,a.mega-menu-title.active' ),
                    'title'    => esc_html__( 'Main Menu link active color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'menu-active-link-border-color',
                    'type'     => 'color',
                    'output'   => array( 'border-color' => 'ul.main-menu>li.current-menu-item > a,ul.main-menu>li.current-page-ancestor > a, ul.main-menu>li.current-menu-ancestor > a, ul.main-menu>li.current-menu-parent > a, ul.main-menu>li.current_page_ancestor > a, ul.main-menu.active>a:hover,a.mega-menu-title.active' ),
                    'title'    => esc_html__( 'Main Menu item active border color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'menu-active-link-color-home',
                    'type'     => 'color',
                    'output'   => array( '.home ul.main-menu>li.current-menu-item > a,.home ul.main-menu>li.current-page-ancestor > a, .home ul.main-menu>li.current-menu-ancestor > a,.home ul.main-menu>li.current-menu-parent > a, .home ul.main-menu>li.current_page_ancestor > a, .home ul.main-menu.active>a:hover,.home a.mega-menu-title.active' ),
                    'title'    => esc_html__( 'Main Menu item active color for Home Page', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'menu-active-link-border-color-home',
                    'type'     => 'color',
                    'output'   => array( 'border-color' => '.home ul.main-menu>li.current-menu-item > a,.home ul.main-menu>li.current-page-ancestor > a, .home ul.main-menu>li.current-menu-ancestor > a,.home ul.main-menu>li.current-menu-parent > a, .home ul.main-menu>li.current_page_ancestor > a, .home ul.main-menu.active>a:hover,.home a.mega-menu-title.active' ),
                    'title'    => esc_html__( 'Main Menu item active border color for Home Page', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'menu-link-bg-color',
                    'type'     => 'color',
                    'output'   => array('background-color' => 'ul.main-menu>li>a' ),
                    'title'    => esc_html__( 'Main Menu item background color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'menu-link-bg-hover-color',
                    'type'     => 'color',
                    'output'   => array('background-color' => 'ul.main-menu>li>a:hover, ul.main-menu>li>a:focus' ),
                    'title'    => esc_html__( 'Main Menu item background hover color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'menu-link-bg-color-home',
                    'type'     => 'color',
                    'output'   => array('background-color' => '.home ul.main-menu>li>a' ),
                    'title'    => esc_html__( 'Main Menu item background color for Home Page', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'menu-link-bg-hover-color-home',
                    'type'     => 'color',
                    'output'   => array('background-color' => '.home ul.main-menu>li>a:hover, .home ul.main-menu>li>a:focus' ),
                    'title'    => esc_html__( 'Main Menu link background hover color for Home Page', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'menu-active-link-bg-color',
                    'type'     => 'color',
                    'output'   => array( 'background-color' => 'ul.main-menu>li.current-menu-item > a,ul.main-menu>li.current-page-ancestor > a, ul.main-menu>li.current-menu-ancestor > a, ul.main-menu>li.current-menu-parent > a, ul.main-menu>li.current_page_ancestor > a, ul.main-menu.active>a:hover' ),
                    'title'    => esc_html__( 'Main Menu link active background color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'menu-active-link-bg-color-home',
                    'type'     => 'color',
                    'output'   => array( 'background-color' => '.home ul.main-menu>li.current-menu-item > a,.home ul.main-menu>li.current-page-ancestor > a, .home ul.main-menu>li.current-menu-ancestor > a, .home ul.main-menu>li.current-menu-parent > a, .home ul.main-menu>li.current_page_ancestor > a, .home ul.main-menu.active>a:hover' ),
                    'title'    => esc_html__( 'Main Menu link active background color Home Page', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                // sub menu color
                array(
                    'id'       => 'sub-menu-bg-color',
                    'type'     => 'color',
                    'output'   => array( 'background-color' =>'.main-menu li > ul,.tx-mega-menu .mega-menu-item .depth0:before' ), 
                    'title'    => esc_html__( 'Sub Menu background color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'sub-menu-link-color',
                    'type'     => 'color',
                    'output'   => array( 'color' =>'.main-menu li ul li a,.tx-mega-menu .mega-menu-item .depth0 li .depth1.standard.sub-menu li a' ), 
                    'title'    => esc_html__( 'Sub Menu link color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'sub-menu-link-hover-color',
                    'type'     => 'color',
                    'output'   => array( 'color' =>'.tx-mega-menu .mega-menu-item .depth0 li .depth1.standard.sub-menu li a:hover,.tx-mega-menu .mega-menu-item .depth0 li .depth1.sub-menu li a:hover, .depth0.standard.sub-menu li a:hover' ), 
                    'title'    => esc_html__( 'Sub Menu link hover color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'sub-menu-border-color',
                    'type'     => 'color',
                    'output'   => array( 'border-color' =>'.main-menu li ul li a' ), 
                    'title'    => esc_html__( 'Sub Menu border color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                
                array(
                    'id'        => 'menu-dropdown-icon',
                    'type'      => 'switch',
                    'title'     => esc_html__('Main Menu Dropdown Icon', 'avas'),
                    'default'   => 0,
                    'on'        => esc_html__('On','avas'),
                    'off'       => esc_html__('Off','avas'),
                ),
                array(
                    'id'            => 'menu-dropdown-icon-valign',
                    'type'          => 'slider',
                    'title'         => esc_html__( 'Main Menu Dropdown Icon Vertical Align', 'avas' ),
                    'min'           => 0,
                    'step'          => 1,
                    'max'           => 100,
                    'display_value' => 'text',
                    'required'  => array( 'menu-dropdown-icon', '=', '1' ),
                ),
                array(
                    'id'        => 'menu_item_border',
                    'type'      => 'switch',
                    'title'     => esc_html__('Main Menu Item Border on Hover', 'avas'),
                    'default'   => 0,
                    'on'        => esc_html__('On','avas'),
                    'off'       => esc_html__('Off','avas'),
                ),
                array(
                'id'       => 'menu_item_border_select',
                'type'     => 'select',
                'title'    => esc_html__('Select Position', 'avas'), 
                'options'  => array(
                    'menu_item_border_top' => 'Top',
                    'menu_item_border_bottom' => 'Bottom',
                    ),
                'default'  => 'menu_item_border_top',
                'required'  => array( 'menu_item_border', '=', '1' ),
                ),
                array(
                'id'       => 'menu-top-border-hover-color',
                'type'     => 'color',
                'output'   => array( '.main-menu>li:hover a:before' ),
                'title'    => esc_html__( 'Main Menu link hover border color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
                'required'  => array( 'menu_item_border', '=', '1' ),
                ),
                // menu item separator
                array(
                    'id'        => 'menu-item-seprator',
                    'type'      => 'switch',
                    'title'     => esc_html__('Main Menu Item Separator', 'avas'),
                    'default'   => 0,
                    'on'        => esc_html__('On','avas'),
                    'off'       => esc_html__('Off','avas'),
                ),
                array(
                    'id'       => 'menu-item-seprator-border',
                    'type'     => 'border',
                    'title'    => esc_html__('Main Menu Item Separator Border', 'avas'),
                    'subtitle'    => esc_html__('It will show right border to separate.', 'avas'),
                    'desc'     => esc_html__( 'Enter border width ex: 1, 2, 3 etc to enable border. 0 to disable.', 'avas' ),
                    'output'   => array('.main-menu > li'),
                    'color'    => false,
                    'left'     => false,
                    'top'      => false,
                    'bottom'   => false,
                    'default'  => array(
                        'border-style'  => 'solid', 
                        'border-right' => '0px',
                        'border-top' => '0px',
                        'border-bottom' => '0px',
                    ),
                    'required'  => array( 'menu-item-seprator', '=', '1' ),
                ),
                 array(
                    'id'       => 'menu-item-seprator-border-color',
                    'type'     => 'color_rgba',
                    'output'   => array( 
                    'border-color' => '.main-menu > li',
                     ),
                    'title'    => esc_html__( 'Main Menu Item Separator Border color', 'avas' ),
                    'required'  => array( 'menu-item-seprator', '=', '1' ),
                ),
                // menu fonts
                array(
                    'id'       => 'menu-font',
                    'type'     => 'typography',
                    'title'    => esc_html__( 'Main Menu fonts', 'avas' ),
                    'google'   => true,
                    'font-backup' => false,
                    'output'      => array('.main-menu>li>a,.navbar-collapse > ul > li > a'),
                    'units'       =>'px',
                    'fonts' => $standard_fonts,
                    'font-style'  => true,
                    'all_styles'  => true,
                    'word-spacing'  => true,
                    'letter-spacing'=> true,
                    'color'         => false,
                    'subsets'       => true, 
                    'text-transform' => true,
                    'allow_empty_line_height' => true,
                ),
                // Sub Menu fonts options
                array(
                    'id'       => 'sub-menu-font',
                    'type'     => 'typography',
                    'title'    => esc_html__( 'Sub Menu fonts', 'avas' ),
                    'google'   => true,
                    'font-backup' => false,
                    'output'      => array('.main-menu>li>ul>li>a,.main-menu>li>ul>li>ul>li>a,.main-menu>li>ul>li>ul>li>ul>li>a,.main-menu>li>ul>li>ul>li>ul>li>ul>li>a,.tx-mega-menu .mega-menu-item .depth0 li .depth1.standard.sub-menu li a,.tx-mega-menu .mega-menu-item .depth0 li .depth1 li a,.navbar-collapse > ul > li > ul > li > a,.navbar-collapse > ul > li > ul > li > ul > li > a,.navbar-collapse > ul > li > ul > li > ul > li > ul > li > a,.navbar-collapse > ul > li > ul > li > ul > li > ul > li > ul > li > a'),
                    'units'       =>'px',
                    'fonts' => $standard_fonts,
                    'font-style'  => true,
                    'all_styles'  => true,
                    'word-spacing'  => true,
                    'letter-spacing'=> true,
                    'color'         => false,
                    'subsets'       => true, 
                    'text-transform' => true,
                    'allow_empty_line_height' => true,
                ), 
                // Mega menu
                array(
                    'id'        => 'megamenu-info',
                    'type'      => 'info',
                    'title'     => esc_html__('Mega Menu Options', 'avas'),
                    'style'     => 'success', //success warning
                ), 
                array(
                    'id'        => 'megamenu-full-width',
                    'type'      => 'switch',
                    'title'     => esc_html__('Mega Menu Full Width', 'avas'),
                    'default'   => 1,
                    'on'        => esc_html__('Yes','avas'),
                    'off'       => esc_html__('No','avas'),
                ),
                array(
                    'id'            => 'mega_menu_left_position',
                    'type'          => 'slider',
                    'title'         => esc_html__( 'Mega Menu Left Position', 'avas' ),
                    'default'       => -45,
                    'min'           => -100,
                    'step'          => 1,
                    'max'           => 100,
                    'display_value' => 'text',
                ),
                array(
                        'id'       => 'mega-menu-columns-border',
                        'type'     => 'border',
                        'title'    => esc_html__('Mega Menu Columns Separator', 'avas'),
                        'desc'     => esc_html__( 'Enter border width ex: 1, 2, 3 etc to enable border. 0 to disable.', 'avas' ),
                        'output'   => array('.tx-mega-menu .mega-menu-item .depth0.sub-menu> li'),
                        'color'    => true,
                        'top'      => false,
                        'left'     => false,
                        'bottom'   => false,
                    ),
                array(
                    'id'       => 'mega-menu-columns-title-color',
                    'type'     => 'color',
                    'output'   => array( 'color' =>'.tx-mega-menu .mega-menu-item .depth0 li .mega-menu-title' ), 
                    'title'    => esc_html__( 'Mega Menu Columns Title Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ), 
                
                
                // Menu Highlight Callouts Text Button
                array(
                    'id'        => 'menu-highlight-info',
                    'type'      => 'info',
                    'title'     => esc_html__('Main Menu Highlight Callouts Text Button', 'avas'),
                    'style'     => 'success', //success warning
                ),
                array(
                    'id'          => 'menu-highlight-color',
                    'type'        => 'color',
                    'output'      => array('color' => '.tx-menu-highlight'),
                    'title'       => esc_html__( 'Main Menu Highlight text color', 'avas' ),
                    'transparent' => false,
                    'validate'    => 'color',
                ),
                array(
                    'id'       => 'menu-highlight-bg-color',
                    'type'     => 'color_rgba',
                    'output'      => array('background-color' => '.tx-menu-highlight'),
                    'title'       => esc_html__( 'Main Menu Highlight background color', 'avas' ),
                ),
                array(
                    'id'             => 'menu-highlight-padding',
                    'type'           => 'spacing',
                    'output'         => array('.tx-menu-highlight'),
                    'mode'           => 'padding',
                    'units'          => array('px', 'em'),
                    'units_extended' => 'false',
                    'title'          => esc_html__('Main Menu Highlight padding', 'avas'),
                    'default'        => array (
                        'units'      => 'px'
                    )
                ),
                array(
                    'id'       => 'menu-highlight-font',
                    'type'     => 'typography',
                    'title'    => esc_html__( 'Main Menu Highlight font', 'avas' ),
                    'google'   => true,
                    'font-backup' => false,
                    'output'      => array('.tx-menu-highlight'),
                    'units'       =>'px',
                    'fonts' => $standard_fonts,
                    'font-style'  => true,
                    'all_styles'  => true,
                    'word-spacing'  => true,
                    'letter-spacing'=> true,
                    'color'         => false,
                    'subsets'       => true, 
                    'text-transform' => true,
                    'allow_empty_line_height' => true,
                ),
                array(
                    'id'        => 'menu-highlight-animation',
                    'type'      => 'switch',
                    'title'     => esc_html__('Main Menu Highlight animation disable', 'avas'),
                    'default'   => 0,
                    'on'        => esc_html__('Yes','avas'),
                    'off'       => esc_html__('No','avas'),
                ),
                array(
                    'id'        => 'keyboard_accessible_dropdown_menu',
                    'type'      => 'switch',
                    'title'     => esc_html__('keyboard accessible dropdown menu', 'avas'),
                    'default'   => 1,
                    'on'        => esc_html__('Yes','avas'),
                    'off'       => esc_html__('No','avas'),
                ),


            )));
    // Responsive menu option
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Responsive Menu', 'avas'),
        'id'               => 'res_menu_opt',
        'subsection'       => true,
        'customizer_width' => '344px',
        'fields'           => array(
                is_customize_preview() ? null : array(
                    'id'       => 'tx-res-menu-txt',
                    'type'     => 'text',
                    'title'    => esc_html__('Responsive Main Menu Icon Text','avas'),
                    'default'  => '',
                ),
                is_customize_preview() ? null : array(
                    'id'            => 'tx-res-menu-txt-top',
                    'type'          => 'slider',
                    'title'         => esc_html__( 'Responsive Main Menu Icon Text Position', 'avas' ),
                    // 'default'       => -2,
                    'min'           => -20,
                    'step'          => 1,
                    'max'           => 20,
                    'display_value' => 'text',
                ),
                is_customize_preview() ? null : array(
                    'id'       => 'tx-res-menu-txt-font',
                    'type'     => 'typography',
                    'title'    => esc_html__( 'Responsive Main Menu Icon Text Fonts', 'avas' ),
                    'google'   => true,
                    'font-backup' => false,
                    'output'      => array('.tx-res-menu-txt'),
                    'units'       =>'px',
                    'fonts' => $standard_fonts,
                    'font-style'  => true,
                    'all_styles'  => true,
                    'word-spacing'  => true,
                    'letter-spacing'=> true,
                    'color'         => false,
                    'subsets'       => true, 
                    'text-transform' => true,
                    'allow_empty_line_height' => true,
                ),
                is_customize_preview() ? null : array(
                    'id'          => 'mobile-top-menu-icon-color',
                    'type'        => 'color',
                    'output'      => array('color' => '#responsive-menu-top .navbar-header .navbar-toggle i'),
                    'title'       => esc_html__( 'Responsive Top Menu icon color', 'avas' ),
                    'transparent' => false,
                    'validate'    => 'color',
                    'required'  => array( 'top_menu', '=', '1' )
                    ),
                is_customize_preview() ? null : array(
                    'id'          => 'mobile-top-menu-icon-color-home',
                    'type'        => 'color',
                    'output'      => array('color' => '.home #responsive-menu-top .navbar-header .navbar-toggle i'),
                    'title'       => esc_html__( 'Responsive Top Menu icon color for Home Page only', 'avas' ),
                    'transparent' => false,
                    'validate'    => 'color',
                    'required'  => array( 'top_menu', '=', '1' )
                    ),
                array(
                    'id'          => 'mobile-menu-icon-color',
                    'type'        => 'color',
                    'output'      => array('color' => '.mobile-nav-toggle i, .tx-res-menu-txt,.navbar-header .navbar-toggle i'),
                    'title'       => esc_html__( 'Responsive Main Menu icon color', 'avas' ),
                    'transparent' => false,
                    'validate'    => 'color',
                    ),
                array(
                    'id'          => 'mobile-menu-icon-close-color',
                    'type'        => 'color',
                    'output'      => array('color' => '.mobile-nav-toggle i.bi.bi-x,.tx-res-menu-txt'),
                    'title'       => esc_html__( 'Responsive Main Menu icon close color', 'avas' ),
                    'transparent' => false,
                    'validate'    => 'color',
                    ),
                array(
                    'id'          => 'mobile-menu-icon-bg-color',
                    'type'        => 'color',
                    'output'      => array('background-color' => '.mobile-nav-toggle i'),
                    'title'       => esc_html__( 'Responsive Main Menu icon background color', 'avas' ),
                    'transparent' => false,
                    'validate'    => 'color',
                    ),
                array(
                    'id'          => 'mobile-menu-icon-color-home',
                    'type'        => 'color',
                    'output'      => array('color' => '.home .mobile-nav-toggle i, .home .tx-res-menu-txt'),
                    'title'       => esc_html__( 'Responsive Main Menu icon color for Home Page only', 'avas' ),
                    'transparent' => false,
                    'validate'    => 'color',
                    ),
                array(
                    'id'          => 'mobile-menu-icon-bg-color-home',
                    'type'        => 'color',
                    'output'      => array('background-color' => '.home .mobile-nav-toggle i'),
                    'title'       => esc_html__( 'Responsive Main Menu icon background color for Home Page only', 'avas' ),
                    'transparent' => false,
                    'validate'    => 'color',
                    ),
                array(
                    'id'             => 'mobile-menu-icon-padding',
                    'type'           => 'spacing',
                    'output'         => array('.mobile-nav-toggle i'),
                    'mode'           => 'padding',
                    'units'          => array('px', 'em'),
                    'units_extended' => 'false',
                    'title'          => esc_html__('Responsive Main Menu icon padding', 'avas'),
                    'default'        => array (
                        'units'      => 'px'
                    )
                ),
                array(
                    'id'          => 'mobile-menu-item-color',
                    'type'        => 'color',
                    'title'       => esc_html__( 'Responsive Main Menu item color', 'avas' ),
                    'transparent' => false,
                    'output'      => array('color' => '.tx-res-menu li a,.top-nav-collapse > ul > li > a'),
                    'validate'    => 'color',
                    ),
                array(
                    'id'          => 'mobile-top-menu-item-color',
                    'type'        => 'color',
                    'title'       => esc_html__( 'Responsive Top Menu item color', 'avas' ),
                    'transparent' => false,
                    'output'      => array('color' => '.top-nav-collapse > ul > li > a'),
                    'validate'    => 'color',
                    'required'  => array( 'top_menu', '=', '1' )
                    ),
                array(
                    'id'          => 'mobile-menu-bg-color',
                    'type'        => 'color',
                    'title'       => esc_html__( 'Responsive Main Menu background color', 'avas' ),
                    'transparent' => false,
                    'output'      => array('background-color' => '.tx-res-menu,.tx-nav-right-side-items-mobile'),
                    'validate'    => 'color',
                    ),
                array(
                    'id'          => 'mobile-menu-border-color',
                    'type'        => 'color',
                    'output'      => array('border-color' => '.tx-res-menu li'),
                    'title'       => esc_html__( 'Responsive Main Menu Dropdown border color', 'avas' ),
                    'transparent' => false,
                    'validate'    => 'color',
                    ),
                )));        

    // menu button options
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Menu Button', 'avas'),
        'id'               => 'menu_button_opt',
        'subsection'       => true,
        'customizer_width' => '344px',
        'fields'           => array(
                array(
                    'id'        => 'menu_btn_switch',
                    'type'      => 'switch',
                    'title'     => esc_html__('Menu Button', 'avas'),
                    'default'   => 0,
                    'on'        => 'On',
                    'off'       => 'Off',
                ),
                array( 
                    'title'     => esc_html__( 'Button Text', 'avas' ),
                    'id'        => 'menu_btn_txt',
                    'default'   => 'Button',
                    'type'      => 'text',
                    'required'  => array( 'menu_btn_switch', '=', '1' ),
                ),
                array( 
                    'title'     => esc_html__( 'Button URL', 'avas' ),
                    'id'        => 'menu_btn_url',
                    'default'   => esc_html__('#', 'avas'),
                    'type'      => 'text',
                    'required'  => array( 'menu_btn_switch', '=', '1' ),
                ),
                array(
                    'id'       => 'menu_btn_link_new_window',
                    'type'     => 'checkbox',
                    'title'    => esc_html__('Open link in new window', 'avas'), 
                    'default'  => 0,
                    'required'  => array( 'menu_btn_switch', '=', '1' ),
                ),
                array(
                    'id'             => 'menu_btn_padding',
                    'type'           => 'spacing',
                    'output'         => array('.tx-menu-btn'),
                    'mode'           => 'padding',
                    'units'          => array('px', 'em'),
                    'units_extended' => 'false',
                    'title'          => esc_html__('Menu Button Padding', 'avas'),
                    'required'  => array( 'menu_btn_switch', '=', '1' ),
                    'default'        => array (
                        'units'       => 'px'
                    )
                ),
                array(
                    'id'             => 'menu_btn_margin',
                    'type'           => 'spacing',
                    'output'         => array('.tx-menu-btn-wrap'),
                    'mode'           => 'margin',
                    'units'          => array('px', 'em'),
                    'units_extended' => 'false',
                    'title'          => esc_html__('Menu Button Margin', 'avas'),
                    'required'  => array( 'menu_btn_switch', '=', '1' ),
                    'default'        => array (
                        'units'       => 'px'
                    )
                ),
                // Menu button colors
                array(
                    'id'       => 'menu-btn-bg-color',
                    'type'     => 'color',
                    'output'   => array( 'background-color' => '.tx-menu-btn' ), 
                    'title'    => esc_html__( 'Menu Button Background Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => true,
                    'required'  => array( 'menu_btn_switch', '=', '1' ),
                ),
                array(
                    'id'       => 'menu-btn-bg-hov-color',
                    'type'     => 'color',
                    'output'   => array( 'background-color' => '.tx-menu-btn:hover,.tx-menu-btn:focus' ), 
                    'title'    => esc_html__( 'Menu Button Background Hover Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => true,
                    'required'  => array( 'menu_btn_switch', '=', '1' ),
                ),
                array(
                    'id'       => 'menu-btn-color',
                    'type'     => 'color',
                    'output'   => array( '.tx-menu-btn' ), 
                    'title'    => esc_html__( 'Menu Button Text Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'menu_btn_switch', '=', '1' ),
                ),
                array(
                    'id'       => 'menu-btn-hov-color',
                    'type'     => 'color',
                    'output'   => array( '.tx-menu-btn:hover,.tx-menu-btn:focus' ), 
                    'title'    => esc_html__( 'Menu Button Text Hover Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'menu_btn_switch', '=', '1' ),
                ),
                array(
                   'id'       => 'menu-btn-border',
                    'type'     => 'border',
                    'title'    => esc_html__('Menu Button Border', 'avas'),
                    'desc'     => esc_html__( 'Enter border width, example 1, 2, 3 etc to enable border', 'avas' ),
                    'output'   => array('.tx-menu-btn'),
                    'color' => false,
                    'required'  => array( 'menu_btn_switch', '=', '1' ),
                    ),
                array(
                    'id'            => 'menu-btn-border-radius',
                    'type'          => 'slider',
                    'title'         => esc_html__( 'Menu Button Border Radius', 'avas' ),
                    'min'           => 0,
                    'step'          => 1,
                    'max'           => 100,
                    'display_value' => 'text',
                    'required'  => array( 'menu_btn_switch', '=', '1' ),
                ),
                array(
                    'id'       => 'menu-btn-bord-color',
                    'type'     => 'color',
                    'output'   => array( 'border-color' => '.tx-menu-btn' ), 
                    'title'    => esc_html__( 'Menu Button Border Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => true,
                    'required'  => array( 'menu_btn_switch', '=', '1' ),
                ),
                array(
                    'id'       => 'menu-btn-bord-hov-color',
                    'type'     => 'color',
                    'output'   => array( 'border-color' => '.tx-menu-btn:hover' ), 
                    'title'    => esc_html__( 'Menu Button Border Hover Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => true,
                    'required'  => array( 'menu_btn_switch', '=', '1' ),
                ),

                // menu button fonts options
                array(
                    'id'       => 'menu-btn-font',
                    'type'     => 'typography',
                    'title'    => esc_html__( 'Menu Button Fonts', 'avas' ),
                    'google'   => true,
                    'font-backup' => false,
                    'output'      => array('.tx-menu-btn'),
                    'units'       =>'px',
                    'fonts' => $standard_fonts,
                    'font-style'  => true,
                    'all_styles'  => true,
                    'word-spacing'  => true,
                    'letter-spacing'=> true,
                    'color'         => false,
                    'subsets'       => true, 
                    'text-transform' => true,
                    'allow_empty_line_height' => true,
                    'required'  => array( 'menu_btn_switch', '=', '1' ),
                ),
        )));
        
    // side menu options / hamburger menu
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Hamburger / Side Menu', 'avas'),
        'id'               => 'side_menu_opt',
        'subsection'       => true,
        'customizer_width' => '344px',
        'fields'           => array(
                array(
                    'id'        => 'side_menu',
                    'type'      => 'switch',
                    'title'     => esc_html__('Side Menu', 'avas'),
                    'default'   => 1,
                    'on'        => 'On',
                    'off'       => 'Off',
                ),
                array(
                    'id'             => 'side_menu_margin',
                    'type'           => 'spacing',
                    'output'         => array('#side-menu-icon'),
                    'mode'           => 'margin',
                    'units'          => array('px', 'em'),
                    'units_extended' => 'false',
                    'title'          => esc_html__('Side Menu Margin', 'avas'),
                    'required'  => array( 'side_menu', '=', '1' ),
                    'default'        => array (
                        'units'       => 'px'
                    )
                ),
                array(
                    'id'             => 'side_menu_padding',
                    'type'           => 'spacing',
                    'output'         => array('#side-menu-icon'),
                    'mode'           => 'padding',
                    'units'          => array('px', 'em'),
                    'units_extended' => 'false',
                    'title'          => esc_html__('Side Menu Padding', 'avas'),
                    'required'  => array( 'side_menu', '=', '1' ),
                    'default'        => array (
                        'units'       => 'px'
                    )
                ),
                // side menu colors
                array(
                    'id'       => 'side-menu-icon-color',
                    'type'     => 'color',
                    'output'   => array( '.side_menu_icon' ), 
                    'title'    => esc_html__( 'Side Menu Icon Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'side_menu', '=', '1' ),
                ),
                array(
                    'id'       => 'side-menu-icon-color-hover',
                    'type'     => 'color',
                    'output'   => array( '.side_menu_icon:hover' ), 
                    'title'    => esc_html__( 'Side Menu Icon Hover Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'side_menu', '=', '1' ),
                ),
                array(
                    'id'       => 'side-menu-icon-color-home',
                    'type'     => 'color',
                    'output'   => array( '.home .side_menu_icon' ), 
                    'title'    => esc_html__( 'Side Menu Icon Color on Home Page', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'side_menu', '=', '1' ),
                ),
                array(
                    'id'       => 'side-menu-icon-color-hover-home',
                    'type'     => 'color',
                    'output'   => array( '.home .side_menu_icon:hover' ), 
                    'title'    => esc_html__( 'Side Menu Icon Hover Color on Home Page', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'side_menu', '=', '1' ),
                ),
                array(
                    'id'       => 'side-menu-icon-close-color',
                    'type'     => 'color',
                    'output'   => array( '.side-menu .s-menu-icon-close' ), 
                    'title'    => esc_html__( 'Side Menu Icon Close Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'side_menu', '=', '1' ),
                ),
                array(
                    'id'       => 'side-menu-icon-close-color-hover',
                    'type'     => 'color',
                    'output'   => array( '.side-menu .s-menu-icon-close:hover' ), 
                    'title'    => esc_html__( 'Side Menu Icon Close Hover Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'side_menu', '=', '1' ),
                ),
                array(
                    'id'       => 'side-menu-bg-color',
                    'type'     => 'color',
                    'output'   => array('background-color' => '#side-menu-wrapper' ), 
                    'title'    => esc_html__( 'Side Menu Background Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'side_menu', '=', '1' ),
                ),
                array(
                    'id'       => 'side-menu-text-color',
                    'type'     => 'color',
                    'output'   => array('#side-menu-wrapper' ), 
                    'title'    => esc_html__( 'Side Menu Text Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'side_menu', '=', '1' ),
                ),
                array(
                    'id'       => 'side-menu-link-color',
                    'type'     => 'color',
                    'output'   => array('.side-menu a' ), 
                    'title'    => esc_html__( 'Side Menu Link Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'side_menu', '=', '1' ),
                ),
                array(
                    'id'       => 'side-menu-link-hover-color',
                    'type'     => 'color',
                    'output'   => array('.side-menu a:hover' ), 
                    'title'    => esc_html__( 'Side Menu Link Hover Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'side_menu', '=', '1' ),
                ),
                array(
                    'id'       => 'side-menu-widget-title-color',
                    'type'     => 'color',
                    'output'   => array('#side-menu-wrapper .widget-title' ), 
                    'title'    => esc_html__( 'Side Menu Widget Title Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'side_menu', '=', '1' ),
                ),
                // side menu fonts options
                array(
                    'id'       => 'side-menu-icon-font',
                    'type'     => 'typography',
                    'title'    => esc_html__( 'Side Menu Icon', 'avas' ),
                    'google'   => true,
                    'font-backup' => false,
                    'output'      => array('#side-menu-icon'),
                    'units'       =>'px',
                    'fonts' => $standard_fonts,
                    'font-style'  => true,
                    'all_styles'  => false,
                    'word-spacing'  => false,
                    'letter-spacing'=> false,
                    'color'         => false,
                    'text-transform' => false,
                    'text-align'    => false,
                    'subsets'       => false,
                    'allow_empty_line_height' => true,
                    'required'  => array( 'side_menu', '=', '1' ),
                ),
                array(
                    'id'       => 'side-menu-font',
                    'type'     => 'typography',
                    'title'    => esc_html__( 'Side Menu Fonts', 'avas' ),
                    'google'   => true,
                    'font-backup' => false,
                    'output'      => array('.side-menus'),
                    'units'       =>'px',
                    'fonts' => $standard_fonts,
                    'font-style'  => true,
                    'all_styles'  => true,
                    'word-spacing'  => true,
                    'letter-spacing'=> true,
                    'color'         => false,
                    'subsets'       => true, 
                    'text-transform' => true,
                    'allow_empty_line_height' => true,
                    'required'  => array( 'side_menu', '=', '1' ),
                ),
                array(
                    'id'       => 'side-menu-text-font',
                    'type'     => 'typography',
                    'title'    => esc_html__( 'Side Menu Text Fonts', 'avas' ),
                    'google'   => true,
                    'font-backup' => false,
                    'output'      => array('#side-menu-wrapper p'),
                    'units'       =>'px',
                    'fonts' => $standard_fonts,
                    'font-style'  => true,
                    'all_styles'  => false,
                    'acync_typography' => false,
                    'word-spacing'  => true,
                    'letter-spacing'=> true,
                    'color'         => false,
                    'subsets'       => true, 
                    'text-transform' => true,
                    'allow_empty_line_height' => true,
                    'required'  => array( 'side_menu', '=', '1' ),
                ),
                array(
                    'id'       => 'side-menu-widget-title-font',
                    'type'     => 'typography',
                    'title'    => esc_html__( 'Side Menu Widget Title Fonts', 'avas' ),
                    'google'   => true,
                    'font-backup' => false,
                    'output'      => array('#side-menu-wrapper .widget-title'),
                    'units'       =>'px',
                    'fonts' => $standard_fonts,
                    'font-style'  => true,
                    'all_styles'  => true,
                    'word-spacing'  => true,
                    'letter-spacing'=> true,
                    'color'         => false,
                    'subsets'       => true, 
                    'text-transform' => true,
                    'allow_empty_line_height' => true,
                    'required'  => array( 'side_menu', '=', '1' ),
                ),
                )));

        // One Page Navigation / onepagenav
        Redux::setSection( $opt_name, array(
            'title'            => esc_html__( 'One Page Navigation', 'avas'),
            'id'               => 'onepagenav_sec',
            'subsection'       => true,
            'customizer_width' => '344px',
            'fields'           => array(
                    array(
                        'id'        => 'one_page_nav',
                        'type'      => 'switch',
                        'title'     => esc_html__('One Page Nav', 'avas'),
                        'default'   => 0,
                        'on'        => 'On',
                        'off'       => 'Off',
                    ),
                    array(
                        'id'       => 'one_page_nav_color',
                        'type'     => 'color',
                        'output'   => array('.home ul.main-menu li.current a, ul.main-menu li.current a' ), 
                        'title'    => esc_html__( 'One Page Nav Color', 'avas' ),
                        'validate' => 'color',
                        'transparent' => false,
                        'required'  => array( 'one_page_nav', '=', '1' ),
                    ),
                    array(
                        'id'       => 'one_page_nav_bg_color',
                        'type'     => 'color',
                        'output'   => array('background-color' => '.home ul.main-menu li.current a, ul.main-menu li.current a' ), 
                        'title'    => esc_html__( 'One Page Nav Background Color', 'avas' ),
                        'validate' => 'color',
                        'transparent' => false,
                        'required'  => array( 'one_page_nav', '=', '1' ),
                    ),
                    array(
                        'id'       => 'one_page_nav_border_color',
                        'type'     => 'color',
                        'output'   => array('border-color' => '.home ul.main-menu li.current a, ul.main-menu li.current a' ), 
                        'title'    => esc_html__( 'One Page Nav Border Color', 'avas' ),
                        'validate' => 'color',
                        'transparent' => false,
                        'required'  => array( 'one_page_nav', '=', '1' ),
                    ),

            )
        ));

        // Post options / blog options / Posts options
        Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Posts', 'avas' ),
        'id'         => 'blog-option',
        'icon'       => 'bi bi-pin-angle',
        'fields'     => array(
            // Sidebar index, archive
                array(
                'id'       => 'sidebar-select',
                'type'     => 'select',
                'title'    => esc_html__('Posts Sidebar', 'avas'), 
                'subtitle'     => esc_html__('For blog, archive, category, tag pages sidebar.', 'avas'),
                'options'  => array(
                    'sidebar-right' => 'Right Sidebar',
                    'sidebar-left' => 'Left Sidebar',
                    'sidebar-none' => 'None',
                    ),
                'default'  => 'sidebar-right',
                ),
                array(
                    'id' => 'cat_temp_style',
                    'title' => esc_html__('Posts Taxonomy Template Style', 'avas'),
                    'subtitle' => esc_html__('Will display category, tag, etc template page.', 'avas'),
                    'type' => 'image_select',
                    'options' => array (
                        'cat_style_1' => array('title' => 'Style 1', 'img' => TX_IMAGES . 'cat-style-1.png'),
                        'cat_style_2' => array('title' => 'Style 2', 'img' => TX_IMAGES . 'cat-style-2.png'),
                        'cat_style_3' => array('title' => 'Style 3', 'img' => TX_IMAGES . 'cat-style-3.png'),
                    ),
                    'default'  => 'cat_style_1',
                ),
            array(
                'id'            => 'title-length',
                'type'          => 'slider',
                'title'         => esc_html__( 'Posts Title Length', 'avas' ),
                'subtitle'      => esc_html__( 'Title Limit', 'avas' ),
                'default'       => 85,
                'min'           => 1,
                'step'          => 1,
                'max'           => 300,
                'display_value' => 'text'
                ),
            array(
                'id'            => 'excerpt-word-limit',
                'type'          => 'slider',
                'title'         => esc_html__( 'Posts Excerpt Words', 'avas' ),
                'subtitle'         => esc_html__( 'Word limit for Excerpt in blog, archive, category, tag pages etc.', 'avas' ),
                'default'       => 35,
                'min'           => 1,
                'step'          => 1,
                'max'           => 55,
                'display_value' => 'text'
                ),
            array(
                'id'            => 'blog-posts-per-page',
                'type'          => 'slider',
                'title'         => esc_html__( 'Posts Pagination', 'avas' ),
                'subtitle'      => esc_html__( 'Posts per page', 'avas' ),
                'default'       => 9,
                'min'           => 1,
                'step'          => 1,
                'max'           => 99,
                'display_value' => 'text'
                ),
            array(
                'id'            => 'tag_limit',
                'type'          => 'slider',
                'title'         => esc_html__( 'Tag Cloud Widget', 'avas' ),
                'subtitle'      => esc_html__( 'Tag Limit', 'avas' ),
                'default'       => 15,
                'min'           => 1,
                'step'          => 1,
                'max'           => 99,
                'display_value' => 'text'
                ),
            array(
                'id'        => 'read-more',
                'type'      => 'switch',
                'title'     => esc_html__('Posts Read More Button', 'avas'),
                'default'   => 1,
                'on'        => 'On',
                'off'       => 'Off',
                ),
            array(
                'id'       => 'read-more-text',
                'type'     => 'text',
                'title'    => esc_html__('Posts Read More Button Text','avas'),
                'default'  => 'Read More',
                'required' => array( 'read-more', '=', '1' ),
                ),
            array(
                'id'       => 'content-none-text',
                'type'     => 'text',
                'title'    => esc_html__('Posts nothing found text','avas'),
                'default'  => 'Sorry, nothing found.',
                ),
            array(
                'id'        => 'post-meta-info',
                'type'      => 'info',
                'title'     => esc_html__('Posts meta settings', 'avas'),
                'style'     => 'success', //success warning
                ),
            array(
                'id'        => 'post-time',
                'type'      => 'switch',
                'title'     => esc_html__('Posts Time', 'avas'),
                'default'   => 1,
                'on'        => esc_html__('Show','avas'),
                'off'       => esc_html__('Hide','avas'),
                ),
            array(
                'id'        => 'post-author',
                'type'      => 'switch',
                'title'     => esc_html__('Posts Author', 'avas'),
                'default'   => 1,
                'on'        => esc_html__('Show','avas'),
                'off'       => esc_html__('Hide','avas'),
                ),
            
            array(
                'id'        => 'post-comment',
                'type'      => 'switch',
                'title'     => esc_html__('Posts Comments', 'avas'),
                'default'   => 1,
                'on'        => esc_html__('Show','avas'),
                'off'       => esc_html__('Hide','avas'),
                ),
            array(
                'id'        => 'post-views',
                'type'      => 'switch',
                'title'     => esc_html__('Posts Views', 'avas'),
                'default'   => 1,
                'on'        => esc_html__('Show','avas'),
                'off'       => esc_html__('Hide','avas'),
                ),
            array(
                'id'        => 'social-share-header',
                'type'      => 'switch',
                'title'     => esc_html__('Posts Social Share on Header', 'avas'),
                'default'   => 1,
                'on'        => esc_html__('Show','avas'),
                'off'       => esc_html__('Hide','avas'),
                ),
            array(
                    'id'        => 'share-on-text-header',
                    'type'      => 'text',
                    'title'     => esc_html__('Share on Text', 'avas'),
                    'default'   => 'Share on',
                    'required'  => array( 'social-share-header', '=', '1' ),
                ),
            // Posts color
            array(
                'id'        => 'posts-colors',
                'type'      => 'info',
                'title'     => esc_html__('Posts Colors', 'avas'),
                'style'     => 'success', //success warning
                ),           
            array(
                'id'       => 'posts-title-color',
                'type'     => 'color',
                'output'   => array( '.details-box .post-title a,.entry-title a' ),
                'title'    => esc_html__( 'Posts title color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'post-title-hover-color',
                'type'     => 'color',
                'output'   => array( 'h1.entry-title a:hover,.details-box .post-title a:hover,.tx-cat-style3-right .post-title a:hover' ),
                'title'    => esc_html__( 'Posts title hover color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'posts-text-color',
                'type'     => 'color',
                'output'   => array( '.details-box p' ),
                'title'    => esc_html__( 'Post excerpt color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'post_meta_icon_color',
                'type'     => 'color',
                'output'   => array( 'color' => '.entry-meta i, .entry-footer i' ),
                'title'    => esc_html__( 'Posts meta icon color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'post_meta_text_color',
                'type'     => 'color',
                'output'   => array( 'color' => '.entry-meta, .entry-footer' ),
                'title'    => esc_html__( 'Posts meta text color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'post_meta_text_hov_color',
                'type'     => 'color',
                'output'   => array( 'color' => '.post .post-category a:hover, .post .comments-link a:hover, .post .post-tag a:hover,.nickname a:hover' ),
                'title'    => esc_html__( 'Posts meta text hover color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'posts-date-color',
                'type'     => 'color',
                'output'   => array( '.details-box .post-time' ),
                'title'    => esc_html__( 'Posts date color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'posts-date-bg-color',
                'type'     => 'color',
                'output'   => array( 'background-color' => '.details-box .post-time' ),
                'title'    => esc_html__( 'Posts date background color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'posts-date-hov-color',
                'type'     => 'color',
                'output'   => array( 'color' => '.blog-cols:hover .details-box .post-time' ),
                'title'    => esc_html__( 'Posts date hover color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'posts-date-bg-hov-color',
                'type'     => 'color',
                'output'   => array( 'background-color' => '.blog-cols:hover .details-box .post-time' ),
                'title'    => esc_html__( 'Posts date background hover color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'posts-bottom-border-hov-color',
                'type'     => 'color',
                'output'   => array( 'border-color' => '.blog-cols:hover .details-box' ),
                'title'    => esc_html__( 'Posts bottom border hover color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'posts-read-more-btn-color',
                'type'     => 'color',
                'output'   => array( 'color' => '.tx-read-more, .tx-read-more a, .tx-read-more:after' ),
                'title'    => esc_html__( 'Posts read more button color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'posts-read-more-btn-hov-color',
                'type'     => 'color',
                'output'   => array( 'color' => '.tx-read-more a:focus, .tx-read-more:focus, tx-read-more a:hover, .tx-read-more:hover, .tx-read-more:hover a,.tx-read-more:hover:after' ),
                'title'    => esc_html__( 'Posts read more button hover color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'posts-read-more-btn-bg-color',
                'type'     => 'color',
                'output'   => array( 'background-color' => '.tx-read-more' ),
                'title'    => esc_html__( 'Posts read more button background color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'posts-read-more-btn-bg-hov-color',
                'type'     => 'color',
                'output'   => array( 'background-color' => '.tx-read-more a:focus, .tx-read-more:focus, tx-read-more a:hover, .tx-read-more:hover' ),
                'title'    => esc_html__( 'Posts read more button background hover color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            
            // Posts fonts
            array(
                'id'        => 'posts-fonts',
                'type'      => 'info',
                'title'     => esc_html__('Posts fonts', 'avas'),
                'style'     => 'success', //success warning
                ),
            array(
                'id'       => 'posts-title-font',
                'type'     => 'typography',
                'title'    => esc_html__( 'Post Title', 'avas' ),
                'google'   => true,
                'font-backup' => false,
                'output'      => array('h1.entry-title, h1.entry-title a'),
                'units'       =>'px',
                'fonts' => $standard_fonts,
                'font-style'  => true,
                'all_styles'  => true,
                'word-spacing'  => true,
                'letter-spacing'=> true,
                'text-transform'=> true,
                'color'         => false,
                'subsets'       => true,
                'allow_empty_line_height' => true,
            ),
            array(
                'id'       => 'posts-paragraph-font',
                'type'     => 'typography',
                'title'    => esc_html__( 'Post text', 'avas' ),
                'google'   => true,
                'font-backup' => false,
                'output'      => array('.entry-content p'),
                'units'       =>'px',
                'fonts' => $standard_fonts,
                'font-style'  => true,
                'all_styles'  => true,
                'word-spacing'  => true,
                'letter-spacing'=> true,
                'text-transform'=> true,
                'color'         => false,
                'subsets'       => true,
                'allow_empty_line_height' => true,
            ),
            array(
                'id'       => 'posts-blockquote-font',
                'type'     => 'typography',
                'title'    => esc_html__( 'Post blockquote', 'avas' ),
                'google'   => true,
                'font-backup' => false,
                'output'      => array('.entry-content blockquote p'),
                'units'       =>'px',
                'fonts' => $standard_fonts,
                'font-style'  => true,
                'all_styles'  => true,
                'word-spacing'  => true,
                'letter-spacing'=> true,
                'text-transform'=> true,
                'color'         => false,
                'subsets'       => true,
                'allow_empty_line_height' => true, 
            ),
        )));

        // Single Post Options
        Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Single Post', 'avas'),
        'subtitle'            => esc_html__( 'Single Post Options', 'avas'),
        'id'               => 'single_post_opt',
        'subsection'       => true,
        'customizer_width' => '344px',
        'fields'           => array(
            // sidebar single post
                array(
                'id'       => 'sidebar-single',
                'type'     => 'select',
                'title'    => esc_html__('Single Post Sidebar', 'avas'), 
                'subtitle'     => esc_html__('For Single Post Sidebar', 'avas'),
                'options'  => array(
                    'sidebar-right' => esc_html__('Right Sidebar', 'avas'),
                    'sidebar-left' => esc_html__('Left Sidebar', 'avas'),
                    'sidebar-none' => esc_html__('None', 'avas'),
                    ),
                'default'  => 'sidebar-none',
                ),
            array(
                'id'        => 'featured-image',
                'type'      => 'switch',
                'title'     => esc_html__('Single Post Featured Image', 'avas'),
                'default'   => 1,
                'on'        => esc_html__('Enable','avas'),
                'off'       => esc_html__('Disable','avas'),
                ),
            array(
                'id'        => 'posts-title',
                'type'      => 'switch',
                'title'     => esc_html__('Single Post Title', 'avas'),
                'default'   => 1,
                'on'        => esc_html__('Enable','avas'),
                'off'       => esc_html__('Disable','avas'),
                ),
            array(
                'id'        => 'post-category',
                'type'      => 'switch',
                'title'     => esc_html__('Single Post Categories', 'avas'),
                'default'   => 1,
                'on'        => esc_html__('Enable','avas'),
                'off'       => esc_html__('Disable','avas'),
                ),
            array(
                'id'        => 'post-tag',
                'type'      => 'switch',
                'title'     => esc_html__('Single Post Tags', 'avas'),
                'default'   => 1,
                'on'        => esc_html__('Enable','avas'),
                'off'       => esc_html__('Disable','avas'),
                ),
            array(
                'id'        => 'social-share-footer',
                'type'      => 'switch',
                'title'     => esc_html__('Single Post Social Share on Footer', 'avas'),
                'default'   => 1,
                'on'        => esc_html__('Enable','avas'),
                'off'       => esc_html__('Disable','avas'),
                ),
            array(
                    'id'        => 'share-on-text-footer',
                    'type'      => 'text',
                    'title'     => esc_html__('Share on Text', 'avas'),
                    'default'   => 'Share on',
                    'required'  => array( 'social-share-footer', '=', '1' ),
                ),
            array(
                'id'        => 'prev-next-posts',
                'type'      => 'switch',
                'title'     => esc_html__('Single Post Previous / Next Posts', 'avas'),
                'default'   => 1,
                'on'        => esc_html__('Enable','avas'),
                'off'       => esc_html__('Disable','avas'),
                ),
            array(
                    'id'        => 'prev-post-text',
                    'type'      => 'text',
                    'title'     => esc_html__('Previous Post Text', 'avas'),
                    'default'   => 'Previous Post',
                    'required'  => array( 'prev-next-posts', '=', '1' ),
                ),
            array(
                    'id'        => 'next-post-text',
                    'type'      => 'text',
                    'title'     => esc_html__('Next Post Text', 'avas'),
                    'default'   => 'Next Post',
                    'required'  => array( 'prev-next-posts', '=', '1' ),
                ),
            array(
                'id'        => 'author-bio-posts',
                'type'      => 'switch',
                'title'     => esc_html__('Single Post Author Bio', 'avas'),
                'default'   => 1,
                'on'        => esc_html__('Enable','avas'),
                'off'       => esc_html__('Disable','avas'),
                ),
            array(
                'id'        => 'comments-posts',
                'type'      => 'switch',
                'title'     => esc_html__('Single Post Comments', 'avas'),
                'default'   => 1,
                'on'        => esc_html__('Enable','avas'),
                'off'       => esc_html__('Disable','avas'),
                ),
            array(
                'id'       => 'single-posts-title-color',
                'type'     => 'color',
                'output'   => array( '.single-post .entry-title' ),
                'title'    => esc_html__( 'Single Posts Title color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'single-posts-text-color',
                'type'     => 'color',
                'output'   => array( '.single-post .entry-content p' ),
                'title'    => esc_html__( 'Single Post text color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'next-prev-post-color',
                'type'     => 'color',
                'output'   => array( 'color' => '.single .page-link, .single .page-link a' ),
                'title'    => esc_html__( 'Single Post Previous Post / Next Post color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'next-prev-post-bg-color',
                'type'     => 'color',
                'output'   => array( 'background-color' => '.single .page-link, .single .page-link a' ),
                'title'    => esc_html__( 'Single Post Previous Post / Next Post background color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'next-prev-post-hov-color',
                'type'     => 'color',
                'output'   => array( 'color' => '.single .page-link:hover, .single .page-link:hover a, .single .page-link a:hover' ),
                'title'    => esc_html__( 'Single Post Previous Post / Next Post hover color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'next-prev-post-bg-hov-color',
                'type'     => 'color',
                'output'   => array( 'background-color' => '.single .page-link:hover, .single .page-link:hover a, .single .page-link a:hover' ),
                'title'    => esc_html__( 'Single Post Previous Post / Next Post background hover color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'author-bg-color',
                'type'     => 'color',
                'output'   => array( 'background-color' => '.author_bio_sec' ),
                'title'    => esc_html__( 'Single Post Author background color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'post_comment_form_bg_color',
                'type'     => 'color',
                'output'   => array( 'background-color' => '.single-post textarea.form-control' ),
                'title'    => esc_html__( 'Single Post Comment background color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'post_comment_form_btn_color',
                'type'     => 'color',
                'output'   => array( 'color' => '.form-submit input[type="submit"]' ),
                'title'    => esc_html__( 'Single Post comment form button text color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'post_comment_form_btn_hov_color',
                'type'     => 'color',
                'output'   => array( 'color' => '.form-submit input[type="submit"]:hover' ),
                'title'    => esc_html__( 'Single Post comment form button text hover color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'post_comment_form_btn_bg_color',
                'type'     => 'color',
                'output'   => array( 'background-color' => '.form-submit input[type="submit"]' ),
                'title'    => esc_html__( 'Single Post comment form button background color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'post_comment_form_btn_bg_hov_color',
                'type'     => 'color',
                'output'   => array( 'background-color' => '.form-submit input[type="submit"]:hover' ),
                'title'    => esc_html__( 'Single Post comment form button background hover color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            
            array(
                'id'       => 'form-control-focus',
                'type'     => 'color',
                'output'   => array( 'border-color' => '.form-control:focus' ),
                'title'    => esc_html__( 'Single Post comment form border focus color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
        ),
        ));
        
        // Related Posts Options
        Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Related Posts', 'avas'),
        'id'               => 'related_posts_opt',
        'subsection'       => true,
        'customizer_width' => '344px',
        'fields'           => array(
            array(
                'id'        => 'related-posts',
                'type'      => 'switch',
                'title'     => esc_html__('Related Posts Options', 'avas'),
                'default'   => 1,
                'on'        => esc_html__('Enable','avas'),
                'off'       => esc_html__('Disable','avas'),
                ),
            array(
                    'id'        => 'related-posts_text',
                    'type'      => 'text',
                    'title'     => esc_html__('Related Posts Text', 'avas'),
                    'default'   => 'Related Posts',
                    'required'  => array( 'related-posts', '=', '1' ),
                    ),
            array(
                'id' => 'related_posts_style',
                'title' => esc_html__('Related Posts Style', 'avas'),
                'type' => 'select',
                'options' => array (
                    'rp_style_1' => esc_html__('Style 1','avas'),
                    'rp_style_2' => esc_html__('Style 2','avas'),
                    ),
                    'default'  => 'rp_style_1',
                    'required'  => array( 'related-posts', '=', '1' ),
                ),
            array(
                'id'            => 'related_posts_count',
                'type'          => 'slider',
                'title'         => esc_html__( 'Total Related Posts Count', 'avas' ),
                'default'       => 8,
                'min'           => 1,
                'step'          => 1,
                'max'           => 99,
                'display_value' => 'text',
                'required'  => array( 'related-posts', '=', '1' ),
                ),
            array(
                'id'       => 'related-post-bar-bg-color',
                'type'     => 'color',
                'output'   => array( 'background-color' => '.related-posts-title' ),
                'title'    => esc_html__( 'Related Post Bar background color', 'avas' ),
                'validate' => 'color',
                'transparent' => true,
                'required'  => array( 'related-posts', '=', '1' ),
            ),
            array(
                'id'       => 'related-post-bar-title-color',
                'type'     => 'color',
                'output'   => '.related-posts-title',
                'title'    => esc_html__( 'Related Post Bar Title color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
                'required'  => array( 'related-posts', '=', '1' ),
            ),
            array(
                'id'       => 'related-post-bar-navigation-color',
                'type'     => 'color',
                'output'   => '.related-posts .owl-carousel .owl-nav button i',
                'title'    => esc_html__( 'Related Post Bar Navigation color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
                'required'  => array( 'related-posts', '=', '1' ),
            ),
            array(
                'id'       => 'related-post-overlay-color',
                'type'     => 'color',
                'output'   => array( 'background-color' => '.related-posts-item .overlay' ),
                'title'    => esc_html__( 'Related Post overlay color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
                'required'  => array(
                    array( 'related-posts', '=', '1' ),
                    array( 'related_posts_style', '=', 'rp_style_1' ),
                )
            ),
            array(
                'id'       => 'related-post-title-color',
                'type'     => 'color',
                'output'   => array( 'color' => '.related-posts-item .overlay a, .related-posts-item .entry-title' ),
                'title'    => esc_html__( 'Related Post title color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
                'required'  => array( 'related-posts', '=', '1' ),
            ),
            array(
                'id'       => 'related-post-title-hover-color',
                'type'     => 'color',
                'output'   => array( 'color' => '.related-posts-item .overlay a:hover, .related-posts-item:hover .entry-title' ),
                'title'    => esc_html__( 'Related Post title hover color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
                'required'  => array( 'related-posts', '=', '1' ),
            ),
            array(
                'id'       => 'typography-related-posts-title',
                'type'     => 'typography',
                'title'    => esc_html__( 'Related Posts Title Fonts', 'avas' ),
                'google'   => true,
                'font-backup' => false,
                'output'      => array('.related-posts-item .overlay a, .related-posts-item .entry-title'),
                'units'       =>'px',
                'fonts' => $standard_fonts,
                'font-style'  => true,
                'all_styles'  => false,
                'color'         => false,
                'text-align'    => false,
                'text-transform'=> true,
                'subsets'       => true,
                'allow_empty_line_height' => true,
                'required'  => array( 'related-posts', '=', '1' ),
            ),
                
            )
        ));

        // Page options / Pages options
        Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Pages', 'avas' ),
        'id'         => 'pages-option',
        'icon'       => 'bi bi-files',
        'fields'     => array(
                array(
                    'id'             => 'page-margin',
                    'type'           => 'spacing',
                    'output'         => array('#page .space-content'),
                    'mode'           => 'margin',
                    'units'          => array('px', 'em'),
                    'units_extended' => 'false',
                    'title'          => esc_html__('Page margin', 'avas'),
                    'default'        => array (
                        'units'       => 'px'
                    )
                ),
                array(
                    'id'             => 'page-padding',
                    'type'           => 'spacing',
                    'output'         => array('#page .space-content'),
                    'mode'           => 'padding',
                    'units'          => array('px', 'em'),
                    'units_extended' => 'false',
                    'title'          => esc_html__('Page padding', 'avas'),
                    'default'        => array (
                        'units'       => 'px'
                    )
                ),
            )
        ));

        // 404 Page / 404 error page options
        Redux::setSection( $opt_name, array(
        'title'            => esc_html__( '404 Page', 'avas'),
        'desc'            => esc_html__( '404 Error Page Template Options', 'avas'),
        'id'               => '404_page',
        'subsection'       => true,
        'customizer_width' => '344px',
        'fields'           => array(
                array(
                    'id'        => '404_numb',
                    'type'      => 'text',
                    'title'     => esc_html__('404 Number', 'avas'),
                    'default'   => esc_html__('404', 'avas'),
                ),
                array(
                    'id'        => '404_heading',
                    'type'      => 'text',
                    'title'     => esc_html__('404 Heading', 'avas'),
                    'default'   => 'OOPS! SOMETHING WENT WRONG',
                ),
                array(
                    'id'        => '404_desc',
                    'type'      => 'textarea',
                    'title'     => esc_html__('404 Description', 'avas'),
                    'default'   => 'The page you are looking for doesn\'t exist.',
                ),
                array(
                    'id'        => '404_btn',
                    'type'      => 'text',
                    'title'     => esc_html__('404 Button', 'avas'),
                    'default'   => 'Back to Home',
                ),
                array(
                    'title' => esc_html__( '404 Background', 'avas' ),
                    'id'    => '404_bg',
                    'type'  => 'background',
                    'output'   => array('background-color'=>'.error404'),
                ),
                array(
                    'id'       => '404_numb-color',
                    'type'     => 'color',
                    'output'    => array('color' => '.error-404 h1', 'border-color' => '.error-404 h1'),
                    'title'    => esc_html__( '404 Number Color', 'avas' ),
                    'transparent' => false,
                    'validate'  => 'color',
                ),
                array(
                    'id'       => '404_heading-color',
                    'type'     => 'color',
                    'output'    => array('color' => '.error-404 h4'),
                    'title'    => esc_html__( '404 Heading Color', 'avas' ),
                    'transparent' => false,
                    'validate'  => 'color',
                ),
                array(
                    'id'       => '404_desc-color',
                    'type'     => 'color',
                    'output'    => array('color' => '.error-404 p'),
                    'title'    => esc_html__( '404 Description Color', 'avas' ),
                    'transparent' => false,
                    'validate'  => 'color',
                ),
                array(
                    'id'       => '404_btn-color',
                    'type'     => 'color',
                    'output'    => array('color' => '.error-404 .tx_404_btn'),
                    'title'    => esc_html__( '404 Button text color', 'avas' ),
                    'transparent' => false,
                    'validate'  => 'color',
                ),
                array(
                    'id'       => '404_btn-hov_color',
                    'type'     => 'color',
                    'output'    => array('color' => '.error-404 .tx_404_btn:hover'),
                    'title'    => esc_html__( '404 Button text hover color', 'avas' ),
                    'transparent' => false,
                    'validate'  => 'color',
                ),
                array(
                    'id'       => '404_btn-bg_color',
                    'type'     => 'color',
                    'output'    => array('background-color' => '.error-404 .tx_404_btn'),
                    'title'    => esc_html__( '404 Button background color', 'avas' ),
                    'transparent' => false,
                    'validate'  => 'color',
                ),
                array(
                    'id'       => '404_btn-bg_hov_color',
                    'type'     => 'color',
                    'output'    => array('background-color' => '.error-404 .tx_404_btn:hover'),
                    'title'    => esc_html__( '404 Button background hover color', 'avas' ),
                    'transparent' => false,
                    'validate'  => 'color',
                ),
                array(
                    'id'             => '404_btn-padding',
                    'type'           => 'spacing',
                    'output'         => array('.error-404 .tx_404_btn'),
                    'mode'           => 'padding',
                    'units'          => array('px', 'em'),
                    'units_extended' => 'false',
                    'title'          => esc_html__('404 Button Padding', 'avas'),
                    'default'        => array (
                        'units'       => 'px'
                    )
                ),
                array(
                    'id'       => 'typography-404_numb',
                    'type'     => 'typography',
                    'title'    => esc_html__( '404 number Fonts', 'avas' ),
                    'google'   => true,
                    'font-backup' => false,
                    'output'      => array('.error-404 h1'),
                    'units'       =>'px',
                    'fonts' => $standard_fonts,
                    'font-style'  => true,
                    'all_styles'  => false,
                    'color'         => false,
                    'text-align'    => false,
                    'text-transform'=> true,
                    'subsets'       => true,
                    'allow_empty_line_height' => true,
                ),
                array(
                    'id'       => 'typography-404_head',
                    'type'     => 'typography',
                    'title'    => esc_html__( '404 heading Fonts', 'avas' ),
                    'google'   => true,
                    'font-backup' => false,
                    'output'      => array('.error-404 h4'),
                    'units'       =>'px',
                    'fonts' => $standard_fonts,
                    'font-style'  => true,
                    'all_styles'  => false,
                    'color'         => false,
                    'text-align'    => false,
                    'text-transform'=> true,
                    'subsets'       => true,
                    'allow_empty_line_height' => true,
                ),
                array(
                    'id'       => 'typography-404_desc',
                    'type'     => 'typography',
                    'title'    => esc_html__( '404 description Fonts', 'avas' ),
                    'google'   => true,
                    'font-backup' => false,
                    'output'      => array('.error-404 p'),
                    'units'       =>'px',
                    'fonts' => $standard_fonts,
                    'font-style'  => true,
                    'all_styles'  => false,
                    'color'         => false,
                    'text-align'    => false,
                    'text-transform'=> true,
                    'subsets'       => true,
                    'allow_empty_line_height' => true,
                ),
            )
        ));
       
        // Services Options
        Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Services', 'avas' ),
        'id'         => 'service-option',
        'icon'       => 'el el-wrench',
        'fields'     => array(
            array(
                'id'      => 'service_post_type',
                'title'    => esc_html__('Services Post Type','avas'),
                'desc'    => esc_html__('After Save Changes please refresh the page.','avas'),
                'type'    => 'switch',
                'on'      => esc_html__('Enable','avas'),
                'off'     => esc_html__('Disable','avas'),
                'default' => 1,
                ),
            array(
                    'id'        => 'services_title',
                    'type'      => 'text',
                    'title'     => esc_html__('Services Name', 'avas'),
                    'description' => esc_html__('Sevices menu and archive page title will be changed. After Save Changes please refresh the page.', 'avas'),
                    'default'   => 'Services',
                    'required'  => array( 'service_post_type', '=', '1' ),
                    ),
            array(
                    'id'        => 'service-slug',
                    'type'      => 'text',
                    'title'     => esc_html__('Services slug / Permalink', 'avas'),
                    'description' => esc_html__('After change go to Settings > Permalinks and click Save changes.', 'avas'),
                    'default'   => 'service',
                    'required'  => array( 'service_post_type', '=', '1' ),
                    ),
            array(
                    'id'        => 'service-cat-slug',
                    'type'      => 'text',
                    'title'     => esc_html__('Services category slug / Permalink', 'avas'),
                    'description' => esc_html__('After change go to Settings > Permalinks and click Save changes.', 'avas'),
                    'default'   => 'service-category',
                    'required'  => array( 'service_post_type', '=', '1' ),
                ),
            array(
                'id'            => 'service_excerpt_limit',
                'type'          => 'slider',
                'title'         => esc_html__( 'Service Excerpt Limit', 'avas' ),
                'default'       => 20,
                'min'           => 1,
                'step'          => 1,
                'max'           => 100,
                'display_value' => 'text',
                'required'  => array( 'service_post_type', '=', '1' ),
            ), 
            array(
                    'id'        => 'service-comments',
                    'type'      => 'switch',
                    'title'     => esc_html__('Services Comments', 'avas'),
                    'default'   => 0,
                    'on'        => esc_html__('Show','avas'),
                    'off'       => esc_html__('Hide','avas'),
                    'required'  => array( 'service_post_type', '=', '1' ),
                ),
            array(
                'id'       => 'service_comment_form_btn_color',
                'type'     => 'color',
                'output'   => array( 'color' => '.single-service .form-submit input[type="submit"]' ),
                'title'    => esc_html__( 'Service comment form button text color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
                'required'  => array( 'service-comments', '=', '1' ),
            ),
            array(
                'id'       => 'service_comment_form_btn_hov_color',
                'type'     => 'color',
                'output'   => array( 'color' => '.single-service .form-submit input[type="submit"]:hover' ),
                'title'    => esc_html__( 'Service comment form button text hover color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
                'required'  => array( 'service-comments', '=', '1' ),
            ),
            array(
                'id'       => 'service_comment_form_btn_bg_color',
                'type'     => 'color',
                'output'   => array( 'background-color' => '.single-service .form-submit input[type="submit"]' ),
                'title'    => esc_html__( 'Service comment form button background color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
                'required'  => array( 'service-comments', '=', '1' ),
            ),
            array(
                'id'       => 'service_comment_form_btn_bg_hov_color',
                'type'     => 'color',
                'output'   => array( 'background-color' => '.single-service .form-submit input[type="submit"]:hover' ),
                'title'    => esc_html__( 'Service comment form button background hover color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
                'required'  => array( 'service-comments', '=', '1' ),
            ),
            array(
                'id'       => 'service-form-control-focus',
                'type'     => 'color',
                'output'   => array( 'border-color' => '.single-service .form-control:focus' ),
                'title'    => esc_html__( 'Service comment form border focus color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
                'required'  => array( 'service-comments', '=', '1' ),
            ),
            array(
                    'id'        => 'service_archive_setting-info',
                    'type'      => 'info',
                    'title'     => esc_html__('Services Archive Page Settings', 'avas'),
                    'style'     => 'success', //success warning
                    'required'  => array( 'service_post_type', '=', '1' ),
            ),
            array(
                'id'       => 'service_archive_display',
                'type'     => 'select',
                'title'    => esc_html__('Service Archive Display Type', 'avas'), 
                'options'  => array(
                    'grid'         => esc_html__('Grid', 'avas'),
                    'overlay'      => esc_html__('Overlay', 'avas'),
                ),
                'default'  => 'grid',
                'required'  => array( 'service_post_type', '=', '1' ),
            ),
            array(
                'id'       => 'service_archive_category',
                'title'    => esc_html__('Service Archive Category(for Grid display only)', 'avas'), 
                'type'    => 'switch',
                'on'      => esc_html__('Show','avas'),
                'off'     => esc_html__('Hide','avas'),
                'default' => 1,
                'required'  => array( 'service_archive_display', '=', 'grid' ),
            ),
            array(
                'id'       => 'service_archive_title',
                'title'    => esc_html__('Service Archive Title', 'avas'), 
                'type'    => 'switch',
                'on'      => esc_html__('Show','avas'),
                'off'     => esc_html__('Hide','avas'),
                'default' => 1,
                'required'  => array( 'service_post_type', '=', '1' ),
            ),
            array(
                'id'       => 'service_archive_excerpt',
                'title'    => esc_html__('Service Archive Excerpt', 'avas'), 
                'type'    => 'switch',
                'on'      => esc_html__('Show','avas'),
                'off'     => esc_html__('Hide','avas'),
                'default' => 1,
                'required'  => array( 'service_post_type', '=', '1' ),
            ),
            array(
                'id'       => 'service_archive_link',
                'title'    => esc_html__('Service Archive Link(for Overlay display only)', 'avas'), 
                'type'    => 'switch',
                'on'      => esc_html__('Show','avas'),
                'off'     => esc_html__('Hide','avas'),
                'default' => 1,
                'required'  => array( 'service_archive_display', '=', 'overlay' ),
            ),
            array(
                'id'       => 'service_archive_item',
                'type'          => 'slider',
                'title'    => esc_html__('Service Archive Item per page', 'avas'), 
                'default'       => 9,
                'min'           => -1,
                'step'          => 1,
                'max'           => 100,
                'display_value' => 'text',
                'required'  => array( 'service_post_type', '=', '1' ),
            ),
            array(
                    'id'        => 'service-colors-info',
                    'type'      => 'info',
                    'title'     => esc_html__('Services Colors Settings', 'avas'),
                    'style'     => 'success', //success warning
                    'required'  => array( 'service_post_type', '=', '1' ),
                ),
            array(
                    'id'       => 'service-overlay-color',
                    'type'     => 'color_rgba',
                    'output'    => array('background-color' => '.tx-services-featured a:before, .tx-services-overlay-item:before'),
                    'title'    => esc_html__( 'Services Overlay Color', 'avas' ),
                    'required'  => array( 'service_post_type', '=', '1' ),
                ),
            array(
                    'id'       => 'service-title-color',
                    'type'     => 'color',
                    'output'    => array('color' => '.tx-services-title a'),
                    'title'    => esc_html__( 'Services Title Color', 'avas' ),
                    'transparent' => false,
                    'validate'  => 'color',
                    'required'  => array( 'service_post_type', '=', '1' ),
                ),
            array(
                    'id'       => 'service-title-hov-color',
                    'type'     => 'color',
                    'output'    => array('color' => '.tx-services-title:hover,.tx-services-overlay-item .tx-services-title:hover,.tx-services-title a:hover'),
                    'title'    => esc_html__( 'Services Title Hover Color', 'avas' ),
                    'transparent' => false,
                    'validate'  => 'color',
                    'required'  => array( 'service_post_type', '=', '1' ),
                ),
            array(
                    'id'       => 'service-title-holder-bg-color',
                    'type'     => 'color_rgba',
                    'output'    => array('background-color' => '.tx-services-title-holder'),
                    'title'    => esc_html__( 'Services Title Holder Background Color', 'avas' ),
                    'desc'    => esc_html__( 'For Overlay style only', 'avas' ),
                    'required'  => array( 'service_post_type', '=', '1' ),
                ),
            array(
                    'id'       => 'service-content-bg-color',
                    'type'     => 'color',
                    'output'    => array('background-color' => '.tx-services-content'),
                    'title'    => esc_html__( 'Services Content Background Color', 'avas' ),
                    'transparent' => false,
                    'validate'  => 'color',
                    'required'  => array( 'service_post_type', '=', '1' ),
                ),
            array(
                    'id'       => 'service-excerpt-color',
                    'type'     => 'color',
                    'output'    => array('color' => '.tx-services-excp'),
                    'title'    => esc_html__( 'Services Excerpt Color for Grid style only', 'avas' ),
                    'transparent' => false,
                    'validate'  => 'color',
                    'required'  => array( 'service_post_type', '=', '1' ),
                ),
            array(
                    'id'       => 'service-excerpt-overlay-color',
                    'type'     => 'color',
                    'output'    => array('color' => '.tx-services-overlay-item .tx-services-excp'),
                    'title'    => esc_html__( 'Services Excerpt Color for Overlay style only', 'avas' ),
                    'transparent' => false,
                    'validate'  => 'color',
                    'required'  => array( 'service_post_type', '=', '1' ),
                ),
            array(
                    'id'       => 'service-cat-color',
                    'type'     => 'color',
                    'output'    => array('color' => '.tx-serv-cat'),
                    'title'    => esc_html__( 'Services Category Color', 'avas' ),
                    'transparent' => false,
                    'validate'  => 'color',
                    'required'  => array( 'service_post_type', '=', '1' ),
                ),
            array(
                    'id'       => 'service-cat-hov-color',
                    'type'     => 'color',
                    'output'    => array('color' => '.tx-serv-cat:hover'),
                    'title'    => esc_html__( 'Services Category Hover Color', 'avas' ),
                    'transparent' => false,
                    'validate'  => 'color',
                    'required'  => array( 'service_post_type', '=', '1' ),
                ),
            array(
                    'id'       => 'service-overlay-icon-color',
                    'type'     => 'color',
                    'output'    => array('color' => '.tx-services-featured a:after, .tx-services-overlay-item i'),
                    'title'    => esc_html__( 'Services Overlay Icon Color', 'avas' ),
                    'transparent' => false,
                    'validate'  => 'color',
                    'required'  => array( 'service_post_type', '=', '1' ),
                ),
            array(
                    'id'       => 'service-overlay-icon-hov-color',
                    'type'     => 'color',
                    'output'    => array('color' => '.tx-services-overlay-item i:hover'),
                    'title'    => esc_html__( 'Services Overlay Icon Hover Color', 'avas' ),
                    'desc'    => esc_html__( 'For Services Overlay style only.', 'avas' ),
                    'transparent' => false,
                    'validate'  => 'color',
                    'required'  => array( 'service_post_type', '=', '1' ),
                ),
            array(
                    'id'        => 'service-single-colors-info',
                    'type'      => 'info',
                    'title'     => esc_html__('Services Single Page Colors Settings', 'avas'),
                    'style'     => 'success', //success warning
                    'required'  => array( 'service_post_type', '=', '1' ),
                ),
            array(
                    'id'       => 'service-download-btn-color',
                    'type'     => 'color',
                    'output'    => array('color' => '.btn-brochure'),
                    'title'    => esc_html__( 'Services Download Button Text Color', 'avas' ),
                    'transparent' => false,
                    'validate'  => 'color',
                    'required'  => array( 'service_post_type', '=', '1' ),
                ),
            array(
                    'id'       => 'service-download-btn-bg-color',
                    'type'     => 'color',
                    'output'    => array('background-color' => '.btn-brochure'),
                    'title'    => esc_html__( 'Services Download Button Background Color', 'avas' ),
                    'transparent' => false,
                    'validate'  => 'color',
                    'required'  => array( 'service_post_type', '=', '1' ),
                ),
            array(
                    'id'       => 'service-download-btn-txt-hov-color',
                    'type'     => 'color',
                    'output'    => array('color' => '.btn-brochure:hover'),
                    'title'    => esc_html__( 'Services Download Button Text Hover Color', 'avas' ),
                    'transparent' => false,
                    'validate'  => 'color',
                    'required'  => array( 'service_post_type', '=', '1' ),
                ),
            array(
                    'id'       => 'service-download-btn-bg-hov-color',
                    'type'     => 'color',
                    'output'    => array('background-color' => '.btn-brochure:hover'),
                    'title'    => esc_html__( 'Services Download Button Background Hover Color', 'avas' ),
                    'transparent' => false,
                    'validate'  => 'color',
                    'required'  => array( 'service_post_type', '=', '1' ),
                ),
            )));

    // Portfolio options
    Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Portfolio', 'avas' ),
        'id'         => 'portfolio-option',
        'desc'       => esc_html__( 'Portfolio options', 'avas' ),
        'icon'       => 'el el-th-large',
        'fields'     => array(
            array(
                'id'      => 'portfolio_post_type',
                'title'    => esc_html__('Portfolio Post Type','avas'),
                'desc'    => esc_html__('After Save Changes please refresh the page.','avas'),
                'type'    => 'switch',
                'on'      => esc_html__('Enable','avas'),
                'off'     => esc_html__('Disable','avas'),
                'default' => 1,
                ),
            array(
                    'id'        => 'portfolio_title',
                    'type'      => 'text',
                    'title'     => esc_html__('Name', 'avas'),
                    'description' => esc_html__('Portfolio menu and archive page title will be changed. After Save Changes please refresh the page.', 'avas'),
                    'default'   => 'Portfolio',
                    'required'  => array( 'portfolio_post_type', '=', '1' ),
                    ),
            array(
                    'id'        => 'portfolio-slug',
                    'type'      => 'text',
                    'title'     => esc_html__('Portfolio slug / Permalink', 'avas'),
                    'description' => esc_html__('After change go to Settings > Permalinks and click Save changes.', 'avas'),
                    'default'   => 'portfolio',
                    'required'  => array( 'portfolio_post_type', '=', '1' ),
                    ),
            array(
                    'id'        => 'portfolio-cat-slug',
                    'type'      => 'text',
                    'title'     => esc_html__('Portfolio category slug / Permalink', 'avas'),
                    'description' => esc_html__('After change go to Settings > Permalinks and click Save changes.', 'avas'),
                    'default'   => 'portfolio-category',
                    'required'  => array( 'portfolio_post_type', '=', '1' ),
                    ),
            array(
                    'id'        => 'portfolio-archive-info',
                    'type'      => 'info',
                    'title'     => esc_html__('Portfolio Archive Page Settings', 'avas'),
                    'style'     => 'success', //success warning
                    'required'  => array( 'portfolio_post_type', '=', '1' ),
                    ),
            array(
                'id'       => 'portfolio_archive_layout',
                'type'     => 'select',
                'title'    => esc_html__('Portfolio Archive Layout', 'avas'), 
                'options'  => array(
                    'boxed' => esc_html__('Boxed', 'avas'),
                    '-fluid' => esc_html__('Full Width', 'avas'),
                ),
                'default'  => 'boxed',
                'required'  => array( 'portfolio_post_type', '=', '1' ),
            ),
            array(
                'id'       => 'portfolio_archive_columns',
                'type'     => 'select',
                'title'    => esc_html__('Portfolio Archive Columns', 'avas'), 
                'options'  => array(
                    '4' => esc_html__('Three', 'avas'),
                    '3' => esc_html__('Four', 'avas'),
                    '2' => esc_html__('Six', 'avas'),
                ),
                'default'  => '4',
                'required'  => array( 'portfolio_post_type', '=', '1' ),
            ),
            array(
                'id'       => 'portfolio_archive_display',
                'type'     => 'select',
                'title'    => esc_html__('Portfolio Archive Display Type', 'avas'), 
                'options'  => array(
                    'masonry'         => esc_html__('Masonry', 'avas'),
                    'grid-h' => esc_html__('Grid Horizontal', 'avas'),
                    'grid-v'   => esc_html__('Grid Vertical', 'avas'),
                    'card-h' => esc_html__('Card Horizontal', 'avas'),
                    'card-v' => esc_html__('Card Vertical', 'avas'),
                ),
                'default'  => 'masonry',
                'required'  => array( 'portfolio_post_type', '=', '1' ),
            ),
            array(
                'id'       => 'portfolio_archive_popup',
                'type'     => 'select',
                'title'    => esc_html__('Portfolio Archive Popup', 'avas'), 
                'options'  => array(
                    'content' => esc_html__('With Content', 'avas'),
                    'no-content' => esc_html__('Without Content', 'avas'),
                ),
                'default'  => 'content',
                'required'  => array( 'portfolio_post_type', '=', '1' ),
            ),
            array(
                'id'       => 'portfolio_archive_hover',
                'type'     => 'select',
                'title'    => esc_html__('Portfolio Archive Hover Effects', 'avas'), 
                'options'  => array(
                    'effects-1' => esc_html__('Effect 1', 'avas'),
                    'effects-2' => esc_html__('Effect 2', 'avas'),
                    'effects-3' => esc_html__('Effect 3', 'avas'),
                    'effects-4' => esc_html__('Effect 4', 'avas'),
                    'effects-0' => esc_html__('No Effect', 'avas'),
                ),
                'default'  => 'effects-1',
                'required'  => array( 'portfolio_post_type', '=', '1' ),
            ),
            array(
                'id'       => 'portfolio_archive_filter',
                'title'    => esc_html__('Portfolio Archive Filter', 'avas'), 
                'type'    => 'switch',
                'on'      => esc_html__('Show','avas'),
                'off'     => esc_html__('Hide','avas'),
                'default' => 0,
                'required'  => array( 'portfolio_post_type', '=', '1' ),
            ),
            array(
                'id'       => 'portfolio_archive_category',
                'title'    => esc_html__('Portfolio Archive Category', 'avas'), 
                'type'    => 'switch',
                'on'      => esc_html__('Show','avas'),
                'off'     => esc_html__('Hide','avas'),
                'default' => 1,
                'required'  => array( 'portfolio_post_type', '=', '1' ),
            ),
            array(
                'id'       => 'portfolio_archive_title',
                'title'    => esc_html__('Portfolio Archive Title', 'avas'), 
                'type'    => 'switch',
                'on'      => esc_html__('Show','avas'),
                'off'     => esc_html__('Hide','avas'),
                'default' => 1,
                'required'  => array( 'portfolio_post_type', '=', '1' ),
            ),
            array(
                'id'       => 'portfolio_archive_excerpt',
                'title'    => esc_html__('Portfolio Archive Excerpt', 'avas'), 
                'type'    => 'switch',
                'on'      => esc_html__('Show','avas'),
                'off'     => esc_html__('Hide','avas'),
                'default' => 1,
                'required'  => array( 'portfolio_post_type', '=', '1' ),
            ),
            array(
                'id'       => 'portfolio_archive_enlarge',
                'title'    => esc_html__('Portfolio Archive Enlarge', 'avas'), 
                'type'    => 'switch',
                'on'      => esc_html__('Show','avas'),
                'off'     => esc_html__('Hide','avas'),
                'default' => 1,
                'required'  => array( 'portfolio_post_type', '=', '1' ),
            ),
            array(
                'id'       => 'portfolio_archive_link',
                'title'    => esc_html__('Portfolio Archive Link', 'avas'), 
                'type'    => 'switch',
                'on'      => esc_html__('Show','avas'),
                'off'     => esc_html__('Hide','avas'),
                'default' => 1,
                'required'  => array( 'portfolio_post_type', '=', '1' ),
            ),
            array(
                'id'       => 'portfolio_archive_gutter',
                'type'          => 'slider',
                'title'    => esc_html__('Portfolio Archive Gutter', 'avas'),
                'default'       => 10,
                'min'           => 0,
                'step'          => 1,
                'max'           => 100,
                'display_value' => 'text',
                'required'  => array( 'portfolio_post_type', '=', '1' ),
            ),
            array(
                'id'       => 'portfolio_archive_item',
                'type'          => 'slider',
                'title'    => esc_html__('Portfolio Archive Item per page', 'avas'), 
                'default'       => 9,
                'min'           => -1,
                'step'          => 1,
                'max'           => 100,
                'display_value' => 'text',
                'required'  => array( 'portfolio_post_type', '=', '1' ),
            ),
            array(
                    'id'        => 'portfolio-meta-info',
                    'type'      => 'info',
                    'title'     => esc_html__('Single Portfolio Settings', 'avas'),
                    'style'     => 'success', //success warning
                    'required'  => array( 'portfolio_post_type', '=', '1' ),
                    ),
            array(
                    'id'        => 'portfolio-comments',
                    'type'      => 'switch',
                    'title'     => esc_html__('Portfolio Comments', 'avas'),
                    'default'   => 0,
                    'on'        => esc_html__('Show','avas'),
                    'off'       => esc_html__('Hide','avas'),
                    'required'  => array( 'portfolio_post_type', '=', '1' ),
                ),
            array(
                'id'       => 'portfolio_comment_form_btn_color',
                'type'     => 'color',
                'output'   => array( 'color' => '.single-portfolio .form-submit input[type="submit"]' ),
                'title'    => esc_html__( 'Portfolio comment form button text color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
                'required'  => array( 'portfolio-comments', '=', '1' ),
            ),
            array(
                'id'       => 'portfolio_comment_form_btn_hov_color',
                'type'     => 'color',
                'output'   => array( 'color' => '.single-portfolio .form-submit input[type="submit"]:hover' ),
                'title'    => esc_html__( 'Portfolio comment form button text hover color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
                'required'  => array( 'portfolio-comments', '=', '1' ),
            ),
            array(
                'id'       => 'portfolio_comment_form_btn_bg_color',
                'type'     => 'color',
                'output'   => array( 'background-color' => '.single-portfolio .form-submit input[type="submit"]' ),
                'title'    => esc_html__( 'Portfolio comment form button background color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
                'required'  => array( 'portfolio-comments', '=', '1' ),
            ),
            array(
                'id'       => 'portfolio_comment_form_btn_bg_hov_color',
                'type'     => 'color',
                'output'   => array( 'background-color' => '.single-portfolio .form-submit input[type="submit"]:hover' ),
                'title'    => esc_html__( 'Portfolio comment form button background hover color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
                'required'  => array( 'portfolio-comments', '=', '1' ),
            ),
            array(
                'id'       => 'portfolio-form-control-focus',
                'type'     => 'color',
                'output'   => array( 'border-color' => '.single-portfolio .form-control:focus' ),
                'title'    => esc_html__( 'Portfolio comment form border focus color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
                'required'  => array( 'portfolio-comments', '=', '1' ),
            ),
            array(
                    'id'        => 'portfolio-time',
                    'type'      => 'switch',
                    'title'     => esc_html__('Single Portfolio Date', 'avas'),
                    'default'   => 1,
                    'on'        => 'Show',
                    'off'       => 'Hide',
                    'required'  => array( 'portfolio_post_type', '=', '1' ),
                ),
            array(
                    'id'        => 'portfolio-author',
                    'type'      => 'switch',
                    'title'     => esc_html__('Single Portfolio Author', 'avas'),
                    'default'   => 1,
                    'on'        => 'Show',
                    'off'       => 'Hide',
                    'required'  => array( 'portfolio_post_type', '=', '1' ),
                ),
            array(
                    'id'       => 'portfolio-meta-color-left',
                    'type'     => 'color',
                    'output'    => array('.portfolio-meta h5'),
                    'title'    => esc_html__( 'Single Portfolio Meta Color Left', 'avas' ),
                    'desc'    => esc_html__( 'Created Date, Created By, Website', 'avas' ),
                    'transparent' => false,
                    'validate'  => 'color',
                    'required'  => array( 'portfolio_post_type', '=', '1' ),
                ),
            array(
                    'id'       => 'portfolio-meta-color-right',
                    'type'     => 'color',
                    'output'    => array('.portfolio-meta'),
                    'title'    => esc_html__( 'Single Portfolio Meta Color Right', 'avas' ),
                    'desc'    => esc_html__( 'Date, Author', 'avas' ),
                    'transparent' => false,
                    'validate'  => 'color',
                    'required'  => array( 'portfolio_post_type', '=', '1' ),
                ),
            array(
                    'id'       => 'portfolio-meta-link-color',
                    'type'     => 'color',
                    'output'    => array('.portfolio-meta a'),
                    'title'    => esc_html__( 'Single Portfolio Click to visit color', 'avas' ),
                    'transparent' => false,
                    'validate'  => 'color',
                    'required'  => array( 'portfolio_post_type', '=', '1' ),
                ),
            array(
                    'id'       => 'portfolio-meta-link-hover-color',
                    'type'     => 'color',
                    'output'    => array('.portfolio-meta a:hover'),
                    'title'    => esc_html__( 'Single Portfolio Click to visit hover color', 'avas' ),
                    'transparent' => false,
                    'validate'  => 'color',
                    'required'  => array( 'portfolio_post_type', '=', '1' ),
                ),
            array(
                    'id'       => 'single-portfolio-button-bg-color',
                    'type'     => 'color',
                    'output'    => array('background-color' => '.tx-single-portfolio-btn'),
                    'title'    => esc_html__( 'Single Portfolio Button background color', 'avas' ),
                    'transparent' => false,
                    'validate'  => 'color',
                    'required'  => array( 'portfolio_post_type', '=', '1' ),
                ),
            array(
                    'id'       => 'single-portfolio-button-bg-hov-color',
                    'type'     => 'color',
                    'output'    => array('background-color' => '.tx-single-portfolio-btn:hover'),
                    'title'    => esc_html__( 'Single Portfolio Button background hover color', 'avas' ),
                    'transparent' => false,
                    'validate'  => 'color',
                    'required'  => array( 'portfolio_post_type', '=', '1' ),
                ),
            array(
                    'id'       => 'single-portfolio-button-color',
                    'type'     => 'color',
                    'output'    => array('.tx-single-portfolio-btn'),
                    'title'    => esc_html__( 'Single Portfolio Button text color', 'avas' ),
                    'transparent' => false,
                    'validate'  => 'color',
                    'required'  => array( 'portfolio_post_type', '=', '1' ),
                ),
            array(
                    'id'       => 'single-portfolio-button-hov-color',
                    'type'     => 'color',
                    'output'    => array('.tx-single-portfolio-btn:hover'),
                    'title'    => esc_html__( 'Single Portfolio Button text hover color', 'avas' ),
                    'transparent' => false,
                    'validate'  => 'color',
                    'required'  => array( 'portfolio_post_type', '=', '1' ),
                ),
            array(
                    'id'       => 'single-portfolio-button-typo',
                    'type'     => 'typography',
                    'title'    => esc_html__( 'Single Portfolio Button Fonts', 'avas' ),
                    'google'   => true,
                    'font-backup' => false,
                    'output'      => array('.tx-single-portfolio-btn'),
                    'units'       =>'px',
                    'fonts' => $standard_fonts,
                    'font-style'  => true,
                    'all_styles'  => true,
                    'word-spacing'  => true,
                    'letter-spacing'=> true,
                    'text-transform'=> true,
                    'color'         => false,
                    'subsets'       => true,
                    'allow_empty_line_height' => true,
                    'required'  => array( 'portfolio_post_type', '=', '1' ),
                ),
            array(
                    'id'             => 'single-portfolio-button-padding',
                    'type'           => 'spacing',
                    'output'         => array('.tx-single-portfolio-btn'),
                    'mode'           => 'padding',
                    'units'          => array('px', 'em'),
                    'units_extended' => 'false',
                    'title'          => esc_html__('Single Portfolio Button Padding', 'avas'),
                    'required'  => array( 'portfolio_post_type', '=', '1' ),
                    'default'        => array (
                        'units'       => 'px'
                    )
                ),
            array(
                    'id'             => 'single-portfolio-button-margin',
                    'type'           => 'spacing',
                    'output'         => array('.tx-single-portfolio-btn'),
                    'mode'           => 'margin',
                    'units'          => array('px', 'em'),
                    'units_extended' => 'false',
                    'title'          => esc_html__('Single Portfolio Button Margin', 'avas'),
                    'required'  => array( 'portfolio_post_type', '=', '1' ),
                    'default'        => array (
                        'units'       => 'px'
                    )
                ),
            
            array(
                    'id'        => 'portfolio-colors-info',
                    'type'      => 'info',
                    'title'     => esc_html__('Portfolio Colors', 'avas'),
                    'style'     => 'success', //success warning
                    'required'  => array( 'portfolio_post_type', '=', '1' ),
                    ),
            array(
                    'id'       => 'portfolio-item-overlay-bg-color',
                    'type'     => 'color_rgba',
                    'output'    => array('background-color' => '.tx-port-overlay-content'),
                    'title'    => esc_html__( 'Portfolio Item overlay background color', 'avas' ),
                    'required'  => array( 'portfolio_post_type', '=', '1' ),
                ),
            array(
                    'id'       => 'portfolio-item-card-content-bg-color',
                    'type'     => 'color_rgba',
                    'output'    => array('background-color' => '.tx-port-card-content'),
                    'title'    => esc_html__( 'Portfolio Item card content background color', 'avas' ),
                    'required'  => array( 'portfolio_post_type', '=', '1' ),
                ),
            array(
                    'id'       => 'portfolio_item_title_color',
                    'type'     => 'color_rgba',
                    'output'    => array('color' => '.tx-port-title'),
                    'title'    => esc_html__( 'Portfolio Item Title Color', 'avas' ),
                    'required'  => array( 'portfolio_post_type', '=', '1' ),
                ),
            array(
                    'id'       => 'portfolio_item_title_hov_color',
                    'type'     => 'color_rgba',
                    'output'    => array('color' => '.tx-port-title:hover'),
                    'title'    => esc_html__( 'Portfolio Item Title Hover Color', 'avas' ),
                    'required'  => array( 'portfolio_post_type', '=', '1' ),
                ),
            array(
                    'id'       => 'portfolio_item_excerpt_color',
                    'type'     => 'color_rgba',
                    'output'    => array('color' => '.tx-port-excp'),
                    'title'    => esc_html__( 'Portfolio Item Excerpt Color', 'avas' ),
                    'required'  => array( 'portfolio_post_type', '=', '1' ),
                ),
            array(
                    'id'       => 'portfolio_item_cat_color',
                    'type'     => 'color_rgba',
                    'output'    => array('color' => '.tx-port-cat a', 'border-color' => '.tx-port-cat'),
                    'title'    => esc_html__( 'Portfolio Item Category Color', 'avas' ),
                    'required'  => array( 'portfolio_post_type', '=', '1' ),
                ),
            array(
                    'id'       => 'portfolio_item_cat_hov_color',
                    'type'     => 'color_rgba',
                    'output'    => array('color' => '.tx-port-cat:hover a', 'border-color' => '.tx-port-cat:hover'),
                    'title'    => esc_html__( 'Portfolio Item Category Hover Color', 'avas' ),
                    'required'  => array( 'portfolio_post_type', '=', '1' ),
                ),
            array(
                    'id'       => 'portfolio_item_popup_icon_bg_color',
                    'type'     => 'color_rgba',
                    'output'    => array('background-color' => '.tx-port-enlarge'),
                    'title'    => esc_html__( 'Portfolio Item Popup Icon Background Color', 'avas' ),
                    'required'  => array( 'portfolio_post_type', '=', '1' ),
                ),
            array(
                    'id'       => 'portfolio_item_popup_icon_color',
                    'type'     => 'color_rgba',
                    'output'    => array('color' => '.tx-port-enlarge i'),
                    'title'    => esc_html__( 'Portfolio Item Popup Icon Color', 'avas' ),
                    'required'  => array( 'portfolio_post_type', '=', '1' ),
                ),
            array(
                    'id'       => 'portfolio_item_popup_icon_hover_color',
                    'type'     => 'color_rgba',
                    'output'    => array('color' => '.tx-port-enlarge:hover i'),
                    'title'    => esc_html__( 'Portfolio Item Popup Icon Hover Color', 'avas' ),
                    'required'  => array( 'portfolio_post_type', '=', '1' ),
                ),
            array(
                    'id'       => 'portfolio_item_link_icon_bg_color',
                    'type'     => 'color_rgba',
                    'output'    => array('background-color' => '.tx-port-link'),
                    'title'    => esc_html__( 'Portfolio Item Link Icon Background Color', 'avas' ),
                    'required'  => array( 'portfolio_post_type', '=', '1' ),
                ),
            array(
                    'id'       => 'portfolio_item_link_icon_color',
                    'type'     => 'color_rgba',
                    'output'    => array('color' => '.tx-port-link i'),
                    'title'    => esc_html__( 'Portfolio Item Link Icon Color', 'avas' ),
                    'required'  => array( 'portfolio_post_type', '=', '1' ),
                ),
            array(
                    'id'       => 'portfolio_item_link_icon_hov_color',
                    'type'     => 'color_rgba',
                    'output'    => array('color' => '.tx-port-link:hover i'),
                    'title'    => esc_html__( 'Portfolio Item Link Icon Hover Color', 'avas' ),
                    'required'  => array( 'portfolio_post_type', '=', '1' ),
                ),
            array(
                    'id'       => 'portfolio-project-details-bg-color',
                    'type'     => 'color',
                    'output'    => array('background-color' => '.project-table tbody'),
                    'title'    => esc_html__( 'Single Portfolio Project Details Table background color', 'avas' ),
                    'transparent' => false,
                    'validate'  => 'color',
                    'required'  => array( 'portfolio_post_type', '=', '1' ),
                ),
            array(
                    'id'       => 'portfolio-project-details-br-color',
                    'type'     => 'color',
                    'output'    => array('border-color' => '.project-table tr td'),
                    'title'    => esc_html__( 'Single Portfolio Project Details Table border color', 'avas' ),
                    'transparent' => false,
                    'validate'  => 'color',
                    'required'  => array( 'portfolio_post_type', '=', '1' ),
                ),
            array(
                    'id'       => 'portfolio-project-completion-progressbar-color',
                    'type'     => 'color',
                    'output'    => array('background-color' => '.single-portfolio .progress-bar'),
                    'title'    => esc_html__( 'Single Portfolio Project Completion Progress Bar color', 'avas' ),
                    'transparent' => false,
                    'validate'  => 'color',
                    'required'  => array( 'portfolio_post_type', '=', '1' ),
                ),
            
            )));
    // Team options
    Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Team', 'avas' ),
        'id'         => 'team',
        'icon'       => 'bi bi-person',
        'fields'     => array(
            array(
                'id'      => 'team_post_type',
                'title'    => esc_html__('Team Post Type','avas'),
                'desc'    => esc_html__('After Save Changes please refresh the page.','avas'),
                'type'    => 'switch',
                'on'      => esc_html__('Enable','avas'),
                'off'     => esc_html__('Disable','avas'),
                'default' => 1,
                ),
            array(
                    'id'        => 'team_title',
                    'type'      => 'text',
                    'title'     => esc_html__('Team Name', 'avas'),
                    'description' => esc_html__('Team menu and archive page title will be changed. After Save Changes please refresh the page.', 'avas'),
                    'default'   => 'Team',
                    'required'  => array( 'team_post_type', '=', '1' ),
                    ),
            array(
                    'id'        => 'team-slug',
                    'type'      => 'text',
                    'title'     => esc_html__('Team slug / Permalink', 'avas'),
                    'description' => esc_html__('After change go to Settings > Permalinks and click Save changes.', 'avas'),
                    'default'   => 'team',
                    'required'  => array( 'team_post_type', '=', '1' ),
                ),
            array(
                    'id'        => 'team-cat-slug',
                    'type'      => 'text',
                    'title'     => esc_html__('Team category slug / Permalink', 'avas'),
                    'description' => esc_html__('After change go to Settings > Permalinks and click Save changes.', 'avas'),
                    'default'   => 'team-category',
                    'required'  => array( 'team_post_type', '=', '1' ),
                ),
            array(
                    'id'        => 'team_archive_setting-info',
                    'type'      => 'info',
                    'title'     => esc_html__('Team Archive Settings', 'avas'),
                    'style'     => 'success', //success warning
                    'required'  => array( 'team_post_type', '=', '1' ),
            ),
            array(
                'id'       => 'team_archive_display',
                'type'     => 'select',
                'title'    => esc_html__('Team Style Display', 'avas'), 
                'options'  => array(
                    'grid_t' => esc_html__('Grid', 'avas'),
                    'card_t' => esc_html__('Card', 'avas'),
                ),
                'default'  => 'grid_t',
                'required'  => array( 'team_post_type', '=', '1' ),
            ),
            array(
                'id'       => 'team_archive_category',
                'title'    => esc_html__('Team Archive Category', 'avas'), 
                'type'    => 'switch',
                'on'      => esc_html__('Show','avas'),
                'off'     => esc_html__('Hide','avas'),
                'default' => 1,
                'required'  => array( 'team_post_type', '=', '1' ),
            ),
            array(
                'id'       => 'team_archive_title',
                'title'    => esc_html__('Team Archive Title', 'avas'), 
                'type'    => 'switch',
                'on'      => esc_html__('Show','avas'),
                'off'     => esc_html__('Hide','avas'),
                'default' => 1,
                'required'  => array( 'team_post_type', '=', '1' ),
            ),
            array(
                'id'       => 'team_archive_excerpt',
                'title'    => esc_html__('Team Archive Excerpt', 'avas'), 
                'type'    => 'switch',
                'on'      => esc_html__('Show','avas'),
                'off'     => esc_html__('Hide','avas'),
                'default' => 1,
                'required'  => array( 'team_post_type', '=', '1' ),
            ),
            array(
                'id'       => 'team_archive_social_profiles',
                'title'    => esc_html__('Team Archive Social Profiles', 'avas'), 
                'type'    => 'switch',
                'on'      => esc_html__('Show','avas'),
                'off'     => esc_html__('Hide','avas'),
                'default' => 1,
                'required'  => array( 'team_post_type', '=', '1' ),
            ),
            array(
                'id'            => 'team_archive_per_page',
                'type'          => 'slider',
                'title'         => esc_html__( 'Team Archive per page', 'avas' ),
                'default'       => 12,
                'min'           => -1,
                'step'          => 1,
                'max'           => 99,
                'display_value' => 'text',
                'required'  => array( 'team_post_type', '=', '1' ),
            ),
            array(
                    'id'        => 'single_team_setting-info',
                    'type'      => 'info',
                    'title'     => esc_html__('Single Team Settings', 'avas'),
                    'style'     => 'success', //success warning
                    'required'  => array( 'team_post_type', '=', '1' ),
            ),        
            array(
                'id'          => 'team-profile-skill-bar-color',
                'type'        => 'color',
                'output'      => array('background-color' => '.team-skills .progress-bar'),
                'title'       => esc_html__( 'Single Team Skill Bar color', 'avas' ),
                'transparent' => false,
                'validate'    => 'color',
                'required'  => array( 'team_post_type', '=', '1' ),
            ),
            array(
                'id'      => 'project_experience',
                'title'   => esc_html__('Single Team Project Experience','avas'),
                'type'    => 'switch',
                'on'      => esc_html__('On','avas'),
                'off'     => esc_html__('Off','avas'),
                'default' => 1,
                'required'  => array( 'team_post_type', '=', '1' ),
                ),
            array(
                'id'        => 'project_experience_title',
                'type'      => 'text',
                'title'     => esc_html__('Single Team Project Experience Title', 'avas'),
                'default'   => esc_html__('Project Experience','avas'),
                'required'  => array( 'project_experience', '=', '1' ),
                ),
            array(
                'id'            => 'project-exp-count',
                'type'          => 'slider',
                'title'         => esc_html__( 'Single Team Project Display', 'avas' ),
                'default'       => 8,
                'min'           => 4,
                'step'          => 1,
                'max'           => 100,
                'display_value' => 'text',
                'required'  => array( 'project_experience', '=', '1' ),
            ),
            array(
                    'id'       => 'team-project-overlay-bg-color',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Single Team Project Image Overlay Color', 'avas' ),
                    'output'   => array('background-color' => '.project-carousel figcaption'),
                    'transparent' => false,
                    'validate' => 'color',
                    'required'  => array( 'project_experience', '=', '1' ),
                ),
            array(
                'id'      => 'team_social_profile',
                'title'   => esc_html__('Single Team Social Profile','avas'),
                'type'    => 'switch',
                'on'      => esc_html__('On','avas'),
                'off'     => esc_html__('Off','avas'),
                'default' => 1,
                'required'  => array( 'team_post_type', '=', '1' ),
                ),
            array(
               'id'       => 'team-profile-pic-border',
                'type'     => 'border',
                'title'    => esc_html__('Single Team Profile Picture Border', 'avas'),
                'desc'     => esc_html__( 'Enter border width, example 1, 2, 3 etc to enable border', 'avas' ),
                'output'   => array('.team-single-left img'),
                'color' => true,
                'default'  => array(
                    'border-color'  => '#dfdfdf', 
                    'border-style'  => 'solid', 
                    'border-top' => '0px',
                    'border-bottom' => '0px',
                    'border-left' => '0px',
                    'border-right' => '0px',
                ),
                'required'  => array( 'team_post_type', '=', '1' ),
                ),
            array(
               'id'       => 'team-hire-border',
                'type'     => 'border',
                'title'    => esc_html__('Single Team Button Border', 'avas'),
                'desc'     => esc_html__( 'Enter border width, example 1, 2, 3 etc to enable border', 'avas' ),
                'output'   => array('.single-team .hire_me'),
                'color' => true,
                'default'  => array(
                    'border-color'  => '#fff', 
                    'border-style'  => 'solid', 
                ),
                'required'  => array( 'team_post_type', '=', '1' ),
                ),
            
            array(
                'id'        => 'team-color-settings',
                'type'      => 'info',
                'title'     => esc_html__('Team Color Settings', 'avas'),
                'style'     => 'success',
                'required'  => array( 'team_post_type', '=', '1' ),
            ),
            array(
                    'id'       => 'team-overlay-bg-color',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Team Image Overlay Background Color', 'avas' ),
                    'output'   => array('background-color' => '.team figcaption'),
                    'transparent' => false,
                    'validate' => 'color',
                    'required'  => array( 'team_display', '=', 'grid_t' ),
                ),
            array(
                    'id'       => 'team-card-bg-color',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Team Card Background Color', 'avas' ),
                    'output'   => array('background-color' => '.tx-team-card'),
                    'transparent' => false,
                    'validate' => 'color',
                    'required'  => array( 'team_display', '=', 'card_t' ),
                ),
            array(
                'id'          => 'team-name-color',
                'type'        => 'color',
                'output'      => array('color' => '.team figcaption h4 a, .tx-team-card h4 a'),
                'title'       => esc_html__( 'Team Name Color', 'avas' ),
                'transparent' => false,
                'validate'    => 'color',
                'required'  => array( 'team_post_type', '=', '1' ),
            ),
            array(
                'id'          => 'team-name-hov-color',
                'type'        => 'color',
                'output'      => array('color' => '.team figcaption h4 a:hover, .tx-team-card:hover h4 a'),
                'title'       => esc_html__( 'Team Name Hover Color', 'avas' ),
                'transparent' => false,
                'validate'    => 'color',
                'required'  => array( 'team_post_type', '=', '1' ),
            ),
            array(
                'id'          => 'team-cat-color',
                'type'        => 'color',
                'output'      => array('color' => '.team .team-cat a, .team-cat, .team-cat a'),
                'title'       => esc_html__( 'Team Position Color', 'avas' ),
                'desc'       => esc_html__( 'Formaly Category Color', 'avas' ),
                'transparent' => false,
                'validate'    => 'color',
                'required'  => array( 'team_post_type', '=', '1' ),
            ),
            array(
                'id'          => 'team-cat-hov-color',
                'type'        => 'color',
                'output'      => array('color' => '.team .team-cat a:hover, .team .team-cat a:focus, .team-cat a:hover'),
                'title'       => esc_html__( 'Team Position Hover Color', 'avas' ),
                'desc'       => esc_html__( 'Formaly Category Hover Color', 'avas' ),
                'transparent' => false,
                'validate'    => 'color',
                'required'  => array( 'team_post_type', '=', '1' ),
            ),
            array(
                'id'          => 'team-bio-color',
                'type'        => 'color',
                'output'      => array('color' => '.team .team-bio'),
                'title'       => esc_html__( 'Team Bio Color', 'avas' ),
                'transparent' => false,
                'validate'    => 'color',
                'required'  => array( 'team_post_type', '=', '1' ),
            ),
            array(
                'id'          => 'team-social-icon-color',
                'type'        => 'color',
                'output'      => array(
                    'color' => '.team-social i, .team.card_t .team-social i',
                    'border-color' => '.team-social li, .team.card_t .team-social li'
                ),
                'title'       => esc_html__( 'Team Social Icon Color', 'avas' ),
                'transparent' => false,
                'validate'    => 'color',
                'required'  => array( 'team_post_type', '=', '1' ),
            ),
            array(
                'id'          => 'team-social-icon-hov-color',
                'type'        => 'color',
                'output'      => array(
                    'color' => '.team-social li:hover i, .team.card_t .team-social li:hover i',
                    'border-color' => '.team-social li:hover, .team.card_t .team-social li:hover'
                ),
                'title'       => esc_html__( 'Team Social Icon Hover Color', 'avas' ),
                'transparent' => false,
                'validate'    => 'color',
                'required'  => array( 'team_post_type', '=', '1' ),
            ),
            array(
                'id'        => 'team-single-color-settings',
                'type'      => 'info',
                'title'     => esc_html__('Single Team Profile Color Settings', 'avas'),
                'style'     => 'success',
                'required'  => array( 'team_post_type', '=', '1' ),
            ),
            array(
                'id'          => 'team-profile-pic-bg-color',
                'type'        => 'color',
                'output'      => array('background-color' => '.team_profile'),
                'title'       => esc_html__( 'Single Team Picture underneath background color', 'avas' ),
                'transparent' => false,
                'validate'    => 'color',
                'required'  => array( 'team_post_type', '=', '1' ),
            ),
            array(
                'id'          => 'team-profile-button-color',
                'type'        => 'color',
                'output'      => array(
                    'color' => '.hire_me',
                    'border-color' => '.hire_me',
                ),
                'title'       => esc_html__( 'Single Team Button color', 'avas' ),
                'transparent' => false,
                'validate'    => 'color',
                'required'  => array( 'team_post_type', '=', '1' ),
            ),
            array(
                'id'          => 'team-profile-button-hov-color',
                'type'        => 'color',
                'output'      => array(
                    'color' => '.hire_me:hover',
                    'border-color' => '.hire_me:hover',
                ),
                'title'       => esc_html__( 'Single Team Button hover color', 'avas' ),
                'transparent' => false,
                'validate'    => 'color',
                'required'  => array( 'team_post_type', '=', '1' ),
            ),

            )));
    
    if(class_exists('LearnPress')) :
    // -> START LearnPress options
    Redux::setSection( $opt_name, array(
        'title'     => esc_html__( 'LearnPress Courses','avas' ),
        'id'        => 'learnpress',
        'icon'      => 'fas fa-user-graduate',
        'fields'    => array(
            array(
                'id'      => 'lp_search',
                'title'   => esc_html__('LearnPress Courses Page Search Bar','avas'),
                'type'    => 'switch',
                'on'      => esc_html__('Show','avas'),
                'off'     => esc_html__('Hide','avas'),
                'default' => 1,
            ),
            array(
                'id'      => 'lp_layout',
                'title'   => esc_html__('LearnPress Courses Layout Switch','avas'),
                'type'    => 'switch',
                'on'      => esc_html__('Show','avas'),
                'off'     => esc_html__('Hide','avas'),
                'default' => 1,
            ),
            array(
                'id'            => 'lp_course_min_height',
                'type'          => 'slider',
                'title'         => esc_html__( 'LearnPress Course minimum height', 'avas' ),
                'min'           => 0,
                'step'          => 1,
                'max'           => 350,
                'display_value' => 'text',
            ),
            array(
                'id'          => 'lp-course-price',
                'type'        => 'color',
                'output'      => array('background-color' => '.lp-course-price'),
                'title'       => esc_html__( 'LearnPress Course Price background color', 'avas' ),
                'transparent' => false,
                'validate'    => 'color',
            ),
            array(
                'id'          => 'lp-course-price-color',
                'type'        => 'color',
                'output'      => array('color' => '.lp-course-price'),
                'title'       => esc_html__( 'LearnPress Course Price color', 'avas' ),
                'transparent' => false,
                'validate'    => 'color',
            ),
            array(
                'id'          => 'lp-course-reg-price-color',
                'type'        => 'color',
                'output'      => array('color' => '.lp-course-price .origin-price'),
                'title'       => esc_html__( 'LearnPress Course Regular Price color', 'avas' ),
                'transparent' => false,
                'validate'    => 'color',
            ),
             array(
                'id'          => 'lp-course-featured-badge-bg-color',
                'type'        => 'color',
                'output'      => array('background' => '.lp-badge.featured-course'),
                'title'       => esc_html__( 'LearnPress Course Featured Badge background color', 'avas' ),
                'transparent' => false,
                'validate'    => 'color',
            ),
            array(
                'id'          => 'lp-course-title-color',
                'type'        => 'color',
                'output'      => array('color' => '.course-title a'),
                'title'       => esc_html__( 'LearnPress Course Title color', 'avas' ),
                'transparent' => false,
                'validate'    => 'color',
            ),
            array(
                'id'          => 'lp-course-title-hover-color',
                'type'        => 'color',
                'output'      => array('color' => '.course-title a:hover'),
                'title'       => esc_html__( 'LearnPress Course Title hover color', 'avas' ),
                'transparent' => false,
                'validate'    => 'color',
            ),
            array(
                'id'          => 'lp-course-sep-color',
                'type'        => 'color',
                'output'      => array('border-color' => '.type-lp_course:hover .edu-course-footer'),
                'title'       => esc_html__( 'LearnPress Course footer separator color', 'avas' ),
                'transparent' => false,
                'validate'    => 'color',
            ),
            array(
                'id'          => 'lp-single-course-btn-bg-color',
                'type'        => 'color',
                'output'      => array('background-color' => '.single-lp_course form[name="purchase-course"] .button-purchase-course, .single-lp_course form[name="enroll-course"] .lp-button'),
                'title'       => esc_html__( 'LearnPress Single Course Button BG color', 'avas' ),
                'transparent' => false,
                'validate'    => 'color',
            ),
            array(
                'id'          => 'lp-single-course-btn-bg-hov-color',
                'type'        => 'color',
                'output'      => array('background-color' => '.single-lp_course form[name="purchase-course"] .button-purchase-course:hover, .single-lp_course form[name="enroll-course"] .lp-button:hover'),
                'title'       => esc_html__( 'LearnPress Single Course Button BG hover color', 'avas' ),
                'transparent' => false,
                'validate'    => 'color',
            ),
            array(
                'id'          => 'lp-single-course-related-title-bg-color',
                'type'        => 'color',
                'output'      => array('background-color' => '.edu-ralated-course .related-title'),
                'title'       => esc_html__( 'LearnPress Single Course Related bar BG color', 'avas' ),
                'transparent' => false,
                'validate'    => 'color',
            ),
        )
    ));
    endif;

    if(class_exists('WooCommerce')) :
    // -> START Woocommerce options
    Redux::setSection( $opt_name, array(
        'title'     => esc_html__( 'WooCommerce','avas' ),
        'id'        => 'woocommerce',
        'icon'      => 'el el-shopping-cart',
        'fields'    => array(
            // cart icon options
                array(
                    'id'        => 'tx-cart',
                    'type'      => 'switch',
                    'title'     => esc_html__('Cart Icon', 'avas'),
                    'desc'     => esc_html__('Cart icon will display on header right side.', 'avas'),
                    'default'   => 0,
                    'on'        => 'On',
                    'off'       => 'Off',
                ),
                array(
                    'id'             => 'tx-cart_space',
                    'type'           => 'spacing',
                    'output'         => array('.tx-cart'),
                    'mode'           => 'margin',
                    'units'          => array('px', 'em'),
                    'units_extended' => false,
                    'title'          => esc_html__('Cart Space', 'avas'),
                    'required'  => array( 'tx-cart', '=', '1' ),
                    'default'        => array (
                        'units'       => 'px'
                    )
                ),
                array(
                    'id'       => 'tx-cart-icon-color',
                    'type'     => 'color',
                    'output'   => array( '.tx-cart' ),
                    'title'    => esc_html__( 'Cart icon color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'tx-cart', '=', '1' ),
                ),
                array(
                    'id'       => 'tx-cart-icon-hover-color',
                    'type'     => 'color',
                    'output'   => array( '.tx-cart:hover' ),
                    'title'    => esc_html__( 'Cart icon hover color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'tx-cart', '=', '1' ),
                ),
                array(
                    'id'       => 'tx-cart-icon-color-home',
                    'type'     => 'color',
                    'output'   => array( '.home .tx-cart' ),
                    'title'    => esc_html__( 'Cart icon color on Home Page', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'tx-cart', '=', '1' ),
                ),
                array(
                    'id'       => 'tx-cart-icon-hover-color-home',
                    'type'     => 'color',
                    'output'   => array( '.home .tx-cart:hover' ),
                    'title'    => esc_html__( 'Cart icon hover color on Home Page', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'tx-cart', '=', '1' ),
                ),
            // Wishlist option
                array(
                    'id'        => 'tx-wishlist',
                    'type'      => 'switch',
                    'title'     => esc_html__('Wishlist Icon', 'avas'),
                    'subtitle'  => esc_html__('Wishlist icon will display on header right side.', 'avas'),
                    'desc'      => esc_html__('"WPC Smart Wishlist for WooCommerce" plugin need to be installed & activated for this', 'avas'),
                    'default'   => 0,
                    'on'        => 'On',
                    'off'       => 'Off',
                ),
                array(
                    'id'             => 'tx-wishlist_space',
                    'type'           => 'spacing',
                    'output'         => array('.tx-whishlist-icon'),
                    'mode'           => 'margin',
                    'units'          => array('px', 'em'),
                    'units_extended' => false,
                    'title'          => esc_html__('Wishlist Space', 'avas'),
                    'required'  => array( 'tx-wishlist', '=', '1' ),
                    'default'        => array (
                        'units'       => 'px'
                    )
                ),
                array(
                    'id'       => 'tx-wishlist-icon-color',
                    'type'     => 'color',
                    'output'   => array( '.tx-whishlist-icon i' ),
                    'title'    => esc_html__( 'Wishlist icon color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'tx-wishlist', '=', '1' ),
                ),
                array(
                    'id'       => 'tx-wishlist-icon-hover-color',
                    'type'     => 'color',
                    'output'   => array( '.tx-whishlist-icon i:hover' ),
                    'title'    => esc_html__( 'Wishlist icon hover color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'tx-wishlist', '=', '1' ),
                ),
                array(
                    'id'       => 'tx-wishlist-icon-color-home',
                    'type'     => 'color',
                    'output'   => array( '.home .tx-whishlist-icon i' ),
                    'title'    => esc_html__( 'Wishlist icon color on Home Page', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'tx-wishlist', '=', '1' ),
                ),
                array(
                    'id'       => 'tx-wishlist-icon-hover-color-home',
                    'type'     => 'color',
                    'output'   => array( '.home .tx-whishlist-icon i:hover' ),
                    'title'    => esc_html__( 'Wishlist icon hover color on Home Page', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'tx-wishlist', '=', '1' ),
                ),    
            array(
                'id'            => 'woo-product-per-row',
                'type'          => 'slider',
                'title'         => esc_html__( 'WooCommerce Product per row', 'avas' ),
                'default'       => 3,
                'min'           => 1,
                'step'          => 1,
                'max'           => 6,
                'display_value' => 'text'
            ),
            // array(
            //     'id'            => 'woo-product-min-height',
            //     'type'          => 'slider',
            //     'title'         => esc_html__( 'WooCommerce Product Minimum Height', 'avas' ),
            //     'default'       => 335,
            //     'min'           => 1,
            //     'step'          => 1,
            //     'max'           => 1000,
            //     'display_value' => 'text'
            // ),
            array(
                'id'             => 'woo_product_space',
                'type'           => 'spacing',
                'output'         => array('.woocommerce ul.products li.product, .woocommerce-page ul.products li.product'),
                'mode'           => 'margin',
                'units'          => array('px', 'em'),
                'units_extended' => 'false',
                'title'          => esc_html__('WooCommerce Product Space', 'avas'),
                'default'            => array(
                    'units'          => 'px', 
                ),
            ),
            array(
                'id'            => 'woo-product-per-page',
                'type'          => 'slider',
                'title'         => esc_html__( 'WooCommerce Product per page', 'avas' ),
                'default'       => 12,
                'min'           => 1,
                'step'          => 1,
                'max'           => 99,
                'display_value' => 'text'
            ),
            array(
                'id'       => 'woo-product-bg-color',
                'type'     => 'color',
                'output'   => array( 'background-color' => '.woocommerce ul.products li.product, .woocommerce-page ul.products li.product' ),
                'title'    => esc_html__( 'WooCommerce Product background color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'woo-sidebar-select',
                'type'     => 'select',
                'title'    => esc_html__('WooCommerce Shop Sidebar', 'avas'), 
                'options'  => array(
                    'woo-sidebar-right' => esc_html__('Right Sidebar', 'avas'),
                    'woo-sidebar-left' => esc_html__('Left Sidebar', 'avas'),
                    'woo-sidebar-none' => esc_html__('No Sidebar', 'avas'),
                ),
                'default'  => 'woo-sidebar-right',
            ),
            array(
                'id'       => 'woo-single-sidebar-select',
                'type'     => 'select',
                'title'    => esc_html__('WooCommerce Single Product Sidebar', 'avas'), 
                'options'  => array(
                    'woo-single-sidebar-right' => esc_html__('Right Sidebar', 'avas'),
                    'woo-single-sidebar-left' => esc_html__('Left Sidebar', 'avas'),
                    'woo-single-sidebar-none' => esc_html__('No Sidebar', 'avas'),
                ),
                'default'  => 'woo-single-sidebar-right',
            ),
            array(
                'id'      => 'woo_number_result',
                'title'   => esc_html__('WooCommerce Product Display Result Count','avas'),
                'desc'   => esc_html__('Number of product result in shop page','avas'),
                'type'    => 'switch',
                'on'      => esc_html__('Show','avas'),
                'off'     => esc_html__('Hide','avas'),
                'default' => 0,
            ),
            array(
                'id'      => 'woo_default_sorting_dropdown',
                'title'   => esc_html__('WooCommerce Product Display Ordering','avas'),
                'desc'   => esc_html__('WooCommerce Product Default sorting dropdown in shop page','avas'),
                'type'    => 'switch',
                'on'      => esc_html__('Show','avas'),
                'off'     => esc_html__('Hide','avas'),
                'default' => 0,
            ),
            array(
                    'id'       => 'prod-title-alignment',
                    'type'     => 'select',
                    'title' => esc_html__('WooCommerce Product Title Alignment', 'avas'),
                    'options'  => array(
                        'left'  => esc_html__('Left','avas'),
                        'center'  => esc_html__('Center','avas'),
                        'right'  => esc_html__('Right','avas'),
                    ),
                    'default'  => 'left',
                ),
            // New badge options
            array(
                    'id'        => 'new_badge_options',
                    'type'      => 'info',
                    'title'     => esc_html__('New Badge Options', 'avas'),
                    'style'     => 'success', //success warning
                ),
            array(
                'id'      => 'woo-new-badge',
                'title'   => esc_html__('WooCommerce Product display New Badge','avas'),
                'desc'    => esc_html__('Show New badge on product in shop page','avas'),
                'type'    => 'switch',
                'on'      => esc_html__('Show','avas'),
                'off'     => esc_html__('Hide','avas'),
                'default' => 1,
            ),
            array(
                'id'       => 'woo-new-badge-text',
                'type'     => 'text',
                'title'    => esc_html__('New badge text on catalog','avas'),
                'default'  => 'New',
                'required'  => array( 'woo-new-badge', '=', '1' ),
            ),
            array(
                'id'            => 'woo-new-badge-days',
                'type'          => 'slider',
                'title'         => esc_html__( 'WooCommerce Product New badge display for days', 'avas' ),
                'default'       => 7,
                'min'           => 1,
                'step'          => 1,
                'max'           => 60,
                'display_value' => 'text',
                'required'  => array( 'woo-new-badge', '=', '1' ),
            ),
            array(
                'id'       => 'woo-new-badge-bg-color',
                'type'     => 'color',
                'output'   => array( 'background-color' => '.tx_wc_new_inner', 'border-top-color' => '.tx_wc_new:before' ),
                'title'    => esc_html__( 'WooCommerce Product New badge background color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
                'required' => array( 'woo-new-badge', '=', '1' ),
            ),
            array(
                'id'       => 'woo-new-badge-text-color',
                'type'     => 'color',
                'output'   => array( 'color' => '.tx_wc_new_inner' ),
                'title'    => esc_html__( 'WooCommerce Product New badge text color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
                'required' => array( 'woo-new-badge', '=', '1' ),
            ),
            array(
                    'id'       => 'woo-new-badge-fonts',
                    'type'     => 'typography',
                    'title'    => esc_html__( 'WooCommerce Product New badge font', 'avas' ),
                    'google'   => true,
                    'font-backup' => false,
                    'output'      => array('.tx_wc_new_inner'),
                    'units'       =>'px',
                    'fonts' => $standard_fonts,
                    'font-style'  => true,
                    'all_styles'  => true,
                    'word-spacing'  => true,
                    'letter-spacing'=> true,
                    'text-transform'=> true,
                    'color'         => false,
                    'subsets'       => true,
                    'allow_empty_line_height' => true,
                    'required' => array( 'woo-new-badge', '=', '1' ),
                ),
            // sale badge
            array(
                    'id'        => 'sale_badge_options',
                    'type'      => 'info',
                    'title'     => esc_html__('Sale Badge Options', 'avas'),
                    'style'     => 'success', //success warning
                ),
            array(
                'id'       => 'woo-sale-badge-text',
                'type'     => 'text',
                'title'    => esc_html__('Sale badge text','avas'),
                'default'  => 'Sale',
                ),
            array(
                'id'       => 'woo-sale-badge-bg-color',
                'type'     => 'color',
                'output'   => array( 'background-color' => '.tx_wc_sale_inner', 'border-top-color' => '.tx_wc_sale:before' ),
                'title'    => esc_html__( 'WooCommerce Product Sale badge background color', 'avas' ),
                'validate' => 'color',
                'transparent' => true,
            ),
            array(
                'id'       => 'woo-sale-badge-text-color',
                'type'     => 'color',
                'output'   => array( 'color' => '.tx_wc_sale_inner' ),
                'title'    => esc_html__( 'WooCommerce Product Sale badge text color', 'avas' ),
                'validate' => 'color',
                'transparent' => true,
            ),
            array(
                    'id'       => 'woo-sale-badge-fonts',
                    'type'     => 'typography',
                    'title'    => esc_html__( 'WooCommerce Product Sale badge font', 'avas' ),
                    'google'   => true,
                    'font-backup' => false,
                    'output'      => array('.tx_wc_sale_inner'),
                    'units'       =>'px',
                    'fonts' => $standard_fonts,
                    'font-style'  => true,
                    'all_styles'  => true,
                    'word-spacing'  => true,
                    'letter-spacing'=> true,
                    'text-transform'=> true,
                    'color'         => false,
                    'subsets'       => true,
                    'allow_empty_line_height' => true,
            ),
            // Featured badge
            array(
                    'id'        => 'featured_badge_options',
                    'type'      => 'info',
                    'title'     => esc_html__('Featured Badge Options', 'avas'),
                    'style'     => 'success', //success warning
                ),
            array(
                'id'       => 'woo-featured-badge-text',
                'type'     => 'text',
                'title'    => esc_html__('Featured badge text','avas'),
                'default'  => 'Featured',
                ),
            array(
                'id'       => 'woo-featured-badge-bg-color',
                'type'     => 'color',
                'output'   => array( 'background-color' => '.tx_wc_featured_inner','border-top-color' => '.tx_wc_featured:before' ),
                'title'    => esc_html__( 'WooCommerce Product Featured badge background color', 'avas' ),
                'validate' => 'color',
                'transparent' => true,
            ),
            array(
                'id'       => 'woo-featured-badge-text-color',
                'type'     => 'color',
                'output'   => array( 'color' => '.tx_wc_featured_inner' ),
                'title'    => esc_html__( 'WooCommerce Product Featured badge text color', 'avas' ),
                'validate' => 'color',
                'transparent' => true,
            ),
            array(
                'id'       => 'woo-featured-badge-fonts',
                'type'     => 'typography',
                'title'    => esc_html__( 'WooCommerce Product Featured badge font', 'avas' ),
                'google'   => true,
                'font-backup' => false,
                'output'      => array('.tx_wc_featured_inner'),
                'units'       =>'px',
                'fonts' => $standard_fonts,
                'font-style'  => true,
                'all_styles'  => true,
                'word-spacing'  => true,
                'letter-spacing'=> true,
                'text-transform'=> true,
                'color'         => false,
                'subsets'       => true,
                'allow_empty_line_height' => true,
            ),

            // Sold Out badge
            array(
                    'id'        => 'soldout_badge_options',
                    'type'      => 'info',
                    'title'     => esc_html__('Sold Out Badge Options', 'avas'),
                    'style'     => 'success', //success warning
                ),
            array(
                'id'       => 'woo-soldout-badge-text',
                'type'     => 'text',
                'title'    => esc_html__('Sold Out badge text','avas'),
                'default'  => 'Sold Out',
                ),
            array(
                'id'       => 'woo-soldout-badge-bg-color',
                'type'     => 'color',
                'output'   => array( 'background-color' => '.tx_wc_soldout_inner','border-top-color' => '.tx_wc_soldout:before' ),
                'title'    => esc_html__( 'WooCommerce Product Sold Out badge background color', 'avas' ),
                'validate' => 'color',
                'transparent' => true,
            ),
            array(
                'id'       => 'woo-soldout-badge-text-color',
                'type'     => 'color',
                'output'   => array( 'color' => '.tx_wc_soldout_inner' ),
                'title'    => esc_html__( 'WooCommerce Product Sold Out badge text color', 'avas' ),
                'validate' => 'color',
                'transparent' => true,
            ),
            array(
                'id'       => 'woo-soldout-badge-fonts',
                'type'     => 'typography',
                'title'    => esc_html__( 'WooCommerce Product Sold Out badge font', 'avas' ),
                'google'   => true,
                'font-backup' => false,
                'output'      => array('.tx_wc_soldout_inner'),
                'units'       =>'px',
                'fonts' => $standard_fonts,
                'font-style'  => true,
                'all_styles'  => true,
                'word-spacing'  => true,
                'letter-spacing'=> true,
                'text-transform'=> true,
                'color'         => false,
                'subsets'       => true,
                'allow_empty_line_height' => true,
            ),
            array(
                'id'       => 'woo-readmore-text',
                'type'     => 'text',
                'title'    => esc_html__('Sold Out button text on catalog','avas'),
                'desc'    => esc_html__('When a product is out of stock and mouse over to show the "Sold Out" text that you can change here.','avas'),
                'default'  => 'Sold Out',
                ),
            array(
                'id'       => 'woo-outofstock-text',
                'type'     => 'text',
                'title'    => esc_html__('Sold Out text on single product','avas'),
                'desc'    => esc_html__('Single product "Sold Out" text that you can change here.','avas'),
                'default'  => 'Sold Out',
                ),
            // Product colors settings
            array(
                'id'        => 'woo_prodcutsion_color_settings',
                'type'      => 'info',
                'title'     => esc_html__('WooCommerce Product colors settings', 'avas'),
                'style'     => 'success',
                ),    
            array(
                'id'       => 'woo-prod-name-color',
                'type'     => 'color',
                'output'   => array( 'color' => '.woocommerce-loop-product__title' ),
                'title'    => esc_html__( 'WooCommerce Product name color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'woo-product-addtocart-color',
                'type'     => 'color',
                'output'   => array( 'color' => '.woocommerce ul.products li.product .button' ),
                'title'    => esc_html__( 'WooCommerce Product hover Add to Cart text color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'woo-product-addtocart-hov-color',
                'type'     => 'color',
                'output'   => array( 'color' => '.woocommerce ul.products li.product .button:hover' ),
                'title'    => esc_html__( 'WooCommerce Product hover Add to Cart text hover color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'woo-product-addtocart-bg-color',
                'type'     => 'color',
                'output'   => array( 'background-color' => '.woocommerce ul.products li.product .button' ),
                'title'    => esc_html__( 'WooCommerce Product hover Add to Cart text background color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'woo-prod-name-fonts',
                'type'     => 'typography',
                'title'    => esc_html__( 'WooCommerce Product name font', 'avas' ),
                'google'   => true,
                'font-backup' => false,
                'output'      => array('.woocommerce ul.products li.product .woocommerce-loop-product__title'),
                'units'       =>'px',
                'fonts' => $standard_fonts,
                'font-style'  => true,
                'all_styles'  => true,
                'word-spacing'  => true,
                'letter-spacing'=> true,
                'text-transform'=> true,
                'color'         => false,
                'subsets'       => true,
                'allow_empty_line_height' => true,
            ),
            array(
                'id'       => 'woo-prod-addtocart-fonts',
                'type'     => 'typography',
                'title'    => esc_html__( 'WooCommerce Product hover Add to Cart font', 'avas' ),
                'google'   => true,
                'font-backup' => false,
                'output'      => array('.woocommerce ul.products li.product .button'),
                'units'       =>'px',
                'fonts' => $standard_fonts,
                'font-style'  => true,
                'all_styles'  => true,
                'word-spacing'  => true,
                'letter-spacing'=> true,
                'text-transform'=> true,
                'color'         => false,
                'subsets'       => true,
                'allow_empty_line_height' => true,
            ),
            array(
                'id'       => 'woo-prod-price-color',
                'type'     => 'color',
                'output'   => array( 'color' => '.woocommerce ul.products li.product .price' ),
                'title'    => esc_html__( 'WooCommerce Product price color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'woo-prod-reg-price-color',
                'type'     => 'color',
                'output'   => array( 'color' => '.woocommerce ul.products li.product .price del' ),
                'title'    => esc_html__( 'WooCommerce Product regular price color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            // cart settings
            array(
                'id'        => 'woo_cart_checkout_color_settings',
                'type'      => 'info',
                'title'     => esc_html__('WooCommerce Cart & Checkout page colors settings', 'avas'),
                'style'     => 'success',
            ),
            array(
                'id'       => 'woo-cart-page-button-color',
                'type'     => 'color',
                'output'   => array( 'background-color' => '.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce button.button.alt.disabled, .woocommerce button.button.alt.disabled:hover, .woocommerce input.button.alt' ),
                'title'    => esc_html__( 'WooCommerce Cart & Checkout Page Button BG color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'woo-cart-page-button-hov-color',
                'type'     => 'color',
                'output'   => array( 'background-color' => '.woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover' ),
                'title'    => esc_html__( 'WooCommerce Cart & Checkout Page Button BG hover color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'woo-cart-checkout-page-border-color',
                'type'     => 'color',
                'output'   => array( 'border-color' => '.woocommerce-info, .woocommerce-message', 'color' => '.woocommerce-info::before, .woocommerce-message::before' ),
                'title'    => esc_html__( 'WooCommerce Cart & Checkout Page border line color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
        )
        ));
    endif; // check woocommerce plugin installed or not

    if(class_exists('Estatik')) :
    // -> START Estatik options / Real Estate
        Redux::setSection( $opt_name, array(
            'title'     => esc_html__( 'Estatik / Real Estate','avas' ),
            'id'        => 'estatik',
            'icon'      => ' bi bi-house-door',
            'fields'    => array(
                array(
                    'id'       => 'estatik-sidebar-select',
                    'type'     => 'select',
                    'title'    => esc_html__('Estatik Real Estate Propety Page Sidebar', 'avas'), 
                    'options'  => array(
                        'estatik-sidebar-right' => esc_html__('Right Sidebar', 'avas'),
                        'estatik-sidebar-left' => esc_html__('Left Sidebar', 'avas'),
                        'estatik-sidebar-none' => esc_html__('No Sidebar', 'avas'),
                    ),
                    'default'  => 'estatik-sidebar-right',
                ),
                array(
                    'id'       => 'estatik-single-sidebar-select',
                    'type'     => 'select',
                    'title'    => esc_html__('Estatik Real Estate Single Propety Page Sidebar', 'avas'), 
                    'options'  => array(
                        'estatik-single-sidebar-right' => esc_html__('Right Sidebar', 'avas'),
                        'estatik-single-sidebar-left' => esc_html__('Left Sidebar', 'avas'),
                        'estatik-single-sidebar-none' => esc_html__('No Sidebar', 'avas'),
                    ),
                    'default'  => 'estatik-single-sidebar-right',
                ),

        )));
    endif; // check Estatik plugin installed or not

    if(class_exists('Tribe__Events__Main')) :
    // -> START Events options / The Events Calendar
        Redux::setSection( $opt_name, array(
            'title'     => esc_html__( 'Events','avas' ),
            'id'        => 'events',
            'icon'      => 'bi bi-calendar4-event',
            'fields'    => array(
                array(
                    'id'       => 'find_events_button_bg_color',
                    'type'     => 'color',
                    'output'   => array( 'background-color' => '.tribe-events .tribe-events-c-search__button, .tribe-events button.tribe-events-c-search__button' ),
                    'title'    => esc_html__( 'Find Events button background color ', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'find_events_button_bg_hov_color',
                    'type'     => 'color',
                    'output'   => array( 'background-color' => '.tribe-events .tribe-events-c-search__button:hover,.tribe-events button.tribe-events-c-search__button:hover' ),
                    'title'    => esc_html__( 'Find Events button background hover color ', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'      => 'events_month_separator',
                    'title'   => esc_html__('Events Month Separator','avas'),
                    'type'    => 'switch',
                    'on'      => esc_html__('Show','avas'),
                    'off'     => esc_html__('Hide','avas'),
                    'default' => 1,
                ),
                array(
                    'id'       => 'events_month_separator_color',
                    'type'     => 'color',
                    'output'   => array( 'color' => 'time.tribe-events-calendar-list__month-separator-text.tribe-common-h7.tribe-common-h6--min-medium.tribe-common-h--alt' ),
                    'title'    => esc_html__( 'Events Month Separator color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required' => array('events_month_separator','=','1'), 
                ),
                array(
                    'id'       => 'events_month_separator_bg_color',
                    'type'     => 'color',
                    'output'   => array( 'background-color' => '.tribe-events .tribe-events-calendar-list__month-separator' ),
                    'title'    => esc_html__( 'Events Month Separator Background color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required' => array('events_month_separator','=','1'), 
                ),
                array(
                    'id'      => 'events_subscribe_to_calendar',
                    'title'   => esc_html__('Subscribe to calendar','avas'),
                    'type'    => 'switch',
                    'on'      => esc_html__('Show','avas'),
                    'off'     => esc_html__('Hide','avas'),
                    'default' => 1,
                ),
                array(
                    'id'        => 'events_color_options',
                    'type'      => 'info',
                    'title'     => esc_html__('Events Colors Options', 'avas'),
                    'style'     => 'success', //success warning
                ),
                array(
                    'id'       => 'events_calendar_date_color',
                    'type'     => 'color',
                    'output'   => array( 'color' => '.tribe-events .tribe-events-calendar-list__event-date-tag-weekday,.tribe-events-calendar-list__event-date-tag-daynum.tribe-common-h5.tribe-common-h4--min-medium', 'border-color' => '.tribe-events .tribe-events-calendar-list__event-date-tag-datetime' ),
                    'title'    => esc_html__( 'Event Calendar Date color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'events_title_color',
                    'type'     => 'color',
                    'output'   => array( 'color' => '.tribe-events .tribe-events-calendar-list__event-title-link' ),
                    'title'    => esc_html__( 'Event Title color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'events_title_hov_color',
                    'type'     => 'color',
                    'output'   => array( 'color' => '.tribe-events .tribe-events-calendar-list__event-title-link:hover' ),
                    'title'    => esc_html__( 'Event Title hover color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'events_venue_color',
                    'type'     => 'color',
                    'output'   => array( 'color' => '.tribe-events .tribe-events-calendar-list__event-venue' ),
                    'title'    => esc_html__( 'Event Venue color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'events_venue_bg_color',
                    'type'     => 'color',
                    'output'   => array( 'background-color' => '.tribe-events .tribe-events-calendar-list__event-venue' ),
                    'title'    => esc_html__( 'Event Venue background color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'events_price_color',
                    'type'     => 'color',
                    'output'   => array( 'color' => 'span.tribe-events-c-small-cta__price' ),
                    'title'    => esc_html__( 'Event Price color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'events_price_bg_color',
                    'type'     => 'color',
                    'output'   => array( 'background-color' => 'span.tribe-events-c-small-cta__price' ),
                    'title'    => esc_html__( 'Event Price background color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'        => 'event_single_options',
                    'type'      => 'info',
                    'title'     => esc_html__('Single Event Options', 'avas'),
                    'style'     => 'success', //success warning
                ),
                array(
                    'id'      => 'events_single_featured_image',
                    'title'   => esc_html__('Single Event Featured Image','avas'),
                    'type'    => 'switch',
                    'on'      => esc_html__('Show','avas'),
                    'off'     => esc_html__('Hide','avas'),
                    'default' => 1,
                ),
                array(
                    'id'       => 'events_single_title_bg_color',
                    'type'     => 'color_rgba',
                    'output'   => array( 'background-color' => '.tx-single-event-title-wrap' ),
                    'title'    => esc_html__( 'Single Event Title Background color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required' => array('events_single_featured_image','=','1'), 
                ),
                array(
                    'id'       => 'events_single_title_color',
                    'type'     => 'color',
                    'output'   => array( 'color' => '.tx-single-event-title-wrap .entry-title' ),
                    'title'    => esc_html__( 'Single Event Title color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required' => array('events_single_featured_image','=','1'), 
                ),
                array(
                    'id'       => 'events_single_date_color',
                    'type'     => 'color',
                    'output'   => array( 'color' => '.tx-single-event-title-wrap h2' ),
                    'title'    => esc_html__( 'Single Event Date color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required' => array('events_single_featured_image','=','1'), 
                ),
                array(
                    'id'       => 'events_single_price_color',
                    'type'     => 'color',
                    'output'   => array( 'color' => '.tx-single-event-title-wrap .tribe-events-cost' ),
                    'title'    => esc_html__( 'Single Event Price color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required' => array('events_single_featured_image','=','1'), 
                ),
                array(
                    'id'       => 'events_single_price_divider_color',
                    'type'     => 'color',
                    'output'   => array( 'color' => '.single-tribe_events .tribe-events-divider' ),
                    'title'    => esc_html__( 'Single Event Price divider color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required' => array('events_single_featured_image','=','1'), 
                ),
                array(
                    'id'      => 'events_single_add_to_google_calendar',
                    'title'   => esc_html__('Single Event Add to Google Calendar','avas'),
                    'type'    => 'switch',
                    'on'      => esc_html__('Show','avas'),
                    'off'     => esc_html__('Hide','avas'),
                    'default' => 1,
                ),
                array(
                    'id'       => 'events_single_add_to_google_calendar_color',
                    'type'     => 'color',
                    'output'   => array( 'color' => '.single-tribe_events .tribe-events-cal-links .tribe-events-gcal' ),
                    'title'    => esc_html__( 'Single Event Add to Google Calendar color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required' => array('events_single_add_to_google_calendar','=','1'), 
                ),
                array(
                    'id'       => 'events_single_add_to_google_calendar_bg_color',
                    'type'     => 'color',
                    'output'   => array( 'background-color' => '.single-tribe_events .tribe-events-cal-links .tribe-events-gcal' ),
                    'title'    => esc_html__( 'Single Event Add to Google Calendar background color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required' => array('events_single_add_to_google_calendar','=','1'), 
                ),
                array(
                    'id'       => 'events_single_add_to_google_calendar_bg_hov_color',
                    'type'     => 'color',
                    'output'   => array( 'background-color' => '.single-tribe_events .tribe-events-cal-links .tribe-events-gcal:hover' ),
                    'title'    => esc_html__( 'Single Event Add to Google Calendar background hover color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required' => array('events_single_add_to_google_calendar','=','1'), 
                ),
                array(
                    'id'      => 'events_single_add_to_icalendar',
                    'title'   => esc_html__('Single Event Add to iCalendar','avas'),
                    'type'    => 'switch',
                    'on'      => esc_html__('Show','avas'),
                    'off'     => esc_html__('Hide','avas'),
                    'default' => 1,
                ),
                array(
                    'id'       => 'events_single_add_to_icalendar_color',
                    'type'     => 'color',
                    'output'   => array( 'color' => '.single-tribe_events .tribe-events-cal-links .tribe-events-ical' ),
                    'title'    => esc_html__( 'Single Event Add to iCalendar color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required' => array('events_single_add_to_icalendar','=','1'), 
                ),
                array(
                    'id'       => 'events_single_add_to_icalendar_bg_color',
                    'type'     => 'color',
                    'output'   => array( 'background-color' => '.single-tribe_events .tribe-events-cal-links .tribe-events-ical' ),
                    'title'    => esc_html__( 'Single Event Add to iCalendar background color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required' => array('events_single_add_to_icalendar','=','1'), 
                ),
                array(
                    'id'       => 'events_single_add_to_icalendar_bg_hov_color',
                    'type'     => 'color',
                    'output'   => array( 'background-color' => '.single-tribe_events .tribe-events-cal-links .tribe-events-ical:hover' ),
                    'title'    => esc_html__( 'Single Event Add to iCalendar background hover color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required' => array('events_single_add_to_icalendar','=','1'), 
                ),
                array(
                    'id'        => 'single_event_right_side',
                    'type'      => 'info',
                    'title'     => esc_html__('Single Event Right Side Colors Options', 'avas'),
                    'style'     => 'success',
                ),
                array(
                    'id'       => 'events_single_right_side_bg_color',
                    'type'     => 'color',
                    'output'   => array( 'background-color' => '.tribe-events-event-meta' ),
                    'title'    => esc_html__( 'Single Event Right Sidebar background color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'events_single_right_side_heading_color',
                    'type'     => 'color',
                    'output'   => array( 'color' => '.tribe-events-meta-group .tribe-events-single-section-title' ),
                    'title'    => esc_html__( 'Single Event Right Sidebar Heading color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'events_single_right_side_heading_bg_color',
                    'type'     => 'color',
                    'output'   => array( 'background-color' => '.tribe-events-meta-group .tribe-events-single-section-title' ),
                    'title'    => esc_html__( 'Single Event Right Sidebar Heading background color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'events_single_right_side_content_color',
                    'type'     => 'color',
                    'output'   => array( 'color' => '.tribe-events-event-meta' ),
                    'title'    => esc_html__( 'Single Event Right Sidebar content color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),

        )));
    endif; // check The Events Calendar plugin installed or not

    if(class_exists('bbpress')) :
    // -> START Events options / The Events Calendar
        Redux::setSection( $opt_name, array(
            'title'     => esc_html__( 'bbPress / Forum','avas' ),
            'id'        => 'bbpress',
            'icon'      => 'bi bi-people',
            'fields'    => array(
                array(
                    'id'       => 'bbp_froum_search_border_color',
                    'type'     => 'color',
                    'output'   => array( 'border-color' => '#bbpress-forums #bbp-search-form #bbp_search,.bbp-search-form input' ),
                    'title'    => esc_html__( 'bbPress Forum Search Border Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'bbp_froum_search_btn_color',
                    'type'     => 'color',
                    'output'   => array( 'color' => '#bbpress-forums #bbp-search-form #bbp_search_submit' ),
                    'title'    => esc_html__( 'bbPress Forum Search Button Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'bbp_froum_search_btn_bg_color',
                    'type'     => 'color',
                    'output'   => array( 'background-color' => '#bbpress-forums #bbp-search-form #bbp_search_submit,.widget_display_search #bbp_search_submit' ),
                    'title'    => esc_html__( 'bbPress Forum Search Button Background Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'bbp_froum_search_btn_bg_hov_color',
                    'type'     => 'color',
                    'output'   => array( 'background-color' => '#bbpress-forums #bbp-search-form #bbp_search_submit:hover,.widget_display_search #bbp_search_submit:hover' ),
                    'title'    => esc_html__( 'bbPress Forum Search Button Background Hover Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'bbp_froum_head_bg_color',
                    'type'     => 'color_rgba',
                    'output'   => array( 'background-color' => '#bbpress-forums li.bbp-header' ),
                    'title'    => esc_html__( 'bbPress Forum Header Background Color', 'avas' ),
                ),
                array(
                    'id'       => 'bbp_froum_head_font_color',
                    'type'     => 'color',
                    'output'   => array( 'color' => '#bbpress-forums li.bbp-header ul' ),
                    'title'    => esc_html__( 'bbPress Forum Header Font Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'bbp_froum_bg_color',
                    'type'     => 'color_rgba',
                    'output'   => array( 'background-color' => '#bbpress-forums li.bbp-body ul.forum' ),
                    'title'    => esc_html__( 'bbPress Forum Background Color', 'avas' ),
                ),
                array(
                    'id'       => 'bbp_froum_border_color',
                    'type'     => 'color',
                    'output'   => array( 'border-color' => '#bbpress-forums ul.bbp-forums,#bbpress-forums li.bbp-body ul.forum' ),
                    'title'    => esc_html__( 'bbPress Forum Border Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'bbp_froum_link_color',
                    'type'     => 'color',
                    'output'   => array( 'color' => '#bbpress-forums a' ),
                    'title'    => esc_html__( 'bbPress Forum Link Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'bbp_froum_link_hov_color',
                    'type'     => 'color',
                    'output'   => array( 'color' => '#bbpress-forums a:hover' ),
                    'title'    => esc_html__( 'bbPress Forum Link Hover Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'bbp_froum_title_color',
                    'type'     => 'color',
                    'output'   => array( 'color' => '#bbpress-forums .bbp-forum-title, #bbpress-forums .bbp-topic-title .bbp-topic-permalink' ),
                    'title'    => esc_html__( 'bbPress Forum Title Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'bbp_froum_title_hov_color',
                    'type'     => 'color',
                    'output'   => array( 'color' => '#bbpress-forums .bbp-forum-title:hover, #bbpress-forums .bbp-topic-title .bbp-topic-permalink:hover' ),
                    'title'    => esc_html__( 'bbPress Forum Title Hover Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'bbp_froum_content_color',
                    'type'     => 'color',
                    'output'   => array( 'color' => '#bbpress-forums .bbp-forum-info .bbp-forum-content, #bbpress-forums p.bbp-topic-meta' ),
                    'title'    => esc_html__( 'bbPress Forum Content Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'bbp_froum_form_submit_btn_color',
                    'type'     => 'color',
                    'output'   => array( 'color' => '#bbpress-forums .bbp-submit-wrapper button' ),
                    'title'    => esc_html__( 'bbPress Forum Form Submit Button Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'bbp_froum_form_submit_btn_bg_color',
                    'type'     => 'color',
                    'output'   => array( 'background-color' => '#bbpress-forums .bbp-submit-wrapper button' ),
                    'title'    => esc_html__( 'bbPress Forum Form Submit Button Background Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'bbp_froum_notice_font_color',
                    'type'     => 'color',
                    'output'   => array( 'color' => 'div.bbp-template-notice li' ),
                    'title'    => esc_html__( 'bbPress Forum Notice Font Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'bbp_froum_notice_bg_color',
                    'type'     => 'color',
                    'output'   => array( 'background-color' => 'div.bbp-template-notice' ),
                    'title'    => esc_html__( 'bbPress Forum Notice Background Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'bbp_froum_notice_border_color',
                    'type'     => 'color',
                    'output'   => array( 'border-color' => 'div.bbp-template-notice' ),
                    'title'    => esc_html__( 'bbPress Forum Notice Border Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'bbp_froum_base_font',
                    'type'     => 'typography',
                    'title'    => esc_html__( 'bbPress Forum Base Font', 'avas' ),
                    'google'   => true,
                    'font-backup' => false,
                    'output'      => array('#bbpress-forums'),
                    'units'       =>'px',
                    'fonts' => $standard_fonts,
                    'font-style'  => true,
                    'all_styles'  => true,
                    'word-spacing'  => true,
                    'letter-spacing'=> true,
                    'text-transform'=> true,
                    'color'         => false,
                    'subsets'       => true,
                    'allow_empty_line_height' => true,
                ),
                array(
                    'id'       => 'bbp_froum_header_font',
                    'type'     => 'typography',
                    'title'    => esc_html__( 'bbPress Forum Header Font', 'avas' ),
                    'google'   => true,
                    'font-backup' => false,
                    'output'      => array('#bbpress-forums li.bbp-header'),
                    'units'       =>'px',
                    'fonts' => $standard_fonts,
                    'font-style'  => true,
                    'all_styles'  => true,
                    'word-spacing'  => true,
                    'letter-spacing'=> true,
                    'text-transform'=> true,
                    'color'         => false,
                    'subsets'       => true,
                    'allow_empty_line_height' => true,
                ),
                array(
                    'id'       => 'bbp_froum_title_font',
                    'type'     => 'typography',
                    'title'    => esc_html__( 'bbPress Forum Title Font', 'avas' ),
                    'google'   => true,
                    'font-backup' => false,
                    'output'      => array('#bbpress-forums .bbp-forum-title, #bbpress-forums .bbp-topic-title .bbp-topic-permalink'),
                    'units'       =>'px',
                    'fonts' => $standard_fonts,
                    'font-style'  => true,
                    'all_styles'  => true,
                    'word-spacing'  => true,
                    'letter-spacing'=> true,
                    'text-transform'=> true,
                    'color'         => false,
                    'subsets'       => true,
                    'allow_empty_line_height' => true,
                ),
                array(
                    'id'       => 'bbp_froum_content_font',
                    'type'     => 'typography',
                    'title'    => esc_html__( 'bbPress Forum Content Font', 'avas' ),
                    'google'   => true,
                    'font-backup' => false,
                    'output'      => array('#bbpress-forums .bbp-forum-info .bbp-forum-content, #bbpress-forums p.bbp-topic-meta, #bbpress-forums .bbp-reply-content p'),
                    'units'       =>'px',
                    'fonts' => $standard_fonts,
                    'font-style'  => true,
                    'all_styles'  => true,
                    'word-spacing'  => true,
                    'letter-spacing'=> true,
                    'text-transform'=> true,
                    'color'         => false,
                    'subsets'       => true,
                    'allow_empty_line_height' => true,
                ),
                
            )
        ));
    endif; // check BBPress plugin installed or not    
    
    // Widgets options
        Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Widgets', 'avas'),
        'id'               => 'sidebar-widgets',
        'icon'       => 'el el-pause',
        'fields'           => array(
                array(
                    'id'        => 'sidebar_shadow_switch',
                    'type'      => 'switch',
                    'title'    => esc_html__('Sidebar shadow','avas'),
                    'default'   => 1,
                    'on'        => esc_html__('Enable', 'avas'),
                    'off'       => esc_html__('Disable', 'avas')
                ),
                
                // sidebar color options
                array(
                    'id'       => 'sidebar-bg-color',
                    'type'     => 'color',
                    'output'   => array( 'background-color' => '#secondary .widget, #secondary_2 .widget,.avas .lp-archive-courses .course-summary .course-summary-content .lp-entry-content.lp-content-area .course-summary-sidebar .course-summary-sidebar__inner .course-sidebar-secondary' ),
                    'title'    => esc_html__( 'Sidebar background color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'sidebar-border-color',
                    'type'     => 'color',
                    'output'   => array( 'border-color' => '#secondary .widget, #secondary_2 .widget,.avas .lp-archive-courses .course-summary .course-summary-content .lp-entry-content.lp-content-area .course-summary-sidebar .course-summary-sidebar__inner > div .widgettitle' ),
                    'title'    => esc_html__( 'Sidebar border color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'sidebar-title-color',
                    'type'     => 'color',
                    'output'   => array( '.elementor h2.widgettitle, .elementor h3.widget-title, #secondary h2.widgettitle, #secondary h3.widget-title, #secondary_2 h3.widget-title,.avas .lp-archive-courses .course-summary .course-summary-content .lp-entry-content.lp-content-area .course-summary-sidebar .course-summary-sidebar__inner > div .widgettitle, header.tribe-events-widget-events-list__header h2.tribe-events-widget-events-list__header-title' ),
                    'title'    => esc_html__( 'Sidebar title color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'sidebar-title-border-color',
                    'type'     => 'color',
                    'output'   => array( 'border-color' => '.elementor h2.widgettitle,.elementor h3.widget-title,#secondary h2.widgettitle, #secondary h3.widget-title, #secondary_2 h3.widget-title,.avas .lp-archive-courses .course-summary .course-summary-content .lp-entry-content.lp-content-area .course-summary-sidebar .course-summary-sidebar__inner > div .widgettitle, #secondary .tribe-events-widget-events-list__header, #secondary_2 .tribe-events-widget-events-list__header' ),
                    'title'    => esc_html__( 'Sidebar title border color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'sidebar-title-border-after-color',
                    'type'     => 'color',
                    'output'   => array( 'background-color' => '.elementor h2.widgettitle:after,.elementor h3.widget-title:after,#secondary h2.widgettitle:after, #secondary h3.widget-title:after, #secondary_2 h3.widget-title:after,.lp-archive-courses .course-summary .course-summary-content .lp-entry-content.lp-content-area .course-summary-sidebar .course-summary-sidebar__inner > div .widgettitle:after,#secondary .tribe-events-widget-events-list__header:after, #secondary_2 .tribe-events-widget-events-list__header:after' ),
                    'title'    => esc_html__( 'Sidebar title border after color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'sidebar-search-icon-color',
                    'type'     => 'color',
                    'output'   => array( 'color' => '.search-form i' ),
                    'title'    => esc_html__( 'Sidebar search icon color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'sidebar-search-icon-hover-color',
                    'type'     => 'color',
                    'output'   => array( 'color' => '.search-form i:hover' ),
                    'title'    => esc_html__( 'Sidebar search icon hover color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'sidebar-category-color',
                    'type'     => 'color',
                    'output'   => array( 'color' => '#secondary li.cat-item a' ),
                    'title'    => esc_html__( 'Sidebar category color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'sidebar-category-hover-color',
                    'type'     => 'color',
                    'output'   => array( 'color' => '#secondary li.cat-item a:hover' ),
                    'title'    => esc_html__( 'Sidebar category hover color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'tags_cloud_color',
                    'type'     => 'color',
                    'output'   => array( 'color' => '#footer-top .tagcloud a, .tagcloud a', 'border-color' => '.tagcloud a' ),
                    'title'    => esc_html__( 'Tag Cloud color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'tags_cloud_hover_color',
                    'type'     => 'color',
                    'output'   => array( 'color' => '#footer-top .tagcloud a:hover, .tagcloud a:hover', 'border-color' => '#footer-top .tagcloud a:hover, .tagcloud a:hover' ),
                    'title'    => esc_html__( 'Tag Cloud hover color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                ),
                // sidebar fonts
                array(
                    'id'       => 'sidebar-title-font',
                    'type'     => 'typography',
                    'title'    => esc_html__( 'Sidebar Title', 'avas' ),
                    'google'   => true,
                    'font-backup' => false,
                    'output'      => array('#secondary h2.widgettitle, #secondary h3.widget-title, #secondary_2 h3.widget-title,.elementor h3.widget-title'),
                    'units'       =>'px',
                    'fonts' => $standard_fonts,
                    'font-style'  => true,
                    'all_styles'  => true,
                    'word-spacing'  => true,
                    'letter-spacing'=> true,
                    'text-transform'=> true,
                    'color'         => false,
                    'subsets'       => true,
                    'allow_empty_line_height' => true,
                ),
                array(
                    'id'       => 'sidebar-recent-posts-title-font',
                    'type'     => 'typography',
                    'title'    => esc_html__( 'Avas | Recent Posts Widget Posts Title', 'avas' ),
                    'google'   => true,
                    'font-backup' => false,
                    'output'      => array('#side-menu-wrapper .widget-title, .elementor .widget-title'),
                    'units'       =>'px',
                    'fonts' => $standard_fonts,
                    'font-style'  => true,
                    'all_styles'  => true,
                    'word-spacing'  => true,
                    'letter-spacing'=> true,
                    'text-transform'=> true,
                    'color'         => false,
                    'subsets'       => true,
                    'allow_empty_line_height' => true,
                ),

        )));
        // Ads options
        Redux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Ads', 'avas' ),
        'id'         => 'ads-option',
        'icon'       => 'el el-bullhorn',
        'fields'     => array(
                
            // content post ads option from here         
                 array(
                    'id'        => 'post_ads',
                    'type'      => 'switch',
                    'title'     => esc_html__('Single Post Ads', 'avas'),
                    'default'   => 0,
                    'on'        => 'Enable',
                    'off'       => 'Disable',
                ),
                array(
                    'id'        => 's_ads_switch',
                    'type'      => 'switch',
                    'title'     => esc_html__('Content ad', 'avas'),
                    'subtitle' => esc_html__('Size 300x250','avas'),
                    'default'   => 1,
                    'on'        => 'Banner',
                    'off'       => 'Adsense',
                    'required' => array('post_ads','=','1'), 
                ),
                array(
                    'id'        => 's_ads_after_p',
                    'type'      => 'slider',
                    'title'     => esc_html__('After paragraph', 'avas'),
                    "default"   => 1,
                    "min"       => 1,
                    "step"      => 1,
                    "max"       => 10,
                    'display_value' => 'text',
                    'required' => array('post_ads','=','1'), 

                ),
                array(
                    'title'    => esc_html__('Ad Banner', 'avas'),
                    'id'       => 's_ad_banner',
                    'required'  => array( 's_ads_switch', '=', '1' ),
                    'type'     => 'media',
                    'complier' => true,
                    'url'      => true,
                    'desc'     => esc_html__( 'You can upload png, jpg, gif image.', 'avas' ),
                    'default'  => array(
                      'url'=> TX_IMAGES . '300x250.jpg'
                    ),
                    'required' => array( 
                                  array('post_ads','=','1'), 
                                  array('s_ads_switch','=','1'),
                    ),
                ),
                array(
                    'id'       => 's_ad_banner_link',
                    'type'     => 'text',
                    'title'    => esc_html__('Banner link', 'avas'),
                    'required' => array( 
                                  array('post_ads','=','1'), 
                                  array('s_ads_switch','=','1'),
                    ),
                ),
                array(
                'id'       => 's_ad_js',
                'title'    => esc_html__( 'Adsense codes here.', 'avas' ),
                'type'     => 'ace_editor',
                'mode'     => 'javascript',
                'theme'    => 'chrome',
                'desc'      => esc_html__('Example: Google Adsense etc', 'avas'),
                'required'  => array( 's_ads_switch', '=', '0' ),
                 ),

        )));

    // Social Media  / social share         
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Social Media', 'avas' ),
        'desc'            => esc_html__( 'Use [avas-social-media] for shortcode', 'avas' ),
        'id'               => 'social_media',
        'customizer_width' => '344px',
        'icon'             => 'el el-share-alt',
        'fields'           =>  array(            
            array(
                'id'        => 'social',
                'type'      => 'switch',
                'default'   => 1,
                'on'        => esc_html__('Enable', 'avas'),
                'off'       => esc_html__('Disable', 'avas'),
                ),
            array(
                'id'       => 'behance',
                'type'     => 'text',
                'title'    => esc_html__('Behance','avas'),
                'default'  => '',
                'required' => array( 'social', '=', '1' ),
                ),
            array(
                'id'       => 'delicious',
                'type'     => 'text',
                'title'    => esc_html__('Delicious','avas'),
                'default'  => '',
                'required' => array( 'social', '=', '1' ),
                ),
            array(
                'id'       => 'deviantart',
                'type'     => 'text',
                'title'    => esc_html__('DeviantArt','avas'),
                'default'  => '',
                'required' => array( 'social', '=', '1' ),
                ),
            array(
                'id'       => 'discord',
                'type'     => 'text',
                'title'    => esc_html__('Discord','avas'),
                'default'  => '',
                'required' => array( 'social', '=', '1' ),
                ),
            array(
                'id'       => 'dribbble',
                'type'     => 'text',
                'title'    => esc_html__('Dribbble','avas'),
                'default'  => '',
                'required' => array( 'social', '=', '1' ),
                ),
            array(
                'id'       => 'ello',
                'type'     => 'text',
                'title'    => esc_html__('Ello','avas'),
                'default'  => '',
                'required' => array( 'social', '=', '1' ),
                ),
            array(
                'id'       => 'facebook',
                'type'     => 'text',
                'title'    => esc_html__('Facebook','avas'),
                'default'  => 'https://www.facebook.com/avas.wordpress.theme/',
                'required' => array( 'social', '=', '1' ),
                ),
            array(
                'id'       => 'flickr',
                'type'     => 'text',
                'title'    => esc_html__('Flickr','avas'),
                'default'  => '',
                'required' => array( 'social', '=', '1' ),
                ),
            array(
                'id'       => 'foursquare',
                'type'     => 'text',
                'title'    => esc_html__('Foursquare','avas'),
                'default'  => '',
                'required' => array( 'social', '=', '1' ),
                ),
            array(
                'id'       => 'github',
                'type'     => 'text',
                'title'    => esc_html__('GitHub','avas'),
                'default'  => '',
                'required' => array( 'social', '=', '1' ),
                ),
            array(
                'id'       => 'goodreads',
                'type'     => 'text',
                'title'    => esc_html__('Goodreads','avas'),
                'default'  => '',
                'required' => array( 'social', '=', '1' ),
                ),
            array(
                'id'       => 'instagram',
                'type'     => 'text',
                'title'    => esc_html__('Instagram','avas'),
                'default'  => '',
                'required' => array( 'social', '=', '1' ),
                ),
            array(
                'id'       => 'line',
                'type'     => 'text',
                'title'    => esc_html__('Line','avas'),
                'default'  => '',
                'required' => array( 'social', '=', '1' ),
                ),
            array(
                'id'       => 'linkedin',
                'type'     => 'text',
                'title'    => esc_html__('LinkedIn','avas'),
                'default'  => '#',
                'required' => array( 'social', '=', '1' ),
                ),
            array(
                'id'       => 'medium',
                'type'     => 'text',
                'title'    => esc_html__('Medium','avas'),
                'default'  => '',
                'required' => array( 'social', '=', '1' ),
                ),
            array(
                'id'       => 'meetup',
                'type'     => 'text',
                'title'    => esc_html__('Meetup','avas'),
                'default'  => '',
                'required' => array( 'social', '=', '1' ),
                ),
            array(
                'id'       => 'mix',
                'type'     => 'text',
                'title'    => esc_html__('Mix','avas'),
                'default'  => '',
                'required' => array( 'social', '=', '1' ),
                ),
            array(
                'id'       => 'pinterest',
                'type'     => 'text',
                'title'    => esc_html__('Pinterest','avas'),
                'default'  => '',
                'required' => array( 'social', '=', '1' ),
                ),
            array(
                'id'       => 'quora',
                'type'     => 'text',
                'title'    => esc_html__('Quora','avas'),
                'default'  => '',
                'required' => array( 'social', '=', '1' ),
                ),
            array(
                'id'       => 'qq',
                'type'     => 'text',
                'title'    => esc_html__('QQ','avas'),
                'default'  => '',
                'required' => array( 'social', '=', '1' ),
                ),
            array(
                'id'       => 'ravelry',
                'type'     => 'text',
                'title'    => esc_html__('Ravelry','avas'),
                'default'  => '',
                'required' => array( 'social', '=', '1' ),
                ),
            array(
                'id'       => 'reddit',
                'type'     => 'text',
                'title'    => esc_html__('Reddit','avas'),
                'default'  => '',
                'required' => array( 'social', '=', '1' ),
                ),
            array(
                'id'       => 'skype',
                'type'     => 'text',
                'title'    => esc_html__('Skype','avas'),
                'default'  => '',
                'required' => array( 'social', '=', '1' ),
                ),
            array(
                'id'       => 'snapchat',
                'type'     => 'text',
                'title'    => esc_html__('Snapchat','avas'),
                'default'  => '',
                'required' => array( 'social', '=', '1' ),
                ),
            array(
                'id'       => 'soundcloud',
                'type'     => 'text',
                'title'    => esc_html__('SoundCloud','avas'),
                'default'  => '',
                'required' => array( 'social', '=', '1' ),
                ),
            array(
                'id'       => 'spotify',
                'type'     => 'text',
                'title'    => esc_html__('Spotify','avas'),
                'default'  => '',
                'required' => array( 'social', '=', '1' ),
                ),
            array(
                'id'       => 'stumbleupon',
                'type'     => 'text',
                'title'    => esc_html__('Stumbleupon','avas'),
                'default'  => '',
                'required' => array( 'social', '=', '1' ),
                ),
            array(
                'id'       => 'telegram',
                'type'     => 'text',
                'title'    => esc_html__('Telegram','avas'),
                'default'  => '',
                'required' => array( 'social', '=', '1' ),
                ),
            array(
                'id'       => 'tiktok',
                'type'     => 'text',
                'title'    => esc_html__('Tiktok','avas'),
                'default'  => '',
                'required' => array( 'social', '=', '1' ),
                ),
            array(
                'id'       => 'tumblr',
                'type'     => 'text',
                'title'    => esc_html__('Tumblr','avas'),
                'default'  => '',
                'required' => array( 'social', '=', '1' ),
                ),
            array(
                'id'       => 'twitch',
                'type'     => 'text',
                'title'    => esc_html__('Twitch','avas'),
                'default'  => '',
                'required' => array( 'social', '=', '1' ),
                ),
            array(
                'id'       => 'twitter',
                'type'     => 'text',
                'title'    => esc_html__('Twitter','avas'),
                'default'  => 'https://twitter.com/AvasTheme',
                'required' => array( 'social', '=', '1' ),
                ),
            array(
                'id'       => 'viber',
                'type'     => 'text',
                'title'    => esc_html__('Viber','avas'),
                'default'  => '',
                'required' => array( 'social', '=', '1' ),
                ),              
            array(
                'id'       => 'vimeo',
                'type'     => 'text',
                'title'    => esc_html__('Vimeo','avas'),
                'default'  => '',
                'required' => array( 'social', '=', '1' ),
                ),
            array(
                'id'       => 'vine',
                'type'     => 'text',
                'title'    => esc_html__('Vine','avas'),
                'default'  => '',
                'required' => array( 'social', '=', '1' ),
                ),
             array(
                'id'       => 'vk',
                'type'     => 'text',
                'title'    => esc_html__('VK','avas'),
                'default'  => '',
                'required' => array( 'social', '=', '1' ),
                ),
             array(
                'id'       => 'wechat',
                'type'     => 'text',
                'title'    => esc_html__('WeChat','avas'),
                'default'  => '',
                'required' => array( 'social', '=', '1' ),
                ),
            array(
                'id'       => 'whatsapp',
                'type'     => 'text',
                'title'    => esc_html__('WhatsApp','avas'),
                'default'  => '',
                'required' => array( 'social', '=', '1' ),
                ),
            array(
                'id'       => 'wikipedia',
                'type'     => 'text',
                'title'    => esc_html__('Wikipedia','avas'),
                'default'  => '',
                'required' => array( 'social', '=', '1' ),
                ),
            array(
                'id'       => 'xing',
                'type'     => 'text',
                'title'    => esc_html__('Xing','avas'),
                'default'  => '',
                'required' => array( 'social', '=', '1' ),
                ),
            array(
                'id'       => 'yelp',
                'type'     => 'text',
                'title'    => esc_html__('Yelp','avas'),
                'default'  => '',
                'required' => array( 'social', '=', '1' ),
                ),
            array(
                'id'       => 'youtube',
                'type'     => 'text',
                'title'    => esc_html__('Youtube','avas'),
                'default'  => 'https://www.youtube.com/c/AvasWordPressTheme',
                'required' => array( 'social', '=', '1' ),
                ),
            array(
                'id'       => 'social-media-icon-shortcode-color',
                'type'     => 'color',
                'output'   => array( 'color' => '#header .social li a i' ),
                'title'    => esc_html__( 'Social icon color on shortcode', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
                'required' => array( 'social', '=', '1' ),
            ),
            array(
                'id'       => 'social-media-icon-shortcode-color-hover',
                'type'     => 'color',
                'output'   => array( 'color' => '#header .social li a:hover i' ),
                'title'    => esc_html__( 'Social icon hover color on shortcode', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
                'required' => array( 'social', '=', '1' ),
            ),
            array(
                'id'       => 'social_share_bg_clr',
                'type'     => 'color',
                'output'   => array( 'background-color' => '.social-share' ),
                'title'    => esc_html__( 'Share on Background Color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
                'required' => array( 'social', '=', '1' ),
            ),
            array(
                'id'       => 'social_share_border_clr',
                'type'     => 'color',
                'output'   => array( 'border-color' => '.social-share' ),
                'title'    => esc_html__( 'Share on Border Color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
                'required' => array( 'social', '=', '1' ),
            ),
            array(
                'id'       => 'social-share-title-color',
                'type'     => 'color',
                'output'   => array( 'color' => '.social-share h5' ),
                'title'    => esc_html__( 'Share on text color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
                'required' => array( 'social', '=', '1' ),
            ),
           
    ) 
    ) );

    // -> START Cookie options
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Cookie', 'avas' ),
        'id'               => 'tx_cookie',
        'desc'             => esc_html__('Cookie Options.', 'avas'),
        'customizer_width' => '344px',
        'icon'             => 'el el-star-alt',
        'fields'           =>  array(
                array(
                    'id'        => 'cookie_notice',
                    'title'     => esc_html__( 'Cookie Notice', 'avas' ),
                    'type'      => 'switch',
                    'default'   => 0,
                    'on'        => esc_html__('Enable', 'avas'),
                    'off'       => esc_html__('Disable', 'avas'),
                ),
                array(
                    'id'       => 'cookie_notice_bg_color',
                    'type'     => 'color_rgba',
                    'output'   => array( 
                    'background-color' => '.cc-window' ),
                    'title'    => esc_html__( 'Notice Bar Background Color', 'avas' ),
                    'required'  => array( 'cookie_notice', '=', '1' ),
                ),
                array(
                    'id'       => 'cookie_notice_text',
                    'title'    =>  esc_html__('Notice Text', 'avas'),
                    'type'     => 'textarea',
                    'default'  => 'This website uses cookies to ensure you get the best experience on our website.',
                    'required'  => array( 'cookie_notice', '=', '1' ),
                ),
                array(
                    'id'       => 'cookie_notice_text_color',
                    'type'     => 'color',
                    'output'   => array( 'color' => '.cc-window' ),
                    'title'    => esc_html__( 'Notice Text Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'cookie_notice', '=', '1' ),
                ),
                array(
                    'id'       => 'cookie_notice_learnmore_text',
                    'title'    =>  esc_html__('Learn More Text', 'avas'),
                    'type'     => 'text',
                    'default'  => 'Learn More',
                    'required'  => array( 'cookie_notice', '=', '1' ),
                ),
                array(
                    'id'       => 'cookie_notice_learnmore_link',
                    'title'    =>  esc_html__('Learn More Link URL', 'avas'),
                    'desc'    =>  esc_html__('https://example-website-name.com', 'avas'),
                    'type'     => 'text',
                    'default'  => '',
                    'required'  => array( 'cookie_notice', '=', '1' ),
                ),
                array(
                    'id'       => 'cookie_notice_learnmore_link_color',
                    'type'     => 'color',
                    'output'   => array( 'color' => '.cc-link,.cc-link:active,.cc-link:visited' ),
                    'title'    => esc_html__( 'Learn More Link Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'cookie_notice', '=', '1' ),
                ),
                 array(
                    'id'       => 'cookie_notice_learnmore_link_hover_color',
                    'type'     => 'color',
                    'output'   => array( 'color' => '.cc-link:hover' ),
                    'title'    => esc_html__( 'Learn More Link Hover Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'cookie_notice', '=', '1' ),
                ),
                array(
                    'id'       => 'cookie_notice_accept',
                    'title'    =>  esc_html__('Cookie Allow Text', 'avas'),
                    'type'     => 'text',
                    'default'  => 'Got It!',
                    'required'  => array( 'cookie_notice', '=', '1' ),
                ),
                array(
                    'id'       => 'cookie_notice_accept_color',
                    'type'     => 'color',
                    'output'   => array( 'color' => '.cc-highlight .cc-btn:first-child' ),
                    'title'    => esc_html__( 'Cookie Allow Text Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'cookie_notice', '=', '1' ),
                ),
                array(
                    'id'       => 'cookie_notice_accept_color_hover',
                    'type'     => 'color',
                    'output'   => array( 'color' => '.cc-highlight .cc-btn:first-child:hover, .cc-highlight .cc-btn:first-child:focus' ),
                    'title'    => esc_html__( 'Cookie Allow Text Hover Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'cookie_notice', '=', '1' ),
                ),
                array(
                    'id'       => 'cookie_notice_accept_bg_color',
                    'type'     => 'color',
                    'output'   => array( 'background-color' => '.cc-highlight .cc-btn:first-child' ),
                    'title'    => esc_html__( 'Cookie Allow Background Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'cookie_notice', '=', '1' ),
                ),
                array(
                    'id'       => 'cookie_notice_accept_bg_hover_color',
                    'type'     => 'color',
                    'output'   => array( 'background-color' => '.cc-highlight .cc-btn:first-child:hover, .cc-highlight .cc-btn:first-child:focus' ),
                    'title'    => esc_html__( 'Cookie Allow Background Hover Color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'cookie_notice', '=', '1' ),
                ),
                array(
                    'id'       => 'cookie_notice_position',
                    'type'     => 'select',
                    'title' => esc_html__('Position', 'avas'),
                    'options'  => array(
                        'bottom'  => esc_html__('Bottom','avas'),
                        'cc-bottom cc-left cc-floating'  => esc_html__('Bottom Left','avas'),
                        'cc-bottom cc-right cc-floating'  => esc_html__('Bottom Right','avas'),
                        'top'  => esc_html__('Top','avas'),
                        'cc-top cc-left cc-floating'  => esc_html__('Top Left','avas'),
                        'cc-top cc-right cc-floating'  => esc_html__('Top Right','avas'),
                    ),
                    'default'  => 'bottom',
                    'required'  => array( 'cookie_notice', '=', '1' ),
                ),
                array(
                    'id'       => 'cookie_expiry',
                    'title'    =>  esc_html__('Cookie Expire Date', 'avas'),
                    'desc'    =>  esc_html__('Default expiry days 7, for no expiry please enter -1', 'avas'),
                    'type'     => 'text',
                    'default'  => '7',
                    'required'  => array( 'cookie_notice', '=', '1' ),
                ),
                array(
                    'id'       => 'cookie_typography',
                    'type'     => 'typography',
                    'title'    => esc_html__( 'Font', 'avas' ),
                    'google'   => true,
                    'font-backup' => false,
                    'output'      => array('.cc-banner .cc-message'),
                    'units'       =>'px',
                    'fonts' => $standard_fonts,
                    'font-style'  => true,
                    'all_styles'  => true,
                    'word-spacing'  => true,
                    'letter-spacing'=> true,
                    'text-transform'=> true,
                    'color'         => false,
                    'text-align'    => false,
                    'subsets'       => true,
                    'allow_empty_line_height' => true,
                    'required'  => array( 'cookie_notice', '=', '1' ),
                ),
        )
    ));

    // -> START Cookie options
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Dark Mode', 'avas' ),
        'id'               => 'txdarkmode',
        'customizer_width' => '344px',
        'icon'             => 'bi bi-moon',
        'fields'           =>  array(
                array(
                    'id'        => 'tx_dark_mode',
                    'title'     => esc_html__( 'Display Dark Mode', 'avas' ),
                    'type'      => 'switch',
                    'default'   => 0,
                    'on'        => esc_html__('Enable', 'avas'),
                    'off'       => esc_html__('Disable', 'avas'),
                ),
                array(
                    'id'        => 'tx_dark_mode_toggle',
                    'title'     => esc_html__( 'Enable dark mode automatically when load the website', 'avas' ),
                    'type'      => 'switch',
                    'default'   => 1,
                    'on'        => esc_html__('Yes', 'avas'),
                    'off'       => esc_html__('No', 'avas'),
                    'required'  => array( 'tx_dark_mode', '=', '1' ),
                ),
                array(
                    'id'        => 'tx_dark_mode_btn',
                    'title'     => esc_html__( 'Display Dark Mode Button on Frontend', 'avas' ),
                    'type'      => 'switch',
                    'default'   => 0,
                    'on'        => esc_html__('Yes', 'avas'),
                    'off'       => esc_html__('No', 'avas'),
                    'required'  => array( 'tx_dark_mode', '=', '1' ),
                ),
                array(
                    'id'       => 'darkmode_mixcolor',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Dark Mode Mix Color', 'avas' ),
                    'default' => '#ffffff',
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'tx_dark_mode', '=', '1' ),
                ),
                array(
                    'id'       => 'darkmode_bgcolor',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Dark Mode Background Color', 'avas' ),
                    'default' => '#ffffff',
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'tx_dark_mode', '=', '1' ),
                ),
                array(
                    'id'       => 'darkmode_btncolordark',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Dark Mode Button Color Dark', 'avas' ),
                    'default' => '#100f2c',
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'tx_dark_mode', '=', '1' ),
                ),
                array(
                    'id'       => 'darkmode_btncolorlight',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Dark Mode Button Color Light', 'avas' ),
                    'default' => '#ffffff',
                    'validate' => 'color',
                    'transparent' => false,
                    'required'  => array( 'tx_dark_mode', '=', '1' ),
                ),
                array(
                    'id'        => 'darkmode_saveInCookies',
                    'title'     => esc_html__( 'Dark Mode Save In Cookies', 'avas' ),
                    'type'      => 'switch',
                    'default'   => 0,
                    'on'        => esc_html__('Yes', 'avas'),
                    'off'       => esc_html__('No', 'avas'),
                    'required'  => array( 'tx_dark_mode_toggle', '=', '0' ),
                ),
                array(
                    'id'        => 'darkmode_autoMatchOsTheme',
                    'title'     => esc_html__( 'Dark Mode Auto Match On Theme', 'avas' ),
                    'type'      => 'switch',
                    'default'   => 1,
                    'on'        => esc_html__('Yes', 'avas'),
                    'off'       => esc_html__('No', 'avas'),
                    'required'  => array( 'tx_dark_mode', '=', '1' ),
                ),
    )));
    
    // Start Forms options
    Redux::setSection( $opt_name, array(
        'title' => esc_html__( 'Forms', 'avas' ),
        'id'    => 'forms-settings',
        'icon'  => 'el el-envelope',
        'customizer_width' => '344px',
    ));
if ( function_exists('wpcf7') ) {     
// -> Cotnact form 7 Forms options
    Redux::setSection( $opt_name, array(
        'title' => esc_html__( 'Contact Form 7', 'avas' ),
        'id'    => 'forms',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'contact_form_button_bg_color',
                'type'     => 'color',
                'output'   => array( 'background-color' => 'input.wpcf7-form-control.wpcf7-submit' ),
                'title'    => esc_html__( 'Contact Form Button Background', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'contact_form_button_bg_hov_color',
                'type'     => 'color',
                'output'   => array( 'background-color' => 'input.wpcf7-form-control.wpcf7-submit:hover' ),
                'title'    => esc_html__( 'Contact Form Button Background Hover', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'contact_form_button_border_color',
                'type'     => 'color',
                'output'   => array( 'border-color' => 'input.wpcf7-form-control.wpcf7-submit' ),
                'title'    => esc_html__( 'Contact Form Button Border', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'contact_form_button_color',
                'type'     => 'color',
                'output'   => array( 'color' => 'input.wpcf7-form-control.wpcf7-submit,.footer input.wpcf7-form-control.wpcf7-submit' ),
                'title'    => esc_html__( 'Contact Form Button Color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'contact_form_button_hover_color',
                'type'     => 'color',
                'output'   => array( 'color' => 'input.wpcf7-form-control.wpcf7-submit:hover' ),
                'title'    => esc_html__( 'Contact Form Button Hover Color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'contact_form_button_border_color_hover',
                'type'     => 'color',
                'output'   => array( 'border-color' => 'input.wpcf7-form-control.wpcf7-submit:hover' ),
                'title'    => esc_html__( 'Contact Form Button Border Hover Color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'contact_form_placeholder_color',
                'type'     => 'color',
                'output'   => array( 'color' => 'input.wpcf7-form-control.wpcf7-text::placeholder,textarea.wpcf7-form-control.wpcf7-textarea::placeholder' ),
                'title'    => esc_html__( 'Contact Form Placeholder Color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'contact_form_fields_border_color',
                'type'     => 'color',
                'output'   => array( 'border-color' => '.footer input.wpcf7-form-control.wpcf7-text,.footer textarea.wpcf7-form-control.wpcf7-textarea' ),
                'title'    => esc_html__( 'Contact Form Footer Fields Border Color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            
    )));
}
// Mailchimp form options
if (function_exists('_mc4wp_load_plugin')) {
    Redux::setSection( $opt_name, array(
        'title' => esc_html__( 'Mailchimp Form', 'avas' ),
        'id'    => 'mc4wp_form',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'mc4wp_btn_color',
                'type'     => 'color',
                'output'   => array( 'color' => '.footer .mc4wp-form input[type=submit], .mc4wp-form input[type=submit]' ),
                'title'    => esc_html__( 'Mailchimp Form Submit Button Color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'mc4wp_btn_hov_color',
                'type'     => 'color',
                'output'   => array( 'color' => '.footer .mc4wp-form input[type=submit]:hover, .mc4wp-form input[type=submit]:hover' ),
                'title'    => esc_html__( 'Mailchimp Form Submit Button Hover Color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'mc4wp_btn_bg_color',
                'type'     => 'color',
                'output'   => array( 'background-color' => '.footer .mc4wp-form input[type=submit], .mc4wp-form input[type=submit]' ),
                'title'    => esc_html__( 'Mailchimp Form Submit Button Background Color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'mc4wp_btn_bg_hov_color',
                'type'     => 'color',
                'output'   => array( 'background-color' => '.footer .mc4wp-form input[type=submit]:hover, .mc4wp-form input[type=submit]:hover' ),
                'title'    => esc_html__( 'Mailchimp Form Submit Button Background Hover Color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'mc4wp_btn_border_color',
                'type'     => 'color',
                'output'   => array( 'border-color' => '.footer .mc4wp-form input[type=submit], .mc4wp-form input[type=submit]' ),
                'title'    => esc_html__( 'Mailchimp Form Submit Button Border Color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'mc4wp_btn_border_hov_color',
                'type'     => 'color',
                'output'   => array( 'border-color' => '.footer .mc4wp-form input[type=submit]:hover, .mc4wp-form input[type=submit]:hover' ),
                'title'    => esc_html__( 'Mailchimp Form Submit Button Border Hover Color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
        )));
}
if (class_exists('GFCommon')) {    
// -> Gravity Form options
    Redux::setSection( $opt_name, array(
        'title' => esc_html__( 'Gravity Form', 'avas' ),
        'id'    => 'gravity_form',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'gvf_button_bg_color',
                'type'     => 'color',
                'output'   => array( 'background-color' => '.gform_footer input[type="submit"]' ),
                'title'    => esc_html__( 'Gravity Form Button Background Color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'gvf_button_bg_hov_color',
                'type'     => 'color',
                'output'   => array( 'background-color' => '.gform_footer input[type="submit"]:hover' ),
                'title'    => esc_html__( 'Gravity Form Button Background Hover Color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'gvf_button_border_color',
                'type'     => 'color',
                'output'   => array( 'border-color' => '.gform_footer input[type="submit"]' ),
                'title'    => esc_html__( 'Gravity Form Button Border Color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'gvf_button_color',
                'type'     => 'color',
                'output'   => array( 'color' => '.gform_footer input[type="submit"]' ),
                'title'    => esc_html__( 'Gravity Form Button Text Color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'gvf_button_hover_color',
                'type'     => 'color',
                'output'   => array( 'color' => '.gform_footer input[type="submit"]:hover' ),
                'title'    => esc_html__( 'Gravity Form Button Text Hover Color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'gvf_button_border_color_hover',
                'type'     => 'color',
                'output'   => array( 'border-color' => '.gform_footer input[type="submit"]:hover' ),
                'title'    => esc_html__( 'Gravity Form Button Border Hover Color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
    )));
}
    // -> START pagination options
    Redux::setSection( $opt_name, array(
        'title' => esc_html__( 'Pagination', 'avas' ),
        'id'    => 'pagination',
        'icon'  => 'el el-resize-horizontal',
        'fields'     => array(
            array(
                'id'             => 'pagination_space',
                'type'           => 'spacing',
                'output'         => array('.tx-pagination'),
                'mode'           => 'padding',
                'units'          => array('px', 'em'),
                'units_extended' => 'false',
                'title'          => esc_html__('Pagination Space', 'avas'),
                'default'        => array (
                        'units'       => 'px'
                    )
            ),
            array(
                'id'       => 'pagination_bg_color',
                'type'     => 'color',
                'output'   => array( 
                    'background-color' => '.tx-pagination a,.woocommerce nav.woocommerce-pagination ul li a, .woocommerce nav.woocommerce-pagination ul li span,.post-type-archive-lp_course .learn-press-pagination .page-numbers>li a'
                ),
                'title'    => esc_html__( 'Pagination Background color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'pagination_bg_hover_color',
                'type'     => 'color',
                'output'   => array( 
                    'background-color' => '.tx-pagination a:hover,.post-type-archive-lp_course .learn-press-pagination .page-numbers>li a:hover',
                    'border-color' => '.tx-pagination a:hover,.post-type-archive-lp_course .learn-press-pagination .page-numbers>li a:hover'
                     ),
                'title'    => esc_html__( 'Pagination Background hover color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'pagination_active_bg_color',
                'type'     => 'color',
                'output'   => array( 
                    'background-color' => '.tx-pagination span,.woocommerce nav.woocommerce-pagination ul li a:focus, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li span.current,.post-type-archive-lp_course .learn-press-pagination .page-numbers>li span',
                    'border-color' => '.tx-pagination span,.woocommerce nav.woocommerce-pagination ul li a:focus, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li span.current,.post-type-archive-lp_course .learn-press-pagination .page-numbers>li span' 
                ),
                'title'    => esc_html__( 'Pagination Current Page background color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'pagination_color',
                'type'     => 'color',
                'output'   => array( 'color' => '.tx-pagination a,.post-type-archive-lp_course .learn-press-pagination .page-numbers>li a', 'border-color' => '.tx-pagination a,.post-type-archive-lp_course .learn-press-pagination .page-numbers>li a' ),
                'title'    => esc_html__( 'Pagination Number Color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'pagination_hover_color',
                'type'     => 'color',
                'output'   => array( '.tx-pagination a:hover,.post-type-archive-lp_course .learn-press-pagination .page-numbers>li a:hover' ),
                'title'    => esc_html__( 'Pagination Number Hover color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'pagination_active_color',
                'type'     => 'color',
                'output'   => array( 
                    'color' => '.tx-pagination span,.post-type-archive-lp_course .learn-press-pagination .page-numbers>li span',
                    'border-color' => '.tx-pagination span',
                ),
                'title'    => esc_html__( 'Pagination Current Page Number color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                    'id'            => 'pagination_num_arrow_size',
                    'type'          => 'slider',
                    'title'         => esc_html__( 'Pagination Number and Arrow Size', 'avas' ),
                    'default'       => '',
                    'min'           => 0,
                    'step'          => 1,
                    'max'           => 100,
                    'display_value' => 'text',
            ),
            array(
                    'id'       => 'pagination-fonts',
                    'type'     => 'typography',
                    'title'    => esc_html__( 'Pagination fonts', 'avas' ),
                    'google'   => true,
                    'font-backup' => false,
                    'output'      => array('.tx-pagination a, .tx-pagination span'),
                    'units'       =>'px',
                    'fonts' => $standard_fonts,
                    'font-style'  => true,
                    'all_styles'  => true,
                    'word-spacing'  => true,
                    'letter-spacing'=> true,
                    'text-transform'=> true,
                    'color'         => false,
                    'subsets'       => true,
                    'allow_empty_line_height' => true,
            ),
            
    )));

    // -> START Footer options
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Footer', 'avas' ),
        'id'               => 'footer',
        'desc'             => esc_html__('Footer Options.', 'avas'),
        'customizer_width' => '344px',
        'icon'             => 'el el-photo',
        'fields'           =>  array(
            array(
                'id'        => 'elem_footer_switch',
                'type'      => 'switch',
                'default'   => 0,
                'on'        => 'Enable',
                'off'       => 'Disable',
                'title'    => esc_html__( 'Elementor Footer', 'avas' ),
            ),
            array(
                'id'       => 'elem_footer',
                'type'     => 'select',
                'data'     => 'posts',
                
                'title' => esc_html__( 'Select Elementor Template for Footer', 'avas' ),
                'desc'     => esc_html__( 'You need to create custom Footer via Elementor Template Library on WP Dashboard > Templates.', 'avas' ),
                'args'  => array(
                        'post_type'      => 'elementor_library',
                        'post_status'    => 'publish',
                        'ignore_sticky_posts' => true,
                        'posts_per_page' => -1,
                        'orderby'        => 'title',
                        'order'          => 'ASC',
                    ),
                'required'  => array( 'elem_footer_switch', '=', '1' ),
            ),
                               
        ),
    ));

    // -> START Footer Top options
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Footer Top', 'avas' ),
        'id'               => 'footer-top-opt',
        'subsection'       => true,
        'customizer_width' => '344px',
        'fields'           =>  array(
                array(
                    'id'        => 'footer_top',
                    'title'     => esc_html__( 'Footer Top Section', 'avas' ),
                    'type'      => 'switch',
                    'default'   => 1,
                    'on'        => esc_html__('Enable', 'avas'),
                    'off'       => esc_html__('Disable', 'avas'),
                ),
                array(
                    'title'    => esc_html__('Footer Top Background', 'avas'),
                    'id'       => 'footer_bg',
                    'type'     => 'background',
                    'output'   => array('background-color'=>'#footer-top'),
                    'required' => array('footer_top', '=', '1' ),
                ),
                array(
                    'id'       => 'footer_top_bg_overlay',
                    'type'     => 'color_rgba',
                    'output'   => array( 
                    'background-color' => '.footer-top-overlay' ),
                    'title'    => esc_html__( 'Footer Top  Background Overlay Color', 'avas' ),
                    'required' => array('footer_top', '=', '1' ),
                ),
                array(
                    'id'       => 'footer-text-color',
                    'type'     => 'color',
                    'output'    => array('#footer-top'),
                    'title'    => esc_html__( 'Footer Top text color', 'avas' ),
                    'transparent' => false,
                    'validate'  => 'color',
                    'required' => array('footer_top', '=', '1' ),
                ),
                array(
                    'id'       => 'footer-link-color',
                    'type'     => 'color',
                    'output'    => array('#footer-top a'),
                    'title'    => esc_html__( 'Footer Top link color', 'avas' ),
                    'transparent' => false,
                    'validate'  => 'color',
                    'required' => array('footer_top', '=', '1' ),
                    ),
                array(
                    'id'       => 'footer-link-hover-color',
                    'type'     => 'color',
                    'output'    => array('#footer-top a:hover'),
                    'title'    => esc_html__( 'Footer Top link hover color', 'avas' ),
                    'transparent' => false,
                    'validate'  => 'color',
                    'required' => array('footer_top', '=', '1' ),
                    ),
                array(
                    'id'          => 'footer-widget-title-color',
                    'type'        => 'color',
                    'output'      => array('#footer-top .widget-title'),
                    'title'       => esc_html__( 'Footer Top widget title color', 'avas' ),
                    'transparent' => false,
                    'validate'    => 'color',
                    'required' => array('footer_top', '=', '1' ),
                    ),
                array(
                    'id'       => 'footer-top-fonts',
                    'type'     => 'typography',
                    'title'    => esc_html__( 'Footer Top font', 'avas' ),
                    'google'   => true,
                    'font-backup' => false,
                    'output'      => array('#footer-top'),
                    'units'       =>'px',
                    'fonts' => $standard_fonts,
                    'font-style'  => true,
                    'all_styles'  => true,
                    'word-spacing'  => true,
                    'letter-spacing'=> true,
                    'text-transform'=> true,
                    'color'         => false,
                    'subsets'       => true,
                    'allow_empty_line_height' => true,
                    'required' => array('footer_top', '=', '1' ),
                ),
                array(
                    'id'       => 'footer-widget',
                    'type'     => 'typography',
                    'title'    => esc_html__( 'Footer Top widget title font', 'avas' ),
                    'google'   => true,
                    'font-backup' => false,
                    'output'      => array('.widget-title'),
                    'units'       =>'px',
                    'fonts' => $standard_fonts,
                    'font-style'  => true,
                    'all_styles'  => true,
                    'word-spacing'  => true,
                    'letter-spacing'=> true,
                    'text-transform'=> true,
                    'color'         => false,
                    'subsets'       => true,
                    'allow_empty_line_height' => true,
                    'required' => array('footer_top', '=', '1' ),
                ),
                array(
                    'id' => 'footer_layout',
                    'title' => esc_html__('Footer Layout', 'avas'),
                    'type' => 'image_select',
                    'options' => array (
                        'boxed' => array('title' => 'Boxed', 'img' => TX_IMAGES . 'footer-boxed.png'),
                        'width' => array('title' => 'Wide', 'img' => TX_IMAGES . 'footer-width.png'),
                    ),
                    'default'  => 'boxed',
                    'required'  => array( 
                                    array('footer_top', '=', '1' ),
                                    array( 'page-layout', '=', 'full-width' )
                                )
                ),
                array(
                    'id'       => 'footer_cols',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Footer Top Columns', 'avas' ),
                    'required' => array('footer_top', '=', '1' ),
                    'options'  => array(
                        '12'   => 'Footer Column 1',
                         '6'   => 'Footer Column 2',
                         '4'   => 'Footer Column 3',
                         '3'   => 'Footer Column 4',
                        ),
                    'default'  => '3',
                ),
                array(
                    'id'             => 'footer_top_space',
                    'type'           => 'spacing',
                    'output'         => array('#footer-top'),
                    'mode'           => 'padding',
                    'units'          => array('px', 'em'),
                    'units_extended' => 'false',
                    'title'          => esc_html__('Footer Padding', 'avas'),
                    'required'  => array('footer_top', '=', '1' ),
                    'default'        => array (
                        'units'       => 'px'
                    )
                ),
                array(
                    'id'       => 'footer-top-widget-alignment',
                    'type'     => 'select',
                    'title' => esc_html__('Footer Widgets Alignment', 'avas'),
                    'options'  => array(
                        'left'  => esc_html__('Left','avas'),
                        'center'  => esc_html__('Center','avas'),
                    ),
                     'default'  => 'left',
                    'required'  => array('footer_top', '=', '1' ),
                ),
                array(
                    'id'             => 'footer_top_widget_margin',
                    'type'           => 'spacing',
                    'output'         => array('#footer-top aside'),
                    'mode'           => 'margin',
                    'units'          => array('px', 'em'),
                    'units_extended' => 'false',
                    'title'          => esc_html__('Footer Widget Margin', 'avas'),
                    'required'  => array('footer_top', '=', '1' ),
                    'default'        => array (
                        'units'       => 'px'
                    )
                ),

        )
    ));

    // -> START Footer Bottom options
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Footer Bottom', 'avas' ),
        'id'               => 'footer-bottom-opt',
        'subsection'       => true,
        'customizer_width' => '344px',
        'fields'           =>  array(
                array(
                'id'        => 'footer_bottom',
                'title'     => esc_html__( 'Footer Bottom Section', 'avas' ),
                'type'      => 'switch',
                'default'   => 1,
                'on'        => esc_html__('Enable', 'avas'),
                'off'       => esc_html__('Disable', 'avas'),
                ),
                array(
                    'id'       => 'footer-select',
                    'type'     => 'select',
                    'title' => esc_html__('Select Footer Bottom Style', 'avas'),
                    'options'  => array(
                        'footer1'  => esc_html__('Footer Bottom Style 1','avas'),
                        'footer2'  => esc_html__('Footer Bottom Style 2','avas'),
                        'footer3'  => esc_html__('Footer Bottom Style 3','avas'),
                    ),
                    'default'  => 'footer2',
                    'required'  => array( 'footer_bottom', '=', '1' ),
                ),
                array(
                    'id'       => 'footer-style1',
                    'type'     => 'image_select',
                    'title'    => esc_html__('Style 1', 'avas'),
                    'required'  => array( 'footer-select', '=', 'footer1' ),
                    'options'  => array(
                    'header-style1'  => array(
                      'alt' => 'Footer Style 1',
                      'img' => TX_IMAGES .'f1.png'
                    ),
                    ),
                ),
                array(
                    'id'       => 'footer-style2',
                    'type'     => 'image_select',
                    'title'    => esc_html__('Style 2', 'avas'),
                    'required'  => array( 'footer-select', '=', 'footer2' ),
                    'options'  => array(
                    'header-style1'  => array(
                      'alt' => 'Footer Style 2',
                      'img' => TX_IMAGES .'f2.png'
                    ),
                    ),
                ),
                array(
                    'id'       => 'footer-style3',
                    'type'     => 'image_select',
                    'title'    => esc_html__('Style 3', 'avas'),
                    'required'  => array( 'footer-select', '=', 'footer3' ),
                    'options'  => array(
                    'header-style1'  => array(
                      'alt' => 'Footer Style 3',
                      'img' => TX_IMAGES .'f3.png'
                    ),
                    ),
                ),
                array(
                    'id'       => 'footer-bottom-layout1',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Footer Bottom Layout', 'avas' ),
                    'required'  => array('footer-select', '!=', 'footer2' ),
                    'options'  => array(
                        '12'   => esc_html__('Copyright Text only','avas'),
                         '6'   => esc_html__('Copyright Text with Footer Menu &amp; Social Icons','avas'),
                        ),
                    'default'  => '6',
                ),
                array(
                    'id'       => 'footer-bottom-layout2',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Footer Bottom Layout', 'avas' ),
                   'required'  => array( 'footer-select', '=', 'footer2' ),
                    'options'  => array(
                        '12'   => esc_html__('Copyright Text only','avas'),
                         '4'   => esc_html__('Copyright Text with Footer Menu &amp; Social Icons','avas'),
                        ),
                    'default'  => '12',
                ),
                array(
                    'id'          => 'footer-bottom-bg-color',
                    'type'        => 'color',
                    'output'      => array('background-color' => '#footer'),
                    'title'       => esc_html__( 'Footer Bottom background color', 'avas' ),
                    'transparent' => false,
                    'validate'    => 'color',
                    'required'  => array( 'footer_bottom', '=', '1' ),
                    ),
                array(
                    'id'          => 'footer-border-color',
                    'type'        => 'color',
                    'output'      => array('border-color' => '#footer'),
                    'title'       => esc_html__( 'Footer Bottom border color', 'avas' ),
                    'transparent' => false,
                    'validate'    => 'color',
                    'required'  => array( 'footer_bottom', '=', '1' ),
                    ),
                // social icon on footer
                array(
                    'id'        => 'social_icons_footer',
                    'title'     => esc_html__( 'Footer Social Media Icons', 'avas' ),
                    'desc'     => esc_html__( 'Social Icons link optoins are located at Theme Optoins > Social Media.', 'avas' ),
                    'type'      => 'switch',
                    'default'   => 0,
                    'on'        => esc_html__('On', 'avas'),
                    'off'       => esc_html__('Off', 'avas'),
                    'required'  => array( 'footer_bottom', '=', '1' ),
                ),
                array(
                    'id'            => 'social_icons_footer_size',
                    'type'          => 'slider',
                    'title'         => esc_html__( 'Footer Social Media Icons Size', 'avas' ),
                    'default'       => 14,
                    'min'           => 0,
                    'step'          => 1,
                    'max'           => 100,
                    'display_value' => 'text',
                    'required'  => array( 'social_icons_footer', '=', '1' ),
                ),
                array(
                    'id'       => 'social-media-icon-footer-color',
                    'type'     => 'color',
                    'output'   => array( 'color' => '#footer .social li a' ),
                    'title'    => esc_html__( 'Footer Social Media icon color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required' => array('social_icons_footer', '=', '1' ),
                ),
                array(
                    'id'       => 'social-media-icon-footer-color-hover',
                    'type'     => 'color',
                    'output'   => array( 'color' => '#footer .social li a:hover' ),
                    'title'    => esc_html__( 'Footer Social Media icon hover color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required' => array('social_icons_footer', '=', '1' ),
                ),
                // Footer menu options
                array(
                    'id'        => 'footer-menu',
                    'title'     => esc_html__( 'Footer Menu Options', 'avas' ),
                    'desc'     => esc_html__( 'Please create and set Footer Menu first via Dashboard > Appearance > Menus > Menu Settings > Display location > Footer Menu.', 'avas' ),
                    'type'      => 'switch',
                    'default'   => 0,
                    'on'        => esc_html__('On', 'avas'),
                    'off'       => esc_html__('Off', 'avas'),
                    'required' => array('footer_bottom', '=', '1' ),
                ),
                // Footer Menu Color
                array(
                    'id'          => 'footer-menu-color',
                    'type'        => 'color',
                    'output'      => array('color' => '.footer-menu li a'),
                    'title'       => esc_html__( 'Footer menu color', 'avas' ),
                    'transparent' => false,
                    'validate'    => 'color',
                    'required' => array('footer-menu', '=', '1' ),
                    ),
                array(
                    'id'          => 'footer-menu-hover-color',
                    'type'        => 'color',
                    'output'      => array('color' => '.footer-menu li a:hover'),
                    'title'       => esc_html__( 'Footer menu hover color', 'avas' ),
                    'transparent' => false,
                    'validate'    => 'color',
                    'required' => array('footer-menu', '=', '1' ),
                    ),
                array(
                    'id'          => 'footer-menu-separator-color',
                    'type'        => 'color',
                    'output'      => array('color' => '.footer-menu li:after'),
                    'title'       => esc_html__( 'Footer menu seperator color', 'avas' ),
                    'transparent' => false,
                    'validate'    => 'color',
                    'required' => array('footer-menu', '=', '1' ),
                    ),
                // footer menu fonts
                array(
                    'id'       => 'footer-menu-font',
                    'type'     => 'typography',
                    'title'    => esc_html__( 'Footer menu font', 'avas' ),
                    'google'   => true,
                    'font-backup' => false,
                    'output'      => array('.footer-menu li a'),
                    'units'       =>'px',
                    'fonts' => $standard_fonts,
                    'font-style'  => true,
                    'all_styles'  => true,
                    'text-transform'=> true,
                    'word-spacing'  => true,
                    'letter-spacing'=> true,
                    'color'         => false,
                    'subsets'       => true,
                    'allow_empty_line_height' => true,
                    'required' => array('footer-menu', '=', '1' ),

                ),

                // copryright
                array(
                'id'       => 'copyright',
                'title'    =>  esc_html__('Copyright', 'avas'),
                'type'     => 'textarea',
                'default'  => 'Copyright &copy; <a href="https://1.envato.market/mPA2X">Avas WordPress Theme</a> | All rights reserved.',
                'required'  => array( 'footer_bottom', '=', '1' ),
                ),
                array(
                'id'          => 'footer-copyright-text-color',
                'type'        => 'color',
                'output'      => array('color' => '.copyright'),
                'title'       => esc_html__( 'Footer copyright text color', 'avas' ),
                'transparent' => false,
                'validate'    => 'color',
                'required'  => array( 'footer_bottom', '=', '1' ),
                ),
                array(
                    'id'          => 'footer-copyright-link-color',
                    'type'        => 'color',
                    'output'      => array('color' => '.copyright a'),
                    'title'       => esc_html__( 'Footer copyright link color', 'avas' ),
                    'transparent' => false,
                    'validate'    => 'color',
                    'required'  => array( 'footer_bottom', '=', '1' ),
                ),
                array(
                    'id'          => 'footer-copyright-link-hover-color',
                    'type'        => 'color',
                    'output'      => array('color' => '.copyright a:hover'),
                    'title'       => esc_html__( 'Footer copyright link hover color', 'avas' ),
                    'transparent' => false,
                    'validate'    => 'color',
                    'required'  => array( 'footer_bottom', '=', '1' ),
                ),
                array(
                    'id'       => 'footer-copyright',
                    'type'     => 'typography',
                    'title'    => esc_html__( 'Copyright text', 'avas' ),
                    'google'   => true,
                    'font-backup' => false,
                    'output'      => array('.copyright'),
                    'units'       =>'px',
                    'fonts' => $standard_fonts,
                    'font-style'  => true,
                    'all_styles'  => true,
                    'word-spacing'  => true,
                    'letter-spacing'=> true,
                    'text-transform'=> true,
                    'color'         => false,
                    'subsets'       => true,
                    'allow_empty_line_height' => true,
                    'required'  => array( 'footer_bottom', '=', '1' ),
                ),

        )
    ));
    // -> START Scroll to top options / back to top options
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Scroll to Top', 'avas' ),
        'id'               => 'scroll-to-top-opt',
        'subsection'       => true,
        'customizer_width' => '344px',
        'fields'           =>  array(
                array(
                    'id'        => 'back_top',
                    'title'     => esc_html__( 'Scroll to Top options', 'avas' ),
                    'type'      => 'switch',
                    'default'   => 1,
                    'on'        => esc_html__('On', 'avas'),
                    'off'       => esc_html__('Off', 'avas'),
                ),
                array(
                    'id'       => 'back_top_position',
                    'type'     => 'button_set',
                    'title'    => esc_html__('Scroll to Top Position', 'avas'),
                    'options' => array(
                        '1' => esc_html__('Left', 'avas'),
                        '2' => esc_html__('Right', 'avas'),
                     ), 
                    'default' => '2',
                    'required'  => array( 'back_top', '=', '1' ),
                                
                ), 
                array(
                    'id'            => 'back_top_radius',
                    'type'          => 'slider',
                    'title'         => esc_html__( 'Scroll to Top border radius', 'avas' ),
                    'default'       => 0,
                    'min'           => 0,
                    'step'          => 1,
                    'max'           => 100,
                    'display_value' => 'text',
                    'required' => array('back_top', '=', '1' ),
                ),
                array(
                'id'       => 'back_top_bg',
                'type'     => 'color',
                'output'   => array( 'background-color' => '#back_top' ),
                'title'    => esc_html__( 'Scroll to Top background color', 'avas' ),
                'validate' => 'color',
                'transparent' => false,
                'required' => array('back_top', '=', '1' ),
                ),
                array(
                    'id'       => 'back_top_bg_hover',
                    'type'     => 'color',
                    'output'   => array( 'background-color' => '#back_top:hover,#back_top:focus' ),
                    'title'    => esc_html__( 'Scroll to Top background hover color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required' => array('back_top', '=', '1' ),
                ),
                array(
                    'id'       => 'back_top_border',
                    'type'     => 'color',
                    'output'   => array( 'border-color' => '#back_top' ),
                    'title'    => esc_html__( 'Scroll to Top border color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required' => array('back_top', '=', '1' ),
                ),
                array(
                    'id'       => 'back_top_border_hover',
                    'type'     => 'color',
                    'output'   => array( 'border-color' => '#back_top:hover,#back_top:focus' ),
                    'title'    => esc_html__( 'Scroll to Top border hover color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required' => array('back_top', '=', '1' ),
                ),
                array(
                    'id'       => 'back_top_icon',
                    'type'     => 'color',
                    'output'   => array( 'color' => '#back_top i' ),
                    'title'    => esc_html__( 'Scroll to Top icon color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required' => array('back_top', '=', '1' ),
                ),
                array(
                    'id'       => 'back_top_icon_hover',
                    'type'     => 'color',
                    'output'   => array( 'color' => '#back_top i:hover,#back_top i:focus, #back_top:hover i' ),
                    'title'    => esc_html__( 'Scroll to Top icon hover color', 'avas' ),
                    'validate' => 'color',
                    'transparent' => false,
                    'required' => array('back_top', '=', '1' ),
                ),
            )
    ));
    
    // -> START custom css
    Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Custom CSS', 'avas' ),
            'id'         => 'css-code',
            'icon'  => 'el el-css',
            'fields'     => array(
                array(
                    'id'       => 'custom_css',
                    'type'     => 'ace_editor',
                    'title'    => esc_html__( 'Additonal CSS', 'avas' ),
                    'mode'     => 'css',
                    'theme'    => 'monokai',
                    'desc'     =>  sprintf( esc_html__( 'Custom CSS entered here will override the theme CSS so in some cases, you need to add the %s tag after the codes.', 'avas' ), '<code>!important</code>' ),
                    
                ),
            ),
        ) );
    // -> START custom javascript
    Redux::setSection( $opt_name, array(
            'title'      => esc_html__( 'Custom JS', 'avas' ),
            'id'         => 'js-code',
            'icon'  => 'bi bi-code-slash',
            'fields'     => array(
                array(
                    'id'       => 'custom_js_head',
                    'title'    => esc_html__( 'JavaScript on Head', 'avas' ),
                    'type'     => 'ace_editor',
                    'mode'     => 'html',
                    'theme'    => 'monokai',
                    'desc'     => esc_html__( 'Add additional js, jquery, etc. Script will be placed on before </head> tag.', 'avas' ),
                ),
                array(
                    'id'       => 'custom_js_footer',
                    'title'    => esc_html__( 'JavaScript on Footer', 'avas' ),
                    'type'     => 'ace_editor',
                    'mode'     => 'html',
                    'theme'    => 'monokai',
                    'desc'     => esc_html__( 'Add additional js, jquery, etc. Script will be placed on before </body> tag', 'avas' ),
                ),
            ),
        ) );

    // -> START Optimization options
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Optimization', 'avas' ),
        'id'               => 'optimization',
        'customizer_width' => '344px',
        'icon'             => 'bi bi-gear-wide-connected',
        'fields'           =>  array(
                array(
                    'id'        => 'remove_query_strings',
                    'title'     => esc_html__( 'Remove Query Strings', 'avas' ),
                    'desc'     => esc_html__( 'Remove query strings from internal static resources.', 'avas' ),
                    'type'      => 'switch',
                    'default'   => 0,
                    'on'        => esc_html__('Yes', 'avas'),
                    'off'       => esc_html__('No', 'avas'),
                ),
                array(
                    'id'        => 'remove_wordpress_emoji',
                    'title'     => esc_html__( 'Remove WordPress Emoji', 'avas' ),
                    'desc'     => esc_html__( 'Stop loading WordPress.org emoji. Browser default emoji will be displayed instead. This can improve your speed score in services like Pingdom, GTmetrix and PageSpeed.', 'avas' ),
                    'type'      => 'switch',
                    'default'   => 0,
                    'on'        => esc_html__('Yes', 'avas'),
                    'off'       => esc_html__('No', 'avas'),
                ),
            )
    ));

    /*
 * <--- END SECTIONS
 */

/*
 * YOU MUST PREFIX THE FUNCTIONS BELOW AND ACTION FUNCTION CALLS OR OTHER CONFIGS MAY OVERRIDE YOUR CODE.
 */

/*
 * --> Action hook examples.
 */

// Function to test the compiler hook and demo CSS output.
// Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
// add_filter('redux/options/' . $opt_name . '/compiler', 'compiler_action', 10, 3);
//
// Change the arguments after they've been declared, but before the panel is created.
// add_filter('redux/options/' . $opt_name . '/args', 'change_arguments' );
//
// Change the default value of a field after it's been set, but before it's been useds.
// add_filter('redux/options/' . $opt_name . '/defaults', 'change_defaults' );
//
// Dynamically add a section. Can be also used to modify sections/fields.
// add_filter('redux/options/' . $opt_name . '/sections', 'dynamic_section');
// .
if ( ! function_exists( 'compiler_action' ) ) {
    /**
     *
     * This is a test function that will let you see when the compiler hook occurs.
     * It only runs if a field's value has changed and compiler=>true is set.
     *
     * @param array  $options        Options values.
     * @param string $css            Compiler selector CSS values  compiler => array( CSS SELECTORS ).
     * @param array  $changed_values Values changed since last save.
     */
    function compiler_action( $options, $css, $changed_values ) {
        echo '<h1>The compiler hook has run!</h1>';
        echo '<pre>';
        // phpcs:ignore WordPress.PHP.DevelopmentFunctions
        print_r( $changed_values ); // Values that have changed since the last save.
        // echo '<br/>';
        // print_r($options); //Option values.
        // echo '<br/>';
        // print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS ).
        echo '</pre>';
    }
}

if ( ! function_exists( 'redux_validate_callback_function' ) ) {
    /**
     * Custom function for the callback validation referenced above
     *
     * @param array $field          Field array.
     * @param mixed $value          New value.
     * @param mixed $existing_value Existing value.
     *
     * @return mixed
     */
    function redux_validate_callback_function( $field, $value, $existing_value ) {
        $error   = false;
        $warning = false;

        // Do your validation.
        if ( 1 === $value ) {
            $error = true;
            $value = $existing_value;
        } elseif ( 2 === $value ) {
            $warning = true;
            $value   = $existing_value;
        }

        $return['value'] = $value;

        if ( true === $error ) {
            $field['msg']    = 'your custom error message';
            $return['error'] = $field;
        }

        if ( true === $warning ) {
            $field['msg']      = 'your custom warning message';
            $return['warning'] = $field;
        }

        return $return;
    }
}


if ( ! function_exists( 'dynamic_section' ) ) {
    /**
     * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
     * Simply include this function in the child themes functions.php file.
     * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
     * so you must use get_template_directory_uri() if you want to use any of the built in icons.
     *
     * @param array $sections Section array.
     *
     * @return array
     */
    function dynamic_section( $sections ) {
        $sections[] = array(
            'title'  => esc_html__( 'Section via hook', 'avas' ),
            'desc'   => '<p class="description">' . esc_html__( 'This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.', 'avas' ) . '</p>',
            'icon'   => 'el el-paper-clip',

            // Leave this as a blank section, no options just some intro text set above.
            'fields' => array(),
        );

        return $sections;
    }
}

if ( ! function_exists( 'change_arguments' ) ) {
    /**
     * Filter hook for filtering the args.
     * Good for child themes to override or add to the args array. Can also be used in other functions.
     *
     * @param array $args Global arguments array.
     *
     * @return array
     */
    function change_arguments( $args ) {
        $args['dev_mode'] = true;

        return $args;
    }
}

if ( ! function_exists( 'change_defaults' ) ) {
    /**
     * Filter hook for filtering the default value of any given field. Very useful in development mode.
     *
     * @param array $defaults Default value array.
     *
     * @return array
     */
    function change_defaults( $defaults ) {
        $defaults['str_replace'] = esc_html__( 'Testing filter hook!', 'avas' );

        return $defaults;
    }
}

if ( ! function_exists( 'redux_custom_sanitize' ) ) {
    /**
     * Function to be used if the field santize argument.
     *
     * Return value MUST be the formatted or cleaned text to display.
     *
     * @param string $value Value to evaluate or clean.  Required.
     *
     * @return string
     */
    function redux_custom_sanitize( $value ) {
        $return = '';

        foreach ( explode( ' ', $value ) as $w ) {
            foreach ( str_split( $w ) as $k => $v ) {
                if ( ( $k + 1 ) % 2 !== 0 && ctype_alpha( $v ) ) {
                    $return .= mb_strtoupper( $v );
                } else {
                    $return .= $v;
                }
            }
            $return .= ' ';
        }

        return $return;
    }
}
    
    /* ---------------------------------------------------------
     Remove Redux Notice
    ------------------------------------------------------------ */
    if ( ! class_exists( 'reduxNewsflash' ) ):
        class reduxNewsflash {
            public function __construct( $parent, $params ) {}
        }
    endif;
    /* ---------------------------------------------------------
     Remove Redux Ads
    ------------------------------------------------------------ */
    add_filter( 'redux/tx/aURL_filter', '__return_empty_string' );
    /* ---------------------------------------------------------
    Remove Redux Framework menu from Tools
    ------------------------------------------------------------ */
    add_action('admin_menu', 'tx_remove_redux_menu', 12);
    function tx_remove_redux_menu() {
        remove_submenu_page('tools.php', 'redux-framework');

    }

    
/* ==============================================================================
          EOF
================================================================================ */