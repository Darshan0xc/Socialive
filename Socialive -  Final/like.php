<!DOCTYPE html>
<html>
    <head>
        <title>Like</title>
        <style>
            * {
                font-family: "Noto Sans", sans-serif;
            }
            
            html {
                position: relative;
                top: 8px;
            }
        
            body {
                background-color: #fff!important;
            }
            
            form {
                position: absolute;
                top: 0;
            }
            
            /*Applying Styles to Mozilla Browsers */
            @-moz-document url-prefix() { 
                form {
                    position: relative;
                    top: 0px;
                }
            }
            
            .comment_like {
                font-family: "Noto Sans", sans-serif;
                background-color: transparent;
                color: #007bff;
                padding: 0;
                font-size: 15px;
                border: none;
                width: auto;
                height: auto;
            }
            
            .like_value {
                display: inline;
                font-size: 14px;
            }
            
        </style>
    </head>
    <body>
        <?php
            
            require 'config/config.php';
            include "includes/classes/User.php";
            include "includes/classes/Post.php";
            include "includes/classes/Notification.php";
            
            if(isset($_SESSION['username'])) {
                $userLoggedIn = $_SESSION['username'];
                $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username = '$userLoggedIn'");
                $user = mysqli_fetch_array($user_details_query);
            } else {
                header("Location: register.php");
            }
            
            // Get id of post
            if (isset($_GET['post_id'])) {
                $post_id = $_GET['post_id'];
            }
            $get_likes = mysqli_query($con, "SELECT likes, added_by FROM posts WHERE id='$post_id'");
            $row = mysqli_fetch_array($get_likes);
            $total_likes = $row['likes'];
            $user_liked = $row['added_by'];
            $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$user_liked'");
            $row = mysqli_fetch_array($user_details_query);
            $total_user_likes = $row['num_likes'];
            // Like Button
            if (isset($_POST['like_button'])) {
                $total_likes++;
                $query = mysqli_query($con, "UPDATE posts SET likes='$total_likes' WHERE id='$post_id'");
                $total_user_likes++;
                $user_likes = mysqli_query($con, "UPDATE users SET num_likes='$total_user_likes' WHERE username='$user_liked'");
                $insert_user = mysqli_query($con, "INSERT INTO likes VALUES('','$userLoggedIn','$post_id')");
                
                // Insert Notification
                if($user_liked != $userLoggedIn) {
                    $notification = new Notification($con, $userLoggedIn);
                    $notification->insertNotification($post_id, $user_liked, "like");
                }
            }
            // Unlike Button
            if (isset($_POST['unlike_button'])) {
                $total_likes--;
                $query = mysqli_query($con, "UPDATE posts SET likes='$total_likes' WHERE id='$post_id'");
                $total_user_likes--;
                $user_likes = mysqli_query($con, "UPDATE users SET num_likes='$total_user_likes' WHERE username='$user_liked'");
                $insert_user = mysqli_query($con, "DELETE FROM likes WHERE username='$userLoggedIn' AND post_id='$post_id'");
            }
            
            // Check for previous likes
            $check_query = mysqli_query($con, "SELECT * FROM likes WHERE username='$userLoggedIn' AND post_id='$post_id'");
            $num_rows = mysqli_num_rows($check_query);
            if ($num_rows > 0) {
                echo '<form action="like.php?post_id=' . $post_id . '" method="POST"><input type="submit" class="comment_like" name="unlike_button" value="Unlike"><div class="like_value">&nbsp;&nbsp;&nbsp;&nbsp;' . $total_likes . ' Likes</div></form>';
            } else {
                echo '<form action="like.php?post_id=' . $post_id . '" method="POST"><input type="submit" class="comment_like" name="like_button" value="Like"><div class="like_value">&nbsp;&nbsp;&nbsp;&nbsp;' . $total_likes . ' Likes</div></form>';
            }
        ?>
        
        
    </body>
</html>