<?php

namespace TFD\Image\Sizes;

class LandscapeGray extends SizeGroup
{
    public $effect = 'grayscale';
    public $sources =  null;


    public $detailedSources = [
        [
            'media' => '(min-width: 36em)',
            'srcset' => [
                [720, 540],
                [640, 480],
                [320, 240],
            ],
            'sizes' => [
                "50vw"
            ],
        ],
        [
            'media' => '',
            'srcset' => [720, 720],
            'sizes' => '',
        ],
    ];
}
