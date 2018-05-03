<?php

 require'db_credentials.php';
 require 'loggedInCheck.php';
 
$_SESSION['imageErrorMessage'] = "";
$link = new mysqli($servername, $username, $password, $dbname);
    if($link -> connect_error) {
        die("Connection failed: " . $link->connect_error);
        return false;
    }
if(isset($_FILES["photo"])){
    $fileName = $_FILES["photo"]["name"];
    $fileType = $_FILES["photo"]["type"];
    $fileSize = $_FILES["photo"]["size"];
    $tempFileTarget = $_FILES["photo"]["tmp_name"];
    $target = "userImages/";		
    $path = $target.$fileName;	
    
    //move image from temporary location to new location.
    $result = move_uploaded_file($tempFileTarget, $path);
    if($result === FALSE){
        $_SESSION['imageErrorMessage'] = $_SESSION['imageErrorMessage'] . "There was an error uploading the file:33 | ";
        header('Location:uploadPicture.php');
    }
    $_SESSION['imageErrorMessage'] = $_SESSION['imageErrorMessage'] . "Image has been uploaded successfully to the server: ln 36 | ";
}

//Query user for userId
$username = $_SESSION['user'];
$userQuery = "SELECT userId FROM User WHERE username = '$username'";
$userResult = mysqli_query($link ,$userQuery) or die (mysqli_error($link));

if($userResult){
    $userId = mysqli_fetch_row($userResult);
    $_SESSION['imageErrorMessage'] = $_SESSION['imageErrorMessage'] . "userId = '$userId[0]' | ";
}else{
    $_SESSION['imageErrorMessage'] = $_SESSION['imageErrorMessage'] . "There was an issue finding your user: ln 50 | ";
    header('Location:uploadPicture.php');
}

//Create fandom if new is selected, set fandom to selected if not
$fandom = $_POST['fandom'];
        if($fandom == 'newFandom'){
            $title = $_POST['fandomName'];
    
            $createFandomSQL = "INSERT INTO Fandom (title) VALUES ('$title')";
    
            $createFandomResult = mysqli_query($link,$createFandomSQL) or die (mysqli_error($link));
            
            $_SESSION['articleErrorMessage'] = "";
            $fandom = $title;
            $_SESSION['imageErrorMessage'] = $_SESSION['imageErrorMessage'] . "Created new fandom '$title' | ";
        }else{
            //set fandom name to one selected from list of options
            $fandom = $_POST['oldFandom'];
            $_SESSION['imageErrorMessage'] = $_SESSION['imageErrorMessage'] . "Fandom: '$fandom' added a new article | ";
        } 
$type = 2;

$description = "Image Article";

$title = $_POST['title'];

$content = $_POST['description'];//there will be no content here

$lastEdited = date("Y-m-d H:i:s");
    
//INSERT ARTICLE 
$insertArticleSql = "INSERT INTO Article (fandom, type, discription, title, content, authorID, lastEdited) VALUES('$fandom', '$type', '$description', '$title', '$content', '$userId[0]', '$lastEdited')";

if($link->query($insertArticleSql) === TRUE){
          $_SESSION['imageErrorMessage'] = $_SESSION['imageErrorMessage'] . "Article successfully created | ";
}else{
     $_SESSION['imageErrorMessage'] = $_SESSION['imageErrorMessage'] . "There was an issue creating the article: ln 75 | ";
    header('Location:uploadPicture.php');
}

//FIND ARTICLE WHICH WAS JUST CREATED
$articleQuery = "SELECT id FROM Article WHERE authorID = '$userId'";

$articleResult = mysqli_query($link ,$articleQuery) or die (mysqli_error($link));

if($articleResult){
    $articleId = mysqli_fetch_row($articleResult)//query the article just created and get the Id.
}else{
    $_SESSION['imageErrorMessage'] = $_SESSION['imageErrorMessage'] . "There was an issue finding the article: ln 95 | ";
    header('Location:uploadPicture.php');
}
//if article created create image entry in Image table //insert into image is not successfull
$insertImage = "INSERT INTO Image (articleId, path, authorId) VALUES('$articleId[0]', '$path', '$userId[0]')";

if($link->query($insertImage) === TRUE){
    $_SESSION['imageErrorMessage'] = $_SESSION['imageErrorMessage'] . "Image row successfully created in DB | ";
}else{
    $_SESSION['imageErrorMessage'] = $_SESSION['imageErrorMessage'] . "There was an issue inserting the Image info into the DB: ln 96 | ";
    header('Location:uploadPicture.php');
}

mysqli_close($link);
//$_SESSION['imageErrorMessage'] = $_SESSION['imageErrorMessage'] . " line 95 we made it: ";

header('Location:uploadPicture.php');

?>