<?php
include 'cofig.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['productId'])) {
        $productId = $_POST['productId'];
        $customerEmail = $_SESSION['email'];
    
        $sql = "DELETE FROM carte WHERE productid = '$productId' AND cemail = '$customerEmail'";
        $result = sqlsrv_query($conn, $sql);

        if ($result === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        echo "Product deleted successfully";
    } else {
        echo "Invalid product ID";
    }
} else {
    echo "Invalid request method";
}
?>
