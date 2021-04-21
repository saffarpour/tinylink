<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function myPrint($vName, $v, $f , $l) {

    echo "File:" . $f . " ---- Line#: " .$l. "<br>";
    if (is_array($v)) {
        echo $vName . "(array):<br>";
        foreach ($v as $key => $value) {
            echo $key . "=" . $value . "<br>";
        }
    } else {
        echo $vName . "=" . $v . "<br>";
    }
}
