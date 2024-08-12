<?php

namespace App\Service;

use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DataValidator
{
    public function __construct(private ValidatorInterface $validator)
    {
    }

    public function validateData($data)
    {
        $errors = $this->validator->validate($data);
        if (count($errors) > 0) {
            throw new ValidationFailedException($data, $errors);
        }
    }

    public function processErrors(ConstraintViolationListInterface $errors): array
    {
        $errorsDetails = [];
        foreach ($errors as $error) {
            $errorsDetails[$error->getPropertyPath()] = $error->getMessage();
        }

        return $errorsDetails;
    }
}
