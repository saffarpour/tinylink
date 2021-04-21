<?php

/**
 * Summary 
 * A class to access startup information 
 *
 * @author Reza
 */
class StartupInfo {

    protected $pageRoot = null;
    protected $routeList = array();
    protected $selfPhpFile = null;

    public function __construct() {
        
        $this->createRouteList();
        $redirectUrlStr = filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING);
    }

    /**
     * Summary 
     * Gets page root address
     * 
     * @param string $param to add to pageRoot
     * @return string pageRoot
     */
    public function getPageAddress($param = "") {
        return $this->pageRoot . $param;
    }

    /**
     * Summary 
     * Gets routing parameters of URL
     * 
     * @param string $index index starts from 0
     * @return string On success routing parameter of index on failure false
     */
    public function getRoutingParam($index) {
        if (isset($this->routeList[$index])) {
            return $this->routeList[$index];
        }
        return false;
    }

    /**
     * Summary 
     * Gets routing parameters count of URL
     * 
     * @return string On success routing parameter count, on failure false
     */
    public function getRoutingParamCount() {
        if (isset($this->routeList)) {
            return sizeof($this->routeList);
        }
        return false;
    }
    
    /**
     * Summary 
     * Gets self PHP file name
     * 
     * @return string Name of the PHP self file name
     */
    public function getSelfPhpFileName() {
        return $this->selfPhpFile;
    }

    /**
     * Summary 
     * Creates routing parameters of URL
     * 
     * @return None
     */
    protected function createRouteList() {
        $scriptName = filter_input(INPUT_SERVER, 'SCRIPT_NAME', FILTER_SANITIZE_STRING);
        $scriptNameList = explode('/', $scriptName);
        $this->selfPhpFile = $scriptNameList[sizeof($scriptNameList) - 1];

        $requestUri = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_STRING);
        $this->routeList = explode('/', $requestUri);

        while (($index = array_search("", $this->routeList)) !== false) {
            unset($this->routeList[$index]);
        }

        foreach ($scriptNameList as $v) {
            if (($index = array_search($v, $this->routeList)) !== false) {
                unset($this->routeList[$index]);
            }
        }

        $this->routeList = array_values($this->routeList);

        $serverName = filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING);
        $this->pageRoot = $serverName . str_replace($this->selfPhpFile, "", $scriptName);
    }

}

