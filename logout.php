<?php
    // include "Components/_navbar.php";
    session_start();
    session_unset();
    session_destroy();
    header("location:login.php");
?>