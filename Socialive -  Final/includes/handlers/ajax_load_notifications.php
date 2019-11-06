<?php
    include "../../config/config.php";
    include "../classes/User.php";
    include "../classes/Notification.php";
    
    $limit = 6; //No. of Messages to Load
    $notification = new Notification($con, $_REQUEST['userLoggedIn']);
    echo $notification->getNotifications($_REQUEST, $limit);
?>