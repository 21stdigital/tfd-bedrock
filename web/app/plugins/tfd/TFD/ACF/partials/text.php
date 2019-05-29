<?php

namespace TFD\ACF\Partials;

use TFD\ACF;

class Text extends ACF\ACF
{
    public function configFields()
    {
        $this
            ->addText('text', [
                'label' => esc_html__('Partial Text')
            ]);
    }
}
return  new Text();
