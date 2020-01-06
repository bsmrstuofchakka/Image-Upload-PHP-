<!--for checking admin validation-->
<?php
	session_start();
	if (!isset($_SESSION['id'])) {
		header("location:index.php");
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Add About Me</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>
<?php
	#to add navbar from class/navbar.php
	include("class/navbar.php");
?>
<div class="container">
	<!--to add about me-->
	<form action="add_blog_content.php" enctype="multipart/form-data" method="post">
		<div class="form-group">
		  	<label>HEADLINE:</label>
		  	<input type="text" name="headline" class="form-control">
		</div>
		<div class="form-group">
			  <label>DESCRIPTION:</label>
			  <textarea name="description" class="form-control" rows="5" id="comment"></textarea>
		</div>
		<div class="form-group">
		  	<label>DATE:</label>
		  	<input name="date" type="text" class="form-control">
		</div>
		
		<div class="form-group">
		  	<label>ATTACH IMAGE:</label>
		  	<input name="image" type="file" class="form-control">
		</div>
		<input type="submit" class="btn-success" name="add_blog_content">
	</form>
</div>
</body>
</html>
<?php
	#to insert or update value on database
	if (isset($_POST['add_blog_content'])) {
		$headline=$_POST['headline'];
		$description=$_POST['description'];
		$date_u=$_POST['date'];
		
		include 'class/connection.php';
		$image=$_FILES['image'];
		$image_dir="pictures/";
		$target_file=$image_dir.basename($_FILES['image']['name']);
		$file_type=pathinfo($target_file,PATHINFO_EXTENSION);
		if ($file_type == "JPEG" ||$file_type == "jpeg" || $file_type== "png" || $file_type=="jpg" ||$file_type == "JPG" || $file_type=="PNG") {
			if (file_exists($target_file)) {
				echo "<script>alert('Image already exists BOSS!!');location.href='add_blog_content.php';</script>";
			}
			else
			{
				
				//for upload new blog content
				$query="INSERT into blog (headline,description,date,image) values('$headline','$description','$date_u','$target_file')";
				if (mysqli_query($conn,$query)) {
					move_uploaded_file($_FILES['image']['tmp_name'], $target_file);

					echo "<script>alert('Successfully inserted your blog content');location.href='add_blog_content.php';</script>";
				}
				else{
					echo "<script>alert('Problem ase BOSS!!');location.href='add_blog_content.php';</script>";
				}
			}
		}
		else{
			echo "<script>alert('Problem ase BOSS!! File type is not correct!!');location.href='add_blog_content.php';</script>";
		}
	}
?>