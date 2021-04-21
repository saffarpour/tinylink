<?php

/**
 * Summary 
 * A class to access startup information 
 *
 * @author Reza
 */
class Router {

    protected $userParam = array();

    public function __construct() {

        if (!isset($_SERVER['REDIRECT_URL'])) {
            // NOT SET --> index.php is called 
            $r = $this->getApiParamters();
            if ($r == true) {
                return;
            } else {
                $redirectUrlStr = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_STRING);
            }
        } else {
            // SET --> called by redirecting parameters  
            $redirectUrlStr = filter_input(INPUT_SERVER, 'REDIRECT_URL', FILTER_SANITIZE_STRING);
        }

        //Remove sub folder from REDIRECT_URL (if any)
        $this->removeSubDirFromRoute($redirectUrlStr);
    }

    /**
     * Summary 
     * Gets API Parameters
     *  
     * @return string array API parameters
     */
    protected function getApiParamters() {

        if (isset($_GET['job'])) {
            $this->userParam ['job'] = strtoupper(filter_input(INPUT_GET, 'job', FILTER_SANITIZE_STRING));

            // Check API command is valid
            if (isset(Config::$validApi[$this->userParam ['job']])) {

                $this->userParam ['code'] = filter_input(INPUT_GET, 'code', FILTER_SANITIZE_STRING);
                $this->userParam ['longcode'] = filter_input(INPUT_GET, 'longcode', FILTER_SANITIZE_STRING);
            } else {
                $this->userParam ['job'] = "DOCUMENT"; // default page
            }
            return true;
        }

        return false;
    }

    /**
     * Summary 
     * Remove empty and SubDir items from REDIRECT_URL
     *  
     * @return string array API parameters
     */
    protected function removeSubDirFromRoute($redirectUrlStr) {

        $redirectUrl = explode("/", $redirectUrlStr);
        // Remove empty items 
        $redirectUrl = array_values(array_filter($redirectUrl, 'strlen'));
        $scriptNameStr = filter_input(INPUT_SERVER, 'SCRIPT_NAME', FILTER_SANITIZE_STRING);
        $scriptName = explode("/", $scriptNameStr);

        // Remove empty items 
        $scriptName = array_values(array_filter($scriptName, 'strlen'));

        // remove SubDir items from REDIRECT_URL
        foreach ($scriptName as $v) {
            if (($key = array_search($v, $redirectUrl)) !== false) {
                unset($redirectUrl[$key]);
            }
        }

        $commandUrl = array_values(array_filter($redirectUrl, 'strlen'));

        if ($this->checkForwardingRequest($commandUrl) == true) {
            return;
        }

        $this->createCommand($commandUrl);
    }

    /**
     * Summary 
     * Checks if URL requests for forwarding the small link
     *  
     * @param array $redirectUrl Array of URL items
     * @return boolean true on success (request for redirecting) false for no 
     */
    protected function checkForwardingRequest($redirectUrl) {
        if (count($redirectUrl) === 1) {
            $this->userParam['job'] = "REDIRECTSHORTLINK";
            $this->userParam['code'] = $redirectUrl[0];
            return true;
        }
        return false;
    }

    /**
     * Summary 
     * Create userParam array if a valid command found
     *  
     * @param array Purified command in string array format
     */
    protected function createCommand($commandUrl) {

        if (isset($commandUrl[0]) && isset(Config::$validRoutes[$commandUrl[0]])) {
            $command = Config::$validRoutes[$commandUrl[0]];
            $this->userParam['job'] = $command[0];
            for ($i = 1; $i < count($command); $i++) {
                if (isset($commandUrl[$i])) {
                    $this->userParam[$command[$i]] = $commandUrl[$i];
                } else {
                    $this->userParam[$command[$i]] = "";
                }
            }
            return;
        }
        $this->userParam ['job'] = "DOCUMENT"; // default page
    }

    /**
     * Summary 
     * Returns result of routing which has been stored in $this->userParam
     * to be used in indexController
     */
    public function getUserParams() {
        return $this->userParam;
    }

}
