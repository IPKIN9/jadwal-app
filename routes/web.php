<?php

$router->group(['prefix' => 'v1/users', 'middleware' => ['auth', 'scope:crud-list']], function () use ($router) {
    $router->get('/',        ['uses' => 'UserController@getAllData']);
    $router->get('/{id}',    ['uses' => 'UserController@getById']);
    $router->post('/',       ['uses' => 'UserController@upsertData']);
    $router->delete('/{id}', ['uses' => 'UserController@deleteData']);
});

$router->group(['prefix' => 'v1/jurusan'], function () use ($router) {
    $router->get('/',        ['uses' => 'JurusanController@getAllData', 'middleware' => ['auth']]);
    $router->get('/{id}',    ['uses' => 'JurusanController@getById',    'middleware' => ['auth']]);
    $router->post('/',       ['uses' => 'JurusanController@upsertData', 'middleware' => ['auth', 'scope:crud-list']]);
    $router->delete('/{id}', ['uses' => 'JurusanController@deleteData', 'middleware' => ['auth', 'scope:crud-list']]);
});

$router->group(['prefix' => 'v1/pangkat'], function () use ($router) {
    $router->get('/',        ['uses' => 'PangkatController@getAllData', 'middleware' => ['auth']]);
    $router->get('/{id}',    ['uses' => 'PangkatController@getById',    'middleware' => ['auth']]);
    $router->post('/',       ['uses' => 'PangkatController@upsertData', 'middleware' => ['auth', 'scope:crud-list']]);
    $router->delete('/{id}', ['uses' => 'PangkatController@deleteData', 'middleware' => ['auth', 'scope:crud-list']]);
});

$router->group(['prefix' => 'v1/kelas'], function () use ($router) {
    $router->get('/',        ['uses' => 'KelasController@getAllData', 'middleware' => ['auth']]);
    $router->get('/{id}',    ['uses' => 'KelasController@getById',    'middleware' => ['auth']]);
    $router->post('/',       ['uses' => 'KelasController@upsertData', 'middleware' => ['auth', 'scope:crud-list']]);
    $router->delete('/{id}', ['uses' => 'KelasController@deleteData', 'middleware' => ['auth', 'scope:crud-list']]);
});

$router->group(['prefix' => 'v1/mapel'], function () use ($router) {
    $router->get('/',        ['uses' => 'MapelController@getAllData', 'middleware' => ['auth']]);
    $router->get('/{id}',    ['uses' => 'MapelController@getById',    'middleware' => ['auth']]);
    $router->post('/',       ['uses' => 'MapelController@upsertData', 'middleware' => ['auth', 'scope:crud-list']]);
    $router->delete('/{id}', ['uses' => 'MapelController@deleteData', 'middleware' => ['auth', 'scope:crud-list']]);
});

$router->group(['prefix' => 'v1/guru'], function () use ($router) {
    $router->get('/',        ['uses' => 'GuruController@getAllData', 'middleware' => ['auth']]);
    $router->get('/{id}',    ['uses' => 'GuruController@getById',    'middleware' => ['auth']]);
    $router->post('/',       ['uses' => 'GuruController@upsertData', 'middleware' => ['auth', 'scope:crud-list']]);
    $router->delete('/{id}', ['uses' => 'GuruController@deleteData', 'middleware' => ['auth', 'scope:crud-list']]);
});

$router->group(['prefix' => 'v1/jadwal'], function () use ($router) {
    $router->get('/',        ['uses' => 'JadwalController@getAllData', 'middleware' => ['auth']]);
    $router->get('/{id}',    ['uses' => 'JadwalController@getById',    'middleware' => ['auth']]);
    $router->post('/',       ['uses' => 'JadwalController@upsertData', 'middleware' => ['auth']]);
    $router->delete('/{id}', ['uses' => 'JadwalController@deleteData', 'middleware' => ['auth']]);
});

$router->group(['prefix' => 'v1/detail/jadwal'], function () use ($router) {
    $router->get('/',        ['uses' => 'DetailJadwalController@getAllData', 'middleware' => ['auth']]);
    $router->get('/{id}',    ['uses' => 'DetailJadwalController@getById',    'middleware' => ['auth']]);
    $router->post('/',       ['uses' => 'DetailJadwalController@upsertData', 'middleware' => ['auth']]);
    $router->delete('/{id}', ['uses' => 'DetailJadwalController@deleteData', 'middleware' => ['auth']]);
});

$router->group(['prefix' => 'v1/roles'], function () use ($router) {
    $router->get('/', ['uses' => 'UserController@getByRoles']);
});

$router->group(['prefix' => 'v1/detail/scanning'], function () use ($router) {
    $router->get('/', ['uses' => 'DetailJadwalController@scanningData', 'middleware' => ['auth']]);
});

$router->group(['prefix' => 'v1/report'], function () use ($router) {
    $router->get('/jadwal', ['uses' => 'ReportController@getJadwalReport', 'middleware' => ['auth']]);
});
