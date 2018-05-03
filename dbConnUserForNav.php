<?php 
function navPopulateQuery($conn,$query){
    if($result = $conn->query($query)){
        $returnThis = $result->fetch_row(); 
        if($returnThis[0] != null){
            return $returnThis[0];
        }
        else{
            return "No information available";
        }
    }
    else {
        print "Error: " . $query . "<br>" . $conn->error;
    }   
}
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
if (isset($_SESSION['user'])) {
    $_SESSION['user'] = $conn->real_escape_string($_SESSION['user']);    
    $navSql = "SELECT username FROM User Where `username` = '$_SESSION[user]'";

    $resultusername = navPopulateQuery($conn, $navSql);
}

?>