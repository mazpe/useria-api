# USERIA-API

This project aims to test Phalcons PHP Framework API capabilities

### Return all users
#### /api/users
Returns a json with all users

Test
```
curl -i -X GET http://pahlcon:8888/useria-api/api/users
```

Output
```
[{"id":"1","name":"John","username":"johnsmith","description":"first test user"},{"id":"4","name":"Steven","username":"stevenuser","description":""},{"id":"2","name":"Test User","username":"username","description":""},{"id":"3","name":"User","username":"testUser","description":""}]
```

#### /api/users/search
User search for a particular user, username or user description

Test
```
curl -i -X GET http://pahlcon:8888/useria-api/api/users/search/test
```

Output
```
[{"id":"2","name":"Test User","username":"username","description":""},{"id":"3","name":"User","username":"testUser","description":""}]
```