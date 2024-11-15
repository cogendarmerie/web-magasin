<?php
namespace Controllers;

class ProductsController extends Controller
{
    public function index(): void
    {
        $this->twig->display('products/index.html.twig');
    }
}