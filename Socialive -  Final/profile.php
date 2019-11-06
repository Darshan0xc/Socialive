<link rel="stylesheet" href="assets/css/style.css">
<?php
    include "includes/header.php";
    
    if(isset($_GET['profile_username'])) {
        $username = $_GET['profile_username'];
        $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
        $user_array = mysqli_fetch_array($user_details_query);
        
        $num_friends = (substr_count($user_array['friend_array'], ",")) - 1;
    }
    
    if(isset($_POST['remove_friend'])) {
        $user = new User($con, $userLoggedIn);
        $user->removeFriend($username);
    }
    
    if(isset($_POST['add_friend'])) {
        $user = new User($con, $userLoggedIn);
        $user->sendRequest($username);
    }
    
    if(isset($_POST['respond_request'])) {
        header("Location: requests.php");
    }
    
    $message_obj = new Message($con, $userLoggedIn);
    
    if(isset($_POST['post_message'])) {
        if(isset($_POST['message_body'])) {
            $body = mysqli_real_escape_string($con, $_POST['message_body']);
            $date = date('Y-m-d H:i:s');
            $message_obj->sendMessage($username, $body, $date);
        }
        $link = '#profileTabs a[href="#messages_div"]';
        echo "<script>
                $(function() {
                    $('" . $link . "').tab('show');
                    $('html, body').animate({ scrollTop: $(document).height() }, 'slow');
                });
              </script>";
    }
    
?>
        <style type="text/css">
            .wrapper {
                margin-left: 0;
                padding-left: 0;
            }
            
            textarea {
                overflow:hidden;
                outline: none;
            }
            .button_holder i {
                margin-top: 3px;
            }
        </style>
            <div class="profile_left" style="height: 100%;">
                <img src="<?php echo $user_array['profile_pic'] ?>" alt="User Pic">
                <div class="profile_info">
                    <p><?php echo "Posts: " . $user_array['num_posts']; ?></p>
                    <p><?php echo "Likes: " . $user_array['num_likes']; ?></p>
                    <p><?php echo "Friends: " . $num_friends; ?></p>
                </div>
                
                <form action="<?php echo $username; ?>" method="POST">
                    <?php
                        $profile_user_obj = new User($con, $username);
                        if($profile_user_obj->isClosed()) {
                            header("Location: user_closed.php");
                        }
                        
                        $logged_in_user_obj = new User($con, $userLoggedIn);
                        
                        if($userLoggedIn != $username) {
                            
                            if($logged_in_user_obj->isFriend($username)) {
                                echo '<input type="submit" name="remove_friend" class="btn btn-danger" value="Unfriend"><br>';
                            } else if($logged_in_user_obj->didReceiveRequest($username)) {
                                echo '<input type="submit" name="respond_request" class="btn btn-warning" value="Accept Request"><br>';
                            } else if($logged_in_user_obj->didSendRequest($username)) {
                                echo '<input type="submit" name="" class="btn btn-default" value="Request Sent!">';
                            } else {
                                echo '<input type="submit" name="add_friend" class="btn btn-success" value="Add Friend!" style="background-color: #2ECC71;"><br>';
                            }
                            
                        }
                        
                    ?>
                </form>
                <input type="submit" class="btn btn-primary" style="padding: 7px;" style="padding: 5px;" data-toggle="modal" data-target="#post_form" value="Post Something!">
                
                <?php
                    if($userLoggedIn != $username) {
                        echo '<div class="profile_info_bottom">';
                        echo $logged_in_user_obj->getMutualFriends($username) . " Mutual Friends";
                        echo '</div>';
                    }
                ?>
            
            </div>
            <div class="profile-main-column column">
                <h1 class="display-4">Posts</h1><br>
                <ul class="nav nav-tabs" role="tablist" id="profiletabs" >
                    <li role="presentation" class="nav-item active">
                        <a href="#newsfeed_div" aria-controls="newsfeed_div" role="tab" data-toggle="tab" class="nav-link active">Newsfeed</a>
                    </li>
                    <li role="presentation" class="nav-item">
                        <a href="#messages_div" aria-controls="messages_div" role="tab" data-toggle="tab" class="nav-link show-not">Messages</a>
                    </li>
                </ul>
                
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade show active" id="newsfeed_div">
                        <br>
                        <div class="posts_area"></div>
                        <img id="loading" src="assets/icons/loading.gif">
                    </div>
                    
                    <!-- Extra Part -->
                    <style>::-webkit-scrollbar{display: none;} .loaded_messages{border: 1px solid #d3d3d3; border-radius: 5px; padding: 15px;}</style>
                    <?php
                        if($username == $userLoggedIn) {
                            echo "<script>
                                    var element = document.getElementsByClassName('show-not');
                                    //element[0].setAttribute('class', 'nav-link disabled');
                                    $('.show-not').remove();
                                </script>";
                            //Above Script Removes 'messages' tab from nav-tabs When username and userLoggedIn.
                            //Will be Same. Because User Shouldn't Be Allowed To send Message to Themselves.
                        }
                    ?>
                    <!-- Extra Part -->
                    
                    <div role="tabpanel" class="tab-pane fade" id="messages_div">
                        <br>
                        <?php
                                echo "<h4>You and <a href='" . $username . "'>" . $profile_user_obj->getFirstAndLastName() ."</a></h4><hr><br>";
                                echo "<div class='loaded_messages' id='scroll_messages'>";
                                    echo $message_obj->getMessages($username);
                                    
                                echo "</div>";
                        ?>
                        
                        <div class="message_post">
                            <form action="" method="POST">
                                    <textarea name='message_body' id='message_textarea' placeholder='Write Your Message' autofocus></textarea>
                                    <input type='submit' name='post_message' class='btn btn-primary' id='message_submit' value='Send!'>
                            </form>
                        </div>
                        
                        <script>
                            var div = document.getElementById('scroll_messages');
                            div.scrollTop = div.scrollHeight;
                        </script>
                    </div>
                </div>
                
            </div>
            
            <!-- Modal -->
            <div class="modal fade" id="post_form" tabindex="-1" role="dialog" aria-labelledby="postModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Post Something!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <p>This will appear on user's profile page and also on their news feed for your friends to see.</p>
                    
                    <form class="profile_post" method="POST" action="">
                        <div class="form-group">
                            <textarea class="form-control" name="post_body"></textarea>
                            <input type="hidden" name="user_from" value="<?php echo $userLoggedIn; ?>">
                            <input type="hidden" name="user_to" value="<?php echo $_GET['profile_username']; ?>">
                        </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" name="post_button" id="submit_profile_post">Post</button>
                  </div>
                </div>
              </div>
            </div>
            
            <script>
                var userLoggedIn = '<?php echo $userLoggedIn; ?>';
                var profileUsername = '<?php echo $username; ?>';
            
                $(document).ready(function () {
                    $('#loading').show();
            
                    //Original ajax request for loading first posts 
                    $.ajax({
                        url: "includes/handlers/ajax_load_profile_posts.php",
                        type: "POST",
                        data: "page=1&userLoggedIn=" + userLoggedIn + "&profileUsername=" + profileUsername,
                        cache: false,
            
                        success: function(data) {
                            $('#loading').hide();
                            $('.posts_area').html(data);
                        }
                    });
                    
            
                    var ajaxRunning = false;
                    //AJAX Call Handler Variable. If true Call is in progress
                    //if false, no AJAX Calls are Running. Call the AJAX.
                    $(window).scroll(function() {
                        if(ajaxRunning == false) {
                            ajaxRunning = true;
                        }
                        var height = $('.posts_area').height(); //Div containing posts
                        var scroll_top = $(this).scrollTop();
                        var page = $('.posts_area').find('.nextPage').val();
                        var noMorePosts = $('.posts_area').find('.noMorePosts').val();
                        
                        // console.log("====================================");
                        // console.log("Height: " + height);
                        // console.log("Scroll_top: " + scroll_top);
                        // console.log("Page: " + page);
                        // console.log("noMorePosts: " + noMorePosts);
                        // console.log("scrollHeight: " + document.body.scrollHeight);
                        // console.log("scrollTop: " + document.body.scrollTop);
                        // console.log("window.innerHeight: " + window.innerHeight);
                        // console.log("====================================");
                        
                        //Option - 1 : Working For Firefox With Small Height Screen
                        //var param = (document.documentElement || document.body.parentNode || document.body).scrollTop;
                        
                        //Option - 2 : Working For Edge and Chrome. - Use This if none works.
                        // var param = Math.round(window.pageYOffset);
                        
                        //Option - 3: Trying - Working For Both Chrome and Firefox(Only Small Screen)
                        // var param = Math.round($('html:not(:animated),body:not(:animated)').scrollTop());
                        
                        //Option - 4: Trying - 
                        var param = Math.round(window.pageYOffset);
                        var browser;
                        //Elements and Their Working in Browsers
                        //document.body.scrollTop :- Edge(F.S.)
                        //document.documentElement.scrollTop :- Chrome, Firefox(Small Screen)
                        //window.pageYOffset :- Working in Chrome, Edge, Firefox(Small Screen) - Final
                        if(navigator.userAgent.search("Chrome") >= 0) {
                            param = Math.round(window.pageYOffset)+1;
                            browser = "Chrome";
                        } else {
                            param = Math.round(window.pageYOffset)+1;
                            browser = "Firefox or Edge";
                        }
                        
                        //Testing Area
                        // console.log("====================================");
                        // console.log(param + window.innerHeight);
                        // console.log("Browser: " + browser);
                        // console.log("====================================");
                        
                        if ((document.body.scrollHeight == param + window.innerHeight) && noMorePosts === 'false') {
                            //alert("scrollHeight: " + document.body.scrollHeight);
                            $('#loading').show();
            
                            var ajaxReq = $.ajax({
                                url: "includes/handlers/ajax_load_profile_posts.php",
                                type: "POST",
                                async: false,//Async off
                                data: "page=" + page + "&userLoggedIn=" + userLoggedIn + "&profileUsername=" + profileUsername,
                                cache: false,
            
                                success: function(response) {
                                    $('.posts_area').find('.nextPage').remove(); //Removes current .nextpage 
                                    $('.posts_area').find('.noMorePosts').remove(); //Removes current .nextpage 
            
                                    $('#loading').hide();
                                    $('.posts_area').append(response);
                                    ajaxRunning = false;
                                }
                            });
                            ajaxRunning = false;
                            if(browser == "Firefox or Edge") {
                                param = 0;
                            }
            
                        } //End if 
                        return false;
                    }); //End (window).scroll(function())
                });
            
            </script>
        </div>
    </body>
</html>