<?php

namespace App\File;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private const IMAGE_EXTENSIONS = ['jpeg', 'jpg', 'png'];

    private $targetDirectory;


    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function upload(UploadedFile $file)
    {
        $clientOriginalFilename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $originalFilename = substr($clientOriginalFilename, 0, strpos($clientOriginalFilename, "."));

        $fileName = rawurlencode("$originalFilename.$extension");

        $subdirectory = '/audio';

        if (in_array($extension, self::IMAGE_EXTENSIONS)) {
            $subdirectory = '/image';
        }

        $directoryPath = $this->getTargetDirectory() . $subdirectory;

        try {
            $file->move($directoryPath, $fileName);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return "$subdirectory/$fileName";
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}