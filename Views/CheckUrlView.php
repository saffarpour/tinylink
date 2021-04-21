<?php

/**
 * Description of CheckUrlView
 * CheckUrlView, view class for API
 * 
 * @author Reza 
 */
class CheckUrlView {

    public function showCodeQueryData($checkUrlData) {
        // To fix problem with floating point precision
        if (version_compare(phpversion(), '7.1', '>=')) {
            ini_set('serialize_precision', -1);
        }
        
        header('Content-Type: application/json');
        echo json_encode($checkUrlData);
    }
}
