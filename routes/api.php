<?php

use Illuminate\Http\Request;

/** @var Router $api */
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    /**
     * Routers Auth
     */
    $api->group(['prefix' => 'auth', 'namespace' => 'App\Api\V1\Controllers\Auth'], function($api) {
        $api->post('register', 'SignUpController@signUp');
        $api->post('login', 'LoginController@login');

        $api->post('recovery', 'ForgotPasswordController@sendResetEmail');
        $api->post('reset', 'ResetPasswordController@resetPassword');

        $api->post('logout', 'LogoutController@logout');
        $api->post('refresh', 'RefreshController@refresh');
        $api->get('me', 'UserController@me');
    });

    /**
     * Routers Roles 
     */
    $api->group(['prefix' => 'admin', 'namespace' => 'App\Api\V1\Controllers\Admin'], function($api) {

        // Route to Çist all Permissions
        $api->get('permissions', 'Roles\PermissionsList@List');
        // Route to create a new permission
        $api->post('permissions/create', 'Roles\PermissionsCreate@CreatePermission');


        // Route to assign role to user
        $api->post('add-user-role', 'Roles\RolesControllers@assignRole');
        // Route to attache permission to a role
        $api->post('add-permission-to-role', 'Roles\RolesControllers@attachPermission');

        // Route TEST for show permissions, need token valid.
        $api->post('show-permissions', 'Roles\RolesControllers@show');
        
        // List all Roles
        $api->get('roles', 'Roles\RolesList@list');
        // Route to create a new role
        $api->post('roles/create', 'Roles\RolesCreate@CreateRole');


        /**
         * Users
         */
        // List all users
        $api->get('users', 'Users\ListUsers@list');
        // Get a user for edit
        $api->get('users/{id}', 'Users\Get@get');
        // Update a user
        $api->put('users/{id}', 'Users\Update@update');
        // Active or Disable a User
        $api->post('users/activate/{id}', 'Users\Active@active');

        /**
         * Organizations
         */
        // List all organizations
        $api->get('organization', 'Organization\OrganizationController@list');

        

        /**
         * More routers for edit coming soon
         */
    });

    $api->group(['middleware' => 'jwt.auth'], function($api) {
        $api->get('protected', function() {
            return response()->json([
                'message' => 'Access to protected resources granted! You are seeing this text as you provided the token correctly.'
            ]);
        });

        $api->get('refresh', [
            'middleware' => 'jwt.refresh',
            function() {
                return response()->json([
                    'message' => 'By accessing this endpoint, you can refresh your access token at each request. Check out this response headers!'
                ]);
            }
        ]);
    });

    $api->get('hello', function() {
        return response()->json([
            'message' => 'This is a simple example of item returned by your APIs. Everyone can see it.'
        ]);
    });
});
