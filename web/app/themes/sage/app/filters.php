<?php

namespace App;

/**
 * Add <body> classes
 */
add_filter('body_class', function (array $classes) {
    /** Add page slug if it doesn't exist */
    if (is_single() || is_page() && !is_front_page()) {
        if (!in_array(basename(get_permalink()), $classes)) {
            $classes[] = basename(get_permalink());
        }
    }

    /** Add class if sidebar is active */
    if (display_sidebar()) {
        $classes[] = 'sidebar-primary';
    }

    /** Clean up class names for custom templates */
    $classes = array_map(function ($class) {
        return preg_replace(['/-blade(-php)?$/', '/^page-template-views/'], '', $class);
    }, $classes);

    return array_filter($classes);
});

/**
 * Add "… Continued" to the excerpt
 */
add_filter('excerpt_more', function () {
    return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
});

/**
 * Template Hierarchy should search for .blade.php files
 */
collect([
    'index', '404', 'archive', 'author', 'category', 'tag', 'taxonomy', 'date', 'home',
    'frontpage', 'page', 'paged', 'search', 'single', 'singular', 'attachment', 'embed'
])->map(function ($type) {
    add_filter("{$type}_template_hierarchy", __NAMESPACE__.'\\filter_templates');
});

/**
 * Render page using Blade
 */
add_filter('template_include', function ($template) {
    collect(['get_header', 'wp_head'])->each(function ($tag) {
        ob_start();
        do_action($tag);
        $output = ob_get_clean();
        remove_all_actions($tag);
        add_action($tag, function () use ($output) {
            echo $output;
        });
    });
    $data = collect(get_body_class())->reduce(function ($data, $class) use ($template) {
        return apply_filters("sage/template/{$class}/data", $data, $template);
    }, []);
    if ($template) {
        echo template($template, $data);
        return get_stylesheet_directory().'/index.php';
    }
    return $template;
}, PHP_INT_MAX);

/**
 * Render comments.blade.php
 */
add_filter('comments_template', function ($comments_template) {
    $comments_template = str_replace(
        [get_stylesheet_directory(), get_template_directory()],
        '',
        $comments_template
    );

    $data = collect(get_body_class())->reduce(function ($data, $class) use ($comments_template) {
        return apply_filters("sage/template/{$class}/data", $data, $comments_template);
    }, []);

    $theme_template = locate_template(["views/{$comments_template}", $comments_template]);

    if ($theme_template) {
        echo template($theme_template, $data);
        return get_stylesheet_directory().'/index.php';
    }

    return $comments_template;
}, 100);

/**
* Settings / Filters for Auto Cloudinary Plugin
* more infor: https://github.com/junaidbhura/auto-cloudinary/wiki/Filters
*/
if (function_exists('cloudinary_url')) {
    // Filter the Cloud Name option.
    add_filter('cloudinary_cloud_name', function ($cloud_name) {
        return defined(CLOUDINARY_CLOUD_NAME) ? CLOUDINARY_CLOUD_NAME : $cloud_name;
    });

    // Filter the Auto Mapping Folder o ption.
    add_filter('cloudinary_auto_mapping_folder', function ($auto_mapping_folder) {
        return defined(CLOUDINARY_AUTO_MAPPING_FOLDER) ? CLOUDINARY_AUTO_MAPPING_FOLDER : $auto_mapping_folder;
    });

    // Filter the URLs option.
    add_filter('cloudinary_urls', function ($urls) {
        if (!is_array($urls)) {
            $urls = [$urls];
        }
        if (defined(CLOUDINARY_URL)) {
            $urls[] = CLOUDINARY_URL;
        }
        return $urls;
    });

    // Filter the Content Images option.
    add_filter('cloudinary_content_images', function ($content_images) {
        return defined(CLOUDINARY_CONTENT_IMAGES) ? CLOUDINARY_CONTENT_IMAGES : $content_images;
    });

    // Change the URL path to your images folder due to relative URLs
    add_filter('cloudinary_upload_url', function ($upload_url) {
        return str_replace(get_home_url(), '', $upload_url);
    });
}
