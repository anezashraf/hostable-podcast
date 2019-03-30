<?php

namespace App\Installation;

abstract class AbstractInstaller
{
    /**
     * @var InstallQuestion[] $questions
     */
    private $questions;

    public function getQuestions() : array
    {
        return [];
    }

    public function setQuestions(array $questions)
    {
        $this->questions = $questions;
    }

    public function findAnswer(string $questionName)
    {
        foreach ($this->questions as $question) {
            if ($questionName === $question->getName()) {
                return $question->getAnswer();
            }
        }

        throw new InstallerException("Cannot find question by name");
    }
}
