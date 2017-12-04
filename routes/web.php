<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'WelcomeController@welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Facebook
Route::get('login/facebook', 'Auth\FacebookLoginController@facebookRedirect');
Route::get('login/facebook/callback', 'Auth\FacebookLoginController@facebookCallback');

// Vkontakte
Route::get('login/vk', 'Auth\VkLoginController@vkRedirect');
Route::get('login/vk/callback', 'Auth\VkLoginController@vkCallback');

// Google
Route::get('login/gp', 'Auth\GoogleLoginController@gpRedirect');
Route::get('login/gp/callback', 'Auth\GoogleLoginController@gpCallback');

// Profile
Route::get('/profile', 'ProfileController@profile');
Route::get('/profile/edit', 'ProfileController@profileEdit');
Route::post('/profile/save', 'ProfileController@profileSave');

// Parse helix lab pages.
Route::get('/utils/parse_helix', 'UtilsController@parseHelix');
Route::get('/utils/parse_helix_marker', 'UtilsController@parseHelixMarker');
Route::get('/utils/parse_helix_marker_name', 'UtilsController@parseHelixAddName');

// User markers.
Route::get('/my_markers', 'UserMarkersController@userMarkers');
Route::post('/markers/row', 'UserMarkersController@createRowWithMarker');
Route::post('/markers/save', 'UserMarkersController@saveMarkers');
Route::post('/markers/edit', 'UserMarkersController@saveMarker');
Route::post('/markers/delete', 'UserMarkersController@deleteMarker');


// Panel.
Route::get('/panel/{id}', 'PanelController@panel');
Route::get('/panel/markers/{id}', 'PanelController@panelMarkers');
Route::post('/panel/markers/save', 'PanelController@saveUserPanelMarkers');
// API for tasks version 2.0
Route::group([
	    'middleware' => ['check_admin'],
        ],
        function() {
            Route::get('admin/panels', [
                'uses' => 'PanelController@panels'
            ]);
            Route::get('admin/panel/edit/{id}', [
                'uses' => 'PanelController@editPanelPage'
            ]);
            Route::post('admin/panel/save', [
                'uses' => 'PanelController@savePanel'
            ]);
        }
);


// Errors.
Route::get('/notaccess', 'ErrorController@notaccess');
