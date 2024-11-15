<?php

namespace Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $this->display('home/index.html.twig', [
            "title" => "Home",
        ]);
    }
}