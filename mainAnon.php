<!--
<?php
require 'db_credentials.php';
require 'loggedInCheck.php';
require 'dbConnUserForNav.php';


function multipleResultQuery($conn,$query){
    if($result = $conn->query($query)){
        return $result;
    }
    else {
        print "Error: " . $query . "<br>" . $conn->error;
    }
}

$query = "Select fandom, title, content, authorId from Article where `type` = 1 order by lastEdited desc limit 3";

$result = multipleResultQuery($conn,$query);
$one = $result->fetch_assoc();
$two = $result->fetch_assoc();
$three = $result->fetch_assoc();
?>
-->
<!DOCTYPE html>
<html lang="en">
    <head>
    <title>FandomDB</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <link rel="stylesheet" type="text/css" href="navbar.css">
        <link rel="stylesheet" type="text/css" href="userPage.css">

        <style>
            p {
                font-size: 15px;
                font-weight: 400;
                color: darkslategray;
                margin-bottom: 15px;

            }
            h1, h2, h3, h4, h5, h6 {
                font-weight: 700;
                color: #515769;
                line-height: 1.4;
                margin: 0 0 15px;
            }
            h1 > a, h2 > a, h3 > a, h4 > a, h5 > a, h6 > a {
                color: #515769;
            }
            .margin-b-20 {
                margin-bottom: 20px !important;
            }

            .margin-b-40 {
                margin-bottom: 40px !important;
            }

            .margin-b-50 {
                margin-bottom: 40px !important;
            }
             a:hover {
                color: #999caa;
                text-decoration: none;
            }
            
            .link:active, .link:focus, .link:hover {
                color: white;
            }
            .text-uppercase {
                text-transform: uppercase;
            }
            .link {
                font-size: 13px;
                font-weight: 600;
                color: #5680E9;
            }

            .slogan{
                font-size: 20pt;
            }
            img.fandomdb{
                z-index: 0;
                width: 100%;  
            }
            .img-responsive{
                width: 100%;
            }
            .topMenu{
                float: left;
            }
/*
            @media only screen and (max-width:1400px){
                .fandomdb{
                    z-index: 0;
                    width: 100%;  
                }
            }
*/

        </style>

    </head>
    <body>  
        
        <?php
            require 'navBar.php';
        ?>
        
        <div class="container latest-product-section">
                <div class="row text-center margin-b-40">
                    <div class="col-sm-6 col-sm-offset-3">
                        <p class="slogan">A Platform for the fans by the fans! Start creating and reading about your favorite Fandoms today!</p>
                        
                        <h3>Most Recent Posts</h3>
                    </div>
                </div>
                <!--// end row -->

                <div class="row">
                    <!-- Latest Products -->
                    <div class="col-sm-4 sm-margin-b-50">
                        <div class="margin-b-20">
                            <img class="img-responsive" src="https://images.pexels.com/photos/288477/pexels-photo-288477.jpeg?w=940&h=650&auto=compress&cs=tinysrgb" alt="Latest Products Image">
                        </div>
                        <h4><a <?php echo 'href="http://www.fandomdb.com/Production/viewArticle.php?title='.$one["title"].'&authorID='.$one["authorId"].'"';?>><?php echo $one["title"];?></a> <span class="text-uppercase margin-l-20"><?php echo $one["fandom"]; ?></span></h4>
                        <p><?php 
                            $oneSub = substr($one["content"],0,150);
                            echo $oneSub."...";
                            
                            ?></p>
                        <a class="link" <?php echo 'href="http://www.fandomdb.com/Production/viewArticle.php?title='.$one["title"].'&authorID='.$one["authorId"].'"';?>>Read More</a>
                    </div>
                    <!-- End Latest Products -->

                    <!-- Latest Products -->
                    <div class="col-sm-4 sm-margin-b-50">
                        <div class="margin-b-20">
                            <img class="img-responsive" src="https://images.pexels.com/photos/288477/pexels-photo-288477.jpeg?w=940&h=650&auto=compress&cs=tinysrgb" alt="Latest Products Image">
                        </div>
                        <h4><a <?php echo 'href="http://www.fandomdb.com/Production/viewArticle.php?title='.$two["title"].'&authorID='.$two["authorId"].'"';?>><?php echo $two["title"];?></a> <span class="text-uppercase margin-l-20"><?php echo $two["fandom"]; ?></span></h4>
                        <p><?php 
                            $twoSub = substr($two["content"],0,150);
                            echo $twoSub."...";
                            
                            ?></p>
                        <a class="link" <?php echo 'href="http://www.fandomdb.com/Production/viewArticle.php?title='.$two["title"].'&authorID='.$two["authorId"].'"';?>>Read More</a>
                    </div>
                    <!-- End Latest Products -->

                    <!-- Latest Products -->
                    <div class="col-sm-4 sm-margin-b-50">
                        <div class="margin-b-20">
                            <img class="img-responsive" src="https://images.pexels.com/photos/288477/pexels-photo-288477.jpeg?w=940&h=650&auto=compress&cs=tinysrgb" alt="Latest Products Image">
                        </div>
                        <h4><a <?php echo 'href="http://www.fandomdb.com/Production/viewArticle.php?title='.$three["title"].'&authorID='.$three["authorId"].'"';?>><?php echo $three["title"];?></a> <span class="text-uppercase margin-l-20"><?php echo $three["fandom"]; ?></span></h4>
                        <p><?php 
                            $threeSub = substr($three["content"],0,150);
                            echo $threeSub."...";
                            
                            ?></p>
                        <a class="link" <?php echo 'href="http://www.fandomdb.com/Production/viewArticle.php?title='.$three["title"].'&authorID='.$three["authorId"].'"';?>>Read More</a>
                    </div>
                    <!-- End Latest Products -->
                </div>
                <!--// end row -->
            </div>
    </body>
</html>
