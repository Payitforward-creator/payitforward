<?php
session_start();
require('admin/db.php');
if (isset($_POST['submit-opportunity'])){
    $organization = mysqli_real_escape_string($conn, $_POST['organization']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $locations = mysqli_real_escape_string($conn, $_POST['locations']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $image = '';
    if (!empty($_FILES['image']['name'])){
        $image = uniqid().$_FILES['image']['name'];
        if (move_uploaded_file($_FILES['image']['tmp_name'], "./uploads/$image")){
        }else{
            $_SESSION['alert'] = 'Error uploading file';
            $_SESSION['alert-class'] = 'alert-danger';
            header("Location: send.php");
            exit;
        }
    }
    $sql = "INSERT INTO `opportunities` (`o_id`, `v_type`, `locations`, `dates`, `description`, `image`) VALUES('$organization', '$type', '$locations', '$date', '$description', '$image')";
    if ($conn->query($sql)){
        $_SESSION['alert'] = 'Opportunity submitted successfully.';
        $_SESSION['alert-class'] = 'alert-success';
    }else{
        $_SESSION['alert'] = 'Something went wrong';
        $_SESSION['alert-class'] = 'alert-danger';
    }
    header("Location: send.php");
    exit;
}
