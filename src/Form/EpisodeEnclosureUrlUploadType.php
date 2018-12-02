<?php

namespace App\Form;

use App\Entity\Episode;
use App\Entity\Podcast;
use App\Form\Transformer\FileToStringTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EpisodeEnclosureUrlUploadType extends AbstractType
{
    private $fileToStringTransformer;

    public function __construct(FileToStringTransformer $fileToStringTransformer)
    {
        $this->fileToStringTransformer = $fileToStringTransformer;

    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('enclosureUrl', FileType::class, ['label' => 'Mp3 Audio File'])
            ->add('save', SubmitType::class);

        $builder->get('enclosureUrl')->addModelTransformer($this->fileToStringTransformer);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Episode::class,
        ]);
    }
}