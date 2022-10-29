<?php
    require_once("setting.php");
    require_once("process_function.php");
    if(!isset($_SERVER['HTTP_REFERER'])){
        header('location:enquire.php');		//redirect to enquire.php if attempted to access directly
        exit;
    }
    function cleanseInput($input) {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }
?>
