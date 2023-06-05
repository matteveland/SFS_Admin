<?php
//include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Login-Logout/verifyLogin.php';
//check if user is logged in. if logged in allow access, otherwise return to login page
isUserLogged_in();
include ('/var/services/web/sfs/Application/data.env');


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Privacy Policy</title>
</head>
<body>

<h3 align="center">Privacy Policy</h3>

<p>Cookies are aused throughout the site. The purpose if to assist in identifying who you are. Here are a few examples of where cookies and the data
    associated with the cookie is used.
    <br>
    <ul>
    <li>Identifies individual's creating appointments. </b></li>
    <li>Identifies individual's uploading appointments to unit appointment section</b></li>
    <li>Identifies individual's who have deleted members of the unit.</b></li>
    </ul>

This systems identifies individuals who may add appointments to clutter the program; arbitrarily delete individuals from the database; or otherwise create errors within the site.

If a member is deleted from the database several things occur, the member who deletes the individual is logged and the individual who is subsequently deleted is modified, not deleted. This occurs to prevent being accidentally deleted.
If you do not agree to this and would like to be removed from the site, please contact the system admin for removal.

Trust me  I do not want your information. The site is designed to help in facilitating administrative functions within a unit. I have done my best to safeguard the information within the site.
However, no claims are made to guarantee the data from being breached or obtained. Information within the site is encrypted using open source programs. If you have questions or would like further information relating to the process for which the information is stored, please contact the system admin.


</p>

<p align="center"><b>Current as of 11 December 2018</b></p>
</body>
</html>
<?php include'/Applications/MAMP/htdocs/UnitTraining/footer.php';?>
