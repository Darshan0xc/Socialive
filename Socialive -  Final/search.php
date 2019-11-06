<?php
    include "includes/header.php";
    
    if(isset($_GET['q'])) {
        $query = $_GET['q'];
    } else {
        $query = "";
    }
    
    if(isset($_GET['type'])) {
        $type = $_GET['type'];
    } else {
        $type = "name";
    }
?>

<div class="main-column column" id="main_column">
    <?php
        if($query == "") {
            echo "You must enter something in searchbox to search";
        } else {
    
            //If Query Contains Underscore, That Means user is Searching For Usernames.
            if(type == "username") {
                $usersReturnedQuery = mysqli_query($con, "SELECT * FROM users WHERE username LIKE '$query%' AND user_closed='no'");
            } else {
                $names = explode(" ", $query);
                
                //If There are Two Words, Assume They are First and Last Name.
                if(count($names) == 3){
                    $usersReturnedQuery = mysqli_query($con, "SELECT * FROM users WHERE (first_name LIKE '$names[0]%' AND last_name LIKE '$names[2]%') AND user_closed='no'");
                }
                //If Query Has one Word Only, Search All First Names and Last Names...
                else if(count($names) == 2){
                    $usersReturnedQuery = mysqli_query($con, "SELECT * FROM users WHERE (first_name LIKE '$names[0]%' AND last_name LIKE '$names[1]%') AND user_closed='no'");
                } else {
                    $usersReturnedQuery = mysqli_query($con, "SELECT * FROM users WHERE (first_name LIKE '$names[0]%' OR last_name LIKE '$names[0]%') AND user_closed='no'");
                }
            }
        }
        
        //Check if results were found
        if(mysqli_num_rows($usersReturnedQuery) == 0) {
            echo "We Can't Find Anyone With a " . $type . " Like" . $query;
        } else {
            echo mysqli_num_rows($usersReturnedQuery) . " Results Found.<br><br>";
        }
        
        echo "<p id='grey'>Try Searching For:</p>";
        echo "<a href='search.php?q=" . $query . "&type=name'>Names</a>, <a href='search.php?q=" . $query . "&type=username'>Usernames</a><br><br><hr id='search_hr'>";
        
        while($row = mysqli_fetch_array($usersReturnedQuery)) {
            $user_obj = new User($con, $user['username']);
            
            $button = "";
            $mutual_friends = "";
            
            if($user['username'] != $row['username']) {
                
                //Generate Button Depending on Frinedship Status
                if($user_obj->isFriend($row['username'])) {
                    $button = "<input type='submit' name='" . $row['username'] . "' class='btn btn-danger' value='Remove Friend'>";
                } else if($user_obj->didReceiveRequest($row['username'])) {
                    $button = "<input type='submit' name='" . $row['username'] . "' class='btn btn-warning' value='Respond to Request'>";
                } else if($user_obj->didSendRequest($row['username'])) {
                    $button = "<input type='submit' name='" . $row['username'] . "' class='btn btn-default' value='Request Sent!'>";
                } else {
                    $button = "<input type='submit' name='" . $row['username'] . "' class='btn btn-success' value='Add Friend!'>";
                }
                
                $mutual_friends = $user_obj->getMutualFriends($row['username']) . " Friends in common";
                
                //Button Forms and Logic
                if(isset($_POST[$row['username']])) {
                    
                    if($user_obj->isFriend($row['username'])) {
                        $user_obj->removeFriend($row['username']);
                        header("Location: https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
                    } else if($user_obj->didReceiveRequest($row['username'])) {
                        header("Location: requests.php");
                    } else if($user_obj->didSendRequest($row['username'])) {
                        //Future Development
                    } else {
                        $user_obj->sendRequest($row['username']);
                        header("Location: https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
                    }
                    
                }
                
            }
            
            echo "<div class='search_result'>
                    <div class='searchPageFriendButtons'>
                        <form action='' method='POST'>
                            " . $button . "
                            <br>
                        </form>
                    </div>
                    
                    <div class='result_profile_pic'<
                        <a href='". $row['username'] ."'><img src='". $row['profile_pic'] ."' style='height:100px;'></a>
                    </div>
                    <a href='". $row['username'] ."'>" . $row['first_name'] . " " . $row['last_name'] . "
                        <p id='grey'>" . $row['username'] . "</p>
                    </a>
                    ". $mutual_friends ."<br>
                  </div>
                  <hr id='search_hr'>";
        }//End While Loop
    ?>
</div>