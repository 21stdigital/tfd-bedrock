<?php

namespace TFD\CPT;

class Podcast extends CPT
{
    public $args = [];

    public function getNames()
    {
        return [
            'singular' => 'Podcast',
            'plural' => 'Podcasts',
        ];
    }
}

return new Podcast();
