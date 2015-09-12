<?php



$target_dir = "../imageUpload/uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$extension = pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION);
$uploadOk = 1;// verify if the boolean value for the upload is right(when it's equal to 1)
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
$user_id = $_SESSION["user_id"];

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . "."; // gives that is an image and its type(jpg,jpeg,etc)
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0; // set the boolean value of the upload to false/fail
    }
}
else{
	
	
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo '<script>
    alert("Sorry, your file is too large");
    </script>';
    $uploadOk = 0;
}

// Allow certain file formats
else if($extension != "jpg" && $extension != "png" && $extension != "JPG" && $extension != "gif" && $extension != "jpeg" && $extension != "JPEG" && $extension != "GIF") {
    //echo "Sorry, only JPG files are allowed.";
    $uploadOk = 0;
    echo '<script>
    alert("Only .jpg, .png, .gif and .jpeg images accepted");
    </script>';
}

// Check if $uploadOk is set to 0 by an error
else if ($uploadOk == 0) {
    echo '<script>
    alert("Your image was not uploaded");
    </script>';

// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir . $user_id . ".jpg")) {
        echo '<script>
    alert("Your image has been uploaded");
    	</script>';
    } else {

       echo '<script>
    alert("Sorry, there was an error uploading your file. Try again or choose a different file.");
    	</script>';
    	
    }
}

echo "<script>
	window.location.href='../general/index.php';
</script>";




?>