<?php

namespace Mini\Controllers;

use Mini\Core\Controller;

class PageController extends Controller
{
    public function contact()
    {
        $this->render('pages/contact', ['title' => 'Contact']);
    }

    public function delivery()
    {
        $this->render('pages/delivery', ['title' => 'Livraison & Retours']);
    }

    public function faq()
    {
        $this->render('pages/faq', ['title' => 'FAQ']);
    }

    public function history()
    {
        $this->render('pages/history', ['title' => 'Histoire de la Maison']);
    }

    public function careers()
    {
        $this->render('pages/careers', ['title' => 'Carrières']);
    }

    public function sustainability()
    {
        $this->render('pages/sustainability', ['title' => 'Développement Durable']);
    }

    public function press()
    {
        $this->render('pages/press', ['title' => 'Presse']);
    }

    public function cgv()
    {
        $this->render('pages/cgv', ['title' => 'Conditions Générales de Vente']);
    }

    public function privacy()
    {
        $this->render('pages/privacy', ['title' => 'Politique de Confidentialité']);
    }

    public function cookies()
    {
        $this->render('pages/cookies', ['title' => 'Cookies']);
    }

    public function legal()
    {
        $this->render('pages/legal', ['title' => 'Mentions Légales']);
    }
}
