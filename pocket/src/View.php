<?php

namespace Atomir\AtomirCore;

use Jenssegers\Blade\Blade;

class View
{

    protected Blade $blade;

    public function __construct()
    {

        $this->blade = new Blade(
            Application::$ROOT_DIR . DIRECTORY_SEPARATOR . "resources" . DIRECTORY_SEPARATOR . "views",
            Application::$ROOT_DIR . DIRECTORY_SEPARATOR . "storage" . DIRECTORY_SEPARATOR . "cache" . DIRECTORY_SEPARATOR . "views"
        );

    }

    public function render(string $view, array $data = []): string
    {
        return $this->blade->render($view, $data);

    }

}