<?php

namespace Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $this->twig->display('home/index.html.twig', [
            "title" => "Home",
        ]);
    }
}