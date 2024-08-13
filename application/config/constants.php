<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code
defined('WHATAPP_TOKEN')       OR define('WHATAPP_TOKEN', 'c24fbd2e-bec7-4c24-a384-448050064e8d');//what app token
defined('API_ACCESS_KEY')      OR define('API_ACCESS_KEY', 'AAAAa2uizTg:APA91bH4ZKQLsl5H-jyiyAjQRN0fjm2nNABHORy-87TcrXIatBjiV9wMtJV1gKmaVKU3tf58OfM3_VcY8qII6RDAu9JIccQALL3aukYxi4B_4u8a5baC5F5zEfpWHiwyYuUJUZnvhinH');//what app token

//Client_Secret_PAN
defined('Client_Id_PAN')       OR define('Client_Id_PAN', '11199344');//Client_Id_PAN
defined('Client_Secret_PAN')      OR define('Client_Secret_PAN', 'jFjXGxllHLzs1jlQIcM9leJZL4RRAhCk');
defined('PAN_API_URL')      OR define('PAN_API_URL', 'https://svcdemo.digitap.work/validation/kyc/v1/pan_basic');//PAN_API_URL
defined('GENERATE_ESIGN_URL')      OR define('GENERATE_ESIGN_URL', 'https://api.digitap.ai/ent/v1/generate-esign');//PAN_API_URL
defined('GET_E_SIGN_DOC')      OR define('GET_E_SIGN_DOC', 'https://api.digitap.ai/ent/v1/get-esign-doc');//PAN_API_URL
defined('E_SIGN_PROCESS')      OR define('E_SIGN_PROCESS', 'https://sdk.digitap.ai/e-sign/templateesignprocess.html?docId=');//PAN_API_URL
defined('SMS_GATEWAY_USERNAME')      OR define('SMS_GATEWAY_USERNAME', 'shantanu@antworksmoney.com');//
defined('SMS_GATEWAY_HASH_API')      OR define('SMS_GATEWAY_HASH_API', 'b3a4f30ed009f72aa58fcad1e58ddd49b8b7fd44f5a82bc2b93da9325174d68f');//
defined('SMS_GATEWAY_SENDER')      OR define('SMS_GATEWAY_SENDER', 'ANTFIN');//
defined('ANTWORKS_BANK_AC')      OR define('ANTWORKS_BANK_AC', '0004102000040071');// dated: 15-nov-2023 using this for generate bank file in surge module

defined('NACH_EXPIRE_AT')      OR define('NACH_EXPIRE_AT', strtotime('+1 year'));
defined('NACH_AMOUNT')      OR define('NACH_AMOUNT', '100000');
defined('RAZORPAY_NACH_KEY')      OR define('RAZORPAY_NACH_KEY', 'rzp_live_PeZTIp1sCphoZd');
defined('API_EXPIRE_TIME')      OR define('API_EXPIRE_TIME', strtotime('+60 seconds'));// DATED 08/08/2024 using this for nach apis
