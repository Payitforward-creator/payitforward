<?php
    session_start();
    require('db.php');
if (isset($_POST['add-organization'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $file = '';
    if (!empty($_FILES['image']['name'])){
        $file = uniqid().$_FILES['image']['name'];
        if (move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/$file")){
        }else{
            $_SESSION['alert'] = 'Error uploading file';
            $_SESSION['alert-class'] = 'alert-danger';
            header("Location: index.php");
            exit;
        }
    }
    $sql = "INSERT INTO organizations (name, email, description, file) VALUES('$name', '$email', '$description', '$file')";
    if ($conn->query($sql)){
        $_SESSION['alert'] = 'Organization added successfully.';
        $_SESSION['alert-class'] = 'alert-success';
    }else{
        $_SESSION['alert'] = 'Something went wrong';
        $_SESSION['alert-class'] = 'alert-danger';
    }
    header("Location: index.php");
    exit;
}

if (isset($_POST['upd-organization'])){
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $file = '';
    if (!empty($_FILES['image']['name'])){
        $file = uniqid().$_FILES['image']['name'];
        if (move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/$file")){
        }else{
            $_SESSION['alert'] = 'Error uploading file';
            $_SESSION['alert-class'] = 'alert-danger';
            header("Location: index.php");
            exit;
        }
    }
    if ($file == ''){
        $sql = "UPDATE organizations SET name='$name', email='$email', description='$description' WHERE id='$id'";
    }else{
        $sql = "UPDATE organizations SET name='$name', email='$email', description='$description', file='$file' WHERE id='$id'";
    }
    if ($conn->query($sql)){
        $_SESSION['alert'] = 'Organization updated successfully.';
        $_SESSION['alert-class'] = 'alert-success';
    }else{
        $_SESSION['alert'] = 'Something went wrong';
        $_SESSION['alert-class'] = 'alert-danger';
    }
    header("Location: index.php");
    exit;
}


if (isset($_POST['update-opportunity'])){
    $organization = mysqli_real_escape_string($conn, $_POST['organization']);
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $locations = mysqli_real_escape_string($conn, $_POST['location']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $image = '';
    if (!empty($_FILES['image']['name'])){
        $image = uniqid().$_FILES['image']['name'];
        if (move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/$image")){
        }else{
            $_SESSION['alert'] = 'Error uploading file';
            $_SESSION['alert-class'] = 'alert-danger';
            header("Location: requests.php");
            exit;
        }
    }
    if ($image == ''){
        $sql = "UPDATE `opportunities` SET `o_id`='$organization', `v_type`='$type', `locations`='$locations', `dates`='$date', `description`='$description' WHERE id='$id'";
    }else{
        $sql = "UPDATE `opportunities` SET `o_id`='$organization', `v_type`='$type', `locations`='$locations', `dates`='$date', `description`='$description', `image`='$image' WHERE id='$id'";
    }
    if ($conn->query($sql)){
        $_SESSION['alert'] = 'Opportunity updated successfully.';
        $_SESSION['alert-class'] = 'alert-success';
    }else{
        $_SESSION['alert'] = 'Something went wrong';
        $_SESSION['alert-class'] = 'alert-danger';
    }
    header("Location: requests.php");
    exit;
}
