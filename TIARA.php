<?php 
//FIND THE ERROR
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
if(isset($_GET['title'])){
$_GET['title'] = $conn->real_escape_string($_GET['title']);    
$specificArticleSQL = 'SELECT title, authorID FROM Article WHERE fandom = "'.$_GET['title'].'"';
$clickableArticle = multipleResultQuery($conn,$specificArticleSQL);
$htmlList = '';
while ($row = $clickableArticle->fetch_row()) {
            $htmlList .= '<dt class="links"><a href="http://www.fandomdb.com/Production/viewArticle.php?title='.$row[0].'&authorID='.$row[1].'">'.$row[0].' </a></dt>';
        }
}
else{
    $specificArticleSQL = 'SELECT title, authorID FROM Article';
$clickableArticle = multipleResultQuery($conn,$specificArticleSQL);
$htmlList = '';
while ($row = $clickableArticle->fetch_row()) {
            $htmlList .= '<dt class="links"><a href="http://www.fandomdb.com/Production/viewArticle.php?title='.$row[0].'&authorID='.$row[1].'">'.$row[0].' </a></dt>';
        }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Artcles for the Fandom</title><!--    potentially change 'the Fandom" to the specific fandom name -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="navbar.css">
    
    <style>
    
        .fandomdb{
            height: 50px;
            width: 250px;
            padding-right: 10px;

        }
        span {
            font-size: 14px;
            font-weight: 400;
            color: #8860D0;
        }
        
        .pageContent{
            background-color: #C1C8EA;
        }
        h2{
            font-size: 50px;
            font-weight: bold;
            font-family: sans-serif;
            text-align: center;
        }
        .links{
            margin: 30px;
            float: left;
            height: 75px;
            width: 275px;
        }
        #myInput {
            background-image: url('/css/searchicon.png');
            background-position: 10px 12px;
            background-repeat: no-repeat;
            width: 50%;
            font-size: 16px;
            padding: 12px 20px 12px 40px;
            border: 1px solid #ddd;
/*            margin-bottom: 12px;*/
            margin-left: 40px; 
            margin-top: 20px;
        }

        #myUL {
          list-style-type: none;
          padding: 0;
          margin: 0;
        }

        #myUL li a {
          margin-top: -1px; /* Prevent double borders */
          padding: 12px;
          text-decoration: none;
          font-size: 18px;
          color: black;
          display: block;
        }

        #myUL li a:hover:not(.header) {
          color: #8860D0;
            font-size: 20pt;
            background-color: #C1C8E4;
            border-radius: 10px;
            border: 7px ridge #5AB9EA;
        }
        .fullFandomList{
            text-align: center;
        }
        .input{
            text-align: center;
        }
        #message{
            margin-top: 5px;
            text-align: center;
            font-size: 16pt;
            color: #5680E9;
        }
        


    </style>
    
</head>
<body class="pageContent">   
    <?php require 'navBar.php'?>
    <div class="fandoms">
            <h2><?php
                if(isset($_GET['title'])){
                echo $_GET['title'];
                }
                else{
                    echo 'All';
                }
            ?> Articles</h2>
        
        <div class="input">
            <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for fandoms..." title="Type in a name">
        </div>
        <div id="message">
            <p>Is your Fandom missing? Create A Post to Add it!</p>
        </div>
        <div class="fullFandomList">
            <ul id="myUL">
                <li> 
                    <?php echo $htmlList; ?> 
                </li>
            </ul>
        </div>      
    </div>
    
    <script>
        function myFunction() {
            var input, filter, ul, li, a, i;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            ul = document.getElementById("myUL");
            li = ul.getElementsByTagName("dt");
            for (i = 0; i < li.length; i++) {
                a = li[i].getElementsByTagName("a")[0];
                if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";
                }
            }
        }
    </script>
</body>
</html>
