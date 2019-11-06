<?php
//Declaring Variables to prevent errors
    $fname = ""; //First name
    $lname = ""; //Last Name
    $email = ""; //Email
    $email2 = ""; //Confirm email
    $password = ""; //Password
    $password2 = ""; //Password2
    $date = ""; //Signup date
    $error_array = array(); //Error array
    
    if(isset($_POST['register_button'])) {
        
        //Registration form values
        //First name
        $fname = strip_tags($_POST['reg_fname']); //Remove HTML Tags.
        $fname = str_replace(' ', '', $fname); //Remove Spaces.
        $fname = ucfirst(strtolower($fname)); //Lowercase all characters, keeping First character capital.
        $_SESSION['reg_fname'] = $fname; //Stores first name into session
        
        //Last name
        $lname = strip_tags($_POST['reg_lname']); //Remove HTML Tags.
        $lname = str_replace(' ', '', $lname); //Remove Spaces.
        $lname = ucfirst(strtolower($lname)); //Lowercase all characters, keeping First character capital.
        $_SESSION['reg_lname'] = $lname; //Stores last name into session
        
        //Email
        $email = strip_tags($_POST['reg_email']); //Remove HTML Tags.
        $email = str_replace(' ', '', $email); //Remove Spaces.
        //$email = ucfirst(strtolower($email)); //Lowercase all characters, keeping First character capital.
        $_SESSION['reg_email'] = $email; //Stores email into session
        
        //Email Confirm
        $email2 = strip_tags($_POST['reg_email2']); //Remove HTML Tags.
        $email2 = str_replace(' ', '', $email2); //Remove Spaces.
        //$email2 = ucfirst(strtolower($email2)); //Lowercase all characters, keeping First character capital.
        $_SESSION['reg_email2'] = $email2; //Stores email2 into session
        
        //Password
        $password = strip_tags($_POST['reg_password']); //Remove HTML Tags.
        
        //Password Confirm
        $password2 = strip_tags($_POST['reg_password2']); //Remove HTML Tags.
        
        //Registration Date
        $date = date("Y-m-d"); //Get's current date.
        
        if($email == $email2) {
            //Check if email is in valid format
            if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $email = filter_var($email, FILTER_VALIDATE_EMAIL);
                
                //Check if email already exists
                $e_check = mysqli_query($con, "SELECT email FROM users WHERE email='$email'");
                
                //Count no. of rows returned
                $num_rows = mysqli_num_rows($e_check);
                
                if($num_rows > 0) {
                    array_push($error_array, "Email Already in Use.<br>");
                }
                
            } else {
                array_push($error_array, "Invalid Email Format.<br>");
            }
            
            
        } else {
            array_push($error_array, "Emails don't match.<br>");
        }
        
        if(strlen($fname) > 25 || strlen($fname) < 2) {
            array_push($error_array, "Your first name must be between 2 and 25 characters.<br>");
        }
        
        if(strlen($lname) > 25 || strlen($lname) < 2) {
            array_push($error_array, "Your last name must be between 2 and 25 characters.<br>");
        }
        
        if($password != $password2) {
            array_push($error_array, "Your passwords do not match.<br>");
        } else {
            if(strlen($password) > 30 || strlen($password) < 5) {
                array_push($error_array, "Your password must be between 5 and 30 characters.<br>");
            }
            
            if(preg_match('/[^A-Za-z0-9]/', $password)) {
                array_push($error_array, "Your password can only contain english characters or numbers.<br>");
            }
        }
        
        if(empty($error_array)) {
            $password = md5($password); //Encrypt the password before sending to database.
            
            //Generate Username by concatenating first name and last name
            $username = strtolower($fname."_".$lname);
            $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username = '$username'");
            
            $i = 0; 
            //if username exists add number to username
            while(mysqli_num_rows($check_username_query) != 0) {
                $i++; //Add one to i.
                $username = $username . "_" . $i;
                $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username = '$username'");
            }
            
            //profile picture assignment
            $rand = rand(1,2); //Random no between 1 and 2
            
            if($rand == 1) {
                $profile_pic = 'assets/images/profile_pics/defaults/head_deep_blue.png';
            } else if($rand == 2) {
                $profile_pic = 'assets/images/profile_pics/defaults/head_emerald.png';
            }
            
            $query = mysqli_query($con, "INSERT INTO users VALUES ('', '$fname', '$lname', '$username', '$email', '$password', '$date', '$profile_pic', '0', '0', 'no', ',')");
            
            array_push($error_array, "<span style=\"color: #14CB00;\">You're all set. Go ahead and Login.</span><br>");
        
            //Clear session variables
            $_SESSION['reg_fname'] = '';
            $_SESSION['reg_lname'] = '';
            $_SESSION['reg_email'] = '';
            $_SESSION['reg_email2'] = '';
        }
        
    }
?>