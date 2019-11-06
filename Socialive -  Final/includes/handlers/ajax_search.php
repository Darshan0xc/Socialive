<?php
    include "../../config/config.php";
    include "../../includes/classes/User.php";
    
    $query = $_POST['query'];
    $userLoggedIn = $_POST['userLoggedIn'];
    
    $names = explode(" ", $query);
    
    //If Query Contains Underscore, That Means user is Searching For Usernames.
    if(strpos($query,"_") !== false) {
        $usersReturnedQuery = mysqli_query($con, "SELECT * FROM users WHERE username LIKE '$query%' AND user_closed='no' LIMIT 8");
    }
    //If There are Two Words, Assume They are First and Last Name.
    else if(count($names) == 2){
        $usersReturnedQuery = mysqli_query($con, "SELECT * FROM users WHERE (first_name LIKE '$names[0]%' AND last_name LIKE '$names[1]%') AND user_closed='no' LIMIT 8");
    }
    //If Query Has one Word Only, Search All First Names and Last Names...
    else {
        $usersReturnedQuery = mysqli_query($con, "SELECT * FROM users WHERE (first_name LIKE '$names[0]%' OR last_name LIKE '$names[0]%') AND user_closed='no' LIMIT 8");
    }
    
    if($query != "") {
        
        while($row = mysqli_fetch_array($usersReturnedQuery)) {
            $user = new User($con, $userLoggedIn);
            
            if($row['username'] != $userLoggedIn) {
                $mutual_friends = $user->getMutualFriends($row['username']) . " Friends in Common";
            } else {
                $mutual_friends = "";
            }
            
            echo "<div class='resultDisplay'>
                    <a href='" . $row['username'] . "' style='color: #1485BD'>
                        <div class='liveSearchProfilePic'>
                            <img src='". $row['profile_pic'] ."'>
                        </div>
                        <div class='liveSearchText'>
                            " . $row['first_name'] . " " . $row['last_name'] . "
                            <p>" . $row['username'] . "<br>
                            <span id='grey'>". $mutual_friends ."</p>
                        </div>
                    </a>
                  </div>";
        }
    }
?>