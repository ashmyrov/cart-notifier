# Shopping cart notificator
    //TODO: Add validation errors text
    //TODO: Fix update products in cart by adding to existing products
    //TODO: Add remove products from cart
    //TODO: tests

## Prepare project

1. Make git clone.
2. Go to project directory.
3. Run `make init` and wait build the project.

## Working with API

### Customers

#### Create customer

##### Params

- `email`, `string`, `required`, customer email
- `name`, `string`, `optional`, customer name

##### Request
```http request
POST /api/v1/customers

{
    "email": "test@test.com"
}
```
##### Response

```json
{
    "id": 1,
    "email": "test@test.com"
}
```

#### Get list of customers

##### Request
```http request
GET /api/v1/customers
```
##### Response

```json
[
    {
        "id": 1,
        "email": "test@test.com"
    },
    {
        "id": 2,
        "email": "some@email.com"
    }
]
```

### Products

#### Create product

##### Params

- `code`, `string`, `required`, product code
- `name`, `string`, `required`, product name
- `price`, `integer`, `required`, product price

##### Request
```http request
POST /api/v1/products

{
    "code": "product_code",
    "name": "Product name",
    "price": 10
}
```
##### Response

```json
{
    "id": 1,
    "code": "product_code",
    "name": "Product name",
    "price": 10
}
```

#### Get list of products

##### Request
```http request
GET /api/v1/products
```
##### Response

```json
[
    {
        "id": 1,
        "code": "product_code",
        "name": "Product name",
        "price": 10
    },
    {
        "id": 2,
        "code": "product_code2",
        "name": "Product name 2",
        "price": 20
    },
    {
        "id": 3,
        "code": "product_code3",
        "name": "Product name 3",
        "price": 30
    }
]
```

### Carts

#### Create cart

##### Params

- `customer`, `integer`, `required`, customer id
- `products`, `integer[]`, `optional`, product ids

##### Request
```http request
POST /api/v1/carts

{
    "customer": 1,
    "products": [
        1,2
    ]
}
```
##### Response

```json
{
    "id": 1,
    "createAt": "2021-07-30T01:21:01+00:00",
    "customer": {
        "id": 1,
        "email": "test@test.com"
    },
    "products": [
      {
        "id": 1,
        "code": "product_code",
        "name": "Product name",
        "price": 10
      },
      {
        "id": 2,
        "code": "product_code2",
        "name": "Product name 2",
        "price": 20
      }
    ],
    "status": 0
}
```

#### Get list of carts

##### Request
```http request
GET /api/v1/carts

{
    "customer": 1,
    "products": [
        3
    ]
}
```
##### Response

```json
[
    {
        "id": 1,
        "createAt": "2021-07-30T20:45:19+00:00",
        "customer": {
            "id": 1,
            "email": "test@test.com",
            "__isInitialized__": true
        },
        "products": [
          {
            "id": 1,
            "code": "product_code",
            "name": "Product name",
            "price": 10
          },
          {
            "id": 2,
            "code": "product_code2",
            "name": "Product name 2",
            "price": 20
          }
        ]
    },
    {
        "id": 2,
        "createAt": "2021-07-30T20:54:36+00:00",
        "customer": {
            "id": 2,
            "email": "some@email.com",
            "__isInitialized__": true
        },
        "products": []
    }
]
```

#### Update cart products

##### Request
```http request
PATCH /api/v1/carts

{
    "products": [
        3
    ]
}
```
##### Response

```json
{
    "id": 1,
    "createAt": "2021-07-30T20:45:19+00:00",
    "customer": {
        "id": 1,
        "email": "test@test.com",
        "__isInitialized__": true
    },
    "products": [
      {
        "id": 3,
        "code": "product_code3",
        "name": "Product name 3",
        "price": 30
      }
    ]
}
```

#### Delete cart

There will be null response with status code `204`

##### Request
```http request
DELETE /api/v1/carts/1
```
##### Response

```json
null
```

## Notify customers with old carts

There is running cron command every day at 00:00, but you can run it manual in root directory 
`make notify-customers`
