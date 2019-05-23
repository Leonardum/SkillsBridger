<?php

/* Cleans variable input data from potentially harmful code inserted into input fields. */
function cleanInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/* Automaticaly makes sure that all php files within the folder $folder are required for the current script. */
function autoRequire($folder) {
    /* The glob() function searches for all the pathnames matching the pattern described within the parentheses. */
    foreach (glob("{$folder}/*.php") as $filename) {
       require($filename) ;
    }
}

/* Automaticaly makes sure that all php files within the folder $folder are included with the current script. */
function autoInclude($folder) {
    /* The glob() function searches for all the pathnames matching the pattern described within the parentheses. */
    foreach (glob("{$folder}/*.php") as $filename) {
       include($filename) ;
    }
}

/* This function returns a random number between the $min and $max value. */
function createRandomNumber($min, $max) {
    $range = $max - $min;
    if ($range == 0) return $min;
    $log = (int) log($range, 2);
    $bits = (int) $log + 1;
    $bytes = (int) ($log / 8) + 1;
    $filter = (int) (1 << $bits) - 1;
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes, $s)));
        $rnd = $rnd & $filter;
    } while ($rnd >= $range);
    return $min + $rnd;
}

/* This function returns a random token with the specified $length and with the  characters specified in the $characters variable. */
function createToken($length) {
    $token = "";
    $characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $characters.= "abcdefghijklmnopqrstuvwxyz";
    $characters.= "0123456789";
    $max = strlen($characters) - 1;
    for ($i=0; $i < $length; $i++) {
        $token .= $characters[createRandomNumber(0, $max)];
    }
    return $token;
}

/* compares two strings to one another, while being safe from timing attacks (uses the time it takes to return a result to deduct the length and possibly the value of strings like passwords and tokens). */
function timingSafeCompare($safe, $user) {
    if (function_exists('hash_equals')) {
        return hash_equals($safe, $user); // PHP 5.6
    }
    
    // Prevent issues if string length is 0
    $safe .= chr(0);
    $user .= chr(0);
    
    // mbstring.func_overload can make strlen() return invalid numbers
    // when operating on raw binary strings; force an 8bit charset here:
    if (function_exists('mb_strlen')) {
        $safeLen = mb_strlen($safe, '8bit');
        $userLen = mb_strlen($user, '8bit');
    } else {
        $safeLen = strlen($safe);
        $userLen = strlen($user);
    }
    
    // Set the result to the difference between the lengths
    $result = $safeLen - $userLen;
    
    // Note that we ALWAYS iterate over the user-supplied length
    // This is to prevent leaking length information
    for ($i = 0; $i < $userLen; $i++) {
        // Using % here is a trick to prevent notices
        // It's safe, since if the lengths are different
        // $result is already non-0
        $result |= (ord($safe[$i % $safeLen]) ^ ord($user[$i]));
    }
    
    // They are only identical strings if $result is exactly 0...
    return $result === 0;
}

?>