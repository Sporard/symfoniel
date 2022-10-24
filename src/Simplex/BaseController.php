<?php

namespace Simplex;


use Twig\Environment;

class BaseController {

    private Environment $twig;


    public function __construct()
    {
        $loader = new \Twig\Loader\FileSystemLoader(__DIR__ . '/../../templates');
        $this->twig = new Environment($loader,[ 'debug' => true]);
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());

    }

    public function render(string $path, array $args) {

        return $this->twig->render($path, $args);
        
    }

}
