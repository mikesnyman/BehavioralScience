<?php
// curl the xml data
function curlIt( $url ){
$ch = curl_init( $url ); // init the curl class
curl_setopt( $ch, CURLOPT_HEADER, false); // set if we want the header text of remote file – we don’t we just want the body
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );  // converts result to string
curl_setopt( $ch, CURLOPT_FAILONERROR, true );  // report a fail if any error happens
curl_setopt( $ch, CURLOPT_TIMEOUT, 10 ); // set how long it’ll wait for the remote server to respond
$ret = curl_exec( $ch ); // actually run the curl and put result into variable
curl_close( $ch ); // clear curl class and data out of memory
if( $ret ) return $ret; // if no error return our result
return false; // if fail return false
}
?>
