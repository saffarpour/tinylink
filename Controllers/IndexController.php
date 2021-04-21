<?php

/**
 * Description of IndexController
 * Main dispatcher of web page 
 * 
 * @author Reza
 */
class IndexController {
    
    public function __construct() {
    }

    /**
    * Summary 
    * Process all requests (API)
    * 
    * @param string $userRequest request data to be manipulated
    * @return None
    */
    public function processRequest($userRequest) {
        
        if (strlen($userRequest['job']) === 0) {
            
            $startupInfo = new StartupInfo();
            if ($startupInfo->getRoutingParamCount() == 1) {
                // Redirect to short link
                $userRequest['job'] = "REDIRECTSHORTLINK";
                $userRequest['code'] = $startupInfo->getRoutingParam(0);
            } 
            
        }
        // prepare related div visibility
        $_SESSION['default']['resultViewBaisc_visible'] = "w3-hide";
        $_SESSION['default']['resultViewExtended_visible'] = "w3-hide";
        $_SESSION['default']['tiny_link_error_visible'] = "w3-hide";
        $_SESSION['default']['view_id'] = "";

        switch ($userRequest['job']) {

            case "VALIDATEURL":
                $checkUrlController = new CheckUrlController();
                $checkUrlController->processValidateUrl($userRequest['code']);
                break;

            case "EXISTSURL":
                $checkUrlController = new CheckUrlController();
                $checkUrlController->processExistsUrl($userRequest['code']);
                break;

            case "TINYLINK":
                $tinyLinkController = new TinyLinkController();
                $tinyLinkController->processTinyLinkExistance($userRequest['code']);
                break;

            case "INSERTTINYLINK":
                $tinyLinkController = new TinyLinkController();
                $tinyLinkController->processTinyLinkInsert($userRequest['code'], $userRequest['longcode']);
                break;

            case "INSERTRANDOMTINYLINK":
                $tinyLinkController = new TinyLinkController();
                $tinyLinkController->processRandomTinyLinkInsert($userRequest['longcode']);
                break;

            case "VIEW":
                $tinyLinkController = new TinyLinkController();
                $tinyLinkController->readTinyLinkInfo($userRequest['code']);
                break;

            case "REDIRECTSHORTLINK":
                $tinyLinkController = new TinyLinkController();
                $tinyLinkController->gotoTinyLink($userRequest['code']);
                break;
            
            case "DOCUMENT":

            default:
                $documentView = new DocView();
                $documentView->showRootDocument();
                break;
        }
        return;
    }
}

