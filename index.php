<?php
session_start();
   require_once("dbConn.php");
   require_once("mail.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    
  <?php 
 
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $error = ""; 

    if(empty($_POST['email']) || empty($_POST['password']) || empty($_FILES['image']['name'])) {
        $error = "All fields are required to fill.";
    }

    //User Already Exist query;


    if(empty($error)) {

        $data = $_POST;

        if(isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
            $data['image'] = $_FILES['image']['name']; 
            $uploads_dir = 'uploads'; 
            $tmp_name = $_FILES["image"]["tmp_name"]; 
            $name = $_FILES["image"]["name"];
            move_uploaded_file($tmp_name, "$uploads_dir/$name");
        }

        $query = "INSERT INTO users(name, email, password, image, hobbies) VALUES ('".$data['name']."', '".$data['email']."', '". password_hash($data['password'], PASSWORD_BCRYPT)."', '".$data['image']."', '". json_encode($data['hobbies'])."')";

        if($conn->query($query)) {

            $mail = new Mail(); 

            $otp = mt_rand(1000, 9999);

            $_SESSION['otp'] = $otp; 

            $endTime = strtotime("+1 minutes"); 

            $_SESSION['user_id'] = $conn->insert_id;

            $_SESSION['otp_valid'] = $endTime;

            $body = "<p>Your new OTP for new user registration - <b>$otp</b> </p>. This is valid for only 15 minutes.";

            $mail::sendMail($data['email'], $data['name'], "New User Registration - OTP", "shekharsajwan22@gmail.com", "WEBSITE", $body);

            header("Location: /core-php/validate-otp.php");
        }
    }
  }

  ?>
  <div class="container">
    <h3>Register</h3>
    <br />
    <form method="POST" action="index.php" enctype="multipart/form-data">

    <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Name</label>
    <input type="text" class="form-control" name="name" id="exampleInputEmail1" aria-describedby="emailHelp"> 
  </div>

  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp">
    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
  </div>

  <div class="mb-3">
  <label for="formFile" class="form-label">Image</label>
  <input class="form-control" type="file" name="image" id="formFile">
</div>

<div class="mb-3">
<label>Hobbies: </label>
<div class="form-check">
  <input class="form-check-input" type="checkbox" value="" name="hobbies[]" id="flexCheckDefault">
  <label class="form-check-label" for="flexCheckDefault">
    cricket
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="checkbox" value="" name="hobbies[]" id="flexCheckChecked" checked>
  <label class="form-check-label" for="flexCheckChecked">
    football
  </label>
</div>
</div>

  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" class="form-control" name="password" id="exampleInputPassword1">
  </div> 

  <?php if(!empty($error)) { ?>
     <p class="text text-danger font-bold">*<?php echo $error ?></p>
  <?php } ?>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>


<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>