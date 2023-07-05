<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Admin');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Admin::index');
$routes->get('admin', 'Admin::index');
$routes->get('dashboard', 'Admin::dashboard');
$routes->get('logout', 'Admin::logout');



//$routes->get('DeleteBanner', 'CompanyController::delete_image');

$routes->get('Notifications', 'NotificationController::index');
$routes->get('AddNotification', 'NotificationController::add_notification_form');
$routes->get('Notification_details', 'NotificationController::notification_details');
$routes->get('sendnotification', 'NotificationController::send_Notification');
$routes->get('NotificationDelete', 'NotificationController::delete_notification');


$routes->get('Employees', 'EmployeeController::index');
$routes->get('add_new_employee', 'EmployeeController::add_new_form');
$routes->get('Employee_details', 'EmployeeController::employee_details');
$routes->get('EmployeeDelete', 'EmployeeController::delete_employee');
$routes->get('EditEmployee', 'EmployeeController::edit_employee');


$routes->get('MallDetails', 'MallDetailsController::index');
$routes->get('AddMall', 'MallDetailsController::add_mall');
$routes->get('Mall_Details', 'MallDetailsController::Mall_Details');
$routes->get('MallDelete', 'MallDetailsController::delete_mall');

$routes->get('CustomOfferDetails', 'CustomOfferController::index');
$routes->get('AddCustomOffer', 'CustomOfferController::AddCustomOffer');
$routes->get('CustomOffer_Details', 'CustomOfferController::CustomOffer_Details');
$routes->get('EditCustomOffer', 'CustomOfferController::edit_Offer_details');
$routes->get('CustomOfferDelete', 'CustomOfferController::delete_customOffer');

$routes->get('MenuList', 'MenuController::index');
$routes->get('AddMenu', 'MenuController::add_new');
$routes->get('DeleteMenu', 'MenuController::delete_menu');
$routes->get('EditMenu', 'MenuController::edit_menu');
$routes->get('MenuDetails', 'MenuController::menudetails');
$routes->get('DeleteMenuImage', 'MenuController::delete_menu_image');


$routes->get('ContactUs', 'Contact::index');
$routes->get('Contact', 'ApiContact::index');

$routes->Post('transaction', 'ApiTransaction::index');

$routes->get('Customers', 'CustomerController::Allcustomerlist');
$routes->get('Customer_List', 'CustomerController::customerlist');
$routes->get('VipCustomers', 'CustomerController::Vipcustomerlist');

$routes->get('AddCustomer', 'CustomerController::index');

$routes->get('EditCustomer', 'CustomerController::edit_customer');

$routes->get('CustomerDetails', 'CustomerController::customerdetails');

$routes->get('DeleteCustomer', 'CustomerController::delete_customer');

$routes->get('DeleteCelebrity', 'CustomerController::delete_vipcustomer');

$routes->get('vip_plus', 'CustomerController::vip_plus');

$routes->get('Products', 'ProductController::index');

$routes->get('AddProduct', 'ProductController::add_new');

$routes->get('DeleteProduct', 'ProductController::delete_product');

$routes->get('EditProduct', 'ProductController::edit_product');

$routes->get('ProductDetails', 'ProductController::productdetails');

$routes->get('DeleteProductImage', 'ProductController::delete_product_image');

$routes->get('Deletepimage', 'ProductController::delete_product_banner');


$routes->get('Company', 'CompanyController::index');

$routes->get('AddCompany', 'CompanyController::add_new');

$routes->get('EditCompany', 'CompanyController::edit_company');

$routes->get('CompanyDetails', 'CompanyController::companydetails');
$routes->get('getvipcustomer', 'CompanyController::getVipCustomer');
$routes->get('getorgcustomer', 'CompanyController::getorgCustomer');

$routes->get('getvipcompany', 'CompanyController::getVipcompany');

$routes->get('reports', 'ReportController::index');
$routes->get('acomapnyreports', 'ReportController::adminCompanyReport');
$routes->get('aofferreports', 'ReportController::adminOfferReport');
$routes->get('atransactionreports', 'ReportController::adminTransactionReport');
$routes->get('atransactionreportsedit', 'ReportController::EditTransaction');
$routes->get('ReportDetails', 'ReportController::report_details');
$routes->get('others', 'ReportController::adminOtherReport');
$routes->get('toppurchasecutomers', 'ReportController::topPurchaseCustomer');
$routes->get('topsalecompany', 'ReportController::topSalesCompany');
$routes->get('appviewcutomer', 'ReportController::appViewCustomer');
$routes->get('chatreport', 'ReportController::chatReport');
$routes->get('chatdetail', 'ReportController::chatDetail');

$routes->get('companyreport', 'CompanyreportController::index');
$routes->get('deltransaction', 'ReportController::delTransaction');

//coupon report
$routes->get('couponreports', 'ReportController::clist');
$routes->get('couponreportsredeem', 'ReportController::couponreportsredeem');
$routes->get('couponpreviewpurchase', 'ReportController::couponpreviewpurchase');
$routes->get('couponreportexpire', 'ReportController::couponreportexpire');



$routes->post('checkout', 'ApiUsers::checkout');
$routes->get('usercoupon', 'ApiUsers::userCoupon');

$routes->get('Dashboard', 'Admin::dashboard');
$routes->get('multipleImage', 'Form::multipleImage');

$routes->get('Form', 'Form::index');

$routes->get('Advertisement', 'AdvertisementController::index');
$routes->get('add_new', 'AdvertisementController::add_new');
$routes->get('EditAdvertisement', 'AdvertisementController::edit_advertisement');
$routes->get('DeleteAdvertisement', 'AdvertisementController::delete_banner');
$routes->get('DeleteAdvBanner', 'AdvertisementController::delete_city_banner');

$routes->get('dashboardadd', 'DashboardAdvertisementController::index');
$routes->get('dashboardaddnew', 'DashboardAdvertisementController::advertisementNew');
$routes->post('dashboardaddcreate', 'DashboardAdvertisementController::advertisementAddCreate');
$routes->get('editadd', 'DashboardAdvertisementController::editAdvertisement');
$routes->post('updateadd', 'DashboardAdvertisementController::updateAdvertisement');
$routes->get('deladd', 'DashboardAdvertisementController::deleteAdvertise');
$routes->get('deladdimage', 'DashboardAdvertisementController::delAddImage');

$routes->get('AddCelebrity', 'CustomerController::add_celebrity_form');

$routes->get('EditCelebrity', 'CustomerController::edit_celebrity');

$routes->get('CelebrityDetails', 'CustomerController::celebritydetails');

$routes->get('VipCode', 'VipController::VipCode');

$routes->get('AddVipCode', 'VipController::index');

$routes->get('EditVipCode', 'VipController::edit_vip');

$routes->get('DeleteVipCode', 'VipController::delete_VipCode');

$routes->get('VipCodeDetails', 'VipController::VipCodeDetails');
$routes->get('addorganization', 'VipController::addOrganization');
$routes->get('allorganization', 'VipController::addAllOrganization');

$routes->get('CustomerFeedback', 'ContactUsController::index');
$routes->get('FeedbackDetails', 'ContactUsController::feedback_details');
$routes->get('DeleteFeedback', 'ContactUsController::delete_customerFeedback');

$routes->get('CompanyEnquiry', 'CompanyEnquiryController::index');
$routes->get('EnquiryDetails', 'CompanyEnquiryController::enquiry_details');
$routes->get('DeleteEnquiry', 'CompanyEnquiryController::delete_company_enquiry');


$routes->get('VipCustomer', 'CompanyController::add_vip');

$routes->get('DeleteCompany', 'CompanyController::delete_company');

$routes->get('Redeem_Products', 'RedeemController::index');

$routes->get('AddRedeem_Products', 'RedeemController::add_new');

$routes->get('EditRedeem_Products', 'RedeemController::edit_redeem_product');

$routes->get('RedeemProductDetails', 'RedeemController::productdetails');

$routes->get('DeleteRedeem_Products', 'RedeemController::delete_redeem_Product');

$routes->get('DeleteImage', 'RedeemController::delete_images');

$routes->get('DeleteBanner', 'CompanyController::delete_comapny_banner');

$routes->get('DeleteDocument', 'CompanyController::delete_comapny_document');
$routes->get('DeleteBimages', 'CompanyController::delete_business_image');

$routes->get('About_Company', 'AboutCompany::index');
$routes->get('Banners', 'AboutCompany::banner_list');
$routes->get('AddBanner', 'AboutCompany::add_banner');
$routes->get('EditBanner', 'AboutCompany::edit_banner');
$routes->get('Delete', 'AboutCompany::delete');

/***
 *   rest api routing
 */

$routes->resource('ApiUsers');
$routes->post('apilogin','ApiUsers::Login');
$routes->post('apiupdateprofile','ApiUsers::profileUpdate');
$routes->get('apigetotp','ApiUsers::getotp');
$routes->post('getmobdata','ApiUsers::getmobdata');
$routes->get('newgetotp','ApiUsers::newgetotp');
$routes->get('newgetotpverify','ApiUsers::newgetotpverify');
$routes->get('GetMallList','ApiUsers::GetMallList');
$routes->get('GetOfferList','ApiUsers::GetOfferList');
$routes->post('Chat','ApiUsers::chat');
$routes->post('Chatdetalis','ApiUsers::chatdetalis');
$routes->get('userimpression','ApiUsers::ApiUserimpression');
$routes->get('messagestatus','ApiUsers::ApiMessageStatus');
$routes->get('messagecount','ApiUsers::ApiMessageCount');
$routes->get('insertchatstatus','ApiUsers::ApiAddChatStatus');
$routes->get('delchatstatus','ApiUsers::ApiremoveChatStatus');
$routes->get('iosskip','ApiUsers::iosskip');
$routes->get('versionControl','ApiUsers::versionControl');
$routes->post('gettransactioncompany','ApiUsers::gettransactioncompany');

$routes->post('updatetoken','ApiUsers::updatetoken');
$routes->post('notification','ApiUsers::Notification');
$routes->Post('DeleteUserApi','ApiUsers::DeleteUserApi');
$routes->post('notificationdelete','ApiUsers::NotificationDeleteApi');
$routes->post('accept','ApiUsers::Acceptapi');
$routes->post('companytoken','ApiUsers::update_company_token');
$routes->get('NotificationList','ApiUsers::NotificationList');

$routes->get('TransactionCode','ApiUsers::TransactionCode');
$routes->post('CheckTransactionCode','ApiUsers::CheckTransactionCode');
$routes->post('AddUserIntrest','ApiUsers::AddUserIntrest');

$routes->post('apiupdateprofileimage','ApiUsers::UpdateProfileimage');
$routes->get('showvip','ApiUsers::showvip');

$routes->post('getcodedetail','ApiUsers::getCitycode');
$routes->post('addpoints','ApiUsers::addpoints');


$routes->post('transferPoint','ApiUsers::transferPoint');
$routes->get('portfolioApi','ApiUsers::portfolioApi');
//footer banner count
$routes->get('countviewbanner','ApiUsers::countviewbanner');

//location notification
$routes->post('latlongnotification','ApiUsers::latlong');

///address api
$routes->post('saveaddress', 'ApiUsers::userAddress');
$routes->get('getaddress', 'ApiUsers::getAddress');
$routes->post('deleteaddress', 'ApiUsers::deleteAddress');
$routes->post('updateaddress', 'ApiUsers::updateaddress');

$routes->post('getprice', 'ApiUsers::productPrice');

$routes->resource('ApiContactus');
$routes->resource('ApiCompanyenquiry');

$routes->resource('ApiProducts');
$routes->resource('ApiOffers');
$routes->get('apigetoffers','ApiOffers::getOffers');
//buypoint show api
$routes->get('showbuypoints','ApiUsers::showBuyPoints');
//online order and transaction report
// api
$routes->post('ordersave', 'ApiUsers::orderSave');
$routes->post('getorders', 'ApiUsers::orderGet');
// dashoboard

$routes->get('getorderss', 'OnlineShopping::index');
$routes->get('customerdetailsonline', 'OnlineShopping::customerdetailsonline');
//online order and transaction report End

$routes->resource('ApiCompany');
$routes->get('viewcount','ApiCompany::viewcount');
$routes->get('companyproduct','ApiCompany::companyproduct');
$routes->get('onlineshop','ApiCompany::onlineshop');
$routes->post('branchlogin','ApiCompany::branchLogin');
$routes->post('uploadReceipt','ApiCompany::uploadReceipt');
$routes->post('companyoffer','ApiCompany::companyoffer');
$routes->post('cityoffer','ApiCompany::cityoffer');
$routes->post('ApiChatUserList', 'ApiCompany::chat_user_list');
$routes->post('ApiChatUserCompanyList', 'ApiCompany::chat_user_company_list');
$routes->post('redeem_product','ApiProducts::redeem_product'); 
$routes->post('BannerList','ApiAdvertise::BannerList'); 
$routes->post('NewBannerList','ApiAdvertise::newBanner');
$routes->get('getdashboardadd','ApiAdvertise::getDashboardAdd');

$routes->get('update_script','ApiController::update_script'); 


$routes->resource('ApiAdvertise');
$routes->resource('ApiFilters');
$routes->get('getcities','ApiFilters::getcities');


$routes->resource('ApiFavorate');
$routes->post('removefavourate','ApiFavorate::removefavourate');


$routes->get('test','ApiTest::index');
$routes->get('iostest','ApiTest::iostest');


//////////////////////////////// Api ///////////////////////////////////////

$routes->post('UserRegister', 'ApiController::userregisterapi');
$routes->post('UserLogin', 'ApiController::userlogin');
$routes->post('PublicCityCodeOffer', 'ApiController::PublicCityCodeApi');


$routes->post('UserRegister', 'ApiController::userregisterapi');

//$routes->post('UserLogin', 'ApiController::userlogin');

$routes->post('PublicCityCodeOffer', 'ApiController::PublicCityCodeApi');

$routes->get('SearchCompanyInfo', 'ApiController::SearchCompanyInfo');

$routes->get('SearchWithState', 'ApiController::SearchWithState');

$routes->get('ProductDetails', 'ApiController::ProductDetailsByCompany');

$routes->post('UserRegister', 'ApiController::userregisterapi');

$routes->post('UserLogin', 'ApiController::userlogin');

$routes->post('PublicCityCodeOffer', 'ApiController::PublicCityCodeApi');

$routes->get('multipleImage', 'Form::multipleImage');

$routes->get('Form', 'Form::index');

$routes->get('Advertisement', 'AdvertisementController::index');


$routes->get('add_new', 'AdvertisementController::add_new');

$routes->get('EditAdvertisement', 'AdvertisementController::edit_advertisement');

$routes->get('DeleteAdvertisement', 'AdvertisementController::delete_banner');

$routes->get('AddCelebrity', 'CustomerController::add_celebrity_form');

$routes->get('EditCelebrity', 'CustomerController::edit_celebrity');

$routes->get('CelebrityDetails', 'CustomerController::celebritydetails');

$routes->get('CustomerFeedback', 'ContactUsController::index');

$routes->get('FeedbackDetails', 'ContactUsController::feedback_details');

$routes->get('VipCustomer', 'CompanyController::add_vip');

$routes->get('DeleteCompany', 'CompanyController::delete_company');

$routes->get('DeleteOffer', 'CompanyController::delete_offer');

$routes->get('EditOffer', 'CompanyController::edit_code');

$routes->get('EditBranch', 'CompanyController::edit_branch');
$routes->get('DeleteBranch', 'CompanyController::delete_branch');

$routes->get('EditBusiness', 'CompanyController::edit_business');
$routes->get('DeleteBusiness', 'CompanyController::delete_business');

$routes->get('editonlineshop', 'CompanyController::editonlineshop');

$routes->get('delete_onlineshop', 'CompanyController::delete_onlineshop');

$routes->get('openingpoint', 'OpeningPoint::index');
$routes->post('updateopeningpoint', 'OpeningPoint::update');
$routes->get('buypoints', 'OpeningPoint::buyPointIndex');




//////////////////////////////// Api ///////////////////////////////////////

$routes->post('UserRegister', 'ApiController::userregisterapi');

$routes->post('UserLogin', 'ApiController::userlogin');

$routes->post('PublicCityCodeOffer', 'ApiController::PublicCityCodeApi');

$routes->get('SearchCompanyInfo', 'ApiController::SearchCompanyInfo');

$routes->get('SearchWithState', 'ApiController::SearchWithState');

$routes->get('ProductDetails', 'ApiController::ProductDetailsByCompany');

$routes->get('CompanyDetailsByState', 'ApiController::CompanyDetailsByState');

$routes->get('OnlineShop', 'ApiController::OnlineShop');

// -------------- ASHISH -----------------
$routes->get('SearchWithLowDiscount', 'ApiController::SearchWithLowDiscount');
$routes->get('SearchWithHighDiscount', 'ApiController::SearchWithHighDiscount');

//---------------API BANNER COUNT-------------
$routes->get('bannercount', 'ApiAdvertise::bannerCount');

// CART LIST
$routes->post('cartsave','ApiUsers::cartSave');
$routes->get('cartlist','ApiUsers::cartList');
$routes->post('cartremove','ApiUsers::cartRemove');
$routes->get('cartlistsummary','ApiUsers::getListSummary');
$routes->get('companycartlist','ApiUsers::companyCartList');
$routes->post('editquantity','ApiUsers::EditQuantity');
 // transaction
 $routes->get('addtransaction','TransactionController::index');
 $routes->get('viewrecord','TransactionController::ViewRecord');
 $routes->get('recorddetails','TransactionController::recorddetails');
//my order
 $routes->get('myorders','ApiUsers::myOrders');

// Coupon
  $routes->get('addcoupon','Coupon::addCoupon');
  $routes->get('viewcoupon','Coupon::index');
  $routes->get('detailscoupon','Coupon::detailsCoupon');
//api
  $routes->post('couponlist','ApiUsers::couponList');
  $routes->post('couponlistbyid','ApiUsers::couponListbycouponID');
  $routes->post('couponpurchase','ApiUsers::couponPurchase');
  $routes->post('usercouponlist','ApiUsers::userCouponList');
  $routes->post('redeemcoupon','ApiUsers::redeemcoupon');

  //assign coupon amount
   $routes->get('addcouponamt','Coupon::addCouponAmount');
  $routes->get('viewcouponamt','Coupon::list');
  $routes->get('assigndetailscoupon','Coupon::AssigndetailsCoupon');

  //version controll
$routes->get('addversion','VersionControl::add');
$routes->get('listversion','VersionControl::index');

//version get
$routes->post('appversion','ApiUsers::appversion');

// app status install/unistall
$routes->post('appstatus','ApiUsers::appstatus');
$routes->post('usernotificationread','ApiUsers::usernotificationread');
//read notification
$routes->get('viewnotification','NotificationController::viewnotification');
/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
