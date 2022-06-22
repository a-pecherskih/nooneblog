<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\CommentController;

Route::group(['namespace' => 'Api'], function () {

    Route::group(['prefix' => 'article', 'as' => 'article.'], function () {
        Route::post('article/{article}/comment', [CommentController::class, 'save'])->name('add_comment');
        Route::put('article/{article}/like', [ArticleController::class, 'addLike'])->name('like');
        Route::put('article/{article}/count-views', [ArticleController::class, 'addCountView'])->name('count_views');
        Route::get('article/{article}', [ArticleController::class, 'show'])->name('show');
    });

    Route::group(['as' => 'articles.'], function () {
        Route::get('articles/{tag}', [ArticleController::class, 'listByTag'])->name('tag');
        Route::get('articles', [ArticleController::class, 'listArticles'])->name('list');
        Route::get('main-articles', [ArticleController::class, 'mainArticles'])->name('main');
    });
});
