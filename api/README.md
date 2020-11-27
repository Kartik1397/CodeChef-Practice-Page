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
