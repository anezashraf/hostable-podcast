<?php
/**
 * Created by IntelliJ IDEA.
 * User: testaccount123
 * Date: 29/04/19
 * Time: 16:28
 */

namespace App\File;

interface FileParserInterface
{
    public function isValid() : bool;

    public function getFormattedEnclosure() : string;
}
