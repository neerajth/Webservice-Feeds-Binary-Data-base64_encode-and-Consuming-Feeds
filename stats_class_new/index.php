<?php
require_once("dbconnect.php");

$obj = new Stats();
$obj->main();
    
class Stats { 
    
    function __construct() {
    }
    
    private function executeCurl() {
        /**curl request**/
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "http://ec2-54-71-17-96.us-west-2.compute.amazonaws.com/webservicefeed/",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => "currentDate=16-10-2016%2011%3A53%3A56",
          CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "content-type: application/x-www-form-urlencoded",
            "postman-token: 72f83a5e-0274-b529-a5bc-1fa61b4f0b3e"
          ),
        ));

        $base_sixtyfour = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
          //echo $base_sixtyfour;
        }
        /***curl connection closed**/
    return $base_sixtyfour;
    }
        

    public function main () {
        
        $base_sixtyfour=$this->executeCurl();
        if ( $this->isJson($base_sixtyfour) ) {
            $error_arr = json_decode($base_sixtyfour);
            echo "<pre>"; print_r( $error_arr ); echo "</pre>";
            exit;
        }
        
        /*decode base64 to binary data and unpack for mysql table*/
        $base_sixtyfour_de = explode("|", $base_sixtyfour);

        $data = array();
        $last_update= self::unPackBitThirtyTwo( base64_decode($base_sixtyfour_de[0]) );
        $data[] = $last_update;

        $hit_count= self::unPackBitThirtyTwo( base64_decode($base_sixtyfour_de[1]));
        $data[] = $hit_count;

        $lastlag = array_values(unpack('A*', base64_decode($base_sixtyfour_de[2]))); 
        $data[] = $lastlag[0];

        $objDB = DBConnect::getInstance();
        $objDB->insertFeeds($data);
    }

    function unPackBitThirtyTwo($packed) {
        list($higher, $lower) = array_values(unpack('N2', $packed)); 
        $originalValue = $higher << 32 | $lower; 
        return $originalValue;   
    }

    function isJson($string) {
         json_decode($string);
         return (json_last_error() == JSON_ERROR_NONE);
    }
}
?>