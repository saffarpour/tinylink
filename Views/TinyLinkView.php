<?php

/**
 * Description 
 * TinyLinkView is view class for "Tiny Link"
 * 
 * @author Reza 
 */
class TinyLinkView {

    private $startupInfo = null;

    public function __construct() {
        $this->startupInfo = new StartupInfo();
    }

    /**
     * Summary 
     * View for API
     * 
     * @param string $tinyLinkData Tiny Link to be tested
     */
    public function showCodeQueryData($tinyLinkData) {
        // To fix problem with floating point precision
        if (version_compare(phpversion(), '7.1', '>=')) {
            ini_set('serialize_precision', -1);
        }

        header('Content-Type: application/json');
        echo json_encode($tinyLinkData);
    }

    /**
     * Summary 
     * Show "Tiny Link" data
     * 
     * @param string $tinyLinkData Tiny Link to be tested
     */
    public function showCodeReadInfo($tinyLinkData) {
         
        if ($tinyLinkData['result'] === "true") {
            $this->showFoundCodeReadInfo($tinyLinkData);
        } else {
             $this->showErrorCodeReadInfo($tinyLinkData);
        }
    }

    protected function showFoundCodeReadInfo($tinyLinkData) {

        $_SESSION['default']['view_id'] = "view";
        $_SESSION['default']['short_link'] = $this->startupInfo->getPageAddress() . $tinyLinkData['data']['tiny_link'];
        $_SESSION['default']['original_link'] = $tinyLinkData['data']['original_url'];
        $_SESSION['default']['Creation_date'] = $tinyLinkData['data']['creation_date'];
        $_SESSION['default']['hit_counter'] = $tinyLinkData['data']['hit_counter'];

        $_SESSION['default']['resultViewBaisc_visible'] = "w3-show";
        $_SESSION['default']['resultViewExtended_visible'] = "w3-show";

        $_SESSION['default']['tiny_link_error_visible'] = 'w3-hide';
        $documentView = new DocView();
        $documentView->showRootDocument();
    }

    public function showErrorCodeReadInfo($tinyLinkData) {

        $_SESSION['default']['view_id'] = "view";

        $_SESSION['default']['resultViewBaisc_visible'] = "w3-hide";
        $_SESSION['default']['resultViewExtended_visible'] = "w3-hide";

        $_SESSION['default']['tiny_link_error_visible'] = 'w3-show';

        $_SESSION['default']['short_link'] = $tinyLinkData['data']['tiny_link'];
        $documentView = new DocView();
        $documentView->showRootDocument();
    }

}
