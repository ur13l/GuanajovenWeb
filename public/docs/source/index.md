---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://localhost/docs/collection.json)
<!-- END_INFO -->

#general
<!-- START_b7802a3a2092f162a21dc668479801f4 -->
## api/password/email

> Example request:

```bash
curl -X POST "http://localhost/api/password/email" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/password/email",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/password/email`


<!-- END_b7802a3a2092f162a21dc668479801f4 -->

<!-- START_ded4fcd6b8ce5859e30b09d01516edcb -->
## Metodo para la obtención de los items publicitarios que se estarán mostrando en la interfaz principal.

> Example request:

```bash
curl -X GET "http://localhost/api/publicidad" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/publicidad",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
null
```

### HTTP Request
`GET api/publicidad`

`HEAD api/publicidad`


<!-- END_ded4fcd6b8ce5859e30b09d01516edcb -->

<!-- START_b1cd176a3c4faeabcd5ccbc9c02f65e5 -->
## Metodo para la obtención de convocatorias para la app.

> Example request:

```bash
curl -X GET "http://localhost/api/convocatorias" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/convocatorias",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
null
```

### HTTP Request
`GET api/convocatorias`

`HEAD api/convocatorias`


<!-- END_b1cd176a3c4faeabcd5ccbc9c02f65e5 -->

<!-- START_d2e6e9773f8741e58c5e9832e9fdee01 -->
## Función para verificar el acceso de un usuario API

> Example request:

```bash
curl -X POST "http://localhost/api/usuarios/login" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/usuarios/login",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/usuarios/login`


<!-- END_d2e6e9773f8741e58c5e9832e9fdee01 -->

<!-- START_21b088fbbb121561b4d6aa8a587f95f4 -->
## Registrar
params: [email, password, password_confirmation, nombre, apellido_paterno, apellido_materno, genero, codigo_postal, fecha_nacimiento, estado_nacimiento].

Método que sirve para registrar usuarios.

> Example request:

```bash
curl -X POST "http://localhost/api/usuarios/registrar" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/usuarios/registrar",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/usuarios/registrar`


<!-- END_21b088fbbb121561b4d6aa8a587f95f4 -->

<!-- START_20b5adfbd9143f4e0cad0836ffedec2b -->
## api/usuarios/actualizar

> Example request:

```bash
curl -X POST "http://localhost/api/usuarios/actualizar" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/usuarios/actualizar",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/usuarios/actualizar`


<!-- END_20b5adfbd9143f4e0cad0836ffedec2b -->

<!-- START_de216853be6ccf9e6c46f33aec68ac48 -->
## api/usuarios/verificarcorreo

> Example request:

```bash
curl -X POST "http://localhost/api/usuarios/verificarcorreo" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/usuarios/verificarcorreo",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/usuarios/verificarcorreo`


<!-- END_de216853be6ccf9e6c46f33aec68ac48 -->

<!-- START_d22e5bc16440fc4164d8c616c5bacc0c -->
## Función para verificar el acceso de usuario mediante Googl

> Example request:

```bash
curl -X POST "http://localhost/api/usuarios/logingoogle" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/usuarios/logingoogle",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/usuarios/logingoogle`


<!-- END_d22e5bc16440fc4164d8c616c5bacc0c -->

<!-- START_17696e8ccdcda7ee1a4de34c33d89356 -->
## Función para verificar el acceso de usuario mediante Facebook

> Example request:

```bash
curl -X POST "http://localhost/api/usuarios/loginfacebook" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/usuarios/loginfacebook",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/usuarios/loginfacebook`


<!-- END_17696e8ccdcda7ee1a4de34c33d89356 -->

<!-- START_1da7b3b500ab8804a14f445fbc26c8e9 -->
## Función para guardar un nuevo token de dispositivo

> Example request:

```bash
curl -X POST "http://localhost/api/usuarios/token/registrar" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/usuarios/token/registrar",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/usuarios/token/registrar`


<!-- END_1da7b3b500ab8804a14f445fbc26c8e9 -->

<!-- START_112c0abd720bcad6cc27230fbed9e78f -->
## Función para eliminar un token de dispositivo de la base de datos

> Example request:

```bash
curl -X POST "http://localhost/api/usuarios/token/cancelar" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/usuarios/token/cancelar",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/usuarios/token/cancelar`


<!-- END_112c0abd720bcad6cc27230fbed9e78f -->

