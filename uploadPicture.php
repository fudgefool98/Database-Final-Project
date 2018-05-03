<?php
     require'db_credentials.php';
     require 'loggedInCheck.php';
        $link = new mysqli($servername, $username, $password, $dbname);  

    if($link -> connect_error) {
        die("Connection failed: " . $link->connect_error);
        return false;
    }
    $fandomQuery = "SELECT title FROM Fandom";
    $fandomResult = mysqli_query($link, $fandomQuery) or die (mysqli_error());
    $fandoms = array();
    //loop through list of fandoms and push to the fandoms array.
    while($row = mysqli_fetch_array($fandomResult, MYSQLI_NUM)){
        array_push($fandoms, $row);
    }
    //return the arraylist of fandoms
    $fandom = "";
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Upload A Picture</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <link rel="stylesheet" type="text/css" href="userPage.css">
        <link rel="stylesheet" type="text/css" href="navBar.css">
        <style>
       
        .fandomdb{
            height: 50px;
            width: 250px;
            padding-right: 10px;

        }
        .menuDiv{
            height: 55px;
        }
        .image{
            height: auto;
            width: auto;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        .text{
            text-align: center;
        }
        .title{
            font-size: 20px;
            width: 500px;
        }
        .centerTitle{
            text-align: center;
        }
        .words{
            font-size: 75px;
            text-align: center;
        }
        .button{
            text-align: center;
        }
       hr {
            display: block;
            height: 1px;
            border: 0;
            border-top: 1px solid black;
            margin: 1em 0;
            padding: 0; 
        }
        p{
            font-style: oblique;
            font-weight: bold;
            font-size: 15px;
        }
        .top{
            background-image: url(images/Collage.png);
            background-size: cover;
            height: 200px;
            background-repeat: no-repeat;
            padding: 10px;
            }
        .top h1{
            color: white;
            }
        div.transbox{
            background-color: #ffffff;
            opacity: 0.9;
            filter: alpha(opacity=60);
            width: 700px;
            margin: 0 auto;
            }
        
        div.transbox h1{
            margin: 5%;
            font-weight: bold;
            color: #000000;
        }
           div.transbox2{
        background-color: #ffffff;
        opacity: 0.9;
        filter: alpha(opacity=60);
        width: 430px;
        margin: 0 auto;
        padding: 1px 5px 15px 15px;
        }
        .shadow-textarea textarea.form-control::placeholder {
            font-weight: 300;
        }
            
        .shadow-textarea textarea.form-control {
            padding-left: 0.8rem;
        }
                
        .picture{
             width: 500px;
        }
            
        label{
            font-size: 16px;
        }
             .column {
            float: left;
            height: 250px;
        }
        .row:after {
            content: "";
            display: table;
            clear: both;
        }
        .left {
            padding: 40px 0 0 20px;
            width: 50%;
        }
        
        .right{
            padding: 0 0 0 120px;
            width: 50%   
        }
        .fandomTag {
             width: 400px;   
            }
        .newFan{
            width: 400px;
        }
        </style>
    </head>
    <body>
       <?php require 'navBar.php'?>
        
    <!--    the top picture and words-->
       <div class="top"> 
        <div class="transbox">
    <h1 class="words">Share a Drawing</h1>
        </div>
        </div>
        <hr>
        <form action="uploadPictureService.php" method="post" enctype="multipart/form-data">
            <div class="container">
                <?php
                if(isset($_SESSION['imageErrorMessage'])){
                    echo '<div class="alert alert-danger"><p>';
                    echo $_SESSION["imageErrorMessage"];
                    echo "</p></div>";
                    unset($_SESSION['imageErrorMessage']);
                }
                ?>
                          <div class="row">
<!--      the div with the Title textbox and upload video -->
                          <div class="column left">
                            <div>
                            <label for="title">Title</label><br>
                            <textarea class="form-control z-depth-1 title" name="title" id="title" rows="1" cols="45"></textarea>
                            <br><br>
                        </div>
                        <br>
                        <div>
                            
                            <div class="picture">

                                <label for="pictureUpload">Upload your drawing here!</label>
                            <input type="file" class="form-control" id="pictureUpload" name="photo">
                            </div>
                        </div>
                        </div>
                       
                        <br><br>
                              
                    <!--  the div for the fandom tag box-->
                        <div class="column right">
                           <div  class="transbox2 well">
                           <h2 class="button">Fandom Tag</h2> 
                                  <input type="radio" name="fandom" value="fandoms" id="check2">  
                               <label for="sel1">Select an already existing fandom:</label>
                                      <select name="oldFandom" class="form-control fandomTag" id="sel1">
                                        <?php 
                                          foreach($fandoms as $fandom): ?>
                                            <option value="<?php echo $fandom[0]; ?>"> <?php echo $fandom[0]; ?></option>
                                        <?php endforeach; ?>
                                      </select><br>
                               <!--new fandoms-->
                               <input type="radio" name="fandom" value="newFandom" id="check">
                               <label for="new">Create a new fandom:</label><br>
                               <input class="form-control z-depth-1 newFan" id="new" rows="1" cols="25" name="fandomName">
                           </div>   
                            
                        </div>
                </div>
                <!-- the div with the description text area-->
                       <div class="form-group shadow-textarea">
                        <label for="pictureDescription">Description of Drawing</label>
                        <textarea name="description" class="form-control z-depth-1" id="pictureDescription" rows="10" placeholder="Write something here..."></textarea>
                    </div>
                
                <!-- publish button-->
                        <div class="button">
                        <p>By hitting publish, you agree that your work is appropriate, professional, and orginal. Anything that goes against these standards will be taken down. Once posted you will not be able to make changes your article. PROOFREAD!</p>
                        <button class="btn btn-primary" type="submit">Publish</button>
                        <br><br><br>
                        </div>
                     </div>
<!--                     </div>-->
<!--
                    </div>
        </section>
-->
        </form>
    </body>
    
      <script>
        $(document). ready(function(){
            $('#sel1').click(function(){
                $('#check2').trigger('click');
            });
        });
        
        $(document). ready(function(){
            $('#new').click(function(){
                $('#check').trigger('click');
            });
        });
    
    </script>
</html>