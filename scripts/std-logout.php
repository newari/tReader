<?php
session_start();
session_destroy();
header("Location:../student-login.php");
exit();


?>