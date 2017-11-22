## Kawaii-jwt (JWT) for Laravel 5.5+ and Quasar BoilerPlate [![Build Status](https://travis-ci.org/BlackMix/kawaii-jwt.svg)](https://travis-ci.org/BlackMix/kawaii-jwt)
![Kawaii-jwt](https://4.bp.blogspot.com/-iDFV7brDjJk/WgORqIwPcmI/AAAAAAAAD_c/3KQHuWaa8qs9vzRXQCnGLDoazGo4Vjy2ACLcBGAs/s1600/1.jpg)

* Kawaii-jwt is API from Quasar BoilerPlate - [BoilerPlate](https://github.com/phpzm/quasar-boilerplate)


ReLations packets:

* JWT-Auth - [tymondesigns/jwt-auth](https://github.com/tymondesigns/jwt-auth)
* Dingo API - [dingo/api](https://github.com/dingo/api)
* Laravel-CORS [barryvdh/laravel-cors](http://github.com/barryvdh/laravel-cors)
* Laratrust [Laratrust](https://github.com/santigarcor/laratrust/)

## Installation 
* composer create-project kawaiiwaifus/laravel-api-kawaii-jwt NameOfProject
## Usage
* run the `php artisan migrate`
* run the `php artisan db:seed` for create tests users.
## Main Features

### A Ready-To-Use Authentication Controllers

You don't have to worry about authentication and password recovery anymore. 
I created four controllers you can find in the `App\Api\V1\Controllers` for those operations.

For each controller there's an already setup route in `routes/api.php` file:

* `POST api/auth/login`, to do the login and get your access token;
* `POST api/auth/refresh`, to refresh an existent access token by getting a new one;
* `POST api/auth/register`, to create a new user into your application;
* `POST api/auth/recovery`, to recover your credentials;
* `POST api/auth/reset`, to reset your password after the recovery;
* `POST api/auth/logout`, to log out the user by invalidating the passed token;
* `GET api/auth/me`, to get current user data;


## Router ADM Users

* `GET api/admin/users`, get all users
* `GET api/admin/users/{id}`, get user to edit
* `PUT api/admin/users/{id}`, update user
* `POST api/admin/users`,  "create user" I think not finished it.
* `DELETE api/admin/users/{id}`, "delete user" I think not finished it.

## --

## Router Roles e Permissions

* `GET api/admin/roles`, get all roles
* `GET api/admin/roles/{id}`, get role to edit
* `PUT api/admin/roles/{id}`, update role
* `POST api/admin/roles`,  create role
* `DELETE api/admin/roles/{id}`, delete role

* `GET api/admin/permissions`, get all permissions
* `GET api/admin/permissions/{id}`, get permission to edit
* `PUT api/admin/permissions/{id}`, update permission
* `POST api/admin/permissions`, create permission
* `DELETE api/admin/permissions/{id}`, delete permission

### A Separate File for Routes

All the API routes can be found in the `routes/api.php` file. This also follow the Laravel 5.5.

### Secrets Generation

Every time you create a new project starting from this repository, the _php artisan jwt:generate_ command will be executed.

## Configuration

Database example:

```js
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(125) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telephone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` int(1) NOT NULL DEFAULT '0',
  `gender` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(190) COLLATE utf8_unicode_ci DEFAULT NULL,
  `amount` varchar(75) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=325 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
```

You can find all the Kawaii-jwt specific settings in the `config/kawaii-jwt.php` config file.

```php
<?php

return [

    // these options are related to the sign-up procedure
    'sign_up' => [
        
        // this option must be set to true if you want to release a token
        // when your user successfully terminates the sign-in procedure
        'release_token' => env('SIGN_UP_RELEASE_TOKEN', false),
        
        // here you can specify some validation rules for your sign-in request
        'validation_rules' => [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]
    ],

    // these options are related to the login procedure
    'login' => [
        
        // here you can specify some validation rules for your login request
        'validation_rules' => [
            'email' => 'required|email',
            'password' => 'required'
        ]
    ],

    // these options are related to the password recovery procedure
    'forgot_password' => [
        
        // here you can specify some validation rules for your password recovery procedure
        'validation_rules' => [
            'email' => 'required|email'
        ]
    ],

    // these options are related to the password recovery procedure
    'reset_password' => [
        
        // this option must be set to true if you want to release a token
        // when your user successfully terminates the password reset procedure
        'release_token' => env('PASSWORD_RESET_RELEASE_TOKEN', false),
        
        // here you can specify some validation rules for your password recovery procedure
        'validation_rules' => [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ]
    ]

];
```

As I already said before, this Kawaii-jwt is based on _dingo/api_ and _tymondesigns/jwt-auth_ packages. So, you can find many informations about configuration <a href="https://github.com/tymondesigns/jwt-auth/wiki/Configuration" target="_blank">here</a> and <a href="https://github.com/dingo/api/wiki/Configuration">here</a>.

However, there are some extra options that I placed in a _config/kawaii-jwt.php_ file:

* `sign_up.release_token`: set it to `true` if you want your app release the token right after the sign up process;
* `reset_password.release_token`: set it to `true` if you want your app release the token right after the password reset process;

There are also the validation rules for every action (login, sign up, recovery and reset). Feel free to customize it for your needs.

## Creating Endpoints

You can create endpoints in the same way you could to with using the single _dingo/api_ package. You can <a href="https://github.com/dingo/api/wiki/Creating-API-Endpoints" target="_blank">read its documentation</a> for details. After all, that's just a boilerplate! :)

However, I added some example routes to the `routes/api.php` file to give you immediately an idea.

## Cross Origin Resource Sharing

If you want to enable CORS for a specific route or routes group, you just have to use the _cors_ middleware on them.

Thanks to the _barryvdh/laravel-cors_ package, you can handle CORS easily. Just check <a href="https://github.com/barryvdh/laravel-cors" target="_blank">the docs at this page</a> for more info.

## Tests

* coming soon..

## CREDITS:
* I got the idea of this project and modified some things to work.
* [laravel-api-boilerplate-jwt](https://github.com/francescomalatesta/laravel-api-boilerplate-jwt)

