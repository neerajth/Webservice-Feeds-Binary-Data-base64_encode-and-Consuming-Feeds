<?php

require_once("dbconnect.php");

/* initiating main function */
WebServiceFeed::main();

class WebServiceFeed {

    function __construct () {
        
    }
    
    public static function main() {
        $objDB = DBConnect::getInstance();
        if ( isset($_POST['currentDate']) ) {
            $feed_records = $objDB->getFeeds( trim($_POST['currentDate']) );
            if ( count($feed_records) == 0 ) {
                $ret_array = array ("code"=>"1", "message"=>"currentDate value does not exist in the database.");
                echo json_encode($ret_array);
                exit;
            }

            /*pack binary string */
            $packed_lastupdate= self::packBitThirtyTwo($feed_records[0]['LastUpdate']);
            $packed_hits= self::packBitThirtyTwo($feed_records[0]['HitCount']);
            $packed_lastlag = pack('A*', $feed_records[0]['LastTag']); 

            /*covert binary data to base64 */
            $base_sixtyfour = base64_encode($packed_lastupdate) . "|" . base64_encode($packed_hits) . "|" . base64_encode($packed_lastlag);
            echo $base_sixtyfour;

        } else {
            $ret_array = array ("code"=>"2", "message"=>"Please post currentDate field & its value.");
            echo json_encode($ret_array);
            exit;
        }
    }


    static function packBitThirtyTwo($value) {     
        $highMap = 0xffffffff00000000; 
        $lowMap = 0x00000000ffffffff; 
        $higher = ($value & $highMap) >>32; 
        $lower = $value & $lowMap; 
        $packed = pack('NN', $higher, $lower);
        return $packed;
    }

}
/*
Code 	Description
a 	NUL-padded string
A 	SPACE-padded string
h 	Hex string, low nibble first
H 	Hex string, high nibble first
c	signed char
C 	unsigned char
s 	signed short (always 16 bit, machine byte order)
S 	unsigned short (always 16 bit, machine byte order)
n 	unsigned short (always 16 bit, big endian byte order)
v 	unsigned short (always 16 bit, little endian byte order)
i 	signed integer (machine dependent size and byte order)
I 	unsigned integer (machine dependent size and byte order)
l 	signed long (always 32 bit, machine byte order)
L 	unsigned long (always 32 bit, machine byte order)
N 	unsigned long (always 32 bit, big endian byte order)
V 	unsigned long (always 32 bit, little endian byte order)
q 	signed long long (always 64 bit, machine byte order)
Q 	unsigned long long (always 64 bit, machine byte order)
J 	unsigned long long (always 64 bit, big endian byte order)
P 	unsigned long long (always 64 bit, little endian byte order)
f 	float (machine dependent size and representation)
d 	double (machine dependent size and representation)
x 	NUL byte
X 	Back up one byte
Z 	NUL-padded string (new in PHP 5.5)
@ 	NUL-fill to absolute position
*/
?>