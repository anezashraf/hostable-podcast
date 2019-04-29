<?php

namespace App\File;

class LocalHostFileParser implements FileParserInterface
{
    const VALID_AUDIO_TYPES = ['audio/mp3', 'audio/mp4', 'audio/mpeg'];
    const VALID_IMAGE_TYPES = ['image/jpeg', 'image/png'];

    private $value;
    private $dest;
    private $filename;
    private $validTypes;
    private $fileType;

    public function __construct(string $value, string $fileType)
    {
        $this->value = $value;
        $this->fileType = $fileType;

        $this->filename = basename($this->value);
        $this->dest = __DIR__ . "/../../public/$this->fileType/$this->filename";

        $this->validTypes = self::VALID_AUDIO_TYPES;

        if ($fileType === 'image') {
            $this->validTypes = self::VALID_IMAGE_TYPES;
        }
    }

    public function isValid(): bool
    {
        $contentType = mime_content_type($this->value);

        if (in_array($contentType, $this->validTypes)) {
            return true;
        }

        return false;
    }

    public function getFormattedEnclosure(): string
    {
        copy($this->value, $this->dest);

        return "/$this->fileType/$this->filename";
    }
}
