<?php
    include "includes/header.php";
    include "includes/form_handlers/settings_handler.php";
?>
<br>
<div class="user_details column">
    <a href="<?php echo $userLoggedIn ?>"><img src="<?php echo $user['profile_pic'] ?>"></a>
    <div class="user_details_left_right">
        <a href="<?php echo $userLoggedIn ?>" style="text-decoration: none;">
            <?php
                echo $user['first_name'] . " " . $user['last_name'];
                
            ?>
        </a>
        <?php echo "<br>Posts: " . $user['num_posts'] . "<br>"; ?>
        <?php echo "Likes: " . $user['num_likes']; ?>
    </div>
</div>

<div class="main-column column">
    
    <h4>Account Settings</h4>
    <?php
        echo "<img src='". $user['profile_pic'] ."' id='small_profile_pic'>";
    ?>
    <br>
    <a href="upload.php">Upload a new Profile Picture</a><br><br><br>
    
    <?php
        $user_data_query = mysqli_query($con, "SELECT first_name,last_name,email FROM users WHERE username='$userLoggedIn'");
        $row = mysqli_fetch_array($user_data_query);
        
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $email = $row['email'];
    ?>
    
    <strong>Modify the Values and Click 'Update Details'</strong><br><br>
    <form action="settings.php" method="POST">
        <span class="label_fix">First Name:</span> <input type="text" name="first_name" value="<?php echo $first_name; ?>" class="settings_input"><br>
        <span class="label_fix">Last Name:</span> <input type="text" name="last_name" value="<?php echo $last_name; ?>" class="settings_input"><br>
        <span class="label_fix">Email:</span> <input type="text" name="email" value="<?php echo $email; ?>" class="settings_input"><br>
        
        <?php echo $message; ?>
        <input type="submit" name="update_details" id="save_details" value="Update Details" class="btn btn-primary"><br>
    </form>
    <br>
    
    <h4>Change Password</h4>
    <form action="settings.php" method="POST">
        <span class="label_fix">Old Password:</span> <input type="password" name="old_password" class="settings_input"><br>
        <span class="label_fix">New Password:</span> <input type="password" name="new_password_1" class="settings_input"><br>
        <span class="label_fix">New Password Again:</span> <input type="password" name="new_password_2" class="settings_input"><br>
        
        <?php echo $password_message; ?>
        <input type="submit" name="update_password" id="save_details" value="Update Password" class="btn btn-primary"><br>
    </form>
    <br>
    
    <h4>Close Account</h4>
    <form action="settings.php" method="POST">
        <input type="submit" name="close_account" id="close_account" value="Close Account" class="btn btn-danger">
    </form>
</div>