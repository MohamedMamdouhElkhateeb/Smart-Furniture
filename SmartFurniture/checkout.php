<?php
session_start();

if (isset($_SESSION['email'])) {
    @include 'cofig.php';
    $customerEmail = $_SESSION['email'];
    $sql = "SELECT * from carte where cemail= '$customerEmail'";
    $result = sqlsrv_query($conn, $sql);
    if ($result === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if(sqlsrv_has_rows($result))
    {
        $clearCartSql = "DELETE FROM carte WHERE cemail = '$customerEmail'";
        $clearCartResult = sqlsrv_query($conn, $clearCartSql);
    
        if ($clearCartResult === false) {
            die(print_r(sqlsrv_errors(), true));
        }
    
        echo "Checkout successful!";
    }else 
    {
        echo "Your cart is empty.";
    }
} else {
    echo "Please log in to check out.";
}
?>
