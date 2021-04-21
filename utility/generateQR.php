<?php
  
//https://www.geeksforgeeks.org/dynamically-generating-a-qr-code-using-php/
// Include the qrlib file
include '../phpqrcode/qrlib.php';
//include $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/phpqrcode/qrlib.php';  
// $text variable has data for QR 
//$shortLink = $_GET['id'];
$shortLink = filter_input(INPUT_GET, 'codeQR', FILTER_SANITIZE_STRING);
  
// QR Code generation using png()
// When this function has only the
// text parameter it directly
// outputs QR in the browser
QRcode::png($shortLink);
?>

