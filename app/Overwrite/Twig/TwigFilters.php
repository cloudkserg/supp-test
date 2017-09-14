<?php
namespace App\Overwrite\Twig;
class TwigFilters extends \Twig_Extension
{
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('get_env', [$this, 'getEnv']),
            new \Twig_SimpleFunction('assets_path', [$this, 'getAssetsPath']),
        ];
    }
    public function getEnv($variable)
    {
        return env($variable);
    }

    public function getAssetsPath($variable)
    {
        return resource_path('assets/' . $variable);
    }

}