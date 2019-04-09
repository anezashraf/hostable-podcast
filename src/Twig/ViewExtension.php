<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ViewExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return array(
            new TwigFunction('cutParagraph', array($this, 'cutParagraph')),
        );
    }


    public function cutParagraph(string $text, int $numOfSentence)
    {

        $sentences = preg_split('/[.]/', $text);
        $cutSentences = array_slice($sentences, 0, $numOfSentence);


        return implode('.', $cutSentences);
    }
}
