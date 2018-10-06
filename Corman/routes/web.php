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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('publications', 'PublicationController');

Route::patch('publications/{id}', 'PublicationController@update');

Route::get('/home/import', 'PublicationController@import');

Route::resource('users', 'UserController');

Route::post('users/{id}', 'UserController@update');

Route::post('groups/{idGroup}', 'GroupController@update');

Route::get('/home/user', 'UserController@index');

Route::get('/home/search', 'SearchController@index');

Route::get('/helpsearch', 'SearchController@helpSearch');

Route::get('/home/search/people','SearchController@searchPeople');

Route::get('/home/search/groups','SearchController@searchGroups');

Route::get('/home/user/filter','UserController@filter');

Route::get('users/{idUser}/filter','UserController@userfilter')->name('users.filter');

Route::resource('groups', 'GroupController');

Route::get('groups/{idGroup}', 'GroupController@show');

Route::get('/searchPartecipants/{idGroup}', 'GroupController@searchPartecipants')->name('groups.cerca');

Route::get('/searchPartecipants/{idGroup}/invite', 'GroupController@addPartecipants')->name('groups.inviaRichiesta');

Route::get('groups/{idGroup}/aggiungi', 'GroupController@aggiungi')->name('groups.aggiungi');

Route::get('groups/rintraccia/{idGroup}/{idUser}', 'GroupController@rintraccia')->name('groups.rintraccia');

Route::get('groups/{idGroup}/promote/{idUser}', 'GroupController@promote')->name('groups.promote');

Route::get('/groupsQuit/{idGroup}', 'GroupController@quit')->name('groups.quit');

Route::get('/groupsRequest/{idGroup}', 'GroupController@sendReq')->name('groups.sendReq');

Route::get('/getgroups', 'GroupController@getGroups');

Route::get('/getnews', 'NewsController@getNews');

Route::post('/uploadImage/{id}', 'UserController@uploadImage')->name('users.uploadImage');

Route::post('/uploadGroupImage/{idGroup}', 'GroupController@uploadGroupImage')->name('users.uploadGroupImage');

Route::get('/hasnews', 'NewsController@hasNews');

Route::get('/acceptinvite/{idGroup}', 'NewsController@acceptInv');

Route::get('/declineinvite/{idGroup}', 'NewsController@declineInv');

Route::get('/acceptreq/{idGroup}/{idUser}', 'NewsController@acceptReq')->name('invite.accept');

Route::get('/declinereq/{idGroup}/{idUser}', 'NewsController@declineReq');

Route::get('users/{idUser}', 'UserController@show');

Route::get('groups/filter/{idGroup}', 'GroupController@filter')->name('groups.filter');

Route::get('searchPartecipants/{idGroup}/filter','GroupController@userfilter')->name('groups.userfilter');

Route::get('groups/rintraccia/{idGroup}/{idUser}/filter', 'GroupController@publicationfilter')->name('groups.publicationfilter');
