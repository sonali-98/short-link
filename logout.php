<?php
// destrot session
session_start();
session_unset();
session_destroy();
// rediect to home page
header("location:index.php");
exit();
