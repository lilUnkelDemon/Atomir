<?php

use App\Http\Controllers\ArticleController;
use Atomir\AtomirCore\Request;
use Atomir\AtomirCore\Router;

Router::get('/',[ArticleController::class,'indexAction']);

Router::get('/articles/create',[ArticleController::class,'create']);
Router::post('/articles/create',[ArticleController::class,'store']);
//Router::get('/articles/{id:\d+}',[ArticleController::class,'index']);
Router::get('/articles',[ArticleController::class,'index']);



Router::view('/about','about');
