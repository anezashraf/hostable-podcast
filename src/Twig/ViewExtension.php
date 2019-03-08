<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ViewExtension extends AbstractExtension
{
    private $host;

    public function __construct(string $host)
    {
        $this->host = $host;
    }

    public function getFunctions()
    {
        return array(
            new TwigFunction('imageUrl', array($this, 'imageUrl')),
            new TwigFunction('firstSentence', array($this, 'firstSentence')),
        );
    }

    public function imageUrl(string $image)
    {
        return $this->host . $image;
    }

    public function firstSentence(string $text)
    {
        //TODO:// implement first sentence
        return $text;
    }
}
