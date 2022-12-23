<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/2/2019
 * Time: 12:42 PM
 */
class Idbi extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $soapclient = $this->load->library("NuSoap_lib");
        $this->nusoap_client = new soap_server();
    }

    public function index()
    {
        $wsdl = "https://vas.idbibank.com/VASGENSERVICE/services/VanAcct?wsdl";
        $client = new nusoap_client($wsdl, 'wsdl');
        $err = $client->getError();

        if ($err) {

            echo $err;           die('error');

        }
        $action = "masterDataInsertion";
        $param = array(
            'accTitle'=>'XYZ',
            'corpEmailId_1'=>'ac@gmail.com',
            'corpEmailId_2'=>'',
            'corpEmailId_3'=>'',
            'corpMobNo_1'=>'',
            'corpMobNo_2'=>'',
            'custId'=>'78836960',
            'mode'=>'CRE',
            'parentAccNumber'=>'0183104000182232',
            'remitterEmailId_1'=>'',
            'remitterEmailId_2'=>'',
            'remitterMobNo_1'=>'',
            'remitterMobNo_2'=>'',
            'remitterName'=>'abc',
            'virtualAccNumber'=>'VCFTNMUM00000001',
        );

        $response = $client->call($action, $param);
        echo "<pre>";
        print_r($response); exit;
        if ($client->fault) {
            echo '<h2>Fault</h2><pre>';
            print_r($result);
            echo '</pre>'; exit;
        } else {
            // Check for errors
            $err = $client->getError();
            if ($err) {
                // Display the error
                echo '<h2>Error</h2><pre>' . $err . '</pre>';
            } else {
                // Display the result
                echo '<h2>Result</h2><pre>';
                print_r($result);
                echo '</pre>';
            }
        }
        echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
        echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
        echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';


    }
}?>