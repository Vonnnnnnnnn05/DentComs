<?php 
$db_name = getenv('DB_NAME') ?: 'dentaflow';
$conn = @mysqli_connect('localhost', 'root', '', $db_name);
if (!$conn) {
    // Fallback to legacy database if dentaflow has not been imported yet
    $conn = mysqli_connect('localhost', 'root', '', 'dentcoms');
}
?>