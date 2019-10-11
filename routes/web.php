<?php

$router->get('/', 'UserSelectionController@index');
$router->post('/user-selection', 'UserSelectionController@goUserRole');

$router->get('/install', 'DBInstallController@index');
$router->post('/install', 'DBInstallController@installDB');

$router->get('/admin', 'AdminController@index');

$router->get('/home', 'UserController@index');

$router->group(['prefix' => 'author/'], function() use($router) {
    $router->get('/', ['as' =>'author.home', 'uses' => 'AuthorController@index']);
    $router->get('/add', 'AuthorController@getAdd');
    $router->post('/add', 'AuthorController@postAuthor');
    $router->get('/edit/{id}', 'AuthorController@getEdit');
    $router->post('/edit/{id}', 'AuthorController@putAuthor');
    $router->get('/delete/{id}', 'AuthorController@deleteAuthor');

    $router->get('/ranks', 'AuthorController@getAuthorsRankedBySota');
    $router->get('/papers/{id}', 'AuthorController@getPapers');
    $router->get('/author/{id}', 'AuthorController@getAuthor');
    $router->get('/co-authors/{id}', 'AuthorController@getCoAuthors');
});

$router->group(['prefix' => 'paper/'], function() use($router) {
    $router->get('/', ['as' =>'paper.home', 'uses' => 'PaperController@index']);
    $router->get('/add', 'PaperController@getAdd');
    $router->post('/add', 'PaperController@postPaper');
    $router->get('/edit/{id}', 'PaperController@getEdit');
    $router->post('/edit/{id}', 'PaperController@putPaper');
    $router->get('/delete/{id}', 'PaperController@deletePaper');

    $router->get('/paper/{id}', 'PaperController@getPaper');

    $router->get('/search', 'PaperController@searchByKeyword');
});

$router->group(['prefix' => 'topic/'], function() use($router) {
    $router->get('/', ['as' =>'topic.home', 'uses' => 'TopicController@index']);
    $router->get('/add', 'TopicController@getAdd');
    $router->post('/add', 'TopicController@postTopic');
    $router->get('/edit/{id}', 'TopicController@getEdit');
    $router->post('/edit/{id}', 'TopicController@putTopic');
    $router->get('/delete/{id}', 'TopicController@deleteTopic');

    $router->get('/topic/{id}', 'TopicController@getTopic');

    $router->get('/sota/{id}', 'TopicController@getSota');
    $router->get('/papers/{id}', 'TopicController@getPapers');
});
