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
                'id'            => $user->id,
                'name'          => $user->name,
                'username'      => $user->username,
                'description'   => $user->description,
                'type'          => $user->type
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
        OR type LIKE :name:
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
                'id'            => $user->id,
                'name'          => $user->name,
                'username'      => $user->username,
                'description'   => $user->description,
                'type'          => $user->type
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
                        'id'            => $user->id,
                        'name'          => $user->name,
                        'username'      => $user->username,
                        'description'   => $user->description,
                        'type'          => $user->type
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
    function () use ($app) {
        $user = $app->request->getJsonRawBody();

        $phql = 'INSERT INTO Useria\Users (name, username, description, type) VALUES (:name:, :username:, :description:, :type:)';

        $status = $app->modelsManager->executeQuery(
            $phql,
            [
                'name'          => $user->name,
                'username'      => $user->username,
                'description'   => $user->description,
                'type'          => $user->type
            ]
        );

        // Create a response
        $response = new Response();

        // Check if the insertion was successful
        if ($status->success() === true) {
            // Change the HTTP status
            $response->setStatusCode(201, 'Created');

            $user->id = $status->getModel()->id;

            $response->setJsonContent(
                [
                    'status' => 'OK',
                    'data'   => $user,
                ]
            );
        } else {
            // Change the HTTP status
            $response->setStatusCode(409, 'Conflict');

            // Send errors to the client
            $errors = [];

            foreach ($status->getMessages() as $message) {
                $errors[] = $message->getMessage();
            }

            $response->setJsonContent(
                [
                    'status'   => 'ERROR',
                    'messages' => $errors,
                ]
            );
        }

        return $response;
    }
);

// Updates users based on primary key
$app->put(
    '/api/users/{id:[0-9]+}',
    function ($id) use ($app) {
        $user = $app->request->getJsonRawBody();

        $phql = 'UPDATE Useria\Users SET name = :name:, username = :username:, description = :description:, type = :type: WHERE id = :id:';

        $status = $app->modelsManager->executeQuery(
            $phql,
            [
                'id'            => $user->id,
                'name'          => $user->name,
                'username'      => $user->username,
                'description'   => $user->description,
                'type'          => $user->type
            ]
        );

        // Create a response
        $response = new Response();

        // Check if the insertion was successful
        if ($status->success() === true) {
            $response->setJsonContent(
                [
                    'status' => 'OK'
                ]
            );
        } else {
            // Change the HTTP status
            $response->setStatusCode(409, 'Conflict');

            $errors = [];

            foreach ($status->getMessages() as $message) {
                $errors[] = $message->getMessage();
            }

            $response->setJsonContent(
                [
                    'status'   => 'ERROR',
                    'messages' => $errors,
                ]
            );
        }

        return $response;
    }
);

// Deletes users based on primary key
$app->delete(
    '/api/users/{id:[0-9]+}',
    function ($id) use ($app) {
        $phql = 'DELETE FROM Useria\Users WHERE id = :id:';

        $status = $app->modelsManager->executeQuery(
            $phql,
            [
                'id' => $id,
            ]
        );

        // Create a response
        $response = new Response();

        if ($status->success() === true) {
            $response->setJsonContent(
                [
                    'status' => 'OK'
                ]
            );
        } else {
            // Change the HTTP status
            $response->setStatusCode(409, 'Conflict');

            $errors = [];

            foreach ($status->getMessages() as $message) {
                $errors[] = $message->getMessage();
            }

            $response->setJsonContent(
                [
                    'status'   => 'ERROR',
                    'messages' => $errors,
                ]
            );
        }

        return $response;
    }
);

$app->handle();