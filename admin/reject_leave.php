<?php
require_once '../Database.php';

// Create a new instance of the Database class and establish connection
$database = new Database();
$conn = $database->getConnection();
$query = "update leaves set status = 'Rejected' where lid = $_GET[id]";
$query_run = mysqli_query($conn,$query);
if($query_run){
    echo "<script type='text/javascript'>
                alert('Leave successfully updates');
                window.location.href = 'admin_dashboard.php';
                </script>";
}
else{
    echo "<script type='text/javascript'>
                alert('Leave faild to work');
                window.location.href = 'admin_dashboard.php';
                </script>";
}
?>