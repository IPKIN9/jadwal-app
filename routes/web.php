<?php

$router->group(['prefix' => 'v1/jurusan'], function () use ($router) {
    $router->get('/', ['uses' => 'JurusanController@getAllData']);
    $router->get('/{id}', ['uses' => 'JurusanController@getById']);
    $router->post('/', ['uses' => 'JurusanController@upsertData']);
    $router->delete('/{id}', ['uses' => 'JurusanController@deleteData']);
});

$router->group(['prefix' => 'v1/pangkat'], function () use ($router) {
    $router->get('/', ['uses' => 'PangkatController@getAllData']);
    $router->get('/{id}', ['uses' => 'PangkatController@getById']);
    $router->post('/', ['uses' => 'PangkatController@upsertData']);
    $router->delete('/{id}', ['uses' => 'PangkatController@deleteData']);
});

$router->group(['prefix' => 'v1/kelas'], function () use ($router) {
    $router->get('/', ['uses' => 'KelasController@getAllData']);
    $router->get('/{id}', ['uses' => 'KelasController@getById']);
    $router->post('/', ['uses' => 'KelasController@upsertData']);
    $router->delete('/{id}', ['uses' => 'KelasController@deleteData']);
});

$router->group(['prefix' => 'v1/mapel'], function () use ($router) {
    $router->get('/', ['uses' => 'MapelController@getAllData']);
    $router->get('/{id}', ['uses' => 'MapelController@getById']);
    $router->post('/', ['uses' => 'MapelController@upsertData']);
    $router->delete('/{id}', ['uses' => 'MapelController@deleteData']);
});

$router->group(['prefix' => 'v1/guru'], function () use ($router) {
    $router->get('/', ['uses' => 'GuruController@getAllData']);
    $router->get('/{id}', ['uses' => 'GuruController@getById']);
    $router->post('/', ['uses' => 'GuruController@upsertData']);
    $router->delete('/{id}', ['uses' => 'GuruController@deleteData']);
});

$router->group(['prefix' => 'v1/jadwal'], function () use ($router) {
    $router->get('/', ['uses' => 'JadwalController@getAllData']);
    $router->get('/{id}', ['uses' => 'JadwalController@getById']);
    $router->post('/', ['uses' => 'JadwalController@upsertData']);
    $router->delete('/{id}', ['uses' => 'JadwalController@deleteData']);
});

$router->group(['prefix' => 'v1/detail/jadwal'], function () use ($router) {
    $router->get('/', ['uses' => 'DetailJadwalController@getAllData']);
    $router->get('/{id}', ['uses' => 'DetailJadwalController@getById']);
    $router->post('/', ['uses' => 'DetailJadwalController@upsertData']);
    $router->delete('/{id}', ['uses' => 'DetailJadwalController@deleteData']);
});


$router->group(['prefix' => 'v1/detail/scanning'], function () use ($router) {
    $router->get('/', ['uses' => 'DetailJadwalController@scanningData']);
});
