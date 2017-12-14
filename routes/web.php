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
Route::post('/panel/markers/add/file', 'PanelController@addDataFile');

// Admin
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
            Route::get('admin/users', [
                'uses' => 'UsersController@users'
            ]);
            Route::get('admin/markers', [
                'uses' => 'MarkersController@markers'
            ]);
            Route::get('admin/requests', [
                'uses' => 'PanelController@requests'
            ]);
            Route::post('admin/series/files/interpretation/add/{id}', [
                'uses' => 'PanelController@addInterpretationFile'
            ]);
            Route::get('admin/users/profile/{id}', [
                'uses' => 'ProfileController@profileAdmin'
            ]);
            Route::get('admin/marker/edit/{id}', [
                'uses' => 'MarkersController@editMarker'
            ]);
            Route::post('admin/marker/save', [
                'uses' => 'MarkersController@saveMarker'
            ]);
            Route::post('admin/marker/delete', [
                'uses' => 'MarkersController@deleteMarker'
            ]);
            Route::get('admin/marker/add', [
                'uses' => 'MarkersController@addMarker'
            ]);
            Route::post('admin/marker/add/save', [
                'uses' => 'MarkersController@saveNewMarker'
            ]);
            Route::post('admin/marker/add/topanel', [
                'uses' => 'PanelController@addMarkerToPanel'
            ]);
            Route::post('admin/marker/delete/frompanel', [
                'uses' => 'PanelController@deleteMarkerToPanel'
            ]);
        }
);


// Errors.
Route::get('/notaccess', 'ErrorController@notaccess');


// Access to files.
Route::get('/files/data/{series_id}', 'FilesController@getDataFile');
Route::get('/files/interpretation/{series_id}', 'FilesController@getInterpretationFile');
