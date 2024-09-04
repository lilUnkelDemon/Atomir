<?php

namespace Atomir\AtomirCore;

use Rakit\Validation\Validation;
use Rakit\Validation\Validator;

class Controller
{
    protected function validate(array $data,array $rules,array $messages) : Validation
    {

        // call the validation class
        $validator = new Validator($messages);

        // make sure the validator is registered .
        $validation = $validator->make($data, $rules);

        // validate the validation list
        $validation->validate();

        // return validation list from validation class instance.
        return $validation;

    }
    protected function render(string $view, array $data = [])
    {
        return (new View)->render($view,$data);
    }
}