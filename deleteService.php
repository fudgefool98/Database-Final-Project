<?php 
require 'db_credentials.php';
require 'loggedInCheck.php';
require 'dbConnUserForNav.php';
if(isset($_SESSION['articleid'])){
    $query = "Delete from Article where id =".$_SESSION['articleid'];
    $resultBool  = $conn->query($query);
    if(resultBool == "FALSE"){
        header("Location: {$_SERVER['HTTP_REFERER']}");
    }
    else{
        header('Location: mainAnon.php');
    }
}
else{
        header('Location: mainAnon.php');

}

?>