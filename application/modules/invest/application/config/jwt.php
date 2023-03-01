<?php 

if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['jwt_key'] = 'raxtest';

$config['jwt_algorithm'] = 'HS256';

/*
|-----------------------
| Token Request Header Name
|--------------------------------------------------------------------------
*/
$config['token_header'] = 'jauth';


/*
|-----------------------
| Token Expire Time

| https://www.tools4noobs.com/online_tools/hh_mm_ss_to_seconds/
|--------------------------------------------------------------------------
| ( 1 Day ) : 60 * 60 * 24 = 86400
| ( 1 Hour ) : 60 * 60     = 3600
| ( 1 Minute ) : 60        = 60
*/
$config['token_expire_time'] = 60;

/*Generated token will expire in 1 minute for sample code
* Increase this value as per requirement for production
*/
$config['token_timeout'] = 1;

/* End of file jwt.php */
/* Location: ./application/config/jwt.php */
?>