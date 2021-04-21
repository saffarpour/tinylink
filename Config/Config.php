<?php

/**
 * General Configuration class
 *
 * @author Reza
 */
class Config {

    const SUB_DIR = "tinylink"; //without "/"

    /**
     * Generates resource address
     * 
     * @param type $resourceName resource file name 
     * @return string address for resource
     */
    public static function getResourceAddress($resourceName) {
        return self::getSubDir() . "/Resources/" . $resourceName;
    }

    /**
     * Generates subdirectory string
     * @return string subdirectory string
     */
    public static function getSubDir() {
        $subDirPrefix = (self::SUB_DIR == "") ? "" : "/";
        return $subDirPrefix . self::SUB_DIR;
    }

    /**
     * Initializing valid routes
     * 
     */
    public static $validRoutes = array(
        "view" => array("VIEW", "code"),
    );
    
    /**
     * Initializing valid APIs
     * 
     */
    public static $validApi = array(
        "VALIDATEURL" => "Validates a URL",
        "TINYLINK" => "Check a tiny link is available or not",
        "INSERTTINYLINK" => "Registers a preferred Tiny Link",
        "INSERTRANDOMTINYLINK" => "Registers a random Tiny Link"
    );

}
