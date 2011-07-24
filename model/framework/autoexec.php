<?php
if (!isset($_SESSION['clientIP'])) {
    $_SESSION['clientIP'] = $_SERVER['REMOTE_ADDR'];
}
?>
