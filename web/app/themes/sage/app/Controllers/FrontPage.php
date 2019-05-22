<?php

namespace App\Controllers;

use Sober\Controller\Controller;
use TFD;

class FrontPage extends Controller
{
    public function image()
    {
        return TFD\Image::find(6);
    }
}
