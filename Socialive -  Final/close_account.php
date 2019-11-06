<?php
    include "includes/header.php";
    
    if(isset($_POST['cancel'])) {
        header("Location: settings.php");
    }
    
    if(isset($_POST['close_account'])) {
        $close_query = mysqli_query($con, "UPDATE users SET user_closed='yes' WHERE username='$userLoggedIn'");
        session_destroy();
        header("Location: register.php");
    }
?>

<div class="main-column column">
    
    <h4>Close Account</h4>
    Are You Sure You Want to Close Your Account?<br><br>
    Closing Your Account Will Hide Your Profile and All Your Activity From Other Users.<br><br> 
    You Can Re-open Your Account Anytime By Simply Logging in.<br><br>
    
    <form action="close_account.php" method="POST">
        <input type="submit" name="close_account" id="close_account" class="btn btn-danger" value="Yes, Close It">
        <input type="submit" name="cancel" id="update_details" class="btn btn-primary" value="No, No Way">
    </form>
    
</div>