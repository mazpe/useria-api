# USERIA-API

This project aims to test Phalcon's PHP Framework API capabilities

### Todo 
- Test validations from Models

### Retrieve all users
#### GET /api/users
Returns a json with all users

Test
```
curl -i -X GET http://pahlcon:8888/useria-api/api/users
```

Output
```
[
    {
        "id":"1",
        "name":"John",
        "username":"johnsmith",
        "description":"first test user",
        "type":""
    },
    {
        "id":"4",
        "name":"Steven",
        "username":"stevenuser",
        "description":"",
        "type":""
        },
    {
        "id":"2",
        "name":"Test User",
        "username":"username",
        "description":"",
        "type":""
        },
    {
        "id":"3",
        "name":"User",
        "username":"testUser",
        "description":"",
        "type":""
        }
]
```

### Search users
#### GET /api/users/search
User search for a particular user, username or user description

Test
```
curl -i -X GET http://pahlcon:8888/useria-api/api/users/search/test
```

Output
```
[
    {
        "id":"2",
        "name":"Test User",
        "username":"username",
        "description":"",
        "type":""
    },
    {
        "id":"3",
        "name":"User",
        "username":"testUser",
        "description":"",
        "type":""
    }
]
```

### Search user by id
#### GET /api/users/search/1
User search for a particular user, username or user description

Test
```
curl -i -X GET http://pahlcon:8888/useria-api/api/users/search/1
```

Output
```
{
    "status": "FOUND",
    "data": {
        "id": "1",
        "name": "John",
        "username": "johnsmith",
        "description": "first test user",
        "type":""
    }
}
```

### Create a user 
#### POST /api/users
Create a user 

Test
```
curl -i -X POST -d '{"name":"Steve","username":"steve1","description":"testing api crease","type":"user"}'
    http://pahlcon:8888/useria-api/api/users
```

Output
```
{
    "status": "OK",
    "data": {
        "name": "Steve",
        "username": "steve1",
        "description": "testing api crease user",
        "id": "11"
    }
}
```

### Update a user 
#### PUT /api/users/11
Update a user 

Test
```
curl -i -X PUT -d '{"name":"Steve","username":"steveUpdated","description":"testing api crease","type":"user"}'
    http://pahlcon:8888/useria-api/api/users/11
```

Output
```
{
    "status": "OK"
}
```

### Delete a user 
#### DELETE /api/users/11
Update a user 

Test
```
curl -i -X DELETE http://pahlcon:8888/useria-api/api/users/11
```

Output
```
{
    "status": "OK"
}
```