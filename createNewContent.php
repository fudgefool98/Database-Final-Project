<?php 
require 'loggedInCheck.php';
if(!isset($_SESSION['user'])){
    header('Location: signupPage.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Fandom DB Content Creation</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="navbar.css">
<style>
    
    body{
        background-color: #C1C8E4
    }
    .highlight{
    padding: 20px 0;
	text-align: center;
    background-color: #C1C8E4
}
.highlight > div > div{
	padding: 10px;
	border: 1px solid transparent;
	border-radius: 4px;
	transition: 0.2s;
    background-color: #C1C8E4
}
.highlight > div:hover > div{
	margin-top: -10px;
	border: 1px solid rgb(200, 200, 200);
	box-shadow: rgba(0, 0, 0, 0.1) 0px 5px 5px 2px;
	background: rgba(200, 200, 200, 0.1);
	transition: 0.5s;
}
.circle{
        height: 200px;
        width: 300px;    
}
.btn{
    background-color: #5680e9;
}
    .pic{
        height: 1000px;
        width: 1200px;
    }
/*navbar style*/
.fandomdb{
    height: 50px;
    width: 250px;
    padding-right: 10px;
    }
</style>

</head>

<body>
    <?php require 'navBar.php'?>
<div class="container">
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">

      <div class="item active">
        <img src="images/Article.png" alt="Article" class="pic">
        <div class="carousel-caption">
          <h1>Write an Article</h1>
          <h3>Write about your favorite fandoms here!</h3>
            <a href="http://www.fandomdb.com/Production/writeArticle.php" class="btn btn-primary" title="link">Start!</a>
        </div>
      </div>

      <div class="item">
        <img src="images/Camera.png" alt="Camera" class="pic" >
        <div class="carousel-caption">
          <h1>Upload a Video</h1>
          <h3>Upload footage about your favorite fandoms here!</h3>
            <a href="http://www.fandomdb.com/Production/shareVideo.php" class="btn btn-primary" title="link">Start!</a>
        </div>
      </div>
    
      <div class="item">
        <img src="images/Drawing.png" alt="Drawing" class="pic" >
        <div class="carousel-caption">
          <h1>Share a Drawing</h1>
          <h3>Share your art of your favorite fandoms here!</h3>
            <a href="http://www.fandomdb.com/Production/uploadPicture.php" class="btn btn-primary" title="link">Start!</a>
        </div>
      </div>
  
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>   
    
<!-- bottom half-->    
<div class="container">
	<div class="row highlight">
		<div class="col-md-4">
    		<div>
				<img src="images/Article.png" alt="Article" class="img-circle img-thumbnail circle">
				<h2>Write an Article</h2>
				<p>Show off your writing skills by sharing your fan-fictions, fan theories, and more!</p>
				<a href="http://www.fandomdb.com/Production/writeArticle.php" class="btn btn-primary" title="link">Start!</a>
			</div>
		</div>

		<div class="col-md-4">
			<div>
				<img src="images/Camera.png" alt="Video" class="img-circle img-thumbnail circle">
				<h2>Upload a Video</h2>
				<p>Show off your video skills by sharing your video re-enactments, reaction videos, and more!</p>
				<a href="http://www.fandomdb.com/Production/shareVideo.php" class="btn btn-primary" title="link">Start!</a>
			</div>
		</div>

		<div class="col-md-4">
			<div>
				<img src="images/Drawing.png" alt="Picture" class="img-circle img-thumbnail circle">
				<h2>Share a Drawing</h2>
				<p>Show off your artwork by sharing your fan drawings, comic strips, and more!</p>
				<a href="http://www.fandomdb.com/Production/uploadPicture.php" class="btn btn-primary" title="link">Start!</a>
			</div>
		</div>
	</div>
</div>
</body>
</html>