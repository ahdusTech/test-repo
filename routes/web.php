<?php
ini_set('memory_limit', '-1');

use App\Models\Customer\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\DB;


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


Auth::routes();
Route::get('/bid_manager_automation', 'HomeController@bid_manager_automation')->name('bid_manager_automation');
Route::get('/auction_automation', 'HomeController@auction_automation')->name('auction_automation');
Route::get('/access/grant', 'HomeController@access_grant')->name('request_access');
Route::post('/access/grant', 'HomeController@access_grant')->name('access_grant');

// testing starts


//Route::get('testing', function() {
  //  return view('test.image');
//})->name('view.image');

Route::get('/test/users', 'testController@testusers')->name('testusers');


// end testinf

Route::group([
    // 'prefix' => LaravelLocalization::setLocale(session('locale')),
    //'middleware' => ['localeSessionRedirect', 'localizationRedirect'  , 'request_access' ]
    /*->middleware(['request_access'])*/
], function () {

     // front end products home page starts

     Route::get('/', 'frontend\frontendController@home')->name('home');

     Route::get('/collections/{categoryId}/{categoryName}', 'frontend\frontendController@collections')->name('collections');
     Route::get('/collections-photo/cat-id/{categoryId}/cat/{categoryName}/sub-id/{subcategoryId}/sub/{subcategoryName}', 'frontend\frontendController@photo_collections')->name('photo.collections');
     Route::get('/collection/image/{categoryId}/{image_id}/{subcategoryId?}', 'frontend\frontendController@singleImage')->name('single.Image');
     Route::get('/collection/image2/{categoryId}/{image_id}', 'frontend\frontendController@singleImage2')->name('single.Image2');

     Route::get('/Newsest-collection', 'frontend\frontendController@NewestCollection')->name('Newest.Collection');


     Route::get('/pages/about', 'frontend\frontendController@pagesAbout')->name('pages.about');
     Route::get('/pages/contact', 'frontend\frontendController@pagesContact')->name('pages.contact');
     Route::get('/pages/copyright', 'frontend\frontendController@pagesCopyright')->name('pages.copyright');
     Route::get('/pages/lisence', 'frontend\frontendController@pagesLisence')->name('pages.lisence');
     Route::get('/pages/privacy', 'frontend\frontendController@pagesPrivacy')->name('pages.privacy');



     // end front end


    Route::get('/admin', 'HomeController@admin');
    Route::get('/clock/{type}', 'HomeController@clock')->name('clock');

    Route::get('/customer/login', 'Auth\LoginController@showCustomerLoginForm')->name('customer.login_form');
    Route::post('/login/customer', 'Auth\LoginController@customerLogin')->name('customer.login');
    Route::get('/customer/register', 'Auth\RegisterController@showCustomerRegisterForm')->name('customer.register_form');

    /*Auctions*/
    Route::get('/ablauf', 'HomeController@ablauf')->name('auction_process');
    Route::get('/auction/{type}', 'HomeController@auction_details')->name('auction.type');
    Route::get('/auction/domain/{domain_hash}', 'HomeController@auction_domain_detail')->name('auction.domain.bid');

    /*Auctions*/

    Route::get('/domain/{hash}', 'LandingpageController@domain')->name('landingpage.domain');
    Route::post('/send-inquiry', 'LandingpageController@send')->name('landingpage.send');


    Route::get('/impressum', 'StaticController@imprint')->name('static.imprint');
    Route::get('/datenschutz', 'StaticController@dataPrivacy')->name('static.dataprivacy');
    Route::get('/bildnachweise', 'StaticController@imageLicences')->name('static.imagelicences');
    Route::get('/agb', 'StaticController@agb')->name('static.agb');




    Route::group([
        'middleware' => ['auth:web', '2fa', 'isAdmin']
    ], function () {

        Route::get('/admin/2fa', 'LoginSecurityController@show2faForm')->name('2fa-settings');
        Route::post('/admin/2fa/generateSecret', 'LoginSecurityController@generate2faSecret')->name('generate2faSecret');
        Route::post('/admin/2fa/enable2fa', 'LoginSecurityController@enable2fa')->name('enable2fa');
        Route::post('/admin/2fa/disable2fa', 'LoginSecurityController@disable2fa')->name('disable2fa');
        Route::post('/admin/2fa/2faVerify', 'LoginSecurityController@admin_dasboard')->name('2faVerify');

//      Dashboard part started
        Route::get('/admin/dashboard', 'DashboardController@index')->name('dashboard');
//      Dashboard part ended



//      Users part started
        Route::get('/admin/users', 'UserController@index')->name('admin.home');
        Route::get('/admin/users/get-all-users-json', 'UserController@getAllUsersJson')->name('get-all-users-json');
        Route::get('/admin/users/edit-user/{id}', 'UserController@getEditUserPage')->name('get-edit-user-page');
        Route::post('/admin/users/get-delete-user-modal', 'UserController@getDeleteUserModal')->name('get-delete-user-modal');

        Route::post('/admin/users/delete-user-process', 'UserController@deleteUserProcess')->name('delete-user-process');
        Route::get('/admin/users/add-new-user', 'UserController@addNewUserPage')->name('add-new-user-page');
        Route::post('/admin/users/add-new-user-process', 'UserController@addNewUserProcess')->name('add-new-user-process');
        Route::post('/admin/users/update-user-process', 'UserController@updateUserProcess')->name('update-user-process');
        Route::post('/admin/users/get-filter-user-modal', 'UserController@getFilterModal')->name('get-filter-user-modal');
//Users part ended

//    Inquiry part started
        Route::get('/admin/inquiry', 'InquiryController@index')->name('inquiry');
        Route::get('/admin/inquiry/get-all-inquiries-json', 'InquiryController@getAllInquiryJson')->name('get-all-inquiries-json');
        Route::get('/admin/inquiry/add-new-inquiry', 'InquiryController@addNewInquiry')->name('add-new-inquiry');
        Route::post('/admin/inquiry/add-new-inquiry-process', 'InquiryController@addNewInquiryProcess')->name('add-new-inquiry-process');
        Route::post('/admin/inquiry/get-anonymous-inquiry-modal', 'InquiryController@getAnonymousInquiryModal')->name('get-anonymous-inquiry-modal');
        Route::post('/admin/inquiry/anonymous-inquiry-process', 'InquiryController@anonymousInquiryProcess')->name('anonymous-inquiry-process');
        Route::get('/admin/inquiry/edit-inquiry/{id}', 'InquiryController@editInquiry')->name('edit-inquiry');
        Route::post('/admin/inquiry/update-inquiry-process', 'InquiryController@updateInquiryProcess')->name('update-inquiry-process');
        Route::post('/admin/inquiry/get-delete-inquiry-modal', 'InquiryController@getDeleteInquiryModal')->name('get-delete-inquiry-modal');
        Route::post('/admin/inquiry/delete-inquiry-process', 'InquiryController@deleteInquiryProcess')->name('delete-inquiry-process');
        Route::post('/admin/inquiry/get-filter-inquiry-modal', 'InquiryController@getFilterModal')->name('get-filter-inquiry-modal');
        Route::post('/admin/inquiry/create-offer/{inquiry}', 'InquiryController@create_offer')->name('admin.create_offer');
        Route::post('/admin/inquiry/send-offer/{inquiry}', 'InquiryController@send_offer')->name('admin.send_offer');
//    Inquiry part ended

//    Domain part started
        Route::get('/admin/domain', 'DomainController@index')->name('domain');
        Route::get('/admin/domain/get-all-domains', 'DomainController@getAllDomain')->name('get-all-domains');
        Route::get('/admin/domain/get-all-domains-json', 'DomainController@getAllDomainsJson')->name('get-all-domains-json');
        Route::get('/admin/domain/add-new-domain', 'DomainController@addNewDomainPage')->name('add-new-domain');
        Route::get('/admin/domain/edit-domain/{id}', 'DomainController@editDomain')->name('edit-domain');
        Route::post('/admin/domain/add-new-domain-process', 'DomainController@addNewDomainProcess')->name('add-new-domain-process');
        Route::post('/admin/domain/update-domain-process', 'DomainController@updateDomainProcess')->name('update-domain-process');
        Route::post('/admin/domain/get-delete-domain-modal', 'DomainController@getDeleteDomainModal')->name('get-delete-domain-modal');
        Route::post('/admin/domain/delete-domain-process', 'DomainController@deleteDomainProcess')->name('delete-domain-process');
        Route::post('/admin/domain/get-filter-domain-modal', 'DomainController@getFilterDomainModal')->name('get-filter-domain-modal');
//    Domain part ended

//        Not Found Domain part started
        Route::get('/admin/not-found-domain', 'NotFoundController@index')->name('not-found-domains');
        Route::get('/admin/not-found-domain/add-new-domain', 'NotFoundController@addNewDomain')->name('add-new-nf-domain');
        Route::get('/admin/not-found-domain/edit-domain/{id}', 'NotFoundController@editDomain')->name('edit-nf-domain');
        Route::get('/admin/not-found-domain/get-all-domains-json', 'NotFoundController@getAllDomainsJson')->name('get-all-nfdomains-json');
        Route::post('/admin/not-found-domain/update-domain-process', 'NotFoundController@updateDomainProcess')->name('update-nfdomain-process');
        Route::post('/admin/not-found-domain/add-domain-process', 'NotFoundController@addDomainProcess')->name('add-new-nfdomain-process');
        Route::post('/admin/not-found-domain/get-delete-not-found-domain-modal', 'NotFoundController@getDeleteNotFoundDomainModal')->name('get-delete-nfdomain-modal');
        Route::post('/admin/not-found-domain/delete-not-found-domain-process', 'NotFoundController@deleteNotFoundDomainProcess')->name('delete-not-found-domain-process');
        Route::post('/admin/not-found-domain/get-filter-nfdomain-modal', 'NotFoundController@getFilterNfDomainModal')->name('get-filter-nfdomain-modal');
//        Not Found Domain part ended

//        Visit Part Started
        Route::get('/admin/visits', 'VisitsController@index')->name('visits');
        Route::get('/admin/visits/get-all-visits-json', 'VisitsController@getAllVisitsJson')->name('get-all-visits-json');
        Route::post('/admin/visits/get-filter-visits-modal', 'VisitsController@getFilterModal')->name('get-filter-visits-modal');
//        Visit Part Ended

//        Daily Visit part started
        Route::get('/admin/daily-visits', 'DailyVisitController@index')->name('daily-visit');
        Route::get('/admin/visits/get-all-daily-visit-json', 'DailyVisitController@getAllDailyVisitJson')->name('get-all-daily-visit-json');
        Route::post('/admin/visits/get-filter-daily-visit-modal', 'DailyVisitController@getFilterModal')->name('get-filter-daily-visit-modal');
//        Daily Visit part ended

//        Statistic part started
        Route::get('/admin/statistics', 'StatisticController@index')->name('statistics');
        Route::get('/admin/statistics/get-all-statistics-json', 'StatisticController@getAllStatisticsJson')->name('get-all-statistics-json');
        Route::post('/admin/statistics/get-filter-statistics-modal', 'StatisticController@getFilterStatisticModal')->name('get-filter-statistics-modal');
//        statistic part ended

//        Logo Part Started
        Route::get('/admin/logo', 'LogoController@index')->name('logo');
        Route::get('/admin/logo/add-new-logo', 'LogoController@addNewLogo')->name('add-new-logo');
        Route::get('/admin/logo/edit-logo/{id}', 'LogoController@editLogo')->name('edit-logo');
        Route::post('/admin/logo/get-delete-logo-modal', 'LogoController@getDeleteLogoModal')->name('get-delete-logo-modal');
        Route::post('/admin/logo/delete-logo-process', 'LogoController@deleteLogoProcess')->name('delete-logo-process');
        Route::post('/admin/logo/add-new-logo-process', 'LogoController@addLogoProcess')->name('add-new-logo-process');
        Route::post('/admin/logo/update-logo-process', 'LogoController@updateLogoProcess')->name('update-logo-process');
        Route::post('/admin/logo/sort-logo', 'LogoController@sortLogo')->name('sort-logo');
        Route::post('/admin/logo/get-filter-logo-modal', 'LogoController@getFilterLogoModal')->name('get-filter-logo-modal');
        Route::get('/admin/logo/get-all-logo-json', 'LogoController@getAllLogoJson')->name('get-all-logo-json');
//        Logo Part Ended

//        EPP Part Started


//        EPP Part Ended


        Route::namespace('Admin')->prefix('admin')->group(function () {

            // CategoryController

            Route::get('/categories', 'CategoryController@index')->name('admin.categories');
            Route::get('/create/categories', 'CategoryController@create')->name('admin.create.categories');
            Route::post('/store/categories', 'CategoryController@store')->name('admin.store.categories');
            Route::get('/edit/categories/{id}', 'CategoryController@edit')->name('admin.edit.categories');
            Route::post('/update/categories', 'CategoryController@update')->name('admin.update.categories');
            Route::get('/delete-categories/{id}', 'CategoryController@destroy')->name('admin.delete.categories');


            Route::get('/getAllCatJson', 'CategoryController@getAllCatJson')->name('admin.getAllCatJson');
            Route::post('/logo/sort-logo', 'CategoryController@sortLogo')->name('sort-logo');
            Route::post('/logo/get-delete-logo-modal', 'CategoryController@getDeleteLogoModalCat')->name('get-delete-logo-modal-cat');
            Route::post('/logo/delete-logo-process', 'CategoryController@deleteLogoProcessCat')->name('delete-logo-process-cat');


            // sub cate //

            Route::get('/sub-categories/{category_name?}', 'SubCategoryController@index')->name('admin.subcategories');
            Route::get('/getCatName/sub-categories/{name}', 'SubCategoryController@getCatName')->name('admin.getCatName.subcategories');
            Route::get('/create/sub-categories/{name}', 'SubCategoryController@create')->name('admin.create.subcategories');
            Route::post('/store/sub-categories', 'SubCategoryController@store')->name('admin.store.subcategories');
            Route::get('/edit/sub-categories/{id}/{category_name}', 'SubCategoryController@edit')->name('admin.edit.subcategories');
            Route::post('/update/sub-categories', 'SubCategoryController@update')->name('admin.update.subcategories');
            Route::get('/delete-sub-categories/{id}', 'SubCategoryController@destroy')->name('admin.delete.subcategories');

            Route::get('/getAllSubCatJson', 'SubCategoryController@getAllSubCatJson')->name('admin.getAllSubCatJson');
            Route::post('/logo/sort-logo-sub', 'SubCategoryController@sortLogosub')->name('sort-logo-sub');
            Route::post('/logo/get-delete-logo-modal-sub', 'SubCategoryController@getDeleteLogoModaSub')->name('get-delete-logo-modal-sub');
            Route::post('/logo/delete-logo-process-sub', 'SubCategoryController@deleteLogoProcessSub')->name('delete-logo-process-sub');



            //

            // photo section started

            Route::get('/photos/{category_name?}', 'PhotoController@index')->name('admin.photos');
            Route::get('/photos-cat-name/{name}', 'PhotoController@getCatName')->name('admin.getCatName.photos');
            Route::get('/create/photos/{name}', 'PhotoController@create')->name('admin.create.photos');
            Route::post('/store/photos', 'PhotoController@store')->name('admin.store.photos');
            Route::get('/getAllPhotos', 'PhotoController@getAllPhotos')->name('admin.getAllPhotos');
            Route::get('/edit/photos/{photo_id}/{category_name}', 'PhotoController@edit')->name('admin.edit.photos');
            Route::post('/logo/get-delete-modal-photo', 'PhotoController@getDeleteLogoModaPhoto')->name('get-delete-modal-photo');
            Route::post('/logo/get-modal-photo', 'PhotoController@getLogoModaPhoto')->name('get-modal-photo');
            Route::post('/logo/delete-process-photo', 'PhotoController@deleteLogoProcessPhoto')->name('delete-process-photo');
            Route::post('/update/photos', 'PhotoController@update')->name('admin.update.photos');


            // photo ended


            //Customer part started
            Route::get('/customers', 'CustomerController@index')->name('admin.customers');
            Route::get('/customer/add-new-customer', 'CustomerController@create')->name('admin.customer.create_page');
            Route::post('/customer/add-new-customer-process', 'CustomerController@store')->name('admin.customer.create');
        //     Route::get('/customer/edit-customer/{id}', 'CustomerController@edit')->name('admin.customer.edit');
        //     Route::post('/customer/update-customer/{id}', 'CustomerController@update')->name('admin.customer.update');
            Route::post('/customer/get-delete-customer-modal', 'CustomerController@getDeleteCustomerModal')->name('get-delete-customer-modal');
            Route::get('/customer/delete-customer-process/{customer}', 'CustomerController@destroy')->name('delete-customer-process');
            /*Customer part ended*/

            //Email Templates part started
            Route::get('/email-template/{template?}', 'EmailTemplateController@index')->name('admin.email_templates');
            Route::post('/email-template', 'EmailTemplateController@store')->name('admin.email_templates.save');
            Route::post('/email-template/{email_template}', 'EmailTemplateController@update')->name('admin.email_templates.update');
            /*Email Templates part ended*/


            //Customer part started
            Route::get('/black-list', 'FreeMailBlacklistController@index')->name('admin.black_list');
            Route::post('/black-list/update', 'FreeMailBlacklistController@black_list')->name('admin.blacklist_update');

            /*Customer part ended*/
        });


        /*Bulk Processing Start*/


    });

    Route::get('/customer/edit-customer/{id}', 'Admin\CustomerController@edit')->name('admin.customer.edit');
    Route::post('/customer/update-customer/{id}', 'Admin\CustomerController@update')->name('admin.customer.update');


    Route::namespace('Customer')->prefix('customer')->group(function () {



        /*Customer Auth Routes Start*/
        /*Route::middleware('guest')->group(function () {*/
            Route::get('/password/reset', 'AuthController@reset_password_request_form')->name('customer.password.reset.request.form');
            Route::get('/password/reset/{token}/{email}', 'AuthController@reset_password_form')->name('customer.password.reset.form');
        /*});*/
        Route::post('/password/reset', 'AuthController@reset_password_request_validate')->name('customer.password.reset.email');

        Route::post('/password/update', 'AuthController@update_password')->name('customer.password.update');
        Route::get('/verify_code/{email}', 'AuthController@verify_code')->name('customer.verify_code');
        Route::post('/send_verification_code', 'AuthController@send_verification_code')->name('customer.send_verification_code');
        Route::post('/register', 'AuthController@register')->name('customer.register');
        Route::post('/logout', 'AuthController@logout')->name('customer.logout');
        /*Customer Auth Routes End*/

        /*Auction Controller Routes Start*/
        Route::get('/auction/all', 'CustomerAuctionController@index')->name('customer.auction.all');
        Route::get('/auction/favourite/add', 'CustomerAuctionController@add_to_favourite')->name('customer.favourite.add');
        Route::get('/auction/favourite/{type}', 'CustomerAuctionController@favourite')->name('customer.auction.favourite');
        Route::get('/auction/my/{type}', 'CustomerAuctionController@my_auctions')->name('customer.auction.my');
        Route::get('/auction/watchlist/add', 'CustomerAuctionController@add_to_watchlist')->name('customer.watchlist.add');
        Route::get('/auction/watchlist/{type}', 'CustomerAuctionController@watchlist')->name('customer.auction.watchlist');
        /*Route::get('/auctions/{type}', 'CustomerAuctionController@customer_auctions')->name('customer.auctions.type');*/
        Route::any('/auction/bid/{id}', 'CustomerAuctionController@bid')->name('customer.auction.bid');
        Route::post('/auction/bid/{id}/submit', 'CustomerAuctionController@submit_bid')->name('customer.auction.submit_bid');
        Route::post('/get-bidder-list-modal', 'CustomerAuctionController@get_bidder_list_modal')->name('get-bidder-list-modal');
        Route::delete('/auction/{customer_auction}', 'CustomerAuctionController@destroy')->name('customer.auction.delete');

        /*Auction Controller Routes End*/

            /*2Fa Routes for Customer Starts*/

            Route::get('/2fa', 'LoginSecurityController@show2faForm')->name('customer.2fa-settings');
            Route::post('/2fa/generateSecret', 'LoginSecurityController@generate2faSecret')->name('customer.generate2faSecret');
            Route::post('/2fa/enable2fa', 'LoginSecurityController@enable2fa')->name('customer.enable2fa');
            Route::post('/2fa/disable2fa', 'LoginSecurityController@disable2fa')->name('customer.disable2fa');
            Route::post('/2fa/2faVerify', 'LoginSecurityController@customer_dashboard')->name('customer.2faVerify');
            /*2Fa Routes for Customer Ends*/

            /*Dashboard/Home Controller Routes Start*/

            Route::get('/', 'HomeController@dashboard')->name('customer.home');
            Route::get('/dashboard', 'HomeController@dashboard')->name('customer.dashboard');




            /*Certificate Controller Routes End*/

            /*Setting Controller Routes Start*/

            Route::get('/setting', 'SettingController@index')->name('customer.setting');
            Route::get('/profile', 'ProfileController@index')->name('customer.profile');
            Route::post('/profile/update/{customer}', 'ProfileController@update')->name('customer.profile_update');
            Route::get('/profile/delete', 'ProfileController@destroy')->name('customer.delete');
            /*Route::post('/user/get-delete-customer-modal/{user}', 'ProfileController@destroy_alert')->name('customer.delete.alert');*/
            Route::post('/profile/delete/{user}', 'ProfileController@destroy')->name('customer.deletion');

            /*Setting Controller Routes End*/




    });

});

