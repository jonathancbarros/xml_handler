XML Handler
================

## Setting the environment up!

Basically you need to have PHP, MySQL and Composer installed in order to run this application, I strongly recommend the following versions:

```
PHP >= 7.1
MySQL 5.7 (I had problem when trying to using a different version)
```
After installing those dependencies, make sure to have this repository on your local machine. So inside the project, you are going to follow theses steps:
```
Run 'composer update'

Access your MySQL database and create a database with the name you want.

Copy the file .env.dist and rename it to .env

Inside the .env file, look for the line starting with DATABASE and fill it out with your 
database's credentials (Including the database name you just created)

Now you perform the database migrations by running the following command and answer to the prompted questions:

php bin/console doctrine:migrations:migrate

If you didn't have any problem so far and the migrations were ran successfully, you are good to start the server by running:

php -S 127.0.0.1:8000 -t public
```

Now you are good to go, access **http://127.0.0.1:8000** and upload/process a XML file.

## API Documentation

### GET /people

##### Returns:

```
200 OK
Content-Type: "application/json"

[
    {
        "id": 43,
        "name": "Name 1",
        "phones": [
            {
                "id": 52,
                "person": "Name 1",
                "number": 1010101
            },
            {
                "id": 53,
                "person": "Name 1",
                "number": 1234567
            }
        ],
        "personId": 1,
        "shipOrders": []
    },
    {
        "id": 44,
        "name": "Name 2",
        "phones": [
            {
                "id": 54,
                "person": "Name 2",
                "number": 4444444
            }
        ],
        "personId": 2,
        "shipOrders": []
    },
    {
        "id": 45,
        "name": "Name 3",
        "phones": [
            {
                "id": 55,
                "person": "Name 3",
                "number": 7777777
            },
            {
                "id": 56,
                "person": "Name 3",
                "number": 8888888
            }
        ],
        "personId": 3,
        "shipOrders": []
    }
]
```

### GET /people/{id}

Attribute | Description
----------| -----------
id    | Person ID

##### Returns:

```
200 OK
Content-Type: "application/json"

{
    "id": 43,
    "name": "Name 1",
    "phones": [
        {
            "id": 52,
            "person": "Name 1",
            "number": 1010101
        },
        {
            "id": 53,
            "person": "Name 1",
            "number": 1234567
        }
    ],
    "personId": 1,
    "shipOrders": []
}
```

##### Errors:

Error | Description
----- | ------------
404   | Person Not Found


### GET /orders

#### Returns

```
200 OK
Content-Type: "application/json"

[
    {
        "id": 6,
        "orderId": 2,
        "orderPerson": {
            "id": 44,
            "name": "Name 2",
            "phones": [
                {
                    "id": 54,
                    "person": "Name 2",
                    "number": 4444444
                }
            ],
            "personId": 2,
            "shipOrders": [
                2
            ],
            "__initializer__": null,
            "__cloner__": null,
            "__isInitialized__": true
        },
        "shippingName": "Name 2",
        "shippingAddress": "Address 2",
        "shippingCity": "City 2",
        "shippingCountry": "Country 2",
        "items": [
            {
                "id": 8,
                "shipOrder": 2,
                "title": "Title 2",
                "note": "Note 2",
                "quantity": 45,
                "price": 13.45
            }
        ]
    },
    {
        "id": 7,
        "orderId": 3,
        "orderPerson": {
            "id": 45,
            "name": "Name 3",
            "phones": [
                {
                    "id": 55,
                    "person": "Name 3",
                    "number": 7777777
                },
                {
                    "id": 56,
                    "person": "Name 3",
                    "number": 8888888
                }
            ],
            "personId": 3,
            "shipOrders": [
                3
            ],
            "__initializer__": null,
            "__cloner__": null,
            "__isInitialized__": true
        },
        "shippingName": "Name 3",
        "shippingAddress": "Address 3",
        "shippingCity": "City 3",
        "shippingCountry": "Country 3",
        "items": [
            {
                "id": 9,
                "shipOrder": 3,
                "title": "Title 3",
                "note": "Note 3",
                "quantity": 5,
                "price": 1.12
            },
            {
                "id": 10,
                "shipOrder": 3,
                "title": "Title 4",
                "note": "Note 4",
                "quantity": 2,
                "price": 77.12
            }
        ]
    }
]
```


### GET /orders/{id}

Attribute | Description
----------| -----------
id    | Order ID

#### Returns

```
200 Ok
Content-Type: "application/json"

{
    "id": 6,
    "orderId": 2,
    "orderPerson": {
        "id": 44,
        "name": "Name 2",
        "phones": [
            {
                "id": 54,
                "person": "Name 2",
                "number": 4444444
            }
        ],
        "personId": 2,
        "shipOrders": [
            2
        ],
        "__initializer__": null,
        "__cloner__": null,
        "__isInitialized__": true
    },
    "shippingName": "Name 2",
    "shippingAddress": "Address 2",
    "shippingCity": "City 2",
    "shippingCountry": "Country 2",
    "items": [
        {
            "id": 8,
            "shipOrder": 2,
            "title": "Title 2",
            "note": "Note 2",
            "quantity": 45,
            "price": 13.45
        }
    ]
}
```

##### Errors

Error | Description
----- | ------------
404   | Order Not Found
