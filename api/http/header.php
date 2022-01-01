<?php
date_default_timezone_set("Africa/Lagos");
if (isset($_SERVER['HTTP_ORIGIN'])) {
//    if($_SERVER['HTTP_ORIGIN'] == "http://bolusarz-pc:4200") {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        //If required
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day

//    }else{
//        header("HTTP/1.1 403 Access Forbidden");
//    }

}
