<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

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

Route::get('/hello-world', function(){
    return view('hello-world');
});

Route::get('/hello-world/{year}/{yourname?}', function($year, $yourname = null){
    $hello_string = '';
    if($yourname == null){
        $hello_string = 'Hello world, ' . $year;
    }else{
        $hello_string = 'Hello world, ' . $year . '. My name is ' . $yourname;
    }
    return view('hello-world')->with('hello_str', $hello_string);
});

Route::get('/role',[
    'middleware' => 'role:superadmin',
    'uses' => 'App\Http\Controllers\MainController@checkRole',
 ]);

 Route::get('/tin-tuc/{news_id_string}','App\Http\Controllers\MainController@showNews');

 Route::get('/controller-middleware',[
    'middleware'=>'First',
    'uses'=>'App\Http\Controllers\TestController@testControllerMiddleware',

 ]);

 Route::resource('photo', 'PhotoController', ['only' => [
    'index', 'show'
]]);

Route::resource('photo', 'PhotoController', ['except' => [
    'create', 'store', 'update', 'destroy'
]]);

Route::get('category/laravel-nang-cao', 'App\Http\Controllers\MainController@uriTest');

Route::get('user-info', 'App\Http\Controllers\MainController@getUserInfo');

Route::get('contact', 'App\Http\Controllers\ContactController@showContactForm');
Route::post('contact', 'App\Http\Controllers\ContactController@insertMessage');

Route::get('first-blade-example', function(){
    return view('fontend.first-blade-example');
  });

Route::get('components', function () {
    return view('fontend.component-example');
});

Route::get('second-blade-example', function(){
    $comment = 'Tôi là <span class="label label-success">All Laravel</span>'; 
    return view('fontend.second-blade-example')->with('comment', $comment);
});

Route::get('news', function(){
    $news_list = array(
      ['title' => 'Bài viết số 1', 'content' => 'Nội dung bài viết 1', 'post_date' => '2017-01-03'],
      ['title' => 'Bài viết số 2', 'content' => 'Nội dung bài viết 2', 'post_date' => '2017-01-03'],
      ['title' => 'Bài viết số 3', 'content' => 'Nội dung bài viết 3', 'post_date' => '2017-01-03'],
      ['title' => 'Bài viết số 4', 'content' => 'Nội dung bài viết 4', 'post_date' => '2017-01-03']
      );
    return view('fontend.news-list')->with(compact('news_list'));
  });

//   Route::get('register', 'App\Http\Controllers\UserController@showRegisterForm');
//   Route::post('register', 'App\Http\Controllers\UserController@storeUser');

//   Route::post('login', 'App\Http\Controllers\UserController@login');

  Route::resource('product', 'App\Http\Controllers\ProductController', ['only' => [
    'index','create', 'store', 'edit'
    ]]);

    Route::resource('admin/product', 'App\Http\Controllers\ProductController', [
        
        'middleware' => 'auth'
    ]);


Route::resource('careers', 'App\Http\Controllers\CareerController');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/error', [App\Http\Controllers\HomeController::class, 'error'])->name('error');

Route::get('/careers/{id}/apply','App\Http\Controllers\CVController@apply')->middleware('auth')->middleware('role:applicant');
Route::post('/careers/{id}/apply','App\Http\Controllers\CVController@store')->middleware('auth')->middleware('role:applicant');


Route::get('/recruiting-news-management','App\Http\Controllers\CareerController@manageNews')->middleware('auth')->middleware('role:employee');


Route::get('/careers/{id}/applicants','App\Http\Controllers\CVController@manageApplicants')->middleware('auth')->middleware('role:employee');
Route::get('/applicant/{id}','App\Http\Controllers\CVController@showApplicants')->middleware('auth')->middleware('role:employee');

Route::get('/cvs-manage-management','App\Http\Controllers\CVController@manageCVs')->middleware('auth')->middleware('role:applicant');
Route::get('/my-cv/{id}','App\Http\Controllers\CVController@myAppliedCV')->middleware('auth')->middleware('role:applicant');

Route::get('/careers/{id}/hiring-board','App\Http\Controllers\CareerController@hbConfig')->middleware('auth')->middleware('role:employee');
Route::get('/careers/{id}/hiring-board/search','App\Http\Controllers\CareerController@searchAdd')->middleware('auth')->middleware('role:employee');
Route::get('/careers/{id}/hiring-board/add/{uid}','App\Http\Controllers\CareerController@add')->middleware('auth')->middleware('role:employee');
Route::get('/careers/{id}/hiring-board/remove/{uid}','App\Http\Controllers\CareerController@remove')->middleware('auth')->middleware('role:employee');


Route::get('/hiring-board-management','App\Http\Controllers\HiringBoardController@manageMyHB')->middleware('auth')->middleware('role:employee');
Route::get('/careers/{id}/applicants/rating','App\Http\Controllers\HiringBoardController@ratingApplicants')->middleware('auth')->middleware('role:employee');

Route::get('/careers/{rid}/applicants/{id}/rate','App\Http\Controllers\RatingController@rate')->middleware('auth')->middleware('role:employee');
Route::get('/careers/{rid}/applicants/{id}/save','App\Http\Controllers\RatingController@saveRating')->middleware('auth')->middleware('role:employee');

Route::get('/criterias','App\Http\Controllers\CriteriaController@index')->middleware('auth')->middleware('role:admin');
Route::get('/criterias/create','App\Http\Controllers\CriteriaController@create')->middleware('auth')->middleware('role:admin');
Route::get('/criterias/{id}','App\Http\Controllers\CriteriaController@switch')->middleware('auth')->middleware('role:admin');

Route::get('/careers/{id}/criteria','App\Http\Controllers\CareerController@criteriaConfig')->middleware('auth')->middleware('role:employee');

Route::get('/careers/{id}/criteria/update','App\Http\Controllers\CareerController@updateCriteria')->middleware('auth')->middleware('role:employee');

Route::get('/careers/{id}/applicants/rating/{hbid}','App\Http\Controllers\CareerController@checkRating')->middleware('auth')->middleware('role:employee');


Route::get('/careers/{id}/suggestion','App\Http\Controllers\CareerController@suggest')->middleware('auth')->middleware('role:employee');
Route::get('/careers/{id}/hiring','App\Http\Controllers\CareerController@hiring')->middleware('auth')->middleware('role:employee');
Route::get('/careers/{id}/hiring/finish','App\Http\Controllers\CareerController@finishHiring')->middleware('auth')->middleware('role:employee');

Route::get('/test','App\Http\Controllers\CareerController@test');

Route::get('/my-account','App\Http\Controllers\UserController@myAccount')->middleware('auth')->middleware('checkAuth:none');