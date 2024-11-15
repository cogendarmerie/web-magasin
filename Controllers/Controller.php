<?php
namespace Controllers;

abstract class Controller
{
    protected function render(string $view, array $params = []): void
    {
        extract($params);
        require_once "../views/$view.php";
    }
}