# ATB Test
Simple restful API

## Environment
1. Operating system: MacOS High Sierra (ver10.13.6)
2. Apache/2.4.33 (Unix)
3. Mysql5.7.24 - MySQL Community Server (GPL)
4. PHP/7.1.16

## Feature
1. Routing
2. Request Method Handler (GET, POST, PUT, DELETE, PATCH)
3. Http Response Code Handler
4. JSON Output (View)
5. PDO Integration (Model)
6. PSR-4 Autoloading Standard (Controller)

## Installations
- Dump sql file atb_test.sql to your database
- copy source code to public_html folder OR config local domain point to atb-test folder
- Change DB config at app/Config/global.php
    ```php
    define('DB_HOST', 'localhost');
	define('DB_NAME', 'atb_test');
	define('DB_USER', 'root');
	define('DB_PASS', '123456');
     
## API List

### User api
1. http://[domain_name]/user [POST]
2. http://[domain_name]/user/{email_string} [GET]
3. http://[domain_name]/user [GET]
4. http://[domain_name]/user [PUT]
5. http://[domain_name]/user [PATCH]
    
### Auth api
1. http://[domain_name]/auth [POST]
2. http://[domain_name]/auth [GET]
   
## API explain
 
### http://[domain_name]/user [POST]

*Descriptions: register user*

Request method: **POST**

**Argument**

|Name|Type|Header|Require|example|
|:---|:---|:---:|:---:|:---|
|email|string| |✓|david@test.com
|password|string| |✓|123456
|full_name|string| | |David Nguyen
|tel|string| | |(+84)-09123456789
|address|string| | |Ha Noi, Viet Nam

**Return value**

|Name|Type|Descriptions|
|:---|:---|:---|
|user|array|user detail
|http_status|array|HTTP code & message

**Sample data**
```javascript
{
    {
        "user": {
            "email": "david@test.com",
            "full_name": "David Nguyen",
            "tel": "+849123456789",
            "address": "Hanoi, Vietnam"
        },
        "http_status": {
            "code": 200,
            "message": "OK"
        }
    }
}
```
--

### http://[domain_name]/auth [POST]
*Descriptions: User login*

Request method: **POST**

**Argument**

|Name|Type|Header|Require|Descriptions|
|:---|:---|:---:|:---:|:---|
|email|string| |✓|david@test.com
|password|string| |✓|123456

**Return value**

|Name|Type|Descriptions|
|:---|:---|:---|
|token|string| Token string
|http_status|array|HTTP code & message

**Sample data**
```javascript
{
    "token": "example.token.detail",
    "http_status": {
        "code": 200,
        "message": "OK"
    }
}
```
--

### http://[domain_name]/auth [GET]
*Descriptions: User logout*

Request method: **GET**

**Argument**

|Name|Type|Header|Require|Descriptions|
|:---|:---|:---:|:---:|:---|
|Authorization|token string|✓|✓|Bearer example.token.detail

**Return value**

|Name|Type|Descriptions|
|:---|:---|:---|
|info|string|Logout status
|http_status|array|HTTP code & message

**Sample data**
```javascript
{
    "info": "Logout success!",
    "http_status": {
        "code": 200,
        "message": "OK"
    }
}
```

--

### http://[domain_name]/user/{email_string} [GET]
*Get user info*

Request method: **GET** 

**Important:** need ***Authorization*** field in Header

**Argument**

|Name|Type|Header|Require|Descriptions|
|:---|:---|:---:|:---:|:---|
|email_string|string| |✓|david@test.com
|Authorization|token string|✓|✓|Bearer example.token.detail

**Return value**

|Name|Type|Descriptions|
|:---|:---|:---|
|user|array| User info
|http_status|array|HTTP code & message

**Sample data**
```javascript
{
    "user": {
        "email": "david@test.com",
        "full_name": "David Nguyen",
        "tel": "+849123456789",
        "address": "Hanoi, Vietnam"
    },
    "http_status": {
        "code": 200,
        "message": "OK"
    }
}
```
--

### http://[domain_name]/user [GET]
*Get list user info*

Request method: **GET** 

**Important:** need ***Authorization*** field in Header

**Argument**

|Name|Type|Header|Require|Descriptions|
|:---|:---|:---:|:---:|:---|
|Authorization|token string|✓|✓|Bearer example.token.detail

**Return value**

|Name|Type|Descriptions|
|:---|:---|:---|
|users|array| list users info
|http_status|array|HTTP code & message

**Sample data**
```javascript
{
    "users": [
        {
            "email": "david@test.com",
            "full_name": "David Nguyen",
            "tel": "+849123456789",
            "address": "Hanoi, Vietnam"
        },
        {
            "email": "david1@test.com",
            "full_name": "",
            "tel": "+849123456789",
            "address": "Hanoi, Vietnam"
        },
        {
            "email": "dungna1@kayac.vn",
            "full_name": "",
            "tel": "",
            "address": ""
        }
    ],
    "http_status": {
        "code": 200,
        "message": "OK"
    }
}
```
--

### http://[domain_name]/user [PUT]
*update user info (if success then re-generate token)*

Request method: **PUT** 

**Important:** need ***Authorization*** field in Header

**Argument**

|Name|Type|Header|Require|Descriptions|
|:---|:---|:---:|:---:|:---|
|Authorization|token string|✓|✓|Bearer example.token.detail
|full_name|string| | |David Nguyen
|tel|string| | |(+84)-09123456789
|address|string| | |Ha Noi, Viet Nam

**Return value**

|Name|Type|Descriptions|
|:---|:---|:---|
|token|string| example.token.detail
|http_status|array|HTTP code & message

**Sample data**
```javascript
{
    "token": "example.token.detail",
    "http_status": {
        "code": 200,
        "message": "OK"
    }
}
```
--

### http://[domain_name]/user [PATCH]
*update own user' password

Request method: **PATCH** 

**Important:** need ***Authorization*** field in Header

**Argument**

|Name|Type|Header|Require|Descriptions|
|:---|:---|:---:|:---:|:---|
|Authorization|token string|✓|✓|Bearer example.token.detail
|password|string| |✓|123456
|new_password|string| |✓|123456789

**Return value**

|Name|Type|Descriptions|
|:---|:---|:---|
|info|string|change password success!
|http_status|array|HTTP code & message

**Sample data**
```javascript
{
    "info": "change password success!",
    "http_status": {
        "code": 200,
        "message": "OK"
    }
}
````
--
