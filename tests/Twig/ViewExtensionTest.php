<?php

namespace App\Tests\Twig;

use App\Twig\ViewExtension;
use PHPUnit\Framework\TestCase;

class ViewExtensionTest extends TestCase
{
    public function testCutParagraphWithNum()
    {
        $extension = new ViewExtension();

        $sentence = "This is a very cool sentence. Today is a nice day. I hope this test passes otherwise I am fired. Does it make sense to skip?";

        $result = $extension->cutParagraph($sentence, 3);
        $this->assertEquals("This is a very cool sentence. Today is a nice day. I hope this test passes otherwise I am fired", $result);
        $this->assertNotContains("Does it make sense to skip?", $extension->cutParagraph($sentence, 3));
    }

    public function testCutParagraphWithBadNumber()
    {
        $sentence = "This is just one sentence even though we're asking for more.";

        $extension = new ViewExtension();

        $result = $extension->cutParagraph($sentence, 10);

        $this->assertEquals($sentence, $result);
    }

    public function testCutParagraphWithNoFullStops()
    {
        $sentence = "There are not full stops here, what a shame :(";

        $extension = new ViewExtension();

        $result = $extension->cutParagraph($sentence, 234);

        $this->assertEquals($sentence, $result);
    }

}
