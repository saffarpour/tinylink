<?php
/**
 * Description of TinyLinkController
 * 
 * @author Reza
 */
class TinyLinkController {

    private $tinyLinkModel;
    private $tinyLinkView;
    private $startupInfo = null;

    public function __construct() {
        $this->tinyLinkModel = new TinyLinkModel();
        $this->tinyLinkView = new TinyLinkView();
        $this->startupInfo = new StartupInfo();
    }

    /**
    * Summary 
    * Controller to Check database for finding "Tiny Link" existence
    * 
    * @param string $code
    */
    public function processTinyLinkExistance($code) {
        $tinyLinkData = $this->tinyLinkModel->isTinyLinkExists($code);
        $this->tinyLinkView->showCodeQueryData($tinyLinkData);
    }
    
    /**
    * Summary 
    * Controller to read "Tiny Link" from database
    * 
    * @param string $code
    */
    public function readTinyLinkInfo($code) {
        $tinyLinkData = $this->tinyLinkModel->isTinyLinkExists($code);
        $this->tinyLinkView->showCodeReadInfo($tinyLinkData);
    }
    
    /**
    * Summary 
    * Controller to do insert "Tiny Link" into database
    * 
    * @param string $code is preferred short link
    * @param string $longCode is long URL
    */
    public function processTinyLinkInsert($code, $longCode) {
        
        //Check again $code is valid
        $tinyLinkData = $this->tinyLinkModel->isTinyLinkExists($code);
        if($tinyLinkData['result'] !== "false"){
            // $code is not valid
            $tinyLinkInserResult['result'] = "false";
            $this->tinyLinkView->showCodeQueryData($tinyLinkInserResult);
            return;
        }
        
        // Check again $longCode exists
        $checkUrlModel = new CheckUrlModel();
        if($checkUrlModel->isUrlValid($longCode) === "NOT_VALID"){
            $tinyLinkInserResult['result'] = "false";
            $this->tinyLinkView->showCodeQueryData($tinyLinkInserResult);
            return;  
        }
        
        $tinyLinkInserResult = $this->tinyLinkModel->insertTinyLinkData($code, $longCode);
        $this->tinyLinkView->showCodeQueryData($tinyLinkInserResult);
    }
    
    /**
    * Summary 
    * Controller to create a random "Tiny Link" and insert into database
    * 
    * @param string $longCode is long URL
    */
    public function processRandomTinyLinkInsert($longCode) {
        // Check again $longCode exists
        $checkUrlModel = new CheckUrlModel();
        if($checkUrlModel->isUrlValid($longCode) === "NOT_VALID"){
            $tinyLinkInserResult['result'] = "false";
            return $tinyLinkInserResult;  
        }
        $tinyLinkData = $this->tinyLinkModel->insertRandomTinyLinkData($longCode);
        $this->tinyLinkView->showCodeQueryData($tinyLinkData);
    }
    
    /**
    * Summary 
    * Controller to redirect "Tiny Link" to and update usage in database
    * 
    * @param string $code is requested short link
    */
    public function gotoTinyLink($code) {

        // Check the link in database
                
        $tinyLinkData = $this->tinyLinkModel->isTinyLinkExists($code);

        if ($tinyLinkData['result'] === "true") {
            // update usage in database
            $this->tinyLinkModel->increaseHitCounter($tinyLinkData['data']['id']);
			
            // Call original 
            header("Location: ".$tinyLinkData['data']['original_url']);
        } else {
            $this->tinyLinkView->showCodeReadInfo($tinyLinkData);
        }
    }
}
