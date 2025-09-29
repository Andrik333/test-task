<?php

namespace App\Components\Templater;

use Twig\Extension\AttributeExtension;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class Twig
{
    /**
     * @var string
     */
    private string $templateDir = '';

    /**
     * @var string
     */
    private string $templateDirCache = '';

    public function __construct()
    {
        $this->templateDir = $_SERVER['PROJECT_ROOT'] . 'templates';
        $this->templateDirCache = $_SERVER['PROJECT_ROOT'] . implode(DIRECTORY_SEPARATOR, ['var', 'cache', 'twig']);
    }

    /**
     * @return Environment
     */
    public function init(): Environment
    {
        $loader = new FilesystemLoader($this->templateDir);
        $twig = new Environment($loader, [
            // 'cache' => $this->templateDirCache,
        ]);
        $twig->addExtension(new AttributeExtension(TwigExtension::class));

        // $twig->addRuntimeLoader(new \Twig\RuntimeLoader\FactoryRuntimeLoader([
        //     TwigExtension::class => function () use ($lipsumProvider) {
        //         return new TwigExtension($lipsumProvider);
        //     },
        // ]));
        return $twig;
    }
}
