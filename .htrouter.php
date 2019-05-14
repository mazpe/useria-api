<?php

use Phalcon\Mvc\Micro;

$app = new Micro();

// Retrieves all users
$app->get(
    '/api/users',
    function () {
        // Operation to fetch all the users
    }
);

// Searches for users with $name in their name
$app->get(
    '/api/users/search/{name}',
    function ($name) {
        // Operation to fetch user with name $name
    }
);

// Retrieves users based on primary key
$app->get(
    '/api/users/{id:[0-9]+}',
    function ($id) {
        // Operation to fetch user with id $id
    }
);

// Adds a new user
$app->post(
    '/api/users',
    function () {
        // Operation to create a fresh user
    }
);

// Updates users based on primary key
$app->put(
    '/api/users/{id:[0-9]+}',
    function ($id) {
        // Operation to update a user with id $id
    }
);

// Deletes users based on primary key
$app->delete(
    '/api/users/{id:[0-9]+}',
    function ($id) {
        // Operation to delete the user with id $id
    }
);

$app->handle();