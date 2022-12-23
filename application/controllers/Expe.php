<?php
class Expe extends CI_Controller{

    public function index()
    {

        $phash =  hash('SHA512', 'Vishal@75');
        $v = $phash.'KplYTpCSlzLtfqKa';
        echo hash('SHA512', $v); exit;
       $i = 1;
        $this->db->select('borrower_id, experian_response');
        $this->db->from('p2p_borrower_experian_response');
        $this->db->where('borrower_id',5);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        if($this->db->affected_rows()>0) {
            $results = (array)$query->result_array();
            foreach ($results AS $result) {
                $experian_response = htmlspecialchars_decode($result['experian_response']);
                $xmL1 = str_replace('<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"><SOAP-ENV:Header/><SOAP-ENV:Body><ns2:processResponse xmlns:ns2="urn:cbv2"><ns2:out>', '', $experian_response);
                $xmL2 = str_replace('</ns2:out></ns2:processResponse></SOAP-ENV:Body></SOAP-ENV:Envelope>', '', $xmL1);

                if (simplexml_load_string($xmL2)) {
                    $xml_input = simplexml_load_string($xmL2);
                    $json_input = json_encode($xml_input);
                    echo $json_input; exit;
                    $report = json_decode($json_input, true);
                    $status_loan = '0, 00, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 72, 73, 74, 75, 76, 77, 79, 81, 85, 86, 87, 88, 90, 91, 93, 97';
                    $status_loan = explode(',', $status_loan);
                    $active_loan = '11, 21, 22, 23, 24, 25, 71, 78, 80, 82, 83, 84';
                    $active_loan = explode(',', $active_loan);
                    $close_loan = '12, 13, 14, 15, 16, 17';
                    $close_loan = explode(',', $close_loan);
                    $messqge = $report['UserMessage']['UserMessageText'];
                    $message_code = explode(' ', $messqge);
                    if($message_code[0] != 'Normal') {
                        $no_record_found = "SYS100004";
                        $no_record_foun = "SYS100005";
                        if (in_array($no_record_found, $message_code) || in_array($no_record_foun, $message_code) ) {
//                            echo $i.' - Borrower_ID - ' . $result['borrower_id'].' -';
//                            print_r($messqge);
//                            echo "<br>";
//                            $i++;
                        }

                        else{
                            echo $i.' - Borrower_ID - ' . $result['borrower_id'].' -';
                            print_r($messqge);
                            echo "<br>";
                            $i++;
                        }
                        }
                }
                else{
                      //echo $i.' -Borrower_ID - '.$result['borrower_id'].'-'.'Experian Response Issue'; echo "<br>";
//                    $i++;
                }
            }

        } exit;
    }
}
?>
