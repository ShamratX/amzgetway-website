<?php
// theme options customizer

function tx_customize_single_post_options($wp_customize) {

    // Create main panel
    $wp_customize->add_panel('tx_theme_options_panel', array(
        'title'       => __('Theme Options', 'avas'),
        'priority'    => 1,
        'capability'  => 'edit_theme_options',
    ));

    // General Settings section
    $wp_customize->add_section('tx_global_settings', array(
        'title'    => __('Global', 'avas'),
        'panel'    => 'tx_theme_options_panel',
        'priority' => 1,
    ));

    // Enable Redux Framework toggle
    $wp_customize->add_setting('tx_enable_redux', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('tx_enable_redux', array(
        'label'   => __('Enable Redux Framework', 'avas'),
        'section' => 'tx_global_settings',
        'type'    => 'checkbox',
    ));

    // Enable Mouse Cursor
    $wp_customize->add_setting('tx_custom_cursor', array(
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('tx_custom_cursor', array(
        'label'   => __('Enable Cursor', 'avas'),
        'section' => 'tx_global_settings',
        'type'    => 'checkbox',
    ));

    // Top Header Section
    $wp_customize->add_section('tx_top_header_settings', array(
        'title'    => __('Top Header', 'avas'),
        'panel'    => 'tx_theme_options_panel',
        'priority' => 5,
    ));

    // Enable Top Header
    $wp_customize->add_setting('top_head', array(
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('top_head', array(
        'label'    => __('Enable Top Header', 'avas'),
        'section'  => 'tx_top_header_settings',
        'type'     => 'checkbox',
    ));

    // Post Layout Settings section
    $wp_customize->add_section('tx_post_layout_settings', array(
        'title'    => __('Post Layout Settings', 'avas'),
        'panel'    => 'tx_theme_options_panel',
        'priority' => 10,
    ));

    // Posts Sidebar Position
    $wp_customize->add_setting('sidebar-select', array(
        'default'           => 'sidebar-right',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('sidebar-select', array(
        'label'   => __('Sidebar Position (Blog)', 'avas'),
        'section' => 'tx_post_layout_settings',
        'type'    => 'radio',
        'choices' => array(
            'sidebar-left'  => __('Left Sidebar', 'avas'),
            'sidebar-right' => __('Right Sidebar', 'avas'),
            'no-sidebar'    => __('No Sidebar', 'avas'),
        ),
    ));

    $wp_customize->add_setting('tx_post_title_length', array(
        'default'           => 85,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('tx_post_title_length', array(
        'label'   => __('Post Title Length', 'avas'),
        'section' => 'tx_post_layout_settings',
        'type'    => 'number',
        'input_attrs' => array('min' => 0, 'step' => 1),
    ));

    $wp_customize->add_setting('tx_post_excerpt_words', array(
        'default'           => 35,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('tx_post_excerpt_words', array(
        'label'   => __('Post Excerpt Words', 'avas'),
        'section' => 'tx_post_layout_settings',
        'type'    => 'number',
        'input_attrs' => array('min' => 0, 'step' => 1),
    ));

    $wp_customize->add_setting('blog-posts-per-page', array(
        'default'           => 9,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('blog-posts-per-page', array(
        'label'       => __('Blog Posts Per Page', 'avas'),
        'section'     => 'tx_post_layout_settings',
        'type'        => 'number',
        'input_attrs' => array('min' => -1, 'step' => 1),
    ));

    $wp_customize->add_setting('tx_tagcloud_limit', array(
        'default'           => 15,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('tx_tagcloud_limit', array(
        'label'   => __('Tag Cloud Widget Limit', 'avas'),
        'section' => 'tx_post_layout_settings',
        'type'    => 'number',
        'input_attrs' => array('min' => 1, 'step' => 1),
    ));

    $wp_customize->add_setting('tx_readmore_toggle', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('tx_readmore_toggle', array(
        'label'   => __('Show Read More Button', 'avas'),
        'section' => 'tx_post_layout_settings',
        'type'    => 'checkbox',
    ));

    $wp_customize->add_setting('tx_no_posts_text', array(
        'default'           => __('Sorry, nothing found.', 'avas'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('tx_no_posts_text', array(
        'label'   => __('Posts Not Found Text', 'avas'),
        'section' => 'tx_post_layout_settings',
        'type'    => 'text',
    ));

    // Show Post Date
    $wp_customize->add_setting('post-time', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('post-time', array(
        'label'   => __('Show Post Date', 'avas'),
        'section' => 'tx_post_layout_settings',
        'type'    => 'checkbox',
    ));

    // Show Post Author
    $wp_customize->add_setting('post-author', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('post-author', array(
        'label'   => __('Show Post Author', 'avas'),
        'section' => 'tx_post_layout_settings',
        'type'    => 'checkbox',
    ));

    // Show Post Comments Count
    $wp_customize->add_setting('post-comment', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('post-comment', array(
        'label'   => __('Show Post Comments Count', 'avas'),
        'section' => 'tx_post_layout_settings',
        'type'    => 'checkbox',
    ));

    // Show Post Views
    $wp_customize->add_setting('post-views', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('post-views', array(
        'label'   => __('Show Post Views', 'avas'),
        'section' => 'tx_post_layout_settings',
        'type'    => 'checkbox',
    ));

    $wp_customize->add_setting('social-share-header', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('social-share-header', array(
        'label'   => __('Show Social Share Icons (Top of Post)', 'avas'),
        'section' => 'tx_post_layout_settings',
        'type'    => 'checkbox',
    ));

    // Share On Text (Header)
    $wp_customize->add_setting('share-on-text-header', array(
        'default'           => __('Share On:', 'avas'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('share-on-text-header', array(
        'label'   => __('Share On Text (Header)', 'avas'),
        'section' => 'tx_post_layout_settings',
        'type'    => 'text',
    ));

    // Single Post Settings as a subsection under Post Layout Settings
    $wp_customize->add_section('tx_single_post_options', array(
        'title'    => __('Single Post Settings', 'avas'),
        'panel'    => 'tx_theme_options_panel',
        'priority' => 11,
        'description' => __('Settings specific to individual blog posts.', 'avas'),
    ));

    $wp_customize->add_setting('tx_sidebar_single', array(
        'default'           => 'sidebar-right',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('tx_sidebar_single', array(
        'label'   => __('Sidebar Position', 'avas'),
        'section' => 'tx_single_post_options',
        'type'    => 'radio',
        'choices' => array(
            'sidebar-left'  => __('Left Sidebar', 'avas'),
            'sidebar-right' => __('Right Sidebar', 'avas'),
            'no-sidebar'    => __('No Sidebar', 'avas'),
        ),
    ));

    // Show Post Category
    $wp_customize->add_setting('post-category', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('post-category', array(
        'label'   => __('Show Post Category', 'avas'),
        'section' => 'tx_single_post_options',
        'type'    => 'checkbox',
    ));

    // Show Post Tag
    $wp_customize->add_setting('post-tag', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('post-tag', array(
        'label'   => __('Show Post Tags', 'avas'),
        'section' => 'tx_single_post_options',
        'type'    => 'checkbox',
    ));


    $wp_customize->add_setting('related-posts', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('related-posts', array(
        'label'   => __('Show Related Posts', 'avas'),
        'section' => 'tx_single_post_options',
        'type'    => 'checkbox',
    ));

    $wp_customize->add_setting('prev-next-posts', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('prev-next-posts', array(
        'label'   => __('Show Prev/Next Post Links', 'avas'),
        'section' => 'tx_single_post_options',
        'type'    => 'checkbox',
    ));

    $wp_customize->add_setting('author-bio-posts', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('author-bio-posts', array(
        'label'   => __('Show Author Bio', 'avas'),
        'section' => 'tx_single_post_options',
        'type'    => 'checkbox',
    ));

    $wp_customize->add_setting('comments-posts', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('comments-posts', array(
        'label'   => __('Enable Comments', 'avas'),
        'section' => 'tx_single_post_options',
        'type'    => 'checkbox',
    ));
    // Social Share Footer Section
    $wp_customize->add_setting('social-share-footer', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('social-share-footer', array(
        'label'   => __('Show Social Share Icons (Bottom of Post)', 'avas'),
        'section' => 'tx_single_post_options',
        'type'    => 'checkbox',
    ));

    // Share On Text (Footer)
    $wp_customize->add_setting('share-on-text-footer', array(
        'default'           => __('Share On:', 'avas'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('share-on-text-footer', array(
        'label'   => __('Share On Text (Footer)', 'avas'),
        'section' => 'tx_single_post_options',
        'type'    => 'text',
        'description' => __('Text shown above the social share icons at the bottom of posts.', 'avas'),
    ));

    // Services sections
    $wp_customize->add_section('tx_services_settings', array(
        'title'    => __('Services Settings', 'avas'),
        'panel'    => 'tx_theme_options_panel',
        'priority' => 12,
    ));
    $wp_customize->add_setting('service_post_type', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('service_post_type', array(
        'label'   => __('Enable Services Post Type', 'avas'),
        'section' => 'tx_services_settings',
        'type'    => 'checkbox',
    ));
    $wp_customize->add_setting('services_title', array(
        'default'           => 'Services',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('services_title', array(
        'label'   => __('Services Name', 'avas'),
        'section' => 'tx_services_settings',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('service-slug', array(
        'default'           => 'service',
        'sanitize_callback' => 'sanitize_title',
    ));
    $wp_customize->add_control('service-slug', array(
        'label'   => __('Services Slug / Permalink', 'avas'),
        'section' => 'tx_services_settings',
        'type'    => 'text',
    ));
    $wp_customize->add_setting('service-cat-slug', array(
        'default'           => 'service-category',
        'sanitize_callback' => 'sanitize_title',
    ));

    $wp_customize->add_control('service-cat-slug', array(
        'label'   => __('Services Category Slug / Permalink', 'avas'),
        'section' => 'tx_services_settings',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('service_excerpt_limit', array(
        'default'           => 20,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('service_excerpt_limit', array(
        'label'   => __('Service Excerpt Limit', 'avas'),
        'section' => 'tx_services_settings',
        'type'    => 'number',
        'input_attrs' => array('min' => 1, 'max' => 100, 'step' => 1),
    ));

    $wp_customize->add_setting('service-comments', array(
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('service-comments', array(
        'label'   => __('Enable Comments on Services', 'avas'),
        'section' => 'tx_services_settings',
        'type'    => 'checkbox',
    ));


    // Archive Display Type
    $wp_customize->add_setting('service_archive_display', array(
        'default'           => 'grid',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('service_archive_display', array(
        'label'   => __('Service Archive Display Type', 'avas'),
        'section' => 'tx_services_settings',
        'type'    => 'select',
        'choices' => array(
            'grid'    => __('Grid', 'avas'),
            'overlay' => __('Overlay', 'avas'),
        ),
    ));

    // Archive Category (Grid only)
    $wp_customize->add_setting('service_archive_category', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('service_archive_category', array(
        'label'           => __('Show Service Archive Category (Grid only)', 'avas'),
        'section'         => 'tx_services_settings',
        'type'            => 'checkbox',
        'active_callback' => function() {
            return get_theme_mod('service_archive_display', 'grid') === 'grid';
        },
    ));

    // Archive Title
    $wp_customize->add_setting('service_archive_title', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('service_archive_title', array(
        'label'   => __('Show Service Archive Title', 'avas'),
        'section' => 'tx_services_settings',
        'type'    => 'checkbox',
    ));

    // Archive Excerpt
    $wp_customize->add_setting('service_archive_excerpt', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('service_archive_excerpt', array(
        'label'   => __('Show Service Archive Excerpt', 'avas'),
        'section' => 'tx_services_settings',
        'type'    => 'checkbox',
    ));

    // Archive Overlay Link (Overlay only)
    $wp_customize->add_setting('service_archive_link', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('service_archive_link', array(
        'label'           => __('Show Archive Link (Overlay only)', 'avas'),
        'section'         => 'tx_services_settings',
        'type'            => 'checkbox',
        'active_callback' => function() {
            return get_theme_mod('service_archive_display', 'grid') === 'overlay';
        },
    ));

    // Archive Item Per Page
    $wp_customize->add_setting('service_archive_item', array(
        'default'           => 9,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('service_archive_item', array(
        'label'       => __('Service Archive Items Per Page', 'avas'),
        'section'     => 'tx_services_settings',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => -1,
            'step' => 1,
            'max'  => 100,
        ),
    ));

    // Portfolio Section
    $wp_customize->add_section('tx_portfolio_settings', array(
        'title'    => __('Portfolio Settings', 'avas'),
        'panel'    => 'tx_theme_options_panel',
        'priority' => 13,
    ));
    $wp_customize->add_setting('portfolio_post_type', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('portfolio_post_type', array(
        'label'   => __('Enable Portfolio Post Type', 'avas'),
        'section' => 'tx_portfolio_settings',
        'type'    => 'checkbox',
        'description' => __('After enabling, please refresh the page.', 'avas'),
    ));

    // 404 Error Page Settings
    $wp_customize->add_section('tx_404_page_settings', array(
        'title'       => __('404 Error Page', 'avas'),
        'panel'       => 'tx_theme_options_panel',
        'priority'    => 14,
    ));

    $wp_customize->add_setting('404_numb', array(
        'default'           => '404',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('404_numb', array(
        'label'   => __('Error Number', 'avas'),
        'section' => 'tx_404_page_settings',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('404_heading', array(
        'default'           => __('Oops! Page Not Found', 'avas'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('404_heading', array(
        'label'   => __('Heading Text', 'avas'),
        'section' => 'tx_404_page_settings',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('404_desc', array(
        'default'           => __('Sorry, the page you are looking for does not exist.', 'avas'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('404_desc', array(
        'label'   => __('Description', 'avas'),
        'section' => 'tx_404_page_settings',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('404_btn', array(
        'default'           => __('Back to Home', 'avas'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('404_btn', array(
        'label'   => __('Button Text', 'avas'),
        'section' => 'tx_404_page_settings',
        'type'    => 'text',
    ));


    $wp_customize->add_section('tx_social_media', array(
    'title'    => __('Social Media', 'avas'),
    'panel'    => 'tx_theme_options_panel',
    'priority' => 14,
));

    // Enable Social Media Toggle
    $wp_customize->add_setting('social', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('social', array(
        'label'   => __('Enable Social Media Icons', 'avas'),
        'section' => 'tx_social_media',
        'type'    => 'checkbox',
    ));

    // Social Fields Array
    $social_fields = array(
        'behance' => 'Behance',
        'delicious' => 'Delicious',
        'deviantart' => 'DeviantArt',
        'discord' => 'Discord',
        'dribbble' => 'Dribbble',
        'ello' => 'Ello',
        'facebook' => 'Facebook',
        'flickr' => 'Flickr',
        'foursquare' => 'Foursquare',
        'github' => 'GitHub',
        'goodreads' => 'Goodreads',
        'instagram' => 'Instagram',
        'line' => 'Line',
        'linkedin' => 'LinkedIn',
        'medium' => 'Medium',
        'meetup' => 'Meetup',
        'mix' => 'Mix',
        'pinterest' => 'Pinterest',
        'quora' => 'Quora',
        'qq' => 'QQ',
        'ravelry' => 'Ravelry',
        'reddit' => 'Reddit',
        'skype' => 'Skype',
        'snapchat' => 'Snapchat',
        'soundcloud' => 'SoundCloud',
        'spotify' => 'Spotify',
        'stumbleupon' => 'StumbleUpon',
        'telegram' => 'Telegram',
        'tiktok' => 'Tiktok',
        'tumblr' => 'Tumblr',
        'twitch' => 'Twitch',
        'twitter' => 'Twitter',
        'viber' => 'Viber',
        'vimeo' => 'Vimeo',
        'vine' => 'Vine',
        'vk' => 'VK',
        'wechat' => 'WeChat',
        'whatsapp' => 'WhatsApp',
        'wikipedia' => 'Wikipedia',
        'xing' => 'Xing',
        'yelp' => 'Yelp',
        'youtube' => 'YouTube'
    );

    // Generate Customizer Controls for Each Social Field
    foreach ( $social_fields as $key => $label ) {
        $wp_customize->add_setting($key, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control($key, array(
            'label'    => $label,
            'section'  => 'tx_social_media',
            'type'     => 'url',
            'input_attrs' => array(
                'placeholder' => 'https://',
            ),
            'active_callback' => function() {
                return get_theme_mod('social', true);
            },
        ));
    }



}
add_action('customize_register', 'tx_customize_single_post_options');