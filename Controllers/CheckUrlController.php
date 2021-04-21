<?php

/**
 * Description of CheckUrlController
 * Controller for URL checking URL validity
 * @author Reza
 */
class CheckUrlController {

    private $checkUrlModel;
    private $checkUrlView;

    public function __construct() {
        $this->checkUrlModel = new CheckUrlModel();
        $this->checkUrlView = new CheckUrlView();
    }

    /**
     * Summary 
     * Validates URL. Gets page root address (API)
     * 
     * @param string $code URL to be tested
     */
    public function processValidateUrl($code) {
        $checkUrlData['result'] = $this->checkUrlModel->isUrlValid($code);
        $this->checkUrlView->showCodeQueryData($checkUrlData);
    }

}
