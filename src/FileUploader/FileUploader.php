<?php

namespace App\FileUploader;

use App\Entity\Episode;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\OptionsResolver\OptionsResolver;
use UnexpectedValueException;

class FileUploader
{
    private $directory;

    public function __construct(string $directory)
    {
        $this->directory = $directory;
    }

    public function upload(UploadedFile $file)
    {
        $extension = $file->getClientOriginalExtension();
        $fileName = $file->getClientOriginalName();

        switch ($extension) {
            case 'png':
                $location = "img";
                break;
            case 'mp3':
                $location = "mp3";
                break;
            default:
                throw new UnexpectedValueException("Unsupported file typr");
        }

        $directory = "$this->directory/$location";

        $file->move($directory, $fileName);

        return "${directory}/${fileName}";
    }
}
