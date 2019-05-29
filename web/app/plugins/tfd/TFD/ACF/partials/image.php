<?php

namespace TFD\ACF\Partials;
use TFD\ACF;

class Image extends ACF\ACF
{
    public function configFields()
    {
        $this
            ->addImage('image', [
                'label' => 'Bild',
                'return_format' => Image::$configReturnFormat,
                'required' => true,
            ]);
    }
}
return new Image();
