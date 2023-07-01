# jwt-auth
Использование библиотеки lcobucci/jwt

## Installation
Сгенерировать ключи командой:
```
./create_keys.sh
```
Развернуть проект:
```
docker-compose up
```
Выполнить запросы:
```
curl -X POST http://localhost:8080/sign_in -d '{"email":"sergei@second.ru", "password":"1234"}' -H 'Content-Type: application/json'
curl -X GET http://localhost:8081/profile -H 'Content-Type: application/json' -H 'Authorization: Bearer "access_token"'
```