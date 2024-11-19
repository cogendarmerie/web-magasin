<?php
namespace Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class AbstractController
{
    private $loader;
    protected $twig;

    public function __construct()
    {
        $this->loader = new FilesystemLoader(ROOT.'/views');
        $this->twig = new Environment($this->loader);
    }

    protected function display(string $view, array $params = [])
    {
        $this->twig->display($view, $params);
    }

    protected function redirect(string $url)
    {
        header("Location: $url");
        exit();
    }
}