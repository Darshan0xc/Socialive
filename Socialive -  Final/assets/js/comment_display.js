// Transferred This Script From "comment_frame.php
// There was an error causing to return null instead of html element.
// So I have Transferred the Script From "comment_frame.php" to Here,
// so That Whenever The "post.php" Loads It Can Easily Find the iFrame
// and Can Set the "element" variable.

var element = document.getElementById("comment_section");
if(element.style.display == "block") {
    element.style.display = "none";
} else {
    element.style.display = "block";
}