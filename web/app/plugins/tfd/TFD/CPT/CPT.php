<?php

namespace TFD\CPT;

use Cocur\Slugify\Slugify;

class CPT
{
    protected $id = null;
    public $args = [];
    protected $names = [];

    public $supports = [
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
        //if (function_exists('register_extended_post_type')) {
            dlog(plugin_dir_path(__FILE__), plugin_basename(__FILE__));
            $patterns = [
                // 'cpt' => __DIR__ . '/modules/*.php',
                'cpt' => '/app/web/app/plugins/tfd/CustomPostTypes/*.php',
            ];
            $patterns = apply_filters('tfd_cpt_location', $patterns);
            foreach ($patterns as $pattern) {
                collect(glob($pattern))->map(function ($field) {
                    dlog('FIELDS', $field);
                    return require_once($field);
                })->map(function ($field) {
                    if ($field instanceof CPT) {
                        $id = $field->getId();
                        dlog($id);
                        $names = $field->getNames();
                        \register_extended_post_type($id, $field->args, $names);
                    }
                });
            }
        // }
    }


    public function getId()
    {
        if ($this->id) {
            return $this->id;
        }

        $slugify = new Slugify();
        return $slugify->slugify(basename(__FILE__, '.php'));
    }


    public function getNames()
    {
        return [
        ];
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

        if (isset($model->id)) {
            return $model->id;
        } elseif (isset($model->name)) {
            return $model->name;
        }

        throw new Exception('$postType not defined');
    }
}
