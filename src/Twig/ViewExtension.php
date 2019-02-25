<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ViewExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return array(
            new TwigFunction('imageUrl', array($this, 'imageUrl')),
        );
    }

    public function imageUrl(string $image)
    {
        dd($image);
    }
}
