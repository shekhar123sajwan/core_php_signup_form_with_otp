<?php
   session_start();
   require_once("dbConn.php"); 
   if(empty($_SESSION['otp'])) {
    echo "NOt allowed"; die;
   }
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
//  echo $_SESSION['otp_valid'] < strtotime('now'). "VALID"; 

//  echo "<br>".time();  
//  echo "<br>". strtotime($_SESSION['otp_valid']); 

//  echo "<br>". strtotime('now'); 

 
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $error = "";   
    if($_SESSION['otp_valid'] <= strtotime('now')) {
        echo "<h2>OTP EXPIRED</h2>";
        $_SESSION['otp'] = "";
        echo "<script>window.location.href='/core-php/index.php'";
        die;
    } 
    
 

    if(empty($_POST['otp'])) { 
        $error = "Please input valid otp";
    }

    if($_SESSION['otp'] != $_POST['otp']) {
        $error = "Please input valid otp, OTP NOT match.";
    }

    if(empty($error)) {

        try {
            $query = "UPDATE users SET is_verified_user = 1 WHERE id = ". $_SESSION['user_id']. "";

            $conn->query($query);

            $success = 1;
            $_SESSION['otp'] = "";

        }catch(Exception $e) {
            echo $e->getMessage();
        }

    }
  }

  ?>
  <div class="container">

    <?php if(!empty($success) && $success) { ?>
        <h2 class="alert alert-success font-bold">* OTP Verified. Please Login <a href="/core-php/login.php">Login</a></h2>
    <?php } else { ?>

    <h3>OTP VERIFICATION</h3>
    <br />
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">

    <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">OTP</label>
    <input type="text" class="form-control" name="otp" id="exampleInputEmail1" aria-describedby="emailHelp" required> 
  </div>
 
  <?php if(!empty($error)) { ?>
     <p class="alert alert-danger font-bold">*<?php echo $error ?></p>
  <?php } ?>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
<?php } ?>
</div>


<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>