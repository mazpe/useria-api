<?php

namespace Useria;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Message;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;
use Phalcon\Validation\Validator\InclusionIn;

class Users extends Model
{
    public function validation()
    {
        $validator = new Validation();
        
        // Type must be: master, admin or user
        $validator->add(
            "type",
            new InclusionIn(
                [
                    'message' => 'Type must be "master", "admin", or "user"',
                    'domain' => [
                        'master',
                        'admin',
                        'user',
                    ],
                ]
            )
        );

        // Username must be unique
        $validator->add(
            'username',
            new Uniqueness(
                [
                    'field'   => 'username',
                    'message' => 'The username must be unique',
                ]
            )
        );

        // Year cannot be less than zero
        if ($this->year < 0) {
            $this->appendMessage(
                new Message('The year cannot be less than zero')
            );
        }

        // Check if any messages have been produced
        if ($this->validationHasFailed() === true) {
            return false;
        }
    }
}