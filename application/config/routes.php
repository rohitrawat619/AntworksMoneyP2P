<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Home/lender';
$route['lender'] = 'Home/lender';
$route['borrower'] = 'Home';

$route['login/user-login'] = 'login/user';
$route['term-and-conditions'] = 'Term_and_conditions';
$route['fees-and-charges'] = 'Fees_and_charges';
$route['contact-us'] = 'Contact';
$route['contact-us/contact-us-mail'] = 'Contact/contact_us_mail';
$route['privacy-and-policy'] = 'Privacy_and_policy';
$route['how-it-works'] = 'How_it_works';
$route['faq'] = 'Faq';
$route['about-us'] = 'About_us';
$route['performance'] = 'About_us/performance';
$route['thank-you'] = 'Thank_you';
$route['fair-practices-code'] = 'Fair_practices_code';
$route['grievance-redressal'] = 'Grievance_redressal';
$route['grievance-redressal/grievance-redressal-form'] = 'Grievance_redressal/Grievance_redressal_form';
$route['grievance-redressal/thankyou'] = 'Grievance_redressal/thankyou';
$route['investor'] = 'Investor';
$route['emi-calculator'] = 'Emi_calculator';
$route['loan-eligibility-calculator'] = 'Emi_calculator/Loan_eligibility_calculator';
$route['all-in-cost-calculator'] = 'Emi_calculator/All_in_cost_calculator';
$route['browse-lenders'] = 'Browse_lenders';
$route['browse-borrowers'] = 'Borrowers';
$route['user/change-password'] = 'login/change_password';
$route['personal-loan'] = 'Loan/personalLoan';
$route['business-loan'] = 'Loan/businessLoan';
$route['consumer-loan'] = 'Loan/consumerLoan';


$route['lender/business-loan'] = 'Loan/lenderBusinessLoan';
$route['lender/consumer-loan'] = 'Loan/lenderConsumerLoan';
$route['lender/portfolio-performance'] = 'Portfolio_performance';
$route['lender/surge'] = 'Loan/surge';


$route['borrower-registration'] = 'Borrower_registration';
$route['borrower-register'] = 'Borrower_registration/borrower_register';
$route['borrower-register/thank-you'] = 'Borrower_registration/thankyou';
$route['borrower-register/verify-email'] = 'Borrower_registration/verify_email';
$route['lender-registration'] = 'Lender_registration';
$route['lender-register'] = 'Lender_registration/lender_register';
$route['lender-register/thank-you'] = 'Lender_registration/thankyou';
$route['lender-register/verify-email'] = 'Lender_registration/verify_email';
$route['login/recover-password'] = 'login/recover_password';
$route['login/verify-borrower-login'] = 'login/verify_borrower_login';
$route['login/verify-lender-login'] = 'login/verify_lender_login';


$route['thank-you/subscribed'] = 'Thank_you/subscribed';
//Borrower Process
$route['borrowerprocess/payment-successful'] = 'borrowerprocess/payment_successful';
$route['borrowerprocess/kyc-updation'] = 'borrowerprocess/kyc_updation';
$route['borrowerprocess/create-escrow-account'] = 'borrowerprocess/create_escrow_account';
$route['borrowerprocess/escrow-account-successful'] = 'borrowerprocess/escrow_account_successful';
$route['borrowerprocess/credit-bureau'] = 'borrowerprocess/credit_bureau';
$route['borrowerprocess/bank-account-verify'] = 'borrowerprocess/bank_account_verify';
$route['borrowerprocess/bank-statemant'] = 'borrowerprocess/bank_statemant';
$route['borrowerprocess/add-bank'] = 'borrowerprocess/add_bank';
$route['borrowerprocess/profile-confirmation'] = 'borrowerprocess/profile_confirmation';
$route['borrowerprocess/live-listing'] = 'borrowerprocess/live_listing';
$route['borrowerprocess/checking-steps'] = 'borrowerprocess/checking_steps';


//borrower backend
$route['borrower/list-my-proposal'] = 'borrower/list_my_proposal';
$route['borrower/live-listing'] = 'borrower/live_listing';
$route['borrower/proposal-history'] = 'borrower/proposal_history';
$route['borrower/pending-signature'] = 'borrower/pending_signature';

$route['borrower/payment-successful'] = 'borrower/payment_successful';
$route['borrower/escrow-account'] = 'borrower/escrow_account';
$route['borrower/escrow-account-successful'] = 'borrower/escrow_account_successful';
$route['borrower/credit-bureau'] = 'borrower/credit_bureau';
$route['borrower/profile-pic'] = 'borrower/profile_pic';
$route['borrower/borrowerrequest/change-address'] = 'borrower/borrowerrequest/change_address';


$route['affiliates'] = 'affiliates';
//Lender Process
$route['lenderprocess/payment-successful'] = 'lenderprocess/payment_successful';
$route['lenderprocess/kyc-updation'] = 'lenderprocess/kyc_updation';
$route['lenderprocess/bank-account-details'] = 'lenderprocess/bank_account_details';
//$route['lenderprocess/create-escrow-account'] = 'lenderprocess/create_escrow_account';
//$route['lenderprocess/escrow-account-successful'] = 'lenderprocess/escrow_account_successful';
$route['lenderprocess/lender-preferences'] = 'lenderprocess/lender_preferences';
$route['lenderprocess/checking-steps'] = 'lenderprocess/checking_steps';
//end lender process
$route['lender/pay-in'] = 'lender/pay_in';
$route['lender/pay-out'] = 'lender/pay_out';
$route['lender/request/change-address'] = 'lender/request/change_address';
$route['lender/request/change-mobile-no'] = 'lender/request/change_mobile_no';
$route['lender/request/tds-statement'] = 'lender/request/tds_statement';
$route['lender/request/add-nominee'] = 'lender/request/add_nominee';
$route['lender/request/kyc-updation'] = 'lender/request/kyc_updation';
$route['lender/request/escrow-account-statement'] = 'lender/request/escrow_account_statement';
$route['lender/request/lender-ledger-search'] = 'lender/request/search_Accountstatement';
$route['lender/help-center'] = 'lender/help_center';
$route['lender/account/my-performance'] = 'lender/account/my_performance';
$route['lender/account/loan-summary'] = 'lender/account/loan_summary';

//BID
$route['bidding/live-bids'] = 'bidding/live_bids';
$route['bidding/favourite-bids'] = 'bidding/favouriteBids';
$route['bidding/live-bids/(:num)'] = 'bidding/live_bids';



$route['p2padmin/borrowers/(:num)'] = 'p2padmin/borrowers';
$route['p2padmin/lenders/(:num)'] = 'p2padmin/lenders';
$route['p2padmin/pagg/(:num)'] = 'p2padmin/pagg';

$route['documentmanagement/borrower/(:num)'] = 'documentmanagement/borrower';


///Admin
$route['login/admin-login'] = 'login/admin_login';
$route['p2padmin/bidding/lender/(:any)/(:num)'] = 'P2padmin/Bidding/lender';
$route['p2padmin/appdetails/(:num)'] = 'P2padmin/Appdetails';

//MICRO
$route['fundofferglimpse'] = 'micro/index';

//Social details
$route['sl'] = 'social_profile/get_borrower_details_social_profile';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
