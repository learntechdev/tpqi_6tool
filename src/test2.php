<?php
session_start();
if (isset($_SESSION['username'])) {
    echo $_SESSION['username'];
} else {
    echo "Session 'username' ยังไม่มีค่า";
}
