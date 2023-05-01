<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';
use chriskacerguis\RestServer\RestController;

class TestApiController extends RestController
{

    public function test1_get()
    {
        echo 'First API test';
    }

}

?>