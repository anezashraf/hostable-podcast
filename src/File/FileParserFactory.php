<?php
/**
 * Created by IntelliJ IDEA.
 * User: testaccount123
 * Date: 29/04/19
 * Time: 16:25
 */

namespace App\File;

use InvalidArgumentException;

final class FileParserFactory
{
    public static function create(string $value, string $fileType) : FileParserInterface
    {
        switch ($value) {
            case is_file($value):
                return new LocalHostFileParser($value, $fileType);
                break;
            case filter_var($value, FILTER_VALIDATE_URL):
                return new UrlFileParser($value, $fileType);
                break;
            default:
                throw new InvalidArgumentException("Invalid file, must be valid url or local file");
        }
    }
}
