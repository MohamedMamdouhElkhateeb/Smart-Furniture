<?php
   @include 'cofig.php';
   
   session_start();
   if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $pass = md5($_POST['pass']);
    $sql = "SELECT * FROM customers WHERE email = '$email' AND password = '$pass'";
    $result = sqlsrv_query($conn, $sql);
   
    if ($result === false) {
        die(print_r(sqlsrv_errors(), true));
    }
     
    if(sqlsrv_has_rows($result)){
        while($row = sqlsrv_fetch_array($result)){
            $_SESSION['name'] = $row['Username'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['address'] = $row['address'];
            header("Location: home.php");
            
        }
    }else{
        echo "<script>alert('Invalid Email or Password!')</script>";
    }
    
}

   if(isset($_SESSION['email'])){
        $username = $_SESSION['name'];
      $_SESSION['name'] = $username;
        $_SESSION['hidden']='';
        $_SESSION['id']='';
        $_SESSION['btnhidden']='';
        
    }else{
        $_SESSION['id']='id="login-btn"';
        $_SESSION['name'] = '';
        $_SESSION['hidden']='display:none;"';
        $_SESSION['btnhidden']='none"';
    }

      
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


</head>

<body>
    <header class="header">

        <a href="home.php" class="logo"> <img width="206" height="50" src="image/Logo.png" class="" alt=""></a>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="cart-btn" class="fas fa-shopping-cart"></div>
            <div class="dropdown fas fa-user" <?php echo $_SESSION['id'] ?>>
            <button class="dropbtn" id="namebtn">

            </button>
            <script>
                    let username = <?php echo json_encode($_SESSION['name']); ?>;
                    let hidden = <?php echo json_encode($_SESSION['hidden']); ?>;
                    let btn = document.getElementById('namebtn');         
                    btn.style.display = hidden||"inline"  ;
                    btn.innerHTML = username;

                </script>
            <div class="dropdown-content" style=" margin-left: -10px;min-width: 110px;<?php echo $_SESSION['hidden'] ?>">
            <a href="logout.php">Log out <i class="fa-solid fa-right-from-bracket"></i></a>
            </div>
            </div>
        </div>

    </header>

    <div id="closer" class="fas fa-times"></div>

    <nav class="navbar">
        <a href="home.php">home</a>
        <a href="shop.php">shop</a>
        <a href="about.php">about</a>
        <a href="contact.php">contact</a>
    </nav>

    <div class="shopping-cart">
    <?php
   
    @include 'cofig.php';
    $total=0;
    if (isset($_SESSION['email'])) {
        $customerEmail = $_SESSION['email'];
        $sql = "SELECT * FROM products WHERE pid in (SELECT productid FROM carte WHERE cemail = '$customerEmail')";

        $result = sqlsrv_query($conn, $sql);

        if ($result === false) {
            die(print_r(sqlsrv_errors(), true));
        } 
        if (sqlsrv_has_rows($result)) {
            while ($row = sqlsrv_fetch_array($result)) {
                $productName = $row['pname'];
                $price = $row['pprice'];
                $pid = $row['pid'];
                $sqlq = "SELECT count(*) as quantity FROM carte WHERE productid = '$pid' AND cemail = '$customerEmail'";
                $resultq = sqlsrv_query($conn, $sqlq);
                if ($resultq === false) {
                    die(print_r(sqlsrv_errors(), true));
                }
                $rowq = sqlsrv_fetch_array($resultq);
                $quantity = $rowq['quantity'];
                $total += $price * $quantity;
            
                echo '<div class="box" data-product-id="'.$pid.'">';
                echo '<i class="fas fa-times"></i>';
                echo '<img src="image/product-'.$pid.'.jpg" alt="">';
                echo '<div class="content">';
                echo '<h3>'.$productName.'</h3>';
                echo '<span class="quantity">'.$quantity.'</span>';
                echo '<span class="multiply"> x </span>';
                echo '<span class="price">'.$price.'</span>';
                echo '</div>';
                echo '</div>';
            }
        } else {
           
            echo 'No products found in the cart.';
        }
               echo '<h3 class="total"> total : <span>'.$total.'</span> </h3>';
    }else {
           
            echo '<h2>Please log in to view the shopping cart.</h2>';
        }
    ?>



        <a href="#" class="btn btn-checkout">checkout cart</a>

</div>
        <script>
        $(document).ready(function() {
            
            $(document).on('click', '.box .fa-times', function(e) {
    e.stopPropagation();

    var productId = $(this).closest('.box').data('product-id');

    $.ajax({
        url: 'delete.php',
        type: 'POST',
        data: { productId: productId },
        success: function(response) {
            console.log(response);
            alert(response);
            location.reload();
        },
        error: function(xhr, status, error) {
            console.error('Error:', status, error);
        }
    });
});
             $('.btn-checkout').on('click', function() {
                $.ajax({
                    url: 'checkout.php',
                    type: 'POST',
                    success: function(response) {
                        alert(response);
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', status, error);
                    }
                });
            });
        });
        
        </script>


    <div class="login-form">

        <form action="" method ="post">
            <h3>login form</h3>
            <input type="email" placeholder="enter your email" name="email" class="box">
            <input type="password" placeholder="enter your password" name="pass" class="box">
            <div class="remember">
                <input type="checkbox" name="" id="remember-me">
                <label for="remember-me">remember me</label>
            </div>
            <input type="submit" name="submit" value="login now" class="btn">
            <p>forget password? <a href="#">click here</a></p>
            <p>don't have an account? <a href="create/loading.html">create now</a></p>
        </form>

    </div>
    
    <section class="home">
        <div class="slides-container">
            <div class="slide active">
                <div class="content">
                    <h3>WELCOME TO SMART FURNITURE</h3>
                    <p>Smart Furniture Will Help You Create The Most Comfortable And Cozy Living Space Through Innovative, Trendy And Well Designed Solutions With Highest European Quality Standards And Yet Affordable Prices.</p>
                    <a href="shop.php" class="btn">shop now</a>
                </div>
                <div class="image">
                    <img src="image/home-img-1.png" alt="">
                </div>
            </div>

          

    </section>

    <section class="banner-container">
        <div class="banner">
            <img src="image/banner-1.jpg" alt="">
            <div class="content">
                <span>limited offer</span>
                <h3>upto 50% off</h3>
                <a href="shop.php" class="btn">shop now</a>
            </div>
        </div>

        <div class="banner">
            <img src="image/banner-2.jpg" alt="">
            <div class="content">
                <span>limited offer</span>
                <h3>upto 50% off</h3>
                <a href="shop.php" class="btn">shop now</a>
            </div>
        </div>

        <div class="banner">
            <img src="image/banner-3.jpg" alt="">
            <div class="content">
                <span>limited offer</span>
                <h3>upto 50% off</h3>
                <a href="shop.php" class="btn">shop now</a>
            </div>
        </div>

    </section>
    


    <section class="footer">

        <div class="box-container">

            <div class="box">
                <h3>quick links</h3>
                <a href="home.php"> <i class="fas fa-arrow-right"></i> home</a>
                <a href="shop.php"> <i class="fas fa-arrow-right"></i> shop</a>
                <a href="about.php"> <i class="fas fa-arrow-right"></i> about</a>
                <a href="contact.php"> <i class="fas fa-arrow-right"></i> contact</a>
            </div>

            <div class="box">
                <h3>Follow Us On</h3>
            <a href="https://www.facebook.com/smartfurnitureeg1"> <i class="fab fa-facebook-f"></i> facebook</a>
            <a href="https://www.instagram.com/smartfurnitureonline/"> <i class="fab fa-instagram"></i> instagram</a>
            <a href="https://www.youtube.com/channel/UCOs2bJoQE-p44JYr29CxirA"> <i class="fab fa-youtube"></i> youtube</a>
            </div>
           

        </div>

    </section>

    <section class="credit">
        created by Mohamed Mamdouh Elkhateeb | all rights reserved!
    </section>
    <script src="script.js"></script>

</body>

</html>