<?php

require 'config/config.php';
include "includes/classes/User.php";
include "includes/classes/Post.php";
include "includes/classes/Message.php";
include "includes/classes/Notification.php";

if(isset($_SESSION['username'])) {
    $userLoggedIn = $_SESSION['username'];
    $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username = '$userLoggedIn'");
    $user = mysqli_fetch_array($user_details_query);
} else {
    header("Location: register.php");
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Home: Socialive</title>
        
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        
        <!-- CSS -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/jquery.Jcrop.css" type="text/css" />
        
        <!-- Javascript -->
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="assets/js/jquery.jcrop.js"></script>
	    <script src="assets/js/jcrop_bits.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="https://use.fontawesome.com/1d0bbb4074.js"></script><!--Font awesome script-->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
        <script type="text/javascript" src="assets/js/main.js"></script>
        
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Noto+Sans:400,400i,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
        
    </head>
    <body>
        <div class="top_bar">
            <div class="logo">
                <a href="index.php">Socialive</a>
            </div>
            
            <div class="search">
                <form action="search.php" method="GET" name="search_form">
                    <input type="text" onkeyup="getLiveSearchUsers(this.value, '<?php echo $userLoggedIn; ?>')" name="q" placeholder="Search" id="search_text_input" autocomplete="off">
                    <div class="button_holder">
                        <i class="fa fa-search fa-sm"></i>
                    </div>
                </form>
                
                <div class="search_results">
                    
                </div>
                
                <div class="search_results_footer_empty">
                    
                </div>
                
            </div>
            
            <nav>
                
                <?php
                    //Unread Messages
                    $messages = new Message($con, $userLoggedIn);
                    $num_messages = $messages->getUnreadNumber();
                    
                    //Unread Notifications
                    $notifications = new Notification($con, $userLoggedIn);
                    $num_notifications = $notifications->getUnreadNumber();
                    
                    //Friend Requests Notifications
                    $user_obj = new User($con, $userLoggedIn);
                    $num_requests = $user_obj->getNumberOfFriendRequests();
                ?>
                
                <a href="<?php echo $userLoggedIn ?>"><?php echo $user['first_name'] ?></a>
                <a href="index.php">
                    <i class="fa fa-home fa-lg"></i>
                </a>
                <a href="javascript:void(0);" onclick="getDropdownData('<?php echo $userLoggedIn; ?>', 'message')">
                    <i class="fa fa-envelope fa-lg"></i>
                    <?php
                        if($num_messages > 0) {
                            echo '<span class="notification-badge" id="unread_message">' . $num_messages . '</span>';
                        }
                    ?>
                </a>
                <a href="javascript:void(0);" onclick="getDropdownData('<?php echo $userLoggedIn; ?>', 'notification')">
                    <i class="fa fa-bell-o fa-lg"></i>
                    <?php
                        if($num_notifications > 0) {
                            echo '<span class="notification-badge" id="unread_notification">' . $num_notifications . '</span>';
                        }
                    ?>
                </a>
                <a href="requests.php">
                    <i class="fa fa-users fa-lg"></i>
                    <?php
                        if($num_requests > 0) {
                            echo '<span class="notification-badge" id="unread_requests">' . $num_requests . '</span>';
                        }
                    ?>
                </a>
                <a href="settings.php">
                    <i class="fa fa-gear fa-lg"></i>
                </a>
                <a href="includes/handlers/logout.php">
                    <i class="fa fa-sign-out fa-lg"></i>
                </a>
            </nav>
            
            <div class="dropdown_data_window" style="height: 0px;border: none;"></div>
            <input type="hidden" id="dropdown_data_type" value="">
        </div>
        
        <script>
            var userLoggedIn = '<?php echo $userLoggedIn; ?>';
            
            $(document).ready(function () {
        
                //--Changes--
                $('.dropdown_data_window').scroll(function () {
                    var inner_height = $('.dropdown_data_window').innerHeight(); //Div containing data
                    var scroll_top = $('.dropdown_data_window').scrollTop();
                    var page = $('.dropdown_data_window').find('.nextPageDropDownData').val();
                    var noMoreData = $('.dropdown_data_window').find('.noMoreDropDownData').val();
                    
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
                    
                    if ((scroll_top + inner_height >= $('.dropdown_data_window')[0].scrollHeight) && noMoreData === 'false') {
                        //alert("scrollHeight: " + document.body.scrollHeight);
                        var pageName; //This holds name of page to send ajax request to.
                        var type = $('#dropdown_data_type').val();
                        
                        if(type == 'notification') {
                            pageName = 'ajax_load_notifications.php';
                        } else if(type == 'message') {
                            pageName = 'ajax_load_messages.php';
                        }
                        console.log("header.php - page: " + page);
                        var ajaxReq = $.ajax({
                            url: "includes/handlers/" + pageName,
                            type: "POST",
                            data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
                            cache: false,
        
                            success: function (response) {
                                $('.dropdown_data_window').find('.nextPageDropDownData').remove(); //Removes current .nextpage 
                                $('.dropdown_data_window').find('.noMoreDropDownData').remove(); //Removes current .nextpage 
        
                                $('.dropdown_data_window').append(response);
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
        
        <div class="wrapper">
        