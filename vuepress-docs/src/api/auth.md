# Authentication

Some endpoints require authentication. Currently there's not way to create user accounts, making those endpoints admin only on [Gond Tools](https://www.gond.tools). If you create your own version of the API you are free to change that and use the provided functionality for a full user management.

## Bearer Token

Once obtained, the bearer token for auth secured endpoints can be delivered using four different methods:

- As `GET` parameter `bearer={TOKEN}`
- Within a `application/json` type `POST` body using the form `{ "bearer": "{TOKEN}"`
- Within the `Authorization` header using the form `Bearer: {TOKEN}`
- As `bearer` Cookie with a value of `{TOKEN}`

The API will look up `header -> cookie -> body -> get` and pick up the first `{TOKEN}` it can find.

## POST /v1/auth/login

### Body <`application/json`>

```json
{
    "username": "YOUR_USERNAME",
    "password": "YOUR_PASSWORD"
}
```

### Response <`application/json`>

A token similar to this

```json
eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c
```

or an error message

```json
{
    "status": 401,
    "status_msg": "bad credentials"
}
```

### Live Test

<api-tester endpoint="/v1/auth/login" method="POST" />