<?php

/* STILL NEED TO 
    make more queries
    populate everything
    */
require 'db_credentials.php';
require 'loggedInCheck.php';
require 'dbConnUserForNav.php';

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
if(isset($_GET['title']) && isset($_GET['authorID'])){
$_GET['title'] = $conn->real_escape_string($_GET['title']);    
$_GET['authorID'] = $conn->real_escape_string($_GET['authorID']);    

$titleSql = "select title from Article where title = '$_GET[title]' and authorID = '$_GET[authorID]'";
$titleResult = oneResultQuery($conn,$titleSql);
    
$authorUsernameSql = "select username from User where userID = '$_GET[authorID]'";
$authorUsernameResult = oneResultQuery($conn,$authorUsernameSql);
    
$fandomSql = "select fandom from Article where title = '$_GET[title]' and authorID = '$_GET[authorID]'";
$fandomResult = oneResultQuery($conn,$fandomSql);
    
$articleCreationDateSql = "select lastEdited from Article where title = '$_GET[title]' and authorID = '$_GET[authorID]'";
$articleCreationDateResult = oneResultQuery($conn,$articleCreationDateSql);
    
//$descriptionSql = "select description from Article where title = '$_GET[title]' and authorID = '$_GET[authorID]'";
//$descriptionResult = oneResultQuery($conn,$descriptionSql);
    // ask the team about description in the scema.. is it actually content? but when the content isn't words its the "description"?
    // can we drop the column description in the scema?
    
$bodySql = "select content from Article where title = '$_GET[title]' and authorID = '$_GET[authorID]'";
$bodyResult = oneResultQuery($conn,$bodySql);

$aboutAuthorSql = "SELECT about FROM User WHERE userID = '$_GET[authorID]'";
$aboutAuthorResult = oneResultQuery($conn,$aboutAuthorSql);
    
$authorsArticlesListSql = "Select title, authorID From Article, User Where authorID = userId and authorID = '$_GET[authorID]'";
$authorsArticlesListResult = multipleResultQuery($conn, $authorsArticlesListSql);
$authorsArticlesHTML = '';
while ($authorRow = $authorsArticlesListResult->fetch_row()) {
            $authorsArticlesHTML .= '<a class="list-group-item" href="http://www.fandomdb.com/Production/viewArticle.php?title='.$authorRow[0].'&authorID='.$authorRow[1].'"><h4 class="list-group-item-heading">'.$authorRow[0].'</h4> <p class="list-group-item-text"></p></a>';
}
    //<a class="list-group-item" href="#"> <h4 class="list-group-item-heading">Content Title Here</h4> <p class="list-group-item-text"></p> </a>
    
$fandomArticlesListSql = "Select Article.title, authorID From Article, Fandom Where Article.fandom = Fandom.title and Fandom.title = '$fandomResult'";
$fandomArticlesResult = multipleResultQuery($conn, $fandomArticlesListSql);
$articleListHTML = '';
while ($articleRow = $fandomArticlesResult->fetch_row()) {
            $articleListHTML .= '<a class="list-group-item" href="http://www.fandomdb.com/Production/viewArticle.php?title='.$articleRow[0].'&authorID='.$articleRow[1].'"><h4 class="list-group-item-heading">'.$articleRow[0].'</h4> <p class="list-group-item-text"></p></a>';
} 
$articleIdQuery = 'select id from Article where authorID = '.$_GET['authorID'].' and title = "'.$titleResult.'"';
$_SESSION['articleid'] = oneResultQuery($conn,$articleIdQuery);
}
else{
    header('Location: mainAnon.php');
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Articles</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <link rel="stylesheet" type="text/css" href="userPage.css">
        <link rel="stylesheet" type="text/css" href="navbar.css">

        <style>

            .fandomdb{
                height: 50px;
                width: 250px;
                padding-right: 10px;

            }
            .image{
                height: auto;
                width: auto;
                display: block;
                margin-left: auto;
                margin-right: auto;
                
            }
            span {
                font-size: 14px;
                font-weight: 400;
                color: #8860D0;
            }
            .articleLinks{
                width: 220px;
                
            }
            .authorDiv{
                background-color: #5680E9;
            }
            .text{
                text-align: center;
            }
        </style>
    </head>
    <body>
   <?php require 'navBar.php'?>
        <section class="banner-section">
        </section>
        <section class="post-content-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-md-9 col-sm-12">
                        <div class="col-lg-12 col-md-12 col-sm-12 post-title-block">
                            
<!--                            Title will be populated from php fetched from create content pages-->
                            <h1 class="text-center">
                                <?php 
                                        echo $titleResult." "; 
                                        if(0==strcmp($_SESSION['user'],$authorUsernameResult)){
                                            echo '<a href = "http://www.fandomdb.com/Production/deleteService.php" type="button" class="btn btn-danger">Delete</a>';

                                        }
                                ?>
                            </h1>
                            <ul class="list-inline text-center">
                                
<!--                                Auther Name, Fandom, and Date will be fetched from php of create content as well-->
                                <li class="text"><?php echo $authorUsernameResult; ?></li>|
                                <li class="text"><?php echo $fandomResult; ?></li>|
                                <li class="text"><?php echo $articleCreationDateResult; ?></li>
                            </ul>
                        </div>
                        <div class="image-block">
                            <div>
<!--                  the image/video/picture will go here from whatever the creator uploads from content creation page-->
                                 <img src="images/blankImage.png" class="img-responsive image">
                            </div>
                        </div>
                        <div>
<!--                    Words from the create content page is here. Words for article or caption... Whichever, if there is not                             caption or article from the creator this should be left blank-->
                            <p class="lead"><?php echo $bodyResult; ?></p>
                        </div>
                     </div>
                    <div class="col-lg-3  col-md-3 col-sm-12">
                        <div class="well authorDiv">
                            <h2>About Author</h2>
                            <img src="" class="img-rounded" />
<!--                            a little blurb from the authurs bio here-->
                            <p><?php echo $aboutAuthorResult; ?></p>
                            
<!--                            button below should take you to the users profile-->
                            <?php echo '<a href="http://www.fandomdb.com/Production/userProfile.php?user='.$authorUsernameResult.'" class="btn btn-default">Author Profile</a>' ?>
                        </div>
                        <div class="well authorDiv">
                            
<!--                            more content from the creator-->
                            <h3>More by This Author</h3>
                            <div class="input-group">
                                <div class="list-group articleLinks">
                                    <?php echo $authorsArticlesHTML; ?>
<!--                                    <a class="list-group-item" href="#"> <h4 class="list-group-item-heading">Content Title Here</h4> <p class="list-group-item-text"></p> </a>-->
                                </div>
                            </div>
                        </div>
                        <div class="well authorDiv">
<!--                            more content within this fandom-->
                            <h3>More in This Fandom</h3>
                            <div class="input-group">
                                <div class="list-group articleLinks">
                                    <?php echo $articleListHTML; ?>
<!--                                    <a class="list-group-item" href="#"> <h4 class="list-group-item-heading">Content Title Here</h4> <p class="list-group-item-text"></p> </a>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- /container -->
        </section>
      
    </body>
</html>