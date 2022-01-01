
<?php

/**
 *  TO autoload classes.
 */
spl_autoload_register( function( $class_name ) {

$file_name = '../classes/'.$class_name . '.php';
$file_name_2 = $class_name . '.php';
if( file_exists( $file_name ) ) {
require_once $file_name;
}elseif (file_exists( $file_name_2)){
    require_once $file_name_2;
}
} );