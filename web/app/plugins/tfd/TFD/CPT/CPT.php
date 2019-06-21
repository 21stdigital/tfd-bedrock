<?php

namespace TFD\CPT;

use Cocur\Slugify\Slugify;

class CPT
{
    protected static $id = null;
    protected static $slug = null;
    protected static $args = [];
    protected static $names = [];

    public static $supports = [
        'title',
        'editor', // content
        'author',
        'thumbnail', // featured image, current theme must also support post-thumbnails
        'excerpt',
        'trackbacks',
        'custom-fields',
        'comments', // also will see comment count balloon on edit screen
        'revisions', // will store revisions
        'page-attributes', // menu order, hierarchical must be true to show Parent option
        'post-formats',
    ];

    public static function register()
    {
        if (function_exists('register_extended_post_type')) {
            $patterns = [
                // 'cpt' => __DIR__ . '/modules/*.php',
                '/app/web/app/plugins/tfd/CustomPostTypes/*.php',
            ];
            $patterns = apply_filters('tfd_cpt_location', $patterns);
            foreach ($patterns as $pattern) {
                collect(glob($pattern))->map(function ($field) {
                    return require_once($field);
                })->map(function ($field) {
                    if ($field instanceof CPT) {
                        $id = $field::getId();
                        $args = $field::getArgs();
                        $names = $field::getNames();
                        if (!array_key_exists('slug', $names)) {
                            $names['slug'] = $field::getSlug();
                        }
                        \register_extended_post_type($id, $args, $names);
                    }
                });
            }
        }
    }

    public static function getName()
    {
        $reflection = new \ReflectionClass(get_called_class());
        return basename($reflection->getFileName(), '.php');
    }

    public static function getId()
    {
        if (self::$id) {
            return self::$id;
        }
        $slugify = new Slugify();
        return $slugify->slugify(self::getName());
    }

    public static function getArgs()
    {
        return self::$args;
    }

    public static function getNames()
    {
        return [
            'singular' => self::getName(),
            'plural' => self::getName() . 's',
            'slug' => self::getSlug(),
        ];
    }

    /**
     * Create a new model without calling the constructor.
     *
     * @return object
     */
    protected static function newWithoutConstructor()
    {
        $class = get_called_class();
        $reflection = new \ReflectionClass($class);
        return $reflection->newInstanceWithoutConstructor();
    }

    /**
     * Returns the post type
     *
     * @return string
     *
     * @throws \Exception
     */
    public static function getSlug()
    {
        $model = self::newWithoutConstructor();
        $slugify = new Slugify();
        return $slugify->slugify($model::$slug ?: $model::getId());
    }
}
