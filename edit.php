<?php
    include "Components/_navbar.php";
?>

<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
        header("location:login.php");
    }
?>

<?php
    //database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "ecommerce";
    $conn = mysqli_connect($servername,$username,$password,$database);
    if(!$conn){
        die("Connection is not established".mysqli_connect_error());
    }else{
        if($_SERVER['REQUEST_METHOD']=='POST'){
            if(isset($_POST['mail']) && isset($_POST['pass'])){
                $mail = $_POST['mail'];
                $pass = $_POST['pass'];
                $oldmail = $_SESSION['mail'];
                $oldpass = $_SESSION["pass"];
                $query = "UPDATE `user_data` SET `user_mail`='$mail',`user_pass`='$pass' WHERE `user_mail`='$oldmail' and `user_pass`='$oldpass'";
                $result = mysqli_query($conn,$query);
                $_SESSION['mail'] = $mail;
                $_SESSION['pass'] = $pass;
                echo "<script>alert('User Information updated')</script>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .editcontainer{
            width:35%;
            display:block;
            margin:auto;
            border:8px solid;
            margin-top:40px;
            border-radius:15px;
            text-align:center;
        }
        form{
            display:flex;
            flex-direction:column;
            justify-content:center;
            align-items:center; 
            margin:20px;
        }
        input{
            width:300px;
            height:40px;
            border:2px solid;
            border-radius:8px;
            margin:10px;
            text-align:center;
            font-size:15px;
        }
    </style>
</head>
<body>
    <div class="editcontainer">
        <h1>Edit User Information</h1>
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
            <input type="email" name="mail" value="<?php echo $_SESSION['mail'] ?>">
            <input type="text" name="pass" value="<?php echo $_SESSION['pass'] ?>">
            <input type="submit" value="Save changes">
        </form>
    </div>
</body>
</html>