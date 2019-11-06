<?php
    
    require 'config/config.php';
    require 'includes/form_handlers/register_handler.php';
    require 'includes/form_handlers/login_handler.php';

?>

<!-- Documentation
1.  strip_tags()
    It will strip all the HTML Tags if Passed in the Form along with values. 
    It prevents XSS.

2.  ucfirst()
    It converts first character of string into uppercase.
    
3.  preg_match()
    Check string using regular expression.
-->

<!DOCTYPE html>
<html>
    <head>
        <title>Register: Socialive</title>
        <link rel="stylesheet" href="assets/css/register_style.css" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Noto+Sans:400,400i,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script type="text/javascript" src="assets/js/register.js"></script>
    </head>
    <body>
        
        <?php
        
            if(isset($_POST['register_button'])) {
                echo '
                    <script>
                        $(document).ready(function() {
                            $("#first").hide();
                            $("#second").show();
                        });
                    </script>
                ';
            }
        
        ?>
        
        <div class="wrapper">
            <div class="login_box">
                <div class="login-header">
                    <h1>Socialive</h1>
                    Login or signup below.
                </div>
                
                <div id="first">
                    <br>
                    <form action="register.php" method="post">
                        <input type="email" name="log_email" placeholder="Email Address" value="<?php if(isset($_SESSION['log_email'])) {
                            echo $_SESSION['log_email'];
                        } ?>" required/><br>
                        <input type="password" name="log_password" placeholder="Password" required/><br>
                        <?php
                            if(in_array("Wrong email or password.<br>", $error_array)) echo "Wrong email or password.<br>";
                        ?>
                        <input type="submit" value="Login" name="login_button"/><br><br>
                        <a href="#" id="signup" class="signup">Need an account? Register here!</a><br><br>
                    </form>
                </div>
                
                <div id="second">
                    <br>
                    <form action="register.php" method="post">
                        <input type="text" name="reg_fname" placeholder="First Name" value="<?php if(isset($_SESSION['reg_fname'])) {
                            echo $_SESSION['reg_fname'];
                        } ?>" required/>
                        <br>
                        <?php if(in_array("Your first name must be between 2 and 25 characters.<br>", $error_array)) echo "Your first name must be between 2 and 25 characters.<br>"; ?>
                        
                        <input type="text" name="reg_lname" placeholder="Last Name" value="<?php if(isset($_SESSION['reg_lname'])) {
                            echo $_SESSION['reg_lname'];
                        } ?>" required/>
                        <br>
                        <?php if(in_array("Your last name must be between 2 and 25 characters.<br>", $error_array)) echo "Your last name must be between 2 and 25 characters.<br>"; ?>
                        
                        <input type="email" name="reg_email" placeholder="Email Address" value="<?php if(isset($_SESSION['reg_email'])) {
                            echo $_SESSION['reg_email'];
                        } ?>" required/>
                        <br>
                        <input type="email" name="reg_email2" placeholder="Confirm Email" value="<?php if(isset($_SESSION['reg_email2'])) {
                            echo $_SESSION['reg_email2'];
                        } ?>" required/>
                        <br>
                        <?php if(in_array("Email Already in Use.<br>", $error_array)) echo "Email Already in Use.<br>"; 
                              else if(in_array("Invalid Email Format.<br>", $error_array)) echo "Invalid Email Format.<br>";
                              else if(in_array("Emails don't match.<br>", $error_array)) echo "Emails don't match.<br>"; 
                        ?>
                        
                        <input type="password" name="reg_password" placeholder="Password" required/>
                        <br>
                        <input type="password" name="reg_password2" placeholder="Confirm Password" required/>
                        <br>
                        <?php if(in_array("Your password must be between 5 and 30 characters.<br>", $error_array)) echo "Your password must be between 5 and 30 characters.<br>";
                              else if(in_array("Your password can only contain english characters or numbers.<br>", $error_array)) echo "Your password can only contain english characters or numbers.<br>";
                              else if(in_array("Your passwords do not match.<br>", $error_array)) echo "Your passwords do not match.<br>";
                        ?>
                        <input type="submit" value="Register" name="register_button"/>
                        <br><br>
                        <?php if(in_array("<span style=\"color: #14CB00;\">You're all set. Go ahead and Login.</span><br>", $error_array)) echo "<span style=\"color: #14CB00;\">You're all set. Go ahead and Login.</span><br>"; ?>
                        <a href="#" id="signin" class="signin">Already own an account? Login here!</a><br><br>
                    </div>
                </form>
            </div>    
        </div>
    </body>
</html>