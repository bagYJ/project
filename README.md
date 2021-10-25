# 백패커/아이디어스 개발과제 API 문서

## 회원 테이블

    CREATE TABLE `users` (
      `id` bigint unsigned NOT NULL AUTO_INCREMENT,
      `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '이름',
      `nickname` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '별명',
      `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '비밀번호',
      `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '전화번호',
      `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '이메일',
      `sex` enum('m','w') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '성별',
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci

## 주문 테이블

    CREATE TABLE `order` (
      `id` bigint unsigned NOT NULL AUTO_INCREMENT,
      `orderNo` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '주문번호',
      `userId` int NOT NULL COMMENT '회원번호',
      `orderGoodsNm` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '제품명',
      `payed_at` datetime DEFAULT NULL COMMENT '결제일시',
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci

# REST API

## 회원가입

### Request

`POST /auth/regist`

    name (required) 이름
    nickname (required) 별명
    password (required) 비밀번호
    phone (required) 핸드폰번호
    email (required) 이메일
    sex 성별(m,w)
    
    
    curl -i -H 'Accept: application/json' -X POST -d 'name=Name&nickname=NickName&password=Password&phone=0100000000&email=email@email.com&sex=m' http://localhost/auth/regist

### Response

    HTTP/1.1 200 OK
    Date: Thu, 24 Feb 2011 12:36:30 GMT
    Status: 200 OK
    Connection: close
    Content-Type: application/json
    Content-Length: 2

    success

## 로그인

### Request

`POST /auth/login`

    email (required) 이메일
    password (required) 비밀번호
    
    curl -i -H 'Accept: application/json' -X POST -d 'email=email@email.com&password=Password' http://localhost/auth/login

### Response

    HTTP/1.1 201 Created
    Date: Thu, 24 Feb 2011 12:36:30 GMT
    Status: 201 Created
    Connection: close
    Content-Type: application/json
    Location: /thing/1
    Content-Length: 36

    {"token_type":"Bearer","expires_in":1295999,"access_token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5NGFkNWM2Ni1jMDhhLTQ1MzQtOGQ5MC0wNmMwNmI1ZGU1NjQiLCJqdGkiOiIyYmJhMmNlZTZkY2Q1M2QzYjg5NjIxNmIzMDRiOWQxZTRiZDBhZjQ4ODEyYjdkYzA5ZDBiYmVmMjY5MDE5YThmYWIxYjYzZjMzM2EyZjcyMCIsImlhdCI6MTYzNTEyMzE5Ny45OTczNjIsIm5iZiI6MTYzNTEyMzE5Ny45OTczNjYsImV4cCI6MTYzNjQxOTE5Ni4zNDIyNTMsInN1YiI6IjEiLCJzY29wZXMiOlsiKiJdfQ.AwWyVpVfRa7cj6cVCHYtcPqafHz9bTjOJNOhMgRFK_3YtRw8_QtVI_zfU0WSmUn6Ie2EEYF7EzjjxI6nBUraWnfZsY4qRnosT052D0uMQtMq7N-JqsnuyZxRAo7L4ftWcdAh_v9ymooLPVOiC12McZxYwRRiT0cY_mH9RCFIOHubmiokaLVhrMmNn0k8qnFJW9I6OK7hgOm8eu1W9gpzE-urWTsRoAaOj3yMrwqmoVBYgOlKtFscHl_kWzqhHDAQMZilEVE3ab-6JCzHisJg-RL_MJ1-cKYKMMZ1o3chk7Zf6HdA4tN3aHpjZFim8EI3Vnw9WCD9jS8EunGKxXwSTcIIFx7f3cMY_KBwLThXIOY81mT48PAC5I72HDGPv__kt-0mdqwz3XvDZMtpnZC8sb5iG0SyM-_vWDEJRxPVAjQgCUYwMq9hqqRBWesI280ylECUIJPJMBW4ZNWy4iUkrjJk_U6zZEnM99gznFm2faVV7imJ5AmPLoApWfDpqhftteVSa9e1DKy2uCkgfDkXEkLxp7OkMZ00vaeg3rdZqU-7jCpvrvHN5LOlABH43W2wwQZv-5McTzTEbJNI5cxPm3TSSq2Hr68fr5BgcYTR-FUOgbOvjrRNQQQc0XukbMVovWWs2iZswO--J6Gaw_3bqt4DKEi6X_4TpBifeTKgIt8","refresh_token":"def502003d5ce423107f6e5e84810152a9239d633dfe72c84aad7301482e501fc506db7df73a4aedaea622ec3ff8407f648b244797912aa27e88f85dc6eff76eb2e5479eb52019e75e140d2ae2db0a05f7e5cab452f2cca58fa363606a317c799109b546a3fa846d0174b7dcc9a3fc14be74177ad872b1bd9ff9aae48c4169a3ab13670c6a00348962ae01f1cd7c158bbe6c2213431ccf43ee7068d03941960e7ff740cc151ffd20b349c8e0f434604c123f3b4cd86eb1849002c0b361cda201d77f5fd548066ed40dfd1488ced7b2241a32b8c61fac8194a0d6fb3d7d2c7da49d12bf888bc064da3a92425b17091e7f43822a7ca60897ff7d12bd034a23cef2890a46366d05ab1419ed6b7116861a0f341f5fb8fbafe6ff28e380896a173b22004d672c5a28647a7fee19c8148355a408a6168bf467da7c7d3e6cd110eb7234d7894f724a40a3092c9b97c8df7aae3b772ef0dce586995a26762349061fa872305fefda5a026a19f5541c3c9be4fbf581c95fe33dc27cb5be443a7ca19cc4a96ff598075970bc"}

## 내 회원정보 조회

### Request

`GET /auth/user`

    curl -i -H 'Accept: application/json' -H 'Authorization: Bearer access-token' http://localhost/auth/user

### Response

    HTTP/1.1 200 OK
    Date: Thu, 24 Feb 2011 12:36:30 GMT
    Status: 200 OK
    Connection: close
    Content-Type: application/json
    Content-Length: 36

    {"id":1,"name":"이름","nickname":"nickname","phone":"0100000000","email":"email@email.com","sex":null,"created_at":"2021-10-21T16:21:37.000000Z","updated_at":"2021-10-21T16:21:37.000000Z"}

## 다른 회원정보 조회

### Request

`GET /auth/user/{id}`

    id 회원번호

    curl -i -H 'Accept: application/json' -H 'Authorization: Bearer access-token' http://localhost/auth/user/1

### Response

    HTTP/1.1 200 OK
    Date: Thu, 24 Feb 2011 12:36:30 GMT
    Status: 200 OK
    Connection: close
    Content-Type: application/json
    Content-Length: 36

    {"id":1,"name":"이름","nickname":"nickname","phone":"0100000000","email":"email@email.com","sex":null,"created_at":"2021-10-21T16:21:37.000000Z","updated_at":"2021-10-21T16:21:37.000000Z"}

## 회원정보 검색

### Request

`GET /auth/findUser`

    searchType 검색조건
    searchValue 검색값

    curl -i -H 'Accept: application/json' -H 'Authorization: Bearer access-token' -d 'searchType=email&searchValue=email@email.com' http://localhost/auth/findUser

### Response

    HTTP/1.1 200 OK
    Date: Thu, 24 Feb 2011 12:36:30 GMT
    Status: 200 OK
    Connection: close
    Content-Type: application/json
    Content-Length: 36

    {"current_page":1,"data":[{"id":1,"name":"이름","nickname":"nickname","phone":"0100000000","email":"email@email.com","sex":null,"created_at":"2021-10-21 16:21:37","updated_at":"2021-10-21 16:21:37","orderNo":"11112","userId":1,"orderGoodsNm":"상품명","payed_at":null}],"first_page_url":"http://localhost/auth/findUser?=1","from":1,"last_page":1,"last_page_url":"http://localhost/auth/findUser?=1","links":[{"url":null,"label":"&laquo;Previous","active":false},{"url":"http://localhost/auth/findUser?=1","label":"1","active":true},{"url":null,"label":"Next&raquo;","active":false}],"next_page_url":null,"path":"http://localhost/auth/findUser","per_page":10,"prev_page_url":null,"to":1,"total":1}

## Get list of Things again

### 내 주문정보 조회

`GET /auth/order/list`

    curl -i -H 'Accept: application/json' -H 'Authorization: Bearer access-token' http://localhost/auth/order/list

### Response

    HTTP/1.1 200 OK
    Date: Thu, 24 Feb 2011 12:36:31 GMT
    Status: 200 OK
    Connection: close
    Content-Type: application/json
    Content-Length: 74

    [{"id":1,"orderNo":"11111","userId":1,"orderGoodsNm":"상품1","payed_at":null,"created_at":null,"updated_at":null},{"id":2,"orderNo":"11112","userId":1,"orderGoodsNm":"상품2","payed_at":null,"created_at":null,"updated_at":null}]

## 다른 주문정보 조회

### Request

`GET /auth/order/list/{id}`

    id 회원번호

    curl -i -H 'Accept: application/json' -H 'Authorization: Bearer access-token' http://localhost/auth/order/list/1

### Response

    HTTP/1.1 200 OK
    Date: Thu, 24 Feb 2011 12:36:31 GMT
    Status: 200 OK
    Connection: close
    Content-Type: application/json
    Content-Length: 40

    [{"id":1,"orderNo":"11111","userId":1,"orderGoodsNm":"상품1","payed_at":null,"created_at":null,"updated_at":null},{"id":2,"orderNo":"11112","userId":1,"orderGoodsNm":"상품2","payed_at":null,"created_at":null,"updated_at":null}]

## 로그아웃

### Request

`GET /auth/logout`

    curl -i -H 'Accept: application/json' -H 'Authorization: Bearer access-token' http://localhost/auth/logout

### Response

    HTTP/1.1 200 OK
    Date: Thu, 24 Feb 2011 12:36:31 GMT
    Status: 200 OK
    Connection: close
    Content-Type: application/json
    Content-Length: 40

    logout success

