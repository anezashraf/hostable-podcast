<?php
/**
 * Created by IntelliJ IDEA.
 * User: testaccount123
 * Date: 06/04/19
 * Time: 08:13
 */

namespace App\Tests\Resources;

use Faker\Generator;
use Faker\Provider\Base;

class FileLinkProvider extends Base
{
    private $imageLinks;
    private $audioLinks;

    public function __construct(Generator $generator)
    {
        parent::__construct($generator);

        $this->imageLinks = [
            '/image/image1.png',
            '/image/image2.png',
            '/image/image3.png',
            '/image/image4.png',
            '/image/image5.png',
            '/image/image6.png',
            '/image/image7.png',
            '/image/image8.png',
            '/image/image9.png',
            '/image/image10.png',
            '/image/image11.png',
            '/image/image12.png',
            '/image/image13.png',
            '/image/image14.png',
            '/image/image15.png',
            '/image/image16.png',
            '/image/image17.png',
            '/image/image18.png',
            '/image/image19.png',
            '/image/image20.png',
            '/image/image21.png',
            '/image/image22.png',
        ];

        $this->audioLinks = [
            '/audio/audio1.mp3',
            '/audio/audio2.mp3',
            '/audio/audio3.mp3',
            '/audio/audio4.mp3',
            '/audio/audio5.mp3',
            '/audio/audio6.mp3',
            '/audio/audio7.mp3',
            '/audio/audio8.mp3',
            '/audio/audio9.mp3',
            '/audio/audio10.mp3',
            '/audio/audio11.mp3',
            '/audio/audio12.mp3',
            '/audio/audio13.mp3',
            '/audio/audio14.mp3',
            '/audio/audio15.mp3',
            '/audio/audio16.mp3',
            '/audio/audio17.mp3',
            '/audio/audio18.mp3',
            '/audio/audio19.mp3',
            '/audio/audio20.mp3',
            '/audio/audio21.mp3',
        ];
    }

    public function audioLink()
    {
        return $this->getLink($this->audioLinks);
    }

    public function imageLink()
    {
        return $this->getLink($this->imageLinks);
    }

    private function getLink(array &$list) : string
    {
        $key = array_rand($list);
        $link = $list[$key];
        unset($list[$key]);
        $list = array_values($list);

        return $link;
    }
}
