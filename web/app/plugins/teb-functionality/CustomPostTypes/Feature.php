<?php

namespace TFD\CPT;

class Feature
{

    public $singular;
    public $plural;

    public function __construct()
    {
        $this->singular = esc_html__('Feature', TEXT_DOMAIN_BACKEND);
        $this->plural = esc_html__('Features', TEXT_DOMAIN_BACKEND);

        add_action('admin_menu', function () {
            global $menu;
            global $submenu;
            $menu[5][0] = $this->plural;
            $submenu['edit.php'][5][0] = $this->plural;
            $submenu['edit.php'][10][0] = "Add {$this->plural}";
            $submenu['edit.php'][16][0] = "{$this->plural} Tags";
        });

        add_action('init', function () {
            $getPostType = get_post_type_object('post');
            $labels = $getPostType->labels;
            $labels->name = $this->plural;
            $labels->singular_name = $this->singular;
            $labels->add_new = 'Add ' . $this->plural;
            $labels->add_new_item = 'Add ' . $this->plural;
            $labels->edit_item = 'Edit ' . $this->plural;
            $labels->new_item = $this->plural;
            $labels->view_item = 'View ' . $this->plural;
            $labels->search_items = 'Search ' . $this->plural;
            $labels->not_found = "No {$this->plural} found";
            $labels->not_found_in_trash = "No {$this->plural} found in Trash";
            $labels->all_items = 'All ' . $this->plural;
            $labels->menu_name = $this->plural;
            $labels->name_admin_bar = $this->plural;
        });
    }
}

return new Feature();
