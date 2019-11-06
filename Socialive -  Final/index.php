<?php
    include "includes/header.php";
    
    if(isset($_POST['post_thread'])) {
        
        $uploadOk = 1;
        $imageName = $_FILES['fileToUpload']['name'];
        $errorMessage = "";
        
        if($imageName != "") {
            $targetDir = "assets/images/posts/";
            $imageName = $targetDir . uniqid() . basename($imageName);
            $imageFileType = pathinfo($imageName, PATHINFO_EXTENSION);
            
            if($_FILES['fileToUpload']['size'] > 10000000) {
                $errorMessage = "Sorry Your File is Too Large!";
                $uploadOk = 0;
            }
            
            if(strtolower($imageFileType) != "jpeg" && strtolower($imageFileType) != "png" && strtolower($imageFileType) != "jpg") {
                $errorMessage = "Sorry. Only jpeg, png and jpg Files are Allowed";
                $uploadOk = 0;
            }
            
            if($uploadOk) {
                if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $imageName)) {
                    //image uploaded okay.
                } else {
                    //image did not uploaded
                    $uploadOk = 0;
                }
            }
        }
        
        if($uploadOk == 1) {
            $post = new Post($con, $userLoggedIn);
            $post->submitPost($_POST['post_text'], 'none', $imageName);
        } else {
            echo "<div style='text-align:center' class='alert alert-danger'>
                    $errorMessage
                </div>";
        }
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
            
            <div class="main-column column">
                
                <form class="post_form" method="post" action="index.php" enctype="multipart/form-data">
                    <textarea name="post_text" id="post_text" placeholder="Wanna say something?"></textarea>
                    <input type="submit" id="post_button" value="Post" name="post_thread"/>
                    <input type="file" name="fileToUpload" id="fileToUpload">
                    <hr>
                </form>
                
                <div class="posts_area"></div>
                <img src="assets/icons/loading.gif" id="loading">
            
            </div>
            
            <div class="user_details column">
                <h4>Popular on Socialive</h4>
                <hr>
                <div class="trends">
                    <?php
                        $query = mysqli_query($con, "SELECT * FROM trends ORDER BY hits LIMIT 9");
                        
                        foreach ($query as $row) {
                            
                            $word = $row['title'];
                            $word_dot = strlen($word) >= 14 ? "..." : "";
                            
                            $trimmed_word = str_split($word, 14);
                            $trimmed_word = $trimmed_word[0];
                            
                            echo "<div style='padding: 5px; float: left; display: inline-block;'>";
                            echo $trimmed_word . $word_dot;
                            echo "<br></div>";
                        }
                    ?>
                </div>
            </div>
            
            <script>
                var userLoggedIn = '<?php echo $userLoggedIn; ?>';
                
                $(document).ready(function () {
                    $('#loading').show();
            
                    //Original ajax request for loading first posts 
                    $.ajax({
                        url: "includes/handlers/ajax_load_posts.php",
                        type: "POST",
                        data: "page=1&userLoggedIn=" + userLoggedIn,
                        cache: false,
            
                        success: function (data) {
                            $('#loading').hide();
                            $('.posts_area').html(data);
                        }
                    });
                    
                    //--Changes--
                    $(window).scroll(function () {
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
                            param = Math.round(window.pageYOffset);
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
                                url: "includes/handlers/ajax_load_posts.php",
                                type: "POST",
                                async: false,//Change
                                data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
                                cache: false,
            
                                success: function (response) {
                                    $('.posts_area').find('.nextPage').remove(); //Removes current .nextpage 
                                    $('.posts_area').find('.noMorePosts').remove(); //Removes current .nextpage 
            
                                    $('#loading').hide();
                                    $('.posts_area').append(response);
                                }
                            });
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