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

    if(empty($_POST['email']) || empty($_POST['password'])) {
        $error = "All fields are required to fill.";
    }


    if(empty($error)) {

        $data = $_POST;

        $query = "SELECT * FROM users where email = '".$data['email']."'";

        if($user = $conn->query($query)) {

            

            // while ($row = $user->fetch_assoc()) {
            //     printf ("%s (%s)\n", $row["id"], $row["email"]);
            // }

       }
    }
  }

  ?>
  <div class="container">
    <h3>Register</h3>
    <br />
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"] ?>" enctype="multipart/form-data">

  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp">
    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
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