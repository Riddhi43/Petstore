<?php
include './inc/cu.common.php';
session_destroy();
header("location: index.php");
exit;
?>