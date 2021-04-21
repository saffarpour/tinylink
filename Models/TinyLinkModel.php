<?php

/**
 * Description of TinyLinkModel
 * 
 * @author Reza
 */
class TinyLinkModel {

    private $db = null;
    private $startupInfo = null;

    public function __construct() {
        $this->db = new DatabaseConnector();
        $this->startupInfo = new StartupInfo();
    }

    /**
     * Summary 
     * Checks database to find "Tiny Link" exists or not
     * 
     * @param string $code
     * @return array
     */
    public function isTinyLinkExists($code) {

        if (strlen($code) >= 5 and strlen($code) <= 9) {
            // length is valid 
            // Check database for existance
            $tinyLinkDataDB = $this->db->runQuery("SELECT * FROM `short_links` WHERE tiny_link LIKE BINARY \"" . $code . "\";");
            if (is_array($tinyLinkDataDB)) {
                $tinyLinkData['result'] = "true";
                $tinyLinkData['data'] = $tinyLinkDataDB[0];
            } else {
                $tinyLinkData['result'] = "false";
                $tinyLinkData['data']['tiny_link'] = $code;
            }
        } else {
            // length is NOT valid 
            $tinyLinkData['result'] = "Error in length of TINYLINK";
            $tinyLinkData['data']['tiny_link'] = $code;
        }
        return $tinyLinkData;
    }

    /**
     * Summary 
     * Inserts preferred TinyLink to the database
     * 
     * @param string $code is short link
     * @param string $longcode is long URL
     * @return array result of operation
     */
    public function insertTinyLinkData($code, $longcode) {

        $q = "INSERT INTO `short_links` (`original_url`, `tiny_link`) VALUES ('"
                . $longcode . "', '" . $code . "');";

        if ($this->db->runQuery($q) == true) {
            $tinyLinkData['result'] = "true";
            $tinyLinkData['short_link'] = $code;
            $tinyLinkData['short_link_address'] = $this->startupInfo->getPageAddress($code);
        } else {
            $tinyLinkData['result'] = "false";
        }
        return $tinyLinkData;
    }

    /**
     * Summary 
     * Inserts randomly generated TinyLink to the database
     * 
     * @param string $longCode is long URL
     * @return array result of operation
     * @todo function should be revised completely to be faster and 
     * more reliable when table has been populated with more links
     */
    public function insertRandomTinyLinkData($longCode) {
        $i = 0;
        do {
            // Based on problem definition:
            // Shortened link identifiers must be unique strings of 5-9 alphanumeric characters
            $code = $this->randomAlphaNumeric(5, 9);
            $tinyLinkExists = $this->isTinyLinkExists($code);
        } while (++$i < 100 && $tinyLinkExists['result'] === "false");

        // $code is not used and is valid
        $insertTinyLinkData = $this->insertTinyLinkData($code, $longCode);
        
        return $insertTinyLinkData;
    }

    /**
     * Summary 
     * Generates random alphanumeric string based on problem criteria
     * 
     * @param int $minLength is minimum string length
     * @param int $maxLength is maximum string length
     * @return string Generated random string
     */
    protected function randomAlphaNumeric($minLength, $maxLength) {
        // Alphanumeric char list
        $validChars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        $lastIndex = strlen($validChars) - 1;
        $resultLength = mt_rand($minLength, $maxLength);
        $result = "";
        for ($i = 0; $i < $resultLength; $i++) {
            $result .= $validChars[mt_rand(0, $lastIndex)];
        }
        return $result;
    }

    /**
     * Summary 
     * Increases Hit Counter for "Tiny Link" in the database
     * 
     * @param string $id is id of the data in table
     * @return string "true" or "false"
     */
    public function increaseHitCounter($id) {
        
        $q = "UPDATE `short_links` SET `hit_counter` = `hit_counter` + 1 WHERE `short_links`.`id` = " . $id . ";";
        
        if (($r = $this->db->runQuery($q)) == true) {
        //var_dump($r);    
            $tinyLinkData['result'] = "true";
        } else {
            $tinyLinkData['result'] = "false";
        }
        return $tinyLinkData;
    }
}
