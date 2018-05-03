<?php 
require 'db_credentials.php';
session_start();
//<THIS IS RELATED TO THE BIRTHDAY FIELD AND AN ERROR CHECK TO ENSURE AGE>13;>
date_default_timezone_set('UTC');
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$firstName = $conn->real_escape_string($_POST['firstName']);
$lastName = $conn->real_escape_string($_POST['lastName']);
$user = $conn->real_escape_string($_POST['username']);
$email = $conn->real_escape_string($_POST['email']);
$birthday = $conn->real_escape_string($_POST['birthday']);
$password = $conn->real_escape_string($_POST['password']);
$passwordConfirmation = $conn->real_escape_string($_POST['passwordConfirmation']);

function ageCalculator($dob){
    if(!empty($dob)){
        $birthdate = new DateTime($dob);
        $today   = new DateTime('today');
        $age = $birthdate->diff($today)->y;
        if($age>13){
            return 1;
        }
        else{
            return 0;
        }
    }
    else{
        return 0;
    }
}
function usernameIsUniqueCheck($conn,$user){
    $userSql = "Select username from User where username = '$user'";
    $userResult = $conn->query($userSql);
    if($userResult){
        //if query worked
        
        echo 'here';
        $row = $userResult->fetch_row();
        if($row === NULL){
            $userResult->free_result();
            return true;
                    //if userSql has no results return true
            // use this http://php.net/manual/en/mysqli-result.lengths.php
            // we have a result object we need to check that the result has no rows returned from the db. then return true.
        }
        else{
            //else return false
            $userResult->free_result();
            return false;
        }
    }
    
}
//BEGIN THE ERROR CHECKING
//check if all inputs full
if($firstName == '' || $lastName == '' || $email == '' || $password == '' || $passwordConfirmation == '' || $username = ''){
    unset($_SESSION["message"]);
    $_SESSION["message"] = "You must fill all inputs to continue";
    header('Location: signupPage.php');
    exit; 
}
    
// check if older than 13
if(new DateTime($birthday)> new DateTime('now')){
    unset($_SESSION["message"]);
        $_SESSION["message"] = "You must be 13 years of age or older to sign up";
    header('Location: signupPage.php');
    exit; 
}
// ^^ 13 years of age or older
if (ageCalculator($birthday)!=1){
unset($_SESSION["message"]);
    $_SESSION["message"] = "You must be 13 years of age or older to sign up";
    header('Location: signupPage.php');
    exit; 
}
//Passwords match?
if($password == $passwordConfirmation){
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
}
else{
    unset($_SESSION["message"]);
    $_SESSION["message"] = "Your password's do not match each other";
    header('Location: signupPage.php');
    exit; 
}
//is the Username unique?    
if(!usernameIsUniqueCheck($conn,$user)){
    unset($_SESSION["message"]);
    $_SESSION["message"] = "Your username exists pick another unique username";
    header('Location: signupPage.php');
    exit; 
}

//if there's no message set we insert the data to the db
if (!isset($_SESSION['message'])){
$sql = "INSERT INTO User (firstName, lastName, email, birthday, passwordHash, username) VALUES('$firstName', '$lastName', '$email', '$birthday','$hashedPassword','$user')";
}
else{
    header('Location: signupPage.php');
    exit;   
}
//if the query was successful we reroute to (where would we like to reroute?)
if ($conn->query($sql) === TRUE) {
     $_SESSION['user'] = '$user';
     header('Location: userProfile.php');
     exit; 
} 
else {
    print "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();

?>