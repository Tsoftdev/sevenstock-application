<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
// clear chache route

use App\Models\NewsTags;
use Illuminate\Support\Facades\Route;

Route::get('/clear-cache', function () {
  $exitCode    = Artisan::call('cache:clear');
  $config      = Artisan::call('config:cache');
  $view        = Artisan::call('view:clear');
  return "Cache is cleared";
});

Route::group(['prefix' => 'admin', 'middleware' => 'admin_auth'], function () {
  Route::get('login', 'AdminController@login')->name('admin_login');
});

Route::match(['get', 'post'], 'admin/authenticate', 'AdminController@authenticate');

Route::group(['prefix' => 'admin', 'middleware' => 'admin_guest'], function () {
  Route::redirect('/', 'admin/dashboard');
  Route::get('dashboard', 'AdminController@index');
  Route::post('feedhistory-list', 'AdminController@feedhistorylist');
  Route::post('contact-list', 'AdminController@contactlist');

  Route::get('logout', 'AdminController@logout');
  Route::get('customers', 'CustomerController@index');
  Route::get('customer/delete/{id}', 'CustomerController@delete');
  Route::match(array('GET', 'POST'), 'add_customer', 'CustomerController@add');
  Route::match(array('GET', 'POST'), 'edit_customer/{id}', 'CustomerController@update');
  Route::post('getCompanyFilterView', 'CustomerController@getCompanyFilterView');
  Route::post('excel-upload', 'CustomerController@excelupload');
  Route::post('customerdelete', 'CustomerController@massDestroy');
  Route::get('cutomerExport', 'CustomerController@cutomerExport');
  Route::post('cutomerImport', 'CustomerController@cutomerImport');
  Route::post('delete/all/stock-transfers', 'CustomerController@deleteAllStockTransfer');
  Route::post('delete/all/file-transfers', 'CustomerController@deleteAllFileTransfer');
  Route::post('delete/all/post-delivery', 'CustomerController@deleteAllPostDelivery');
  Route::post('delete/all/visit-records', 'CustomerController@deleteAllVisitRecords');
  Route::post('delete/all/inqueries', 'CustomerController@deleteAllInqueries');

  Route::post('stockform', 'CustomerController@stockformadd');
  Route::post('updatestockform', 'CustomerController@stockformupdate');
  Route::post('getstock', 'CustomerController@getstockform');

  Route::post('filefrom', 'CustomerController@transferformadd');
  Route::post('updatetransferform', 'CustomerController@transferformupdate');
  Route::post('getfiletransfer', 'CustomerController@gettransferform');

  Route::post('posterfrom', 'CustomerController@posterformadd');
  Route::post('updateposterfrom', 'CustomerController@posterformupdate');
  Route::post('getposterfrom', 'CustomerController@getposterform');

  Route::post('visitform', 'CustomerController@visitformadd');
  Route::post('updatevisitform', 'CustomerController@visitformupdate');
  Route::post('getvisitform', 'CustomerController@getvisitform');

  Route::post('inqueryform', 'CustomerController@inqueryformadd');
  Route::post('updateinqueryform', 'CustomerController@inqueryformupdate');
  Route::post('getinqueryform', 'CustomerController@getinqueryform');
  Route::post('getModalView', 'CustomerController@getModalView');


  Route::get('articles', 'ArticleController@index');
  Route::post('article/store', 'ArticleController@store');
  Route::post('article/delete/{id}', 'ArticleController@delete');
  Route::post('article/tinymce/image/upload', 'ArticleController@upload');
  Route::post('delete/all/articles', 'ArticleController@deleteAllArticle');

  Route::post('tag/store', 'TagController@store');
  Route::post('tag/delete/{id}', 'TagController@delete');
  Route::post('delete/all/tags', 'TagController@deleteAllTag');

  Route::group(['middleware' => 'admin_can:manage_admin'], function () {
    Route::get('users', 'UserController@index')->name('admin.users');
    Route::match(['GET', 'POST'], 'user/store', 'UserController@store')->name('admin.user.store');
    Route::match(['GET', 'POST'], 'user/edit/{id}', 'UserController@edit')->name('admin.user.edit');
    Route::match(['GET', 'POST'], 'user/delete/{id}', 'UserController@delete')->name('admin.user.delete');

    //Role
    Route::get('roles', 'RoleController@index');
    Route::match(array('GET', 'POST'), 'add_roles', 'RoleController@add');
    Route::match(array('GET', 'POST'), 'edit_roles/{id}', 'RoleController@update');
    Route::post('role-delete', 'RoleController@delete');

    //company
    Route::get('companies', 'CompanyController@index');
    Route::match(array('GET', 'POST'), 'add_companies', 'CompanyController@add');
    Route::match(array('GET', 'POST'), 'edit_companies/{id}', 'CompanyController@update');
    Route::post('companydelete', 'CompanyController@massDestroy');
    Route::post('companyend-delete', 'CompanyController@companyenddelete');

    //statistic part
    Route::get('statistics', 'StockTransactionController@statistics');
    Route::post('statistics_chart', 'StockTransactionController@statistics_chart');
    Route::get('statistics_shareholder', 'StockTransactionController@statistic_shareholder');
    Route::post('statistics_all_chart', 'StockTransactionController@statistics_shareholder_chart');
    Route::post('statistics_sevenstock', 'StockTransactionController@statisticsevenstock');

    //shareholder part
    Route::get('shareholder', 'ShareholderController@index');
  });

  Route::post('category/store', 'SmsController@categoryStore')->name('admin.category.store');
  Route::get('category/category/delete/{id}', 'SmsController@categoryDelete')->name('admin.category.delete');
  Route::get('messages', 'SmsController@index')->name('admin.messages');
  Route::post('file/store', 'SmsController@fileStore')->name('admin.file.store');
  Route::get('file/delete/{id}', 'SmsController@fileDelete')->name('admin.file.delete');
  Route::post('sendSms', 'SmsController@sendSms');
  Route::get('getTitlesByCategory', 'SmsController@getTitlesByCategory');


  Route::get('user-record/stocks', 'StockTransactionController@index');

  Route::match(array('GET', 'POST'), 'user-record/add_stock', 'StockTransactionController@add');
  Route::match(array('GET', 'POST'), 'user-record/edit_stock/{id}', 'StockTransactionController@update');
  Route::post('user-record/stockdelete', 'StockTransactionController@massDestroy');
  Route::post('stock-status', 'StockTransactionController@statuschange');
  Route::post('isSentCheck', 'StockTransactionController@isSentCheck');


  Route::get('user-record/file-transfers', 'FiletransferController@index');
  Route::post('file-transfer-method', 'FiletransferController@methodchange');
  Route::post('new-company', 'FiletransferController@newcompany');

  Route::post('new-city', 'FiletransferController@newcity');
  Route::post('new-group', 'FiletransferController@newgroup');
  Route::post('new-level', 'FiletransferController@newLevel');
  Route::post('new-stock', 'FiletransferController@newstock');
  Route::post('new-route', 'FiletransferController@newroute');
  Route::post('newCustomerStatus', 'FiletransferController@newCustomerStatus');

  Route::post('city/delete/{id}', 'FiletransferController@cityDelete');
  Route::post('group/delete/{id}', 'FiletransferController@groupDelete');
  Route::post('broker/delete/{id}', 'FiletransferController@brokerDelete');
  Route::post('route/delete/{id}', 'FiletransferController@routeDelete');
  Route::post('level/delete/{id}', 'FiletransferController@levelDelete');
  Route::post('status/delete/{id}', 'FiletransferController@statusDelete');

  Route::post('delete/all/cities', 'FiletransferController@deleteAllCity');
  Route::post('delete/all/levels', 'FiletransferController@deleteAllLevel');
  Route::post('delete/all/agents', 'FiletransferController@deleteAllAgent');
  Route::post('delete/all/stocks', 'FiletransferController@deleteAllStock');
  Route::post('delete/all/routeknowns', 'FiletransferController@deleteAllRouteknown');
  Route::post('delete/all/status', 'FiletransferController@deleteAllStatus');

  Route::match(array('GET', 'POST'), 'user-record/add_file_transfer', 'FiletransferController@add');
  Route::match(array('GET', 'POST'), 'user-record/edit_file_transfer/{id}', 'FiletransferController@update');
  Route::post('user-record/filedelete', 'FiletransferController@massDestroy');

  Route::get('user-record/post-delivery', 'PostdeliveryController@index');
  Route::post('post-status', 'PostdeliveryController@statuschange');
  Route::match(array('GET', 'POST'), 'user-record/add_post_delivery', 'PostdeliveryController@add');
  Route::match(array('GET', 'POST'), 'user-record/edit_post_delivery/{id}', 'PostdeliveryController@update');
  Route::post('user-record/postdelete', 'PostdeliveryController@massDestroy');

  Route::get('user-record/visit-record', 'VisitrecordController@index');
  Route::post('visit-status', 'VisitrecordController@statuschange');
  Route::match(array('GET', 'POST'), 'user-record/add_visit_record', 'VisitrecordController@add');
  Route::match(array('GET', 'POST'), 'user-record/edit_visit_record/{id}', 'VisitrecordController@update');
  Route::post('user-record/visitdelete', 'VisitrecordController@massDestroy');

  Route::get('user-record/inquery', 'InqueryController@index');
  Route::match(array('GET', 'POST'), 'user-record/add_inquery', 'InqueryController@add');
  Route::match(array('GET', 'POST'), 'user-record/edit_inquery/{id}', 'InqueryController@update');
  Route::post('user-record/inquerydelete', 'InqueryController@massDestroy');

  Route::group(['middleware' => 'admin_can:manage_schedule'], function () {
    Route::get('schedule', 'ScheduleController@index');
    Route::post('scheduleadd', 'ScheduleController@add');
    Route::post('schedule-update', 'ScheduleController@update');
    Route::post('scheduledelete', 'ScheduleController@scheduledelete');
    Route::post('scheduleupdate', 'ScheduleController@scheduleupdate');
    Route::post('getschedule', 'ScheduleController@getschedule');
    Route::post('getfilterschedule', 'ScheduleController@getfilterschedule');
    Route::post('schedule-list', 'ScheduleController@scheduledaylist');
    Route::post('schedule-all-list', 'ScheduleController@schedulealllist');
    Route::post('schedule-selectdate', 'ScheduleController@selectscheduleday');
    Route::post('schedule-change-status', 'ScheduleController@schedulechangestatus');
    Route::post('schedule-getitem', 'ScheduleController@getitem');
    Route::post('schedule_detail', 'ScheduleController@scheduledetail');
  });

  Route::post('memo-list', 'InqueryController@memolist');
  Route::post('memo-admin-list', 'InqueryController@memoadminlist');
  Route::post('memo-add', 'InqueryController@memoadd');
  Route::post('memo-admin-add', 'InqueryController@memoadminadd');
  Route::post('memo-update', 'InqueryController@memoupdate');
  Route::post('memo-admin-update', 'InqueryController@memoadminupdate');
  Route::post('memo-delete', 'InqueryController@memodelete');
  Route::post('memo-get', 'InqueryController@getmemo');
  Route::post('memo-pin', 'InqueryController@pinmemo');


  //export database
  Route::get('export-db', 'AdminController@exportDB');

  Route::post('notify-user-list', 'NotificationController@userlist');
  Route::post('notify-search-user-list', 'NotificationController@usersearchlist');
  Route::post('notify-user-memo-list', 'NotificationController@usermemolist');
  Route::post('notify-memo-add', 'NotificationController@usermemoadd');
  Route::post('user-memo-get', 'NotificationController@usergetmemo');
  Route::post('user-memo-update', 'NotificationController@usermemoupdate');
  Route::post('user-memo-pin', 'NotificationController@userpinmemo');
  Route::post('user-memo-delete', 'NotificationController@usermemodelete');
  Route::post('admin-memo-add', 'NotificationController@adminmemoadd');
  Route::post('admin-memo-type-list', 'NotificationController@admimtypememolist');
  Route::post('admin-memo-sent-list', 'NotificationController@admimtypememosentlist');
  Route::post('admin-memo-receive-list', 'NotificationController@admimtypememoreceivelist');
  Route::post('admin-memo-pin', 'NotificationController@adminpinmemo');

  // Website
  Route::get('change-content/home', 'HomeController@index');
  Route::get('contact-box/investor', 'ContactBoxController@investor');
  Route::get('contact-box/company', 'ContactBoxController@company');
  Route::get('contact-box/get-inquiries/{inquiry_type}', 'ContactBoxController@get_inquiries');
  Route::delete('contact-box/delete-inquiries', 'ContactBoxController@delete_inquiries');
  Route::post('contact-box/read-inquiries', 'ContactBoxController@read_inquiries');
  Route::get('contact-box/read-inquiry/{id}', 'ContactBoxController@read_inquiry');
  Route::get('contact-box/unread-inquiry/{id}', 'ContactBoxController@unread_inquiry');
  Route::get('change-content/news-room-content', 'NewsRoomController@index');
  Route::get('change-content/blog', 'BlogController@index');
  Route::get('change-content/banner', 'BannerController@index');
  Route::post('change-content/banner/store', 'BannerController@store');
  Route::post('add-visitor-review', 'HomeController@add_visitor_review');
  Route::put('update-visitor-review', 'HomeController@update_visitor_review');
  Route::delete('delete-visitor-review', 'HomeController@delete_visitor_review');
  Route::post('update-home-content', 'HomeController@update_content');
  Route::resource('news-tags', 'NewsTagsController');
  Route::resource('news-content', 'NewsRoomController');
  Route::post('news-content/{id}', 'NewsRoomController@update');
  Route::post('delete-news', 'NewsRoomController@delete_news');
  Route::post('news-content-upload', 'NewsRoomController@upload');
  Route::get('get-news', 'NewsRoomController@get_news');
  Route::resource('blog-tags', 'BlogTagsController');
  Route::resource('blog', 'BlogController');
  Route::post('blog/{id}', 'BlogController@update');
  Route::post('blog-upload', 'BlogController@upload');
  Route::get('get-blog', 'BlogController@get_blog');
  Route::get('change-content/news-room-video', 'VideoController@index');
  Route::resource('video-tags', 'VideoTagsController');
  Route::resource('video', 'VideoController');
  Route::post('video/{id}', 'VideoController@update');
  Route::post('video-upload', 'VideoController@upload');
  Route::get('get-video', 'VideoController@get_video');
  Route::get('change-content/recommend/news-room', 'RecommendController@newsroom');
  Route::get('change-content/recommend/news-room-inner', 'RecommendController@newsroom_inner');
  Route::get('change-content/recommend/news-room-videos', 'RecommendController@newsroomVideos');
  Route::get('change-content/recommend/news-room-videos-inner', 'RecommendController@video_inner');
  Route::get('change-content/recommend/blog', 'RecommendController@blog');
  Route::get('change-content/recommend/consulting-list', 'RecommendController@consulting');
  Route::post('change-content/recommend/news-recommend', 'RecommendController@add_news_recommend');
  Route::post('change-content/recommend/news-unrecommend/{id}', 'RecommendController@add_news_unrecommend');
  Route::post('change-content/recommend/add-news-random', 'RecommendController@add_news_random');
  Route::post('change-content/recommend/del-news-random/{id}', 'RecommendController@del_news_random');
  Route::post('change-content/recommend/add-news-inner-recommend', 'RecommendController@add_news_inner_recommend');
  Route::post('change-content/recommend/del-news-inner-recommend/{id}', 'RecommendController@del_news_inner_recommend');
  Route::post('change-content/recommend/add-video-inner-recommend', 'RecommendController@add_video_inner_recommend');
  Route::post('change-content/recommend/del-video-inner-recommend/{id}', 'RecommendController@del_video_inner_recommend');
  Route::post('change-content/recommend/video-recommend', 'RecommendController@add_video_recommend');
  Route::post('change-content/recommend/video-unrecommend/{id}', 'RecommendController@add_video_unrecommend');
  Route::post('change-content/recommend/add-video-random', 'RecommendController@add_video_random');
  Route::post('change-content/recommend/del-video-random/{id}', 'RecommendController@del_video_random');
  Route::post('change-content/recommend/add-blog-recommend', 'RecommendController@add_blog_recommend');
  Route::post('change-content/recommend/del-blog-recommend/{id}', 'RecommendController@del_blog_recommend');
  Route::get('change-content/consulting/{id}', 'ConsultingController@index');
  Route::post('change-content/consulting/{id}', 'ConsultingController@save');
  Route::post('change-content/consulting/delete-media', 'ConsultingController@delete_media');


  //pinned
  Route::post('pinned-add', 'ScheduleController@pinnedadd');
  Route::post('pinned-update', 'ScheduleController@pinnedupdate');
  Route::post('pinned-list', 'ScheduleController@pinnedlist');
  Route::post('pinned-all-list', 'ScheduleController@pinnedalllist');
  Route::post('pinned_message_delete', 'ScheduleController@pinnedmessagedelete');
  Route::post('pinned-message-get', 'ScheduleController@pinnedmessageget');
  Route::post('pinned-message-pin', 'ScheduleController@pinmessage');
  Route::post('pinned-pagination-fetch', 'ScheduleController@pinnedfetch')->name('pinned.pagination.fetch');

  //Employee
  Route::get('employees', 'EmployeeController@index')->name('admin.employees');
  Route::match(array('GET', 'POST'), 'employees/add', 'EmployeeController@add')->name('admin.employee.add');
  Route::match(['GET', 'POST'], 'employees/update/{id}', 'EmployeeController@update')->name('admin.employee.update');
  Route::post('admin/employee/delete', 'EmployeeController@delete')->name('admin.employee.delete');
  //Receipt
  Route::get('receipt', 'ReceiptController@index')->name('admin.receipt');
  Route::post('employee-list', 'ReceiptController@employeeList')->name('admin.receipt.employeelist');
  Route::post('receipt-detail', 'ReceiptController@invoiceDetail')->name('admin.receipt.detail');
  Route::post('invoice-status', 'ReceiptController@invoicestatuschange')->name('admin.invoice.status');
  Route::post('employee-pending-list', 'ReceiptController@employeePendingList')->name('admin.receipt.employeepending');
  Route::post('employee-company-filter', 'ReceiptController@employeeFilterList')->name('admin.receipt.companyfilter');
  Route::post('receipt/add', 'ReceiptController@add')->name('admin.receipt.add');
  Route::post('receipt/update/{id}', 'ReceiptController@update')->name('admin.receipt.update');
  Route::post('receipt/analysis', 'ReceiptController@invoiceanalyse')->name('admin.receipt.analysis');
  Route::post('receipt/analysisfilter', 'ReceiptController@invoiceanalysefilter')->name('admin.receipt.analysisfilter');
  Route::post('receipt/delete', 'ReceiptController@delete')->name('admin.receipt.delete');
  Route::post('receipt/invoicedata', 'ReceiptController@invoicedata')->name('admin.receipt.invoicedata');
});
