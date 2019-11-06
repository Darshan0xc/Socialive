<?php
    include "includes/header.php";
    
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        $id = 0;
    }
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
    
    <div class="main-column column" id="main_column">
        <div class="posts_area">
            <?php
                $posts = new Post($con, $userLoggedIn);
                $posts->getSinglePost($id);
            ?>
        </div>
    </div>