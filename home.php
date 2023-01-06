<?php

set_error_handler( "log_error" );
set_exception_handler( "log_exception" );
function log_error( $num, $str, $file, $line, $context = null )
{

    log_exception( new ErrorException( $str, 0, $num, $file, $line ) );
}

function log_exception( Exception $e)
{
    http_response_code(500);
    log_error($e);
    echo "Some Error Occured. Please Try Later.";
    exit();
}

error_reporting(E_ALL);
require_once("texsss.php");// I am doing a FATAL Error here
?>
