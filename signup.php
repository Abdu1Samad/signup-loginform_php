<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- tittle  -->
    <title>Email-verification</title>

    <!-- my-css-file-link  -->
    <link rel="stylesheet" href="signup.css">

    <!-- php  -->

    <?php

    include "db.connection.php";

      if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $phone = $_POST['phonenumber'];
        $pass = $_POST['pass'];
        $C_pass = $_POST['C_pass'];

        $password = password_hash($pass,PASSWORD_BCRYPT);
        $Con_password = password_hash($C_pass,PASSWORD_BCRYPT);


        $token = bin2hex(random_bytes(15));

        $emailquery = "SELECT * FROM `register` where email = '$email'";
        $query = mysqli_query($Connection,$emailquery);

        $emailcount = mysqli_num_rows($query);
        if($emailcount>0){
            echo "Email is already exists";
        }
        else{
            if($pass === $C_pass){
               $insertquery =  "INSERT INTO `register`(username, email, phone, pass, C_pass, token, status) VALUES ('$username', '$email', '$phone', '$password', '$Con_password', '$token', 'Inactive')";

               $iquery = mysqli_query($Connection,$insertquery);
               if($iquery){

                $subject = "simple email verification test";
                $body =  "Hi, $username. Click here to activate your account 
                http://localhost/email-verification/account_activation.php?token=$token";
                $sender_email = "From: sammadaltaf43@gmail.com";

                if(mail("sammadaltaf43@gmail.com",$subject,$body,$sender_email)){
                    $session['msg'] = "check you mail to activate your account $email";
                    // session variable ki spelling galat hai: $_SESSION['msg'] hoga
                    header('location:login.php');
                }
                else{
                    echo "email send error";
                }
                   ?>
                    <script>
                        alert("Data inserted sucessfully");
                    </script>
                   <?php 

                }
               else{
                ?>
                <script>
                    alert("Data is not intersted");
                </script>
                <?php
               }
            }
              
             else{
                ?>
                <script>
                    alert("password are not matching")
                </script>
                <?php
            }
        }
      }
    ?>


</head>

<body>

    <div class="Register-container">
        <form action="" method="POST" class="form">
            <p class="title">Register </p>
            <p class="message">Signup now and get full access to our app. </p>
            <div class="flex">
                <label>
                    <input required="" placeholder="" type="text" class="input" name="username">
                    <span>Firstname</span>
                </label>    
            </div>

            <label>
                <input required="" placeholder="" type="email" class="input" name="email">
                <span>Email</span>
            </label>

            <label>
                <input required="" placeholder="" type="tel" class="input" name="phonenumber">
                <span>Phone number</span>
            </label>

            <label>
                <input required="" placeholder="" type="password" class="input" name="pass">
                <span>Password</span>
            </label>
            <label>
                <input required="" placeholder="" type="password" class="input" name="C_pass">
                <span>Confirm password</span>
            </label>
            <button class="submit" name="submit">Submit</button>
            <p class="signin">Already have an acount ? <a href="#">Signin</a> </p>
        </form>
    </div>

</body>

</html>