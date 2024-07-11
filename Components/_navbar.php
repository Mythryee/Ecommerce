<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Page</title>
    <style>
        body{
            margin:0;
            padding:0;
            background-color:#dde0f8;
        }
        #navbar{
            width:100%;
            top:0;
            position:sticky;
            background-color:#d042f8;
            color:white;
            display:flex;
            justify-content:center;
        }
        #navbar .navlist{
            display:flex;
            justify-content:space-evenly;
            width:700px;
            /* border:2px solid; */
        }
        #navbar .navlist li{
            list-style:none;
        }
        #navbar .navlist li a{
            text-decoration:none;
            color:white;
            font-size:25px;
            font-weight:bold;
        }
        #navbar .navlist li a:hover{
            text-decoration:underline;
        }
    </style>
</head>
<body>
    <nav id=navbar>
        <ul class="navlist">
            <li><a href="http://localhost/Ecommerce/home.php">Home</a></li>
            <li><a href="http://localhost/Ecommerce/edit.php">Edit</a></li>
            <li><a href="http://localhost/Ecommerce/login.php">Login</a></li>
            <li><a href="http://localhost/Ecommerce/signup.php">Signup</a></li>
            <li><a href="http://localhost/Ecommerce/logout.php">Logout</a></li>
        </ul>
    </nav>
</body>
</html>