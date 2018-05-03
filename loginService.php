<?php

    //session_destroy();
    session_start();

    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        // Run your function
        Login();
    }
    function Login(){
        if(empty($_POST['username'])){
            $this->HandleError("Username field is emtpy");
            return false;
        }
        if(empty($_POST['password'])){
            $this->HandleError("Password field is empty");
        }
        //pull the values from the fields and into variables
        $username = $_POST['username'];
        $password = $_POST['password'];

        $userCheck = DBCheck($username, $password);
        //if the connection cannot be made redirect to the error page.
        
        if($userCheck === TRUE){
             //Start a session
            //save session
            mysqli_close($link);
            $_SESSION['login'] = true;
            $_SESSION['errorMessage'] = null;
            $_SESSION['user'] = $username;
            header('Location: mainAnon.php');
            exit;
        }else {
            unset($_SESSION["errorMessage"]);
        	 $_SESSION["errorMessage"] = "There was an issue Logging in!";
            header('Location: loginPage.php');
            mysqli_close($link);
        }
    }
    function DBCheck($username,$password){
       
        $servername = "localhost";
        $usrname = "root";
        $passwordDB = "";
        $dbname = "fandom";
        $link = new mysqli($servername, $usrname, $passwordDB, $dbname);

        if($link -> connect_error) {
            die("Connection failed: " . $link->connect_error);
            return false;
        }
        
        $user = mysqli_real_escape_string($link, $username);
        $password = mysqli_real_escape_string($link, $password);
        
        $userQuery = "SELECT passwordHash FROM User WHERE username = '$username'";
        
        $results = mysqli_query($link, $userQuery) or die(mysqli_error());
        
        if(is_null($results) || empty($results)){
            unset($_SESSION["errorMessage"]);
        	 $_SESSION["errorMessage"] = "We had some trouble finding your account.";
            header('Location: loginPage.php');
        }
        while($row = mysqli_fetch_assoc($results)){
            foreach($row as $cname => $cvalue){
                
                if(!is_null($cvalue)){
                    $result = $cvalue;
                    print "$cname is: $result\t <br>";
                }
            }
            print "\r\n";
        } 
        
        $passwordVerification = password_verify($password, $result);
        
        if($passwordVerification == FALSE){
            unset($_SESSION["errorMessage"]);
        	 $_SESSION["errorMessage"] = "Your username or password is incorrect";
            header('Location: loginPage.php');
        }
        if($passwordVerification == TRUE){
            return true;
        }
       return false;
    }

?>