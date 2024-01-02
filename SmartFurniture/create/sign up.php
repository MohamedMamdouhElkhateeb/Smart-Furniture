<?php
  @include '../cofig.php';
  session_start();
  if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $pass = md5($_POST['pass']);
    $cpass = md5($_POST['cpass']);
    if($pass == $cpass){
      $sql = "INSERT INTO customers (Username, email, address, password) VALUES ('$name', '$email', '$address', '$pass')";
      if(sqlsrv_query($conn, $sql)){
        echo "<script>alert('Account Created Successfully!')</script>";
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['address'] = $address;
        header("Location: ../home.php");
      }else{
        echo "<script>alert('Error!')</script>";
      }
    }else{
      echo "<script>alert('Password and Confirm Password does not match!')</script>";
    }
  } ?>
<!DOCTYPE html>
<html>
  <head>
    <title>Sign Up Page</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
  <div class="login-box">
    <form action="" method="post">
      <h1>Create Your Account</h1>
      <div class="user-box">
            <input type="text" placeholder="" name="name" required>
            <label>Name</label>
        </div>
      <div class="user-box t1">
            <input type="email" placeholder="" name="email" required>
            <label>Email</label>
        </div>
      <div class="user-box t2">
            <input type="text" placeholder="" name="address" required>
            <label>Address</label>
          </div>
        <div class="user-box t3" >
            <input type="password" placeholder="" name="pass" required>
            <label>Password</label>
        </div>
      <div class="user-box t4">
            <input type="password" placeholder="" name="cpass" required>
            <label>Confirm Password</label>
        </div>
      <input type="submit" name="submit" value="Send">
    </form>
</div>
  </body>
</html>