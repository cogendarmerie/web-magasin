<?php

namespace Controllers;

class CustomerController extends Controller
{
    /**
     * Lister les clients
     * @return void
     */
    public function index()
    {
        $this->display('customer/index.html.twig');
    }

    public function create()
    {
        $this->display('customer/create.html.twig');
    }

    /**
     * Page détaillant une fiche client
     * @param $customerId
     * @return void
     */
    public function details($customerId)
    {
        $this->display('customer/details.html.twig');
    }
}