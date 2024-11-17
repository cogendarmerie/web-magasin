<?php

namespace Infra\Orm;

use Domain\Order;
use Infra\Orm;

class OrderOrm extends Orm
{
    public function __construct()
    {
        parent::__construct("orders");
    }

    /**
     * Récupérer toutes les commandes
     * @return array
     */
    public function getAll()
    {
        $o = $this->findAll();
        $orders = array();

        return $o;
    }
}