<?php

if(!function_exists('validateURL')){
    function validateURL($url){
        $validRegex = "/^[(http(s)?):\/\/(www\.)?a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&\/\/=]*)$/";
        if (preg_match($validRegex, $url)) {
            return true;
        }
        return false;
    }
}