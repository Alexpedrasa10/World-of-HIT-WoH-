#  World-of-HIT-WoH- API

## Usage
### Admin endpoints

Always use the token of the user.
Bearer token for admin: 101010101010101010

POST /api/user

Type should be "HUM" or "ZOM"

REQUEST
```json
{
	"name": "John John",
    "email" : "john@gmail.com",
    "type" : "HUM"
}
```
RESPONSE
```json
{
    "user": {
        "name": "John John",
        "email" : "john@gmail.com",
        "api_token" : "sa65a6as897987",
        "type_id" : "2",
        "updated_at": "2023-03-25T22:40:02.000000Z",
        "created_at": "2023-03-25T22:40:02.000000Z",
        "id": 2
    }
}
```
POST /api/item

Type should be "SHI", "WAEA" or "BOOT"

REQUEST
```json
{
    "name": "Capa",
    "type": "SHI",
    "shield": "26",
    "attack": "8",
}
```
RESPONSE
```json
{
    "item": {
        "name": "Capa",
        "type_id": 6,
        "shield": "26",
        "attack": "8",
        "updated_at": "2023-03-25T22:41:16.000000Z",
        "created_at": "2023-03-25T22:41:16.000000Z",
        "id": 1
    }
}
```
PUT /api/item/{id}

Type should be "SHI", "WAEA" or "BOOT"

REQUEST
```json
{
    "name": "Capa",
    "type": "SHI",
    "shield": "22",
    "attack": "3",
}
```
RESPONSE
```json
{
    "item": {
        "id": 1,
        "name": "Capa",
        "type_id": 6,
        "shield": "22",
        "attack": "3",
        "updated_at": "2023-03-25T22:45:16.000000Z",
        "created_at": "2023-03-25T22:41:16.000000Z",        
    }
}
```
GET api/usersUlti

RESPONSE
```json
{
    "users": [
        {
            "id": 2,
            "name": "John John",
            "email" : "john@gmail.com",
            "api_token" : "sa65a6as897987",
            "type_id" : "2",
            "life": 100,
            "ulti": 1,
            "created_at": "2023-03-25T22:40:02.000000Z",
            "updated_at": "2023-03-25T22:43:08.000000Z"
        }
    ]
}
```

### Player endpoints

POST api/assignItem
```json
{
    "item_id":1
}

RESPONSE
```json
{
    "message": "Item assigned succesfully"
}
```

POST api/attackBodyToBody
```json
{
    "victim_id":1
}

RESPONSE
```json
{
    "message": "Attack succesfully.",
    "victim": {
        "id": 1,
        "name": "Alex admin",
        "email": "apedrasa@argentina.ar",
        "api_token": "101010101010101010",
        "type_id": null,
        "life": 54.2,
        "ulti": 0,
        "created_at": "2023-03-25T22:33:52.000000Z",
        "updated_at": "2023-03-25T22:43:08.000000Z",
        "shield": 5
    },
    "aggressor": {
        "id": 2,
        "name": "John John",
        "email" : "john@gmail.com",
        "api_token" : "sa65a6as897987",
        "type_id" : "2",
        "life": 100,
        "ulti": true,
        "created_at": "2023-03-25T22:40:02.000000Z",
        "updated_at": "2023-03-25T22:43:08.000000Z",
        "powerAttack": 31
    }
}
```

POST api/rangedAttack
```json
{
    "victim_id":1
}

RESPONSE
```json
{
    "message": "Ranged attack succesfully.",
    "victim": {
        "id": 1,
        "name": "Alex admin",
        "email": "apedrasa@argentina.ar",
        "api_token": "101010101010101010",
        "type_id": null,
        "life": 54.2,
        "ulti": 0,
        "created_at": "2023-03-25T22:33:52.000000Z",
        "updated_at": "2023-03-25T22:43:08.000000Z",
        "shield": 5
    },
    "aggressor": {
        "id": 2,
        "name": "John John",
        "email" : "john@gmail.com",
        "api_token" : "sa65a6as897987",
        "type_id" : "2",
        "life": 100,
        "ulti": true,
        "created_at": "2023-03-25T22:40:02.000000Z",
        "updated_at": "2023-03-25T22:43:08.000000Z",
        "powerAttack": 24.8
    }
}
```

POST api/ulti
```json
{
    "victim_id":1
}

RESPONSE
```json
{
    "message": "Ulti succesfully.",
    "victim": {
        "id": 1,
        "name": "Alex admin",
        "email": "apedrasa@argentina.ar",
        "api_token": "101010101010101010",
        "type_id": null,
        "life": 54.2,
        "ulti": 0,
        "created_at": "2023-03-25T22:33:52.000000Z",
        "updated_at": "2023-03-25T22:43:08.000000Z",
        "shield": 5
    },
    "aggressor": {
        "id": 2,
        "name": "John John",
        "email" : "john@gmail.com",
        "api_token" : "sa65a6as897987",
        "type_id" : "2",
        "life": 100,
        "ulti": true,
        "created_at": "2023-03-25T22:40:02.000000Z",
        "updated_at": "2023-03-25T22:43:08.000000Z",
        "powerAttack": 62
    }
}
```