<?php
    include "includes/header.php";
?>
<style>
    #accept-button,#ignore-button {
        width: 20%;
        border-radius: 5px;
        margin: 5px;
        border: none;
    }
    
</style>
<div class="main-column column" id="main-column">
    <h4>Friend Requests</h4>
    <?php
        $query = mysqli_query($con, "SELECT * FROM friend_requests WHERE user_to='$userLoggedIn'");
        
        if(mysqli_num_rows($query) == 0) {
            echo "You Have No Friend Requests at The Moment";
        } else {
            
            while($row = mysqli_fetch_array($query)) {
                $user_from = $row['user_from'];
                $user_from_obj = new User($con, $user_from);
                
                echo $user_from_obj->getFirstAndLastName() . " Sent You a Friend Request.";
                
                $user_from_friend_array = $user_from_obj->getFriendArray();
                
                if(isset($_POST['accept_request' . $user_from])) {
                    $add_friend_query = mysqli_query($con, "UPDATE users SET friend_array=CONCAT(friend_array,'$user_from,') WHERE username='$userLoggedIn'");
                    $add_friend_query = mysqli_query($con, "UPDATE users SET friend_array=CONCAT(friend_array,'$userLoggedIn,') WHERE username='$user_from'");
                    
                    $delete_query = mysqli_query($con, "DELETE FROM friend_requests WHERE user_to='$userLoggedIn' AND user_from='$user_from'");
                    echo "You Are Now Friends!";
                    header("Location: requests.php");
                }
                
                if(isset($_POST['ignore_request' . $user_from])) {
                    $delete_query = mysqli_query($con, "DELETE FROM friend_requests WHERE user_to='$userLoggedIn' AND user_from='$user_from'");
                    echo "Request Deleted!";
                    header("Location: requests.php");
                }
            ?>
            
                <form method="POST" action="requests.php">
                    <input type="submit" name="accept_request<?php echo $user_from; ?>" id="accept-button" class="btn btn-success" value="Accept"/>
                    <input type="submit" name="ignore_request<?php echo $user_from; ?>" id="ignore-button" class="btn btn-danger" value="Ignore"/>
                </form>
            <?php
            }
            
        }
    ?>
</div>