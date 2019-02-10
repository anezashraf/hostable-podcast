<?php
/**
 * Created by IntelliJ IDEA.
 * User: testaccount123
 * Date: 16/02/19
 * Time: 06:27
 */

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\ConstraintViolationList;


class ApiStructure
{
    /**
     *
     * @Groups("dashboard")
     */
    private $data;


    /**
     *
     * @Groups("dashboard")
     */
    private $metadata;

    public function __construct($data, $metadata)
    {
        $this->data = $data;
        $this->metadata = $metadata;

    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;
    }

    public function getMetadata()
    {
        return $this->metadata;
    }

    public static function create($data, ConstraintViolationList $errors) : ApiStructure
    {
        $metadata = [];

        foreach ($errors as $error) {
            $metadata['errors'][] = ['field' => $error->getPropertyPath(), 'message' => $error->getMessage()];
        }

        $metadata['hasErrors'] = isset($metadata['errors']) ? true : false;

        return new ApiStructure($data, $metadata);
    }
}