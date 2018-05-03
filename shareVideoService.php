<?php


function getFandoms(){
        require('db_credentials.php');
    $link = new mysqli($servername, $username, $password, $dbname);  

    if($link -> connect_error) {
        die("Connection failed: " . $link->connect_error);
        return false;
    }

    $userQuery = "SELECT * FROM User WHERE email = '".$_SESSION['name']."' ";
    $fandomQuery = "SELECT title FROM Fandom LIMIT 4";


    //$userResult = mysqli_query($link, $userQuery) or die (mysqli_error());
    $fandomResult = mysqli_query($link, $fandomQuery) or die (mysqli_error());

    //$user = mysqli_fetch_row($userResult);
    $fandoms = array();

    //Loop through the results and place each one in an array
    //use mysqli_fetch_all() to get them all at one time

    //loop through list of fandoms and push to the fandoms array.
    while($row = mysqli_fetch_array($fandomResult, MYSQLI_NUM)){
        array_push($fandoms, $row);
    }
    //need to pass the list of fandoms through a session variable
    //$_SESSION['fandoms'] = $fandoms;
    //instead just return the arraylist of fandoms
    myqli_close($link);
    return $fandoms;
}

function shareVideo(){
     
     $file = rand(1000,100000)."-".$_FILES['file']['name'];
    $file_loc = $_FILES['file']['tmp_name'];
     $file_size = $_FILES['file']['size'];
     $file_type = $_FILES['file']['type'];
     $folder="VideoUploads/";
    
    $fandom = $_POST['fandom'];
    $type = $_POST['type'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $lastEdited = date("Y-m-d H:i:s");
    

    
    $userResult = mysqli_query($link, $userQuery) or die (mysqli_error());
    
    
     // new file size in KB
     $new_size = $file_size/1024;  
     // new file size in KB

     // make file name in lower case
     $new_file_name = strtolower($file);
     // make file name in lower case

     $final_file=str_replace(' ','-',$new_file_name);

     if(move_uploaded_file($file_loc,$folder.$final_file))
     {
      $sql="INSERT INTO Article(fandom,type,description, title, content, authorID, lastEdited,size , location) VALUES('$new_size', '$file_loc' )";
      mysql_query($sql);

     }
}

function createFandom(){
//if new fandom is selected create fandom THEN create the article in the db

}

?>