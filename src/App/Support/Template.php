<?php

namespace Support;

class Template
{
    private \Twig\Environment $twigEnv;

    public function __construct(string $dir)
    {
        $loader = new \Twig\Loader\FilesystemLoader($dir);
        $this->twigEnv = new \Twig\Environment($loader);
    }

    public function render(string $view, array $data)
    {
        return $this->twigEnv->render($view, $data);
    }
}
