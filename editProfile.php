<?php
//04/1/18: No errors. Full update works but not inserting any values that are entered on the front end.
//After update all columns in row are nullified. Throwing mysqli_query() error
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

//set variables to values in DB unless changed on front end then change values and upsert everything
$_SESSION['email'] = $row[1];

//$_SESSION['username'] = $row[12];

$_SESSION['fname'] = $row[2];

$_SESSION['lname'] = $row[3];

$_SESSION['password'] = $row[5];

//if(empty($_POST['password']) || $confirmPassword !== $password){
//    $hashedPassword = row[5];
//}else{
//    $password = $_POST['password'];
//    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
//}

$_SESSION['about'] = $row[6];

$_SESSION['twitter'] = $row[7];

$_SESSION['facebook'] = $row[8];

$_SESSION['tumblr'] = $row[9];

$_SESSION['instagram'] = $row[10];
    
$_SESSION['snapchat'] = $row[11];

//set remaining values to be updated so we can update the whole table at once.
$userId = $row[0];
$_SESSION['userId'] = $userId;



?>

<!DOCTYPE html>
<html>
    <head>
        <title>Edit Profile</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <link rel="stylesheet" type="text/css" href="userPage.css">
        <link rel="stylesheet" type="text/css" href="navbar.css">
        <style>
            .textAreaStyle{
                border-radius: 5pt;
                border-color: lightgray;
            }

            .blankUserPic{
                width: 250px;
                height: 250px;
                border-color: lightgray;
                border-radius: 15%;
            }
            .userStatus{
                border: 5pt;
                border-color: #5680E9;
                color: #5680E9;
            }
            .fandomdb{
                height: 50px;
                width: 250px;
                padding-right: 10px;
            }

            
        </style>
    </head>
    
    <body>
        <?php require 'navBar.php'?>
<!--        Left of the page that holds photo and upload photo-->
        <div class="container">
        <h1>Edit Profile</h1>
        <hr>
        <div class="row">
          <!-- left column -->
          <div class="col-md-3">
            <div class="text-center">
              <img class="blankUserPic" src="images/blankUser.png" class="avatar img-circle" alt="avatar">
              <h6>Upload a different photo...</h6>
              <input type="file" class="form-control">
            </div>
          </div>

          <!-- edit form column -->
          <div class="col-md-9 personal-info">
            <div class="alert alert-info alert-dismissable">
              <i class="fa fa-coffee"></i>
                These Changes will show on your<strong> Profile</strong>. Passwords are <strong>only</strong> visable to you, and <strong>cannot</strong> be seen by other users.
            </div>
               <?php
                if(isset($_SESSION['errorMessage']) && "We successfully updated your user "!=$_SESSION['errorMessage']){
                    echo '<div class="alert alert-danger"><p>';
                    echo $_SESSION["errorMessage"];
                    echo "</p></div>";
                    unset($_SESSION['errorMessage']);
                }
                elseif(isset($_SESSION['errorMessage']) && "We successfully updated your user "==$_SESSION['errorMessage']){
                    echo '<div class="alert alert-success""><p>';
                    echo $_SESSION["errorMessage"];
                    echo "</p></div>";
                    unset($_SESSION['errorMessage']);
                }
                
            ?>
              
            <h3>Account Settings</h3>
              <hr>
            <form class="form-horizontal" action="editProfileService.php" role="form" method="post">
              <div class="form-group">
                <label class="col-lg-3 control-label">Email:</label>
                <div class="col-lg-8">
                  <input class="form-control" type="text" placeholder="email@yourcompany.com" name="email" value = "<?php echo $_SESSION['email'];?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-3 control-label">Password:</label>
                <div class="col-lg-8">
                  <input class="form-control" type="password" placeholder="password" name="password">
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-3 control-label">Confirm Password:</label>
                <div class="col-lg-8">
                  <input class="form-control" type="password" placeholder="confirm password" name="confirmPassword">
                </div>
                  <br>
                  <br>
                  <br>
                  <br>
              </div>
            
            <h3>Profile Setting</h3> 
              <hr>
              <div class="form-group">
                <label class="col-md-3 control-label">First Name:</label>
                <div class="col-md-8">
                  <input class="form-control" type="text" placeholder="First Name" name="fname" value = "<?php echo $_SESSION['fname'];?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Last Name:</label>
                <div class="col-md-8">
                  <input class="form-control" type="text" placeholder="Last Name" name="lname" value = "<?php echo $_SESSION['lname'];?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">About:</label>
                <div class="col-md-8">
                    <textarea rows="5" cols="50" name="about" placeholder="Tell everyone a little bit about you!" class="textAreaStyle" ><?php echo $_SESSION['about'];?></textarea>
                </div>
                  <br>
                  <br>
                  <br>
                  <br>
              </div>
                
              <h3>Social Media</h3> 
              <hr>
                <div class="form-group">
                    <label class="col-md-3 control-label">Twitter:</label>
                    <div class="col-md-8">
                      <input class="form-control" type="text" placeholder="Twitter" name="twitter" value = "<?php echo $_SESSION['twitter'];?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Facebook:</label>
                    <div class="col-md-8">
                      <input class="form-control" type="text" placeholder="Facebook" name="facebook" value = "<?php echo $_SESSION['facebook'];?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Instagram:</label>
                    <div class="col-md-8">
                      <input class="form-control" type="text" placeholder="Instagram" name="instagram" value = "<?php echo $_SESSION['instagram'];?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Snapchat:</label>
                    <div class="col-md-8">
                      <input class="form-control" type="text" placeholder="Snapchat" name="snapchat" value = "<?php echo $_SESSION['snapchat'];?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Tumblr:</label>
                    <div class="col-md-8">
                      <input class="form-control" type="text" placeholder="Tumblr" name="tumblr" value = "<?php echo $_SESSION['tumblr'];?>">
                    </div>
                </div>
                  <br>
                  <br>
                  <br>
                  <br>
              <div class="form-group">
                <label class="col-md-3 control-label"></label>
                <div class="col-md-8">
                    <button type="submit" class="btn btn-primary" formaction=" editProfileService.php">Save Changes</button>
                  <span></span>
                  <input onClick="window.location.href = 'http://www.fandomdb.com/Production/userProfile.php'" type="reset" class="btn btn-default" value="Cancel">
                </div>
              </div>
            </form> <!-- end form -->
          </div> <!--end edit form colum-->
          </div>
        </div>
        <hr>
    </body>
</html>