<?php 

/*
the problems with this document are as follows

#1 NO IMPLEMENTATION IS DONE FOR THE PROFILE PICTURE!!!!!
#2 ask about the security of this document
#3 surely this should be refactored but it does work.
#4 might have a bug with logged in user.... but it seems get overrides as is needed
#5 WORK ON THE LOG IN LOG OUT AND EDIT LINK
*/

// Start the session
require 'db_credentials.php';
require 'loggedInCheck.php';
require 'dbConnUserForNav.php';

if(!isset($_GET['user']) && !isset($_SESSION['user'])){
    header('Location: signupPage.php');
    exit;
}

if(isset($_GET['user'])){
$_GET['user'] = $conn->real_escape_string($_GET['user']);    
$aboutMeSql = "SELECT about FROM User WHERE `username` = '$_GET[user]'";
$WrittenArticlesListSql = "Select title, authorID From Article, User Where authorID = userId and username = '$_GET[user]'";
$myfandomsSql = "SELECT fandom, username FROM Article, User, Fandom WHERE authorID = userID and username = '$_GET[user]' and fandom = Fandom.title group by Fandom.title";
$twitter = "SELECT twitter FROM User Where `username` = '$_GET[user]'";
$facebook = "SELECT facebook FROM User Where `username` = '$_GET[user]'";
$instagram = "SELECT instagram FROM User Where `username` = '$_GET[user]'";
$snapchat = "SELECT snapchat FROM User Where `username` = '$_GET[user]'";
$tumblr = "SELECT tumblr FROM User Where `username` = '$_GET[user]'";
$usernameSql = "SELECT username FROM User Where `username` = '$_GET[user]'";
$birthdaySql = "SELECT birthday FROM User Where `username` = '$_GET[user]'";
$topFandomSql = "Select Fandom.title 
From Fandom, Article, User 
where authorID = userID and username = '$_GET[user]' and fandom = Fandom.title 
group by Fandom.title 
order by count(Fandom.title) desc
limit 1; ";
$mostRecentArticleSql = "SELECT title FROM Article, User WHERE authorID = userID and username = '$_GET[user]' order by lastEdited desc limit 1";
}
else{
$_SESSION['user'] = $conn->real_escape_string($_SESSION['user']);    

$aboutMeSql = "SELECT about FROM User WHERE `username` = '$_SESSION[user]'";
$WrittenArticlesListSql = "Select title, authorID From Article, User Where authorID = userId and username = '$_SESSION[user]'";
$myfandomsSql = "SELECT fandom, username FROM Article, User, Fandom WHERE authorID = userID and username = '$_SESSION[user]' and fandom = Fandom.title group by Fandom.title";
$twitter = "SELECT twitter FROM User Where `username` = '$_SESSION[user]'";
$facebook = "SELECT facebook FROM User Where `username` = '$_SESSION[user]'";
$instagram = "SELECT instagram FROM User Where `username` = '$_SESSION[user]'";
$snapchat = "SELECT snapchat FROM User Where `username` = '$_SESSION[user]'";
$tumblr = "SELECT tumblr FROM User Where `username` = '$_SESSION[user]'";
$usernameSql = "SELECT username FROM User Where `username` = '$_SESSION[user]'";
$birthdaySql = "SELECT birthday FROM User Where `username` = '$_SESSION[user]'";
$topFandomSql = "Select Fandom.title 
From Fandom, Article, User 
where authorID = userID and username = '$_SESSION[user]' and fandom = Fandom.title 
group by Fandom.title 
order by count(Fandom.title) desc
limit 1; ";
$mostRecentArticleSql = "SELECT title FROM Article, User WHERE authorID = userID and username = '$_SESSION[user]' order by lastEdited desc limit 1";
}
function oneResultQuery($conn,$query){
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
function multipleResultQuery($conn,$query){
    if($result = $conn->query($query)){
        return $result;
    }
    else {
        print "Error: " . $query . "<br>" . $conn->error;
    }
}
//if the value is non nullable we would like to return a string that says 
//"This hasn't been set yet, edit your information by clicking Edit User"
//these are tabs
$resultAboutMe = oneResultQuery($conn, $aboutMeSql);
$resultMyFandoms = multipleResultQuery($conn, $myfandomsSql);
$myFandomsHTML = '';

while ($fandomRow = $resultMyFandoms->fetch_row()) {
            $myFandomsHTML .= '<dt class="links"><a href="http://www.fandomdb.com/Production/articles.php?title='.$fandomRow[0].'&authorID='.$fandomRow[1].'">'.$fandomRow[0].' </a></dt>';
}
if($myFandomsHTML == ''){
    $myFandomsHTML = 'No information available';
}
$resultWrittenArticlesList = multipleResultQuery($conn, $WrittenArticlesListSql);
$articleListHTML = '';
while ($articleRow = $resultWrittenArticlesList->fetch_row()) {
            $articleListHTML .= '<dt class="links"><a href="http://www.fandomdb.com/Production/viewArticle.php?title='.$articleRow[0].'&authorID='.$articleRow[1].'">'.$articleRow[0].' </a></dt>';
}
if($articleListHTML == ''){
    $articleListHTML = 'No information available';
}
//social media
$resultTwitter = oneResultQuery($conn, $twitter);
$resultFacebook = oneResultQuery($conn, $facebook);
$resultInstagram = oneResultQuery($conn, $instagram);
$resultSnapchat = oneResultQuery($conn, $snapchat);
$resultTumblr = oneResultQuery($conn, $tumblr);

//these are in quick look
$resultusername = oneResultQuery($conn, $usernameSql);
$resultBirthday = oneResultQuery($conn, $birthdaySql);
$resultMostRecentArticle = oneResultQuery($conn, $mostRecentArticleSql);

$resultTopFandom = oneResultQuery($conn, $topFandomSql);


$conn->close();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>User Profile</title><!-- this could be "name User Profile"-->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <link rel="stylesheet" type="text/css" href="userPage.css">
        <link rel="stylesheet" type="text/css" href="navbar.css">

        <style>
            .profilePic{
                border-radius: 20%;
            }
            .profileInfo{
                border-radius: 15px;
                border-color: #C1C8EA;
            }
            .contentDiv{
                border-bottom-left-radius: 10px;
                border-bottom-right-radius: 10px;
            }
            .quickLook{
                border-radius: 15px;
                border-color: #8860D0;
                color: #5680E9;
            }
            labelColor{
            }
            .tab {
                overflow: hidden;
                border: 1px solid #8860D0;
/*                border-bottom: none;*/
                background-color: #84CEEB;
                border-top-right-radius: 10px;
                border-top-left-radius: 10px;
            }

            /* Style the buttons inside the tab */
            .tab button {
                background-color: inherit;
                float: left;
                border: none;
                outline: none;
                cursor: pointer;
                padding: 14px 16px;
                transition: 0.3s;
                font-size: 17px;
            }

            /* Change background color of buttons on hover */
            .tab button:hover {
                background-color: #5AB9EA;
            }

            /* Create an active/current tablink class */
            .tab button.active {
                background-color: #5680E9;
            }

            /* Style the tab content */
            .tabcontent {
                display: none;
                padding: 6px 12px;
                border: 1px solid #8860D0;
                border-top: none;
                border-bottom-left-radius: 15px;
                border-bottom-right-radius: 15px;
            }
            .words{
                -webkit-animation: fadeEffect 1s;
                animation: fadeEffect 1s;
            }
            @-webkit-keyframes fadeEffect {
                from {opacity: 0;}
                to {opacity: 1;}
            }

            @keyframes fadeEffect {
                from {opacity: 0;}
                to {opacity: 1;}
            }
            .tabBody{
                background-color: whitesmoke;
                color: #5680E9;
                border-bottom-left-radius: 15px;
                border-bottom-right-radius: 15px;
            }
            hr{
                color: black;
            }

            .createAccount {
             font-size: 20px;
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
<!--        script for tabs-->
        <script>
            function openTab(evt, tabName) {
                var i, tabcontent, tablinks;
                tabcontent = document.getElementsByClassName("tabcontent");
                for (i = 0; i < tabcontent.length; i++) {
                    tabcontent[i].style.display = "none";
                }
                tablinks = document.getElementsByClassName("tablinks");
                for (i = 0; i < tablinks.length; i++) {
                    tablinks[i].className = tablinks[i].className.replace(" active", "");
                }
                document.getElementById(tabName).style.display = "block";
                evt.currentTarget.className += " active";
            }

         
//            document.getElementById("defaultOpen").click();
    
        </script>
<!--        Header-->
        <div class="container-fluid header">
          <div class="row">
            <div class="fb-profile">
                <img align="left" class="fb-image-lg" src="images/FandomDBCropped.png" alt="Profile image example"/>
                <div>
                <img align="left" class="fb-image-profile thumbnail profilePic" src="images/blankUser.png" alt="Profile image example"/>
                </div>
                <div class="fb-profile-text">
                    <h1>User Profile</h1><!-- this could be their name-->
                    <?php
                            if(isset($_SESSION['user'])){
                                if(0==strcmp($_SESSION['user'],$resultusername)){
                                echo'<a href="editProfile.php">Edit Profile</a>';
                                }
                            }
                    ?>
                </div>
            </div>
          </div>
        </div> <!-- /container fluid-->  
        <div class="container pageContent">
          <div class="col-sm-8">
              <!--Tabs for profile-->
              <div data-spy="scroll" class="tabbable-panel profileInfo">
                <div class="tab">
                    <button class="tablinks" onclick="openTab(event, 'About')">About Me</button>
                    <button class="tablinks" onclick="openTab(event, 'Articles')">Written Articles</button>
                    <button class="tablinks" onclick="openTab(event, 'Fandoms')">My Fandoms</button>
                    <button class="tablinks" onclick="openTab(event, 'Other')">Social Media</button>
                </div>
<!--                  Info within tab-->
<!--                  data needs to loaded into these tabs based on user profile information from "Edit Profile" or User tables in DB-->
                  <div class="tabBody">
                    <div id="About" class="tabcontent" style="display:block">
                      <h3>About Me</h3>
                        <hr>
                      <p class="words"><?php echo "$resultAboutMe"; ?></p>
                    </div>

                    <div id="Articles" class="tabcontent">
                      <h3>Written Articles</h3>
                        <hr>
                      <p class="words"><?php echo "$articleListHTML"; ?></p> 
                    </div>

                    <div id="Fandoms" class="tabcontent">
                      <h3>My Fandoms</h3>
                        <hr>
                      <p class="words"><?php echo "$myFandomsHTML"; ?></p>
                    </div>

                    <div id="Other" class="tabcontent">
                      <h3>Social Media</h3>
                        <hr>
                      <ul class="words">Twitter: <?php echo "$resultTwitter"; ?></ul>
                      <ul class="words">Facebook: <?php echo "$resultFacebook";  ?></ul>
                      <ul class="words">Instagram: <?php echo "$resultInstagram";?></ul>
                      <ul class="words">Snapchat: <?php echo "$resultSnapchat"; ?></ul>
                      <ul class="words">Tumblr: <?php echo "$resultTumblr"; ?></ul>
                    </div>
                  </div>
              </div>

          </div>
<!--            Right side quick look at user details-->
          <div class="col-sm-4">
           <div class="panel panel-default quickLook">
                <div class="menu_title">
                   Quick Look
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                             <div class="form-group labelColor">
                                 <label>Username: <?php echo "$resultusername"; ?></label>
                                  <p></p>
                             </div>
                              <div class="form-group labelColor">
                                  <label for="username">Birthday: <?php echo "$resultBirthday"; ?></label>
                                  <p></p>
                              </div>
                              <div class="form-group labelColor">
                                  <label for="username">Top Fandom: <?php echo "$resultTopFandom"; ?></label>
                                  <p></p>
                              </div>
                               <div class="form-group labelColor">
                                  <label for="username">Most Recent Article: <?php echo "$resultMostRecentArticle"; ?></label>
                                   <p></p>
                               </div>

                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </body>
</html>