<?php

use Illuminate\Http\Request;

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

Route::group(['prefix' => 'v1'], function(){
    Route::get('user',function(Request $request){
        return $request->user();
    });
    Route::get('getTags', 'API\ArticleApiController@getTags');
    Route::get('getCompanies', 'API\ArticleApiController@getCompanies');
    Route::get('getArticles', 'API\ArticleApiController@getArticles');
    Route::get('singleArticle/{slug}', 'API\ArticleApiController@singleArticle');
    Route::get('latestArticles', 'API\ArticleApiController@latestArticles');
    Route::get('relatedArticles/{articleId}/{relatedTagID}', 'API\ArticleApiController@relatedArticles');
    Route::get('trandingArticles', 'API\ArticleApiController@trandingArticles');
});

Route::post('login', 'API\EmployeeController@login')->name('employee_login');
Route::group(['prefix' => 'employee', 'middleware' => ['assign.guard:employee','jwt.auth']], function () {
    
});
