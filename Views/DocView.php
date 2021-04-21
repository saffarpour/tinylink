<?php

/**
 * DocView is view class for SPA user interface
 * 
 * @author Reza 
 */

class DocView {
    
    public function __construct(){
        
    }
            
    public function showRootDocument() {
        include_once 'index.html';
        die();
    }
    
    
}
