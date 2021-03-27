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
Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    return 'DONE'; //Return anything
});

Route::get('/migrate', function () {
    $exitCode = Artisan::call('migrate');
    return 'DONE'; //Return anything
});

Route::get('/routeList', function () {
    $exitCode = Artisan::call('route:list');
    return Artisan::output(); //Return anything
});

Route::get('/seed', function () {
    $exitCode = Artisan::call('db:seed');
    return 'DONE'; //Return anything
});

//create symbolic link for storage
Route::get('/symlink', function () {
    return view('symlink');
});
Auth::routes();
Route::get('/loginform', function () {
    return view('auth.login');
});
Route::get('/resetPassword', function () {
    return view('auth.resetpasswrd');
});
Route::post('/resetPasswordSubmit', 'ResetPasswordController@resetPasswordSubmit')->name('resetPassword.submit');

// frontend routes
Route::get('/', 'DesignController@index')-> name('home');
Route::get('/contact', 'DesignController@contactus')->name('contactus');
Route::post('/store/contact', 'DesignController@storeContact')->name('store.contact');
// Route::get('/loginform', 'DesignController@loginForm')-> name('loginform');
Route::resource('/user-manual', 'Admin\UserManualController');
// Route::get('/login', 'HomeController@front')->name('login');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/admin/users', 'Admin\UsersController@index')->middleware('can:manage-users,manage-admin-user,admin')->name('users');
Route::put('/admin/users/update/{id}', 'Admin\UsersController@update')->name('users.update');
Route::delete('/users/destroy/{id}', 'Admin\UsersController@destroy')->name('deleteusers');
// Route::get('/resetPassword', 'Admin\UsersController@resetpas')->name('resetpass');
Route::get('status/{id}', 'Admin\UsersController@status')->name('status');
Route::get('activate/{id}', 'Auth\RegisterController@activate')->name('activate');
Route::post('/subscribe', 'DesignController@storeSubscriber')->name('subscribe');
Route::resource('/coursesData', 'CoursesController');
Route::resource('/tempCoursesData', 'TempCoursesController');
Route::get('/editProfile', 'Admin\UsersController@editProfile')->name('admin.editProfile');
Route::put('/updateProfile', 'Admin\UsersController@updateProfile')->name('admin.updateProfile');


// CourseTab Route
Route::get('/courseTab/create/{id}', 'TempCoursesController@create')->name('tab.create');
Route::post('/courseTab/store/{id}', 'TempCoursesController@storetab')->name('tab.store');
Route::get('admin/tab/edit/{id}', 'CoursesController@edit')->name('edit.tab');
// Status of course tab
Route::get('admin/tab/status/{id}', 'CoursesController@status')->name('status.tab');
Route::put('admin/tab/update/{id}', 'CoursesController@update')->name('tab.update');
// Route::post('/tempCoursesData/tab', 'TempCoursesController@storetab')->name('tab');
Route::post('/admin/tempcourses/store/{id}', 'TempCoursesController@storeCourse')->name('course.store');
Route::post('/tempCoursesData/create', 'TempCoursesController@store')->name('tempCoursesData.store');
Route::delete('/tempCoursesData/delete/{id}', 'TempCoursesController@destroytab')->name('deletetab');
Route::get('/courses', 'CoursesController@index')->name('tempCoursesData.coursesAll');
Route::get('/course/create', 'CoursesController@create')->name('coursetab.create');
Route::post('/course/create', 'CoursesController@store')->name('coursetab.store');
Route::post('/course/module', 'CoursesController@storeModule')->name('module.store');
Route::resource('/adminReg', 'AdminRegController');
Route::get('/adminReg/edit/{id}', 'AdminRegController@edit')->name('adminReg.user.edit');
Route::put('/adminReg/update/{id}', 'AdminRegController@update')->name('adminReg.user.update');
Route::get('/adminReg/userlist/{id}', 'AdminRegController@usersList')->name('users.list');
Route::get('/userlist', 'Admin\UsersController@usersList')->name('auth.users.list');
Route::get('/changePassword', 'ChangePasswordController@ChangePasswordForm')->name('ChangePasswordForm');
Route::post('/changePassword', 'ChangePasswordController@ChangePasswordStore')->name('ChangePasswordStore');
Route::get('/test', 'Admin\TestController@index')->name('test.index');
Route::get('/test/create', 'Admin\TestController@create')->name('test.create');
Route::get('/tablist/{id}','Admin\TestController@getTabList')->name('tab.list');
// Route::get('/module/{id}','Admin\TestController@getModuleList');
Route::post('/test/store', 'Admin\TestController@store')->name('test.store');
Route::get('/test/edit/{id}', 'Admin\TestController@edit')->name('test.edit');
Route::put('/test/update/{id}', 'Admin\TestController@update')->name('test.update');
Route::delete('/test/destroy/{id}', 'Admin\TestController@destroy')->name('test.delete');
Route::get('/test/question/{id}', 'Admin\TestController@questionForm')->name('question.index');
Route::get('/question/add/{id}', 'Admin\TestController@addQuestion')->name('question.create');
Route::get('/examTest', 'User\TestController@index')->name('user.test.index');
Route::get('/viewQuestion/{id}', 'User\TestController@viewQuestion')->name('question.view');
Route::get('/get/question/{id}', 'Admin\TestController@showQuestion')->name('company.question.view');
Route::get('/take/test', 'User\TestController@takeTest')->name('take.test');
Route::post('/view/question/{id}', 'User\TestController@testQuestion')->name('view.question');
Route::post('/getQuestion', 'User\TestController@getTestQuestion')->name('get.question');
Route::get('/getTest/{id}', 'User\TestController@getTestView')->name('get.take.test');
Route::post('/questionNavigate', 'User\TestController@questionNavigate')->name('question.navigate');
Route::post('/storeTest', 'User\TestController@testResultStore')->name('user.test.store');
Route::get('/test/submit/{id}', 'User\TestController@testResultSubmit')->name('submit.test');
Route::get('/resultStore/{id}', 'User\TestController@getTestResult')->name('user.test.result');


// SignaturePad Route
Route::get('signaturepad', 'Admin\SignaturePadController@index');

Route::post('signaturepad', 'Admin\SignaturePadController@upload')->name('signaturepad.upload');


// Test Route
Route::get('/viewTest/{id}', 'Admin\TestController@viewTest')->name('view.result');
Route::get('/admin/question/type/{id}', 'Admin\QuestionController@getQuestionType')->name('question.type');
Route::post('/question/single/store/{id}', 'Admin\QuestionController@questionSingleSubmit')->name('question.single.store');
Route::post('/question/multiple/store/{id}', 'Admin\QuestionController@questionMultipleSubmit')->name('question.multiple.store');
Route::post('/question/blank/store/{id}', 'Admin\QuestionController@questionBlankSubmit')->name('question.blank.store');
Route::post('/question/trueorfalse/store/{id}', 'Admin\QuestionController@questionTrueOrFalseSubmit')->name('question.trueorfalse.store');
Route::get('/question/edit/{id}', 'Admin\QuestionController@editQuestion')->name('question.edit');
Route::put('/question/single/update/{id}', 'Admin\QuestionController@updateSingleQuestion')->name('question.single.update');
Route::put('/question/multiple/update/{id}', 'Admin\QuestionController@updateMultipleQuestion')->name('question.multiple.update');
Route::put('/question/trueorfalse/update/{id}', 'Admin\QuestionController@updateTrueOrFalseQuestion')->name('question.trueorfalse.update');
Route::put('/question/blank/update/{id}', 'Admin\QuestionController@updateBlankQuestion')->name('question.blank.update');
Route::delete('/question/delete/{id}', 'Admin\QuestionController@destroyQuestion')->name('question.delete');
Route::post('/test/multiple/store', 'User\TestController@storeCheckboxAnswer')->name('user.test.multiple.store');
Route::post('/test/blank/store', 'User\TestController@storeInputAnswer')->name('user.test.blank.store');
Route::post('/test/trueorfalse/store', 'User\TestController@storeTrueOrFalseAnswer')->name('user.test.trueorfalse.store');
Route::get('/certificates', 'User\CertificateController@index')->name('user.certificate');
Route::get('/certificate/{id}', 'User\CertificateController@certificateDownload')->name('certificate.download');
Route::get('/admin/testResult', 'Admin\TestController@testResult')->name('admin.test.result');
Route::get('/admin/moduleReactivate', 'Admin\ModuleController@index')->name('user.moduleReactivate.request');
Route::get('/test/enabled/{id}', 'Admin\ModuleController@testEnabled')->name('test.enabled');
Route::post('/checkAnswer', 'User\TestController@checkUserAnswer')->name('checkUserAnswer');
Route::post('/markForReview', 'User\TestController@markForReview')->name('markForReview');
Route::post('/removeAns', 'User\TestController@removeAns')->name('removeAns');
Route::post('submitTestResult', 'User\TestController@submitTestResult')->name('admin.get.submitTestResult');


Route::get('/sendCertificateMail/{id}', 'User\CertificateController@sendCertificateMail')->name('send.certificate.mail');