<?php

use Phalcon\Loader;
use Phalcon\Mvc\Micro;
use Phalcon\Di\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;

// Use Loader() to autoload our model
$loader = new Loader();

$loader->registerNamespaces(
    [
        'Useria\Users' => __DIR__ . '/models/',
    ]
);

$loader->register();

$di = new FactoryDefault();

// Set up the database service
$di->set(
    'db',
    function () {
        return new PdoMysql(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'root',
                'dbname'   => 'useria',
            ]
        );
    }
);

// Create and bind the DI to the application
$app = new Micro($di);

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