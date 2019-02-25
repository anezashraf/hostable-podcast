<?php
/**
 * Created by IntelliJ IDEA.
 * User: testaccount123
 * Date: 16/02/19
 * Time: 05:58
 */

namespace App\Patcher;

use App\Entity\EntityInterface;
use App\Entity\Podcast;
use Rs\Json\Patch;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Patcher
{
    private $serializer;
    private $validator;
    private $entity;
    private $patchDocument;
    private $errors;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    public function makeChangesTo(EntityInterface &$entity) : self
    {
        $this->entity = $entity;

        return $this;
    }

    public function using(string $patchDocument) : self
    {
        $this->patchDocument = $patchDocument;

        return $this;
    }

    public function run() : self
    {
        $targetDocument = $this->serializer->serialize($this->entity, 'json', ['groups' => ['dashboard']]);

        $patch = (new Patch($targetDocument, $this->patchDocument))->apply();


        $this->serializer->deserialize(
            $patch,
            get_class($this->entity),
            'json',
            ['object_to_populate' => $this->entity]
        );

        $this->errors = $this->validator->validate($this->entity);
        return $this;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
