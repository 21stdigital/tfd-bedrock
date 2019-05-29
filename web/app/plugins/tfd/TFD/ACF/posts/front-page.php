<?php

namespace TFD\ACF;

class FrontPage extends ACF
{
    public function locateFields()
    {
        return $this->setLocation('page_type', '==', $this->id);
    }
}

$frontPage = new FrontPage();

$frontPage
    ->addText('text2', [
        'label' => esc_html__('Text')
    ])
    ->addFields($frontPage->partial('partials.image', [
        'image'=> [
            'required' => TRUE,
        ]
    ]))
    ->addFields($frontPage->partial('partials.text', []));

return $frontPage;
