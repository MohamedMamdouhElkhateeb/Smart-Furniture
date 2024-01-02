<?php
@include 'cofig.php';

session_start(); 

if (isset($_POST['productId'])) {
    $productId = $_POST['productId'];
    settype($productId, 'integer');
    
    if (isset($_SESSION['email'])) {
        $customerEmail = $_SESSION['email'];

        $sql = "INSERT INTO carte (productid, cemail) VALUES ('$productId', '$customerEmail')";
        $result = sqlsrv_query($conn, $sql);

        if ($result === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        echo 'Product added successfully!';
    } else {
        echo 'please login!';
    }
} else {
    echo 'Invalid request!';
}
?>
