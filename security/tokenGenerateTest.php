<?php
function crypto_rand_secure($min, $max) {
    $range = $max - $min;
    if ($range == 0) return $min; // Otherwise it would not be very random.
    $log = (int) log($range, 2); /* log2(x) = y <=> 2^y = x. This would determine the length of the range number in bits, but since the first bite has a value of 2^0 = 1, 1 more bit should be counted. */
    $bits = (int) $log + 1; /* Length of the range number in bits, rounded because cast as int. */
    $bytes = (int) ($log / 8) + 1; /* Length of the range number in bytes, rounded because cast as int. */
    $filter = (int) (1 << $bits) - 1; /* creates a bit string with the same length as the range number, where all bits are set (have value 1). */
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes, $s)));
        $rnd = $rnd & $filter; /* Make sure the returned number has the same amount of bits as the range. */
    } while ($rnd >= $range); // Discard the numbers which exceed the range.
    return $min + $rnd; // Return a random number between min and max.
}

/*
$log = 7
$bytes = 1
$bits = 8
$filter = 255 in binary this is 1111 1111

The filter can be used to return a maximum of 8 bit string with the bitwise operator 'And': $a & $b, the bits that are set (value of 1) in both $a and $b are set, the other bits are clear (value of 0).
E.g.: 280 in binary = 1 0001 1000 and 255 = 1111 1111, therefore "1 0001 1000 & 1111 1111" will result in:

1 0001 1000
  1111 1111 &
-------------
0 0001 1000 = (16 + 8 = 24 in decimal notation)

$a = 230;       // 1110 0110
$b = 127;       // 0111 1111
$c = $a & $b;   // 0110 0110 (= 64 + 32 + 4 + 2 = 102)
*/

$len = crypto_rand_secure(64,128);
echo $len;
echo "<br>";

function getToken($length) {
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";
    $max = strlen($codeAlphabet) - 1;
    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[crypto_rand_secure(0, $max)];
    }
    echo $token;
}

getToken($len);

?>