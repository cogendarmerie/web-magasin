<?php

namespace Controllers;

class HomeController extends AbstractController
{
    public function index()
    {
        $this->display('home/index.html.twig', [
            "title" => "Home",
        ]);
    }
}