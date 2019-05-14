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
[{"id":"1","name":"Lester"},{"id":"2","name":"Test User"},{"id":"3","name":"Test User"}]
```