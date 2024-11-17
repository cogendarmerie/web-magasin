<?php

namespace Controllers;

use Domain\Order;
use Domain\Product\Alimentaire;
use Infra\Orm\CustomerOrm;
use Infra\Orm\OrderOrm;

class OrderController extends Controller
{
    protected OrderOrm $orm;

    public function __construct()
    {
        parent::__construct();
        $this->orm = new OrderOrm();
    }

    public function index(): void
    {
        $orders = $this->orm->getAll();
        var_dump($orders);
        exit();
        $this->display('order/index.html.twig', ['orders' => $orders]);
    }
}