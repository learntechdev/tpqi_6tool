<?php
session_start();
$_SESSION['username'] = 'JohnDoe'; // กำหนดค่าให้ session
echo $_SESSION['username']; // ใช้ session



//phpinfo();

?>