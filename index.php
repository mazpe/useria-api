<?php

use Phalcon\Loader;
use Phalcon\Mvc\Micro;
use Phalcon\Http\Response;
use Phalcon\Di\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;

// Use Loader() to autoload our model
$loader = new Loader();

$loader->registerNamespaces(
    [
        'Useria' => __DIR__ . '/models/',
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
    function () use ($app) {
        $phql = 'SELECT * FROM Useria\Users ORDER BY name';

        $users = $app->modelsManager->executeQuery($phql);

        $data = [];

        foreach ($users as $user) {
            $data[] = [
                'id'   => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'description' => $user->description
            ];
        }

        echo json_encode($data);
    }
    
);

// Searches for users with $name in their name
$app->get(
    '/api/users/search/{name}',
    function ($name) use ($app) {
        $phql = 'SELECT * FROM Useria\Users 
        WHERE name LIKE :name: 
        OR username LIKE :name:
        OR description LIKE :name:
        ORDER BY name';

        $users = $app->modelsManager->executeQuery(
            $phql,
            [
                'name'      => '%' . $name . '%'
            ]
        );

        $data = [];

        foreach ($users as $user) {
            $data[] = [
                'id'   => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'description' => $user->description
            ];
        }

        echo json_encode($data);
    }
);

// Retrieves users based on primary key
$app->get(
    '/api/users/{id:[0-9]+}',
    function ($id) use ($app) {
        $phql = 'SELECT * FROM Useria\Users WHERE id = :id:';

        $user = $app->modelsManager->executeQuery(
            $phql,
            [
                'id' => $id,
            ]
        )->getFirst();

        // Create a response
        $response = new Response();

        if ($user === false) {
            $response->setJsonContent(
                [
                    'status' => 'NOT-FOUND'
                ]
            );
        } else {
            $response->setJsonContent(
                [
                    'status' => 'FOUND',
                    'data'   => [
                        'id'   => $user->id,
                        'name' => $user->name,
                        'username' => $user->username,
                        'description' => $user->description
                    ]
                ]
            );
        }

        return $response;
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