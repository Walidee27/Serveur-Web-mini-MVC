<?php

namespace Mini\Controllers;

use Mini\Core\Controller;

class CollectionsController extends Controller
{
    public function index()
    {
        $this->render('collections/index', ['title' => 'Nos Collections']);
    }
}
