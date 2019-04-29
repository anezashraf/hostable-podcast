<?php

namespace App\File;

use GuzzleHttp\Client;

class UrlFileParser implements FileParserInterface
{

    const AUDIO_TYPES = ['audio/mpeg', 'audio/mp4'];
    const IMAGE_TYPES = ['image/jpeg', 'image/png'];
    private $value;
    private $validTypes;

    public function __construct(string $value, string $fileType)
    {
        $this->value = $value;

        $this->validTypes = self::AUDIO_TYPES;

        if ($fileType === 'image') {
            $this->validTypes = self::IMAGE_TYPES;
        }
    }

    public function isValid(): bool
    {
        $response = (new Client)->request('GET', $this->value);

        $contentType = $response->getHeaderLine("Content-Type");

        if (in_array($contentType, $this->validTypes)) {
            return true;
        }

        return false;
    }

    public function getFormattedEnclosure(): string
    {
        return $this->value;
    }
}
