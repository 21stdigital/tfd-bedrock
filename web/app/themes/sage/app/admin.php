<?php

namespace App;

/**
 * Theme customizer
 */
add_action('customize_register', function (\WP_Customize_Manager $wp_customize) {
    // Add postMessage support
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->selective_refresh->add_partial('blogname', [
        'selector' => '.brand',
        'render_callback' => function () {
            bloginfo('name');
        }
    ]);
});

/**
 * Customizer JS
 */
add_action('customize_preview_init', function () {
    wp_enqueue_script('sage/customizer.js', asset_path('scripts/customizer.js'), ['customize-preview'], null, true);
});

function customMenuOrder($menuOrder)
{
    // dlog($menuOrder);

    return [
        'index.php', // Dashboard
        'separator1', // Separator

        'edit.php?post_type=page', // Pages
        'edit.php', // Features (Posts)
        'edit.php?post_type=feed', // Feeds
        'separator2', // Separator

        'edit.php?post_type=podcast', // Podcasts
        'edit.php?post_type=video', //
        'edit.php?post_type=videoplaylist', //
        'separator3', // Separator

        'edit.php?post_type=pressreleases', // Press Releases
        'separator4', // Separator

        'upload.php', // Media
        'separator5', // Separator

        'themes.php', // Appearance
        'plugins.php', // Plugins
        'tools.php', // Tools
        'options-general.php', // Settings
        'users.php', // Users
        //'edit-comments.php', //
        'separator6', // Separator

        'edit.php?post_type=acf-field-group', // ACF Settings
        'separator-last', // Last Separator
    ];
}

add_filter('custom_menu_order', __NAMESPACE__ . '\\customMenuOrder', 10, 1);
add_filter('menu_order', __NAMESPACE__ . '\\customMenuOrder', 10, 1);


