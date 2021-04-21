<?php

/**
 * Description of CheckUrlModel
 *
 * @author Reza
 */
class CheckUrlModel {

    private $db = null;

    public function __construct() {
        $this->db = new DatabaseConnector();
    }

    /**
     * Summary 
     * Checks URL really exists
     * 
     * @param string $code URL
     * @return string
     */
    public function isUrlValid($code) {
        
        $r = $this->isUrlReallyExist($code, true);
        
        if ($r === false) {
            return "NOT_VALID";
        }
        
        // check already used
        $tinyLinkDataDB = $this->db->runQuery("SELECT * FROM `short_links` WHERE original_url LIKE BINARY \"" . $code . "\";");
        if (is_array($tinyLinkDataDB)) {
            $tinyLinkData['result'] = "true";
            $tinyLinkData['data'] = $tinyLinkDataDB[0];
        } else {
            $tinyLinkData['result'] = "false";
            $tinyLinkData['data']['tiny_link'] = $code;
        }

        return "VALID";
    }

    /**
     * Summary 
     * Checks URL really exists and works
     * 
     * @param string $code 
     * @param boolean $extended true: Do real test, false: Do NOT real test
     * @return boolean
     */
    public function isUrlReallyExist($code, $extended = false) {
        
        if(filter_var($code, FILTER_VALIDATE_URL) == false)
                return false;
        
        if( $extended === false)
            return true;
        
        //from stackoverflow.com
        $cUrl = curl_init();
        curl_setopt($cUrl, CURLOPT_URL, $code);
        //get the header
        curl_setopt($cUrl, CURLOPT_HEADER, 1);
        //and ONLY get the header
        curl_setopt($cUrl, CURLOPT_NOBODY, 1);
        //get the response as a string from curl_exec(), rather than echoing it
        curl_setopt($cUrl, CURLOPT_RETURNTRANSFER, 1);
        //do not use a cached version of the url
        curl_setopt($cUrl, CURLOPT_FRESH_CONNECT, 1);
        if (!curl_exec($cUrl)) {
            return false;
        } else {
            return true;
        }
    }
}