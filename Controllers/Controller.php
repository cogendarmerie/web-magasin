<?php
namespace Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class Controller
{
    private $loader;
    protected $twig;

    public function __construct()
    {
        $this->loader = new FilesystemLoader(ROOT.'/views');
        $this->twig = new Environment($this->loader);
    }
}