<?php

namespace TFD\ACF;

use StoutLogic\AcfBuilder\FieldsBuilder;

class ACF extends FieldsBuilder
{
    public $id = null;
    public $location = null;


    public static $configUi = true;
    public static $configReturnFormat = 'id';
    public static $wrapper10 = ['width' => 10];
    public static $wrapper15 = ['width' => 15];
    public static $wrapper20 = ['width' => 20];
    public static $wrapper25 = ['width' => 25];
    public static $wrapper50 = ['width' => 50];
    public static $wrapper75 = ['width' => 75];


    public static function register()
    {
        dlog("Register 👋");
        if (function_exists('acf_add_local_field_group')) {
            $patterns = [
                //'partials' => __DIR__ . '/partials/*.php',
                'modules' => __DIR__ . '/modules/*.php',
                'blocks' => __DIR__ . '/blocks/*.php',
                'posts' => __DIR__ . '/posts/*.php',
            ];
            $patterns = apply_filters('tfd_acf_location', $patterns);
            foreach ($patterns as $pattern) {
                collect(glob($pattern))->map(function ($field) {
                    return require_once($field);
                })->map(function ($field) {
                    if ($field instanceof ACF) {
                        acf_add_local_field_group($field->build());
                    }
                });
            }
        }
    }

    protected function configFields()
    {

    }

    public static function partial($partial, $modifier = null)
    {
        $partial = str_replace('.', '/', $partial);
        $fields = include(__DIR__ . "/{$partial}.php");
        if ($modifier) {
            foreach ($modifier as $key => $value) {
                $fields->modifyField($key, $value);
            }
        }
        return $fields;
    }


    public function __construct()
    {

        $obj = new \ReflectionClass($this);
        $this->id = $this->id ?: str_replace('-', '_', basename($obj->getFileName(), '.php'));
        parent::__construct($this->id, $this->getConfig());
        $this->configFields();
    }

    private function getConfig()
    {
        $default = [
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'seamless',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => [
                'permalink',
                'the_content',
                'excerpt',
                'discussion',
                'comments',
                'revisions',
                'slug',
                'author',
                'format',
                'page_attributes',
                'featured_image',
                'categories',
                'tags',
                'send-trackbacks',
            ],
            'active' => 1,
            'description' => '',
        ];

        return array_merge($default, []);
    }

    protected function locateFields()
    {
        return $this;
    }

    public function build()
    {
        $this->locateFields();
        return parent::build();
    }
}

