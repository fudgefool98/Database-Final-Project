<?php
echo $_POST['password'];
echo $_POST['confirmPassword'];
/*
in each if statment it should look similar to this

    if(post == session){
        either can be assigned to the variable you've already created for the update query statment
    }
    else{
        post should be assigned to the variable you've already created for the update query statment
    }
    
    
here's the first one done for you

    if($_POST['email']==$_SESSION['email']){
        $email = $row[1];(at this point $row could be substituted for the post or session var)
    }
    else{
        $email = $_SESSION['email'];
    }
    the SESSION variable has the data from the database (so does the row)
    up to you which you choose to use
    
    hit me up if this is confusing and I didn't work on passwords at all on either page but hopefully you can figure out something, i just am not comfortable putting unhashed passwords anywhere so that's all my input on that.
    
*/

session_start();
//account settings
//test the post directly vs creating variables.

//pull username in session to query by
$usr = $_SESSION['user'];

//connect to database
$servername = "localhost";
$usrname = "root";
$passwordDB = "";
$dbname = "fandom";
$link = new mysqli($servername, $usrname, $passwordDB, $dbname);

if($link -> connect_error) {
    die("Connection failed: " . $link->connect_error);
    return false;
}
//pull all data from user already in DB then if changed upsert to db again with new and current info not changed
$query = "SELECT * FROM User WHERE username = '$usr'";

$result = mysqli_query($link, $query) or die (mysqli_error());
$row = mysqli_fetch_row($result);

$email = null;
$username = "";
$firstName = "";
$lastName = "";
$about = "";
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];
$twitter = "";
$facebook = "";
$tumblr = "";
$instagram = "";
$snapchat = "";

//set variables to values in DB unless changed on front end then change values and upsert everything
if($_POST['email'] == $_SESSION['email']){
    $email = $_SESSION['email'];//(at this point $row could be substituted for the post or session var)
}else{
    $email = $_POST['email'];
}

if($_POST['fname'] === $_SESSION['fname']){
    $firstName = $_SESSION['fname'];
}else{
     $firstName = $_POST['fname'];
}
if($_POST['lname'] == $_SESSION['lname']){
    $lastName = $_SESSION['lname'];
}else{
    $lastName = $_POST['lname'];
}
$flag = "TRUE";
//TODO: password hash is being nullified fix it!!!!!!!!!!!!
if(strcmp($_POST['password'], $_POST['confirmPassword'])!=0){
        $flag = "FALSE";
    $hashedPassword = $_SESSION['password'];
    header('Location: editProfile.php');
}
elseif(password_verify($_POST['password'],$_SESSION['password'])){
    $hashedPassword = $_SESSION['password'];
}else{
    $password = $_POST['password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
}

if($_POST['about'] == $_SESSION['about']){
    $about = $_SESSION['about'];
}else{
    $about = $_POST['about'];
}

if($_POST['twitter'] == $_SESSION['twitter']){
    $twitter = $_SESSION['twitter'];
}else{
    $twitter = $_POST['twitter'];
}

if($_POST['facebook'] == $_SESSION['facebook']){
    $facebook = $_SESSION['facebook'];
}else{
    $facebook = $_POST['facebook'];
}
if($_POST['tumblr'] == $_SESSION['tumblr']){
    $tumblr = $_SESSION['tumblr'];
}else{
    $tumblr = $_POST['tumblr'];
}
if($_POST['instagram'] == $_SESSION['instagram']){
    $instagram = $_SESSION['instagram'];
}else{
    $instagram = $_POST['instagram'];
}

if($_POST['snapchat'] == $_SESSION['snapchat']){
    $snapchat = $_SESSION['snapchat'];
}else{
    $snapchat = $_POST['snapchat'];
}

//set remaining values to be updated so we can update the whole table at once.
$userId = $_SESSION['userId'];

$updateQuery = "UPDATE User 
                SET email = '".$email."', firstName = '".$firstName."', lastName = '".$lastName."', about = '".$about."', twitter = '".$twitter."', passwordHash = '".$hashedPassword."', facebook = '".$facebook."', tumblr = '".$tumblr."', instagram = '".$instagram."', snapchat = '".$snapchat."'
                WHERE userId = '".$userId."' ";

$queryBool = mysqli_query($link, $updateQuery);

if ($queryBool && $flag == "FALSE") {
    $_SESSION["errorMessage"] .= "Password and Confirm Password do not match.<br>We successfully updated your user with your old password ";
}
elseif($queryBool && $flag == "TRUE"){
    $_SESSION["errorMessage"] = "We successfully updated your user ";
}
elseif(!$queryBool) {
    $_SESSION["errorMessage"] .= "<br>Error updating record: " . mysqli_error($link);
}
mysqli_close($link);

header('Location: editProfile.php');
?>