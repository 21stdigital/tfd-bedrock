<?php

namespace TFD\CPT;

class PressReleases extends CPT
{
    protected static $slug = 'press';

    public static function getNames()
    {
        return [
            'singular' => esc_html__('Press Release', TEXT_DOMAIN_BACKEND),
            'plural' => esc_html__('Press Releases', TEXT_DOMAIN_BACKEND),
        ];
    }
}

return new PressReleases();
