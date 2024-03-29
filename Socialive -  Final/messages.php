<?php
    include "includes/header.php";
    $message_obj = new Message($con, $userLoggedIn);
    
    if(isset($_GET['u'])) {
        $user_to = $_GET['u'];
    } else {
        $user_to = $message_obj->getMostRecentUser();
        if($user_to == false) {
            $user_to = 'new';
        }
    }
    
    if($user_to != 'new') {
        $user_to_obj = new User($con, $user_to);
    }
    if(isset($_POST['post_message'])) {
        if(isset($_POST['message_body'])) {
            $body = mysqli_real_escape_string($con, $_POST['message_body']);
            $date = date("Y-m-d H:i:s");
            $message_obj->sendMessage($user_to, $body, $date);
        }
    }
?>
    <style>
        ::-webkit-scrollbar { 
            display: none; 
        }
    </style>
    
    <div class="user_details column">
        <a href="<?php echo $userLoggedIn ?>"><img src="<?php echo $user['profile_pic'] ?>"></a>
        <div class="user_details_left_right">
            <a href="<?php echo $userLoggedIn ?>" style="text-decoration: none;">
                <?php
                    echo $user['first_name'] . " " . $user['first_name'];
                    
                ?>
            </a>
            <?php echo "<br>Posts: " . $user['num_posts'] . "<br>"; ?>
            <?php echo "Likes: " . $user['num_likes']; ?>
        </div>
    </div>
    
    <div class="main-column column" id="main_column">
        <?php
            if($user_to != 'new') {
                echo "<h4>You and <a href='$user_to'>" . $user_to_obj->getFirstAndLastName() ."</a></h4><hr><br>";
                echo "<div class='loaded_messages' id='scroll_messages'>";
                    echo $message_obj->getMessages($user_to);
                    
                echo "</div>";
            } else {
                echo "<h4>New Message</h4>";
            }
        ?>
        
        <div class="message_post">
            <form action="" method="POST">
                <?php
                    if($user_to == 'new') {
                        echo "Select the friend you would like to message:<br><br>";
                ?> 
                        To: <input type='text' onkeyup='getUsers(this.value, "<?php echo $userLoggedIn; ?>")' name='q' placeholder='Name' autocomplete='off' id='search_text_input'><br><br>
                <?php
                        echo "<div class='results'></div>";
                    } else {
                        echo "<textarea name='message_body' id='message_textarea' placeholder='Write Your Message'></textarea>";
                        echo "<input type='submit' name='post_message' class='btn btn-primary' id='message_submit' value='Send!'>";
                    }
                ?>
            </form>
        </div>
        
        <script>
            var div = document.getElementById('scroll_messages');
            div.scrollTop = div.scrollHeight;
        </script>
    </div>
    
    <div class="user_details column" id="conversations">
        <h4>Conversations</h4><hr>
        <div class="loaded_conversations">
            <?php echo $message_obj->getConvos(); ?>
        </div>
        <br>
        <a href="messages.php?u=new">New Message</a>
    </div>