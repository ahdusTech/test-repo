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
/*Route::get('/inqueries_import', 'HomeController@inqueries_import')->name('inqueries_import');
Route::get('/new-offers', 'HomeController@new_offers')->name('new_offers');
Route::get('/sent-offers', 'HomeController@send_offers')->name('send_offers');
Route::get('/import_offers', 'HomeController@import_offers')->name('import_offers');*/

Route::get('web/new_offers', 'ImportController@new_offers')->name('web.new_offers');
Route::get('web/sent_offers', 'ImportController@sent_offers')->name('web.sent_offers');

Auth::routes();
Route::get('/bid_manager_automation', 'HomeController@bid_manager_automation')->name('bid_manager_automation');
Route::get('/auction_automation', 'HomeController@auction_automation')->name('auction_automation');
Route::get('/access/grant', 'HomeController@access_grant')->name('request_access');
Route::post('/access/grant', 'HomeController@access_grant')->name('access_grant');

Route::group([
    'prefix' => LaravelLocalization::setLocale(session('locale')),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect'  , 'request_access' ]
    /*->middleware(['request_access'])*/
], function () {
    Route::get('/', 'HomeController@home')->name('home');

    Route::get('/admin', 'HomeController@admin');
    Route::get('/clock/{type}', 'HomeController@clock')->name('clock');

    Route::get('/customer/login', 'Auth\LoginController@showCustomerLoginForm')->name('customer.login_form');
    Route::post('/login/customer', 'Auth\LoginController@customerLogin')->name('customer.login');
    Route::get('/customer/register', 'Auth\RegisterController@showCustomerRegisterForm')->name('customer.register_form');

    /*Auctions*/
    Route::get('/ablauf', 'HomeController@ablauf')->name('auction_process');
    Route::get('/auction/{type}', 'HomeController@auction_details')->name('auction.type');
    Route::get('/auction/domain/{domain_hash}', 'HomeController@auction_domain_detail')->name('auction.domain.bid');
    if (env('APP_URL') != 'https://kristundraja.com') {

    }

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

        Route::get('/admin/epp/domain', 'EPPControler@domain')->name('epp-domain');
        Route::post('/admin/epp/domain', 'EPPControler@domain')->name('epp-domain-process');
        Route::get('/admin/epp/authcode', 'EPPControler@authcode')->name('epp-authcode');
        Route::post('/admin/epp/update-auth-code', 'EPPControler@updateAuthCode')->name('update-auth-code');
        Route::get('/admin/epp/send-transfer-out-code', 'EPPControler@sendTransferOutCode')->name('send-transfer-out-code');
        Route::get('/admin/epp/verify-transfer-out-code', 'EPPControler@verifyTransferOutCode')->name('verify-transfer-out-code');
        Route::post('/admin/epp/generate-random-code', 'EPPControler@generateRandomCode')->name('generate-random-code');
        Route::get('/admin/epp/register', 'EPPControler@register')->name('epp-register');
        Route::post('/admin/epp/register-domain', 'EPPControler@registerDomain')->name('register-domain');
        Route::get('/admin/epp/transfer', 'EPPControler@transfer')->name('epp-transfer');
        Route::post('/admin/epp/transfer-domain', 'EPPControler@transferDomain')->name('transfer-domain');
        Route::get('/admin/epp/delete', 'EPPControler@delete')->name('epp-delete');
        Route::post('/admin/epp/delete-confirm', 'EPPControler@deleteConfirm')->name('delete-confirm');
        Route::post('/admin/epp/delete-confirm-modal', 'EPPControler@deleteConfirmModal')->name('delete-confirm-modal');
        Route::post('/admin/epp/delete-confirm-process', 'EPPControler@deleteConfirmProcess')->name('delete-confirm-process');
        Route::get('/admin/epp/undelete', 'EPPControler@undelete')->name('epp-undelete');
        Route::post('/admin/epp/undelete-confirm', 'EPPControler@undeleteConfirm')->name('undelete-confirm');
        Route::post('/admin/epp/undelete-confirm-modal', 'EPPControler@undeleteConfirmModal')->name('undelete-confirm-modal');
        Route::post('/admin/epp/undelete-confirm-process', 'EPPControler@undeleteConfirmProcess')->name('undelete-confirm-process');
        Route::get('/admin/epp/messages', 'EPPControler@messages')->name('epp-messages');
        Route::post('/admin/epp/poll-ack', 'EPPControler@pollAck')->name('poll-ack');
        Route::post('/admin/epp/delete-message-confirm-modal', 'EPPControler@deleteMessageConfirmModal')->name('delete-message-confirm-modal');
        Route::get('/admin/epp/epp-modifications', 'EPPControler@Modification')->name('epp-modification');
        Route::post('/admin/epp/epp-modification-process', 'EPPControler@modificationProcess')->name('modification-domain');

//        EPP Part Ended


        Route::namespace('Admin')->prefix('admin')->group(function () {
             /*Auction Routes Start*/
            Route::get('/auctions/{type}', 'AuctionController@index')->name('admin.auction.list');
            Route::get('/auction/create', 'AuctionController@create')->name('admin.auction.create');
            Route::get('/auction/calculate', 'AuctionController@create')->name('admin.auction.calculate');
            Route::post('/auction/store', 'AuctionController@store')->name('admin.auction.store');
            Route::post('/auction/delete', 'AuctionController@destroy')->name('admin.auction.delete');
            Route::post('/get-bidder-list-modal', 'AuctionController@get_bidder_list_modal')->name('admin.get-bidder-list-modal');
            /*Auction Routes End*/

            //Customer part started
            Route::get('/customers', 'CustomerController@index')->name('admin.customers');
            Route::get('/customer/add-new-customer', 'CustomerController@create')->name('admin.customer.create_page');
            Route::post('/customer/add-new-customer-process', 'CustomerController@store')->name('admin.customer.create');
            Route::get('/customer/edit-customer/{id}', 'CustomerController@edit')->name('admin.customer.edit');
            Route::post('/customer/update-customer/{id}', 'CustomerController@update')->name('admin.customer.update');
            Route::post('/customer/get-delete-customer-modal', 'CustomerController@getDeleteCustomerModal')->name('get-delete-customer-modal');
            Route::post('/customer/delete-customer-process/{customer}', 'CustomerController@destroy')->name('delete-customer-process');
            /*Customer part ended*/

            //Email Templates part started
            Route::get('/email-template/{template?}', 'EmailTemplateController@index')->name('admin.email_templates');
            Route::post('/email-template', 'EmailTemplateController@store')->name('admin.email_templates.save');
            Route::post('/email-template/{email_template}', 'EmailTemplateController@update')->name('admin.email_templates.update');
            /*Email Templates part ended*/

            //Invites part started
            Route::get('/invites', 'InvitationController@index')->name('admin.invites');
            Route::get('/inquiries-with-sent-offers', 'InvitationController@inquiries_sent_offer')->name('admin.inquiries.sent_offers');
            Route::post('/inquiries-send-invites', 'InvitationController@send_invites')->name('admin.inquiries.send-invites');
            /*Invites part ended*/

            //Customer part started
            Route::get('/black-list', 'FreeMailBlacklistController@index')->name('admin.black_list');
            Route::post('/black-list/update', 'FreeMailBlacklistController@black_list')->name('admin.blacklist_update');

            /*Customer part ended*/
        });


        /*Bulk Processing Start*/
        Route::get('/admin/bulk-processing', function () {
            return view('bulk-processing-admin.index', ['sidebar' => 'bulk-processing' ]);
        })->name('bulk-processing');
        /*Bulk Processing End*/

        /*Price List Start*/
        Route::get('/admin/price-list', function () {
            return view('price-list-admin.index', ['sidebar' => 'price-list' ]);
        })->name('price-list');
        /*Price List End*/

        /*Bad IP Start*/
        Route::get('/admin/bad-ip', function () {
            return view('bad-ip-admin.index', ['sidebar' => 'bad-ip' ]);
        })->name('bad-ip');
        /*Bad IP End*/

        /*Deals Start*/
        Route::get('/admin/deals', function () {
            return view('deals-admin.index', ['sidebar' => 'deals' ]);
        })->name('deals');
        /*Deals End*/

        /*DACH ZOne File Start*/
        Route::get('/admin/dach-zone-file', function () {
            return view('dach-zonefile-admin.index', ['sidebar' => 'dach-zone-file' ]);
        })->name('dach-zone-file');
        /*DACH ZOne End*/

        /*keyword check Start*/
        Route::get('/admin/keyword-check', function () {
            return view('keyword-check-admin.index', ['sidebar' => 'keyword_check' ]);
        })->name('keyword_check');
        /*keyword check  End*/

        /*evaluations Start*/
        Route::get('/admin/evaluations', function () {
            return view('evaluations-admin.index', ['sidebar' => 'evaluations' ]);
        })->name('evaluations');
        /*evaluations End*/

    });

    Route::namespace('Customer')->middleware(['request_access'])->prefix('customer')->group(function () {

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
        Route::middleware(['auth:customer', 'customer2fa', 'isCustomer'])->group(function () {

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

            /*Dashboard/Home Controller Routes End*/

            /*Auction Controller Routes Start*/
            Route::get('/auction/all/{type}', 'CustomerAuctionController@index')->name('customer.auction.all');
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

            /*Certificate Controller Routes End*/

            Route::get('/auction/certificate', 'CertificateLevelController@index')->name('customer.auction.certificate');
            Route::get('/auction/certificate/level/{level}', 'CertificateLevelController@create')->name('customer.auction.level');
            Route::post('/auction/certificate/email_confirmation_code', 'CertificateLevelController@email_confirmation_code')->name('customer.level.email_confirmation_code');
            Route::post('/auction/certificate/update_business_details', 'CertificateLevelController@update_business_details')->name('customer.level.update_business_details');
            Route::post('/auction/certificate/send_verification_code_sms', 'CertificateLevelController@send_verification_code_sms')->name('customer.level.send_verification_code_sms');
            Route::post('/auction/certificate/verify_mobile_number', 'CertificateLevelController@verify_mobile_number')->name('customer.level.verify_mobile_number');
            Route::post('/auction/certificate/upload_document', 'CertificateLevelController@upload_document')->name('customer.level.upload_document');

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

});

