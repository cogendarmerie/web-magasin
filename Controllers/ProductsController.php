<?php
namespace Controllers;

class ProductsController extends Controller
{
    public function index(): void
    {
        $this->render('products/index');
    }
}