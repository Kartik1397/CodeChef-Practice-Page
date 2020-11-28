# API

JSON API for authentication, problems and tags.

## Availabel Routes
```
base_url: https://ccpractice.ml/api
```
__User__
```
POST /user/signup
POST /user/signin
PATCH /user/update
GET /user/verify?token=
```

- POST /user/signup
  
  _Request_
  ```javascript
  {
    username: string
    first_name: string
    last_name: string
    email: string
    password: string
  }
  ```
  _Response_
  ```javascript
  code: 200
  {
    success: boolean
  }
  ```
  
- POST /user/signin
  
  _Request_
  ```javascript
  {
    username: string
    password: string
  }
  ```
  _Response_
  ```javascript
  code: 200
  {
    success: true,
    user: {
        id: string,
        username: string,
        first_name: string,
        last_name: string,
        email: string
    },
    token: jwt_token string
  }
  ```

- PATCH /user/update
  
  _Request_
  ```javascript
  {
    one_of_user_attr: new_value string
  }
  ```
  _Response_
  ```javascript
  code: 200
  {
    success: true,
  }
  ```
- GET /user/verify?token=
  
  _Params_
  ```javascript
  token: server_generated_token
  ```
  _Response_
  ```javascript
  HTML response wit message
  ```


__Problem__
```
GET /problems?difficulty=&tags=&custom_tags=&author=
```

__Tags__
```
GET /tags
POST /tags
POST /tags/delete
GET /tags/map
POST /tags/map
POST /tags/unmap
```
- GET /tags
  
  _Pramas_
  ```javascript
  none
  ```
  If authorization token not set only public tags will be sent
  _Response_
  ```javascript
  code: 200
  {
    success: true,
    tags: [
      {
        id: string,
        name: string,
        count: number of problem associated with this tag,
        type: one of [author, actual_tag],
        uid: null
      },
      ...
    ]
  }
  ```
  If authorization token set both public and custom tags will be sent
  _Response_
  ```javascript
  code: 200
  {
    success: true,
    tags: [
      {
        id: string,
        name: string,
        count: number of problem associated with this tag,
        type: one of [author, actual_tag],
        uid: null
      },
      ...,
      {
        id: string,
        name: string,
        count: number of problem associated with this tag,
        type: one of [author, actual_tag],
        uid: user id from jwt_token
      },
      ...
    ]
  }
  ```
- POST /tags

  Authorization header reqired
  
  _Request_
  ```javascript
  {
    name: type[string] name of tags user want to create
  }
  ```
  _Response_
  ```javascript
  code: 200
  {
    success: true,
  }
  ```

- POST /tags/delete

  Authorization header reqired
  
  _Request_
  ```javascript
  {
    id: type[string] id of tag user want to delete
  }
  ```
  _Response_
  ```javascript
  code: 200
  {
    success: true,
  }
  ```

- GET /tags/map

  Authorization header reqired
  
  _Request_
  ```javascript
  none
  ```
  _Response_
  ```javascript
  code: 200
  {
    success: true,
    map: [
      {
        uid: user's id
        tid: tags's id
        pid: problem's id
      },
      ...
    ]
  }
  ```

- POST /tags/map

  Authorization header reqired
  
  _Request_
  ```javascript
  {
    tid: tag's id
    pid: problems's id
  }
  ```
  _Response_
  ```javascript
  code: 200
  {
    success: true,
  }
  ```

- POST /tags/unmap

  Authorization header reqired
  
  _Request_
  ```javascript
  {
    tid: tag's id
    pid: problems's id
  }
  ```
  _Response_
  ```javascript
  code: 200
  {
    success: true,
  }
  ```
