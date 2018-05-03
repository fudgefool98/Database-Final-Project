<?php
    
session_start();
//function postArticle(){
    require('db_credentials.php');
    
    $link = new mysqli($servername, $username, $password, $dbname);
    
    if($link -> connect_error) {
        die("Connection failed: " . $link->connect_error);
        return false;
    }
    $username = $_SESSION['user'];
    $userQuery = "SELECT userId FROM User WHERE username = '$username'";
    
    $userResult = mysqli_query($link ,$userQuery) or die (mysqli_error($link));
    
    $fandom = $_POST['fandom'];
        if($fandom == 'newFandom'){
            $title = $_POST['fandomName'];
    
            $createFandomSQL = "INSERT INTO Fandom (title) VALUES ('$title')";
    
            $createFandomResult = mysqli_query($link,$createFandomSQL) or die (mysqli_error($link));
            
            $_SESSION['articleErrorMessage'] = "Created new fandom '$title'";
            $fandom = $title;
        }else{
            //set fandom name to one selected from list of options
            $fandom = $_POST['oldFandom'];
        }
    //article type = 1
    $type = 1;
    $title = $_POST['title'];
    $content = $_POST['article'];
    if($userResult) {
        $authorId = mysqli_fetch_row($userResult);
    }else{
        $_SESSION['articleErrorMessage'] = "There was an issue with the userId ln: 58 writeArticleService";
    }
    $description = "Written article";
    $lastEdited = date("Y-m-d H:i:s");
  
    $insertArticleSql = "INSERT INTO Article (fandom, type, discription, title, content, authorID, lastEdited) VALUES('$fandom', '$type', '$description', '$title', '$content', '$authorId[0]', '$lastEdited')";
    
    if($link->query($insertArticleSql) === TRUE){
          //SUCCESS
    }
    
    mysqli_close($link);
    
    header('Location: writeArticle.php');

?>