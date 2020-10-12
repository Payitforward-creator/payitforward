<?php
session_start(); //We will start the PHP session with the function session_start()
require('admin/db.php'); //instead writing the username and password details in plain text in the PHP file,weve decided to place this sensitive information in a separate file, and use the PHP inbuilt statement require(). 
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = md5(mysqli_real_escape_string($conn, $_POST['password']));
    $res = $conn->query("SELECT * FROM `admin` WHERE email='$email' AND password='$password'");
    if ($res->num_rows > 0) {
        $user = $res->fetch_assoc();
        $_SESSION['admin'] = $user['id'];
        echo 1;
    } else {
        echo "Invalid email or password";
    }
    exit;
}

if (isset($_POST['action']) and $_POST['action'] == 'fetch-org') {
    $id = $_POST['id'];
    $res = $conn->query("SELECT * FROM organizations WHERE id='$id'");
    if ($res->num_rows > 0) {
        echo json_encode($res->fetch_assoc());
    } else {
        echo -1;
    }
    exit;
}

if (isset($_POST['action']) and $_POST['action'] == 'fetch-opp') {
    $id = $_POST['id'];
    $res = $conn->query("SELECT * FROM opportunities WHERE id='$id'");
    if ($res->num_rows > 0) {
        echo json_encode($res->fetch_assoc());
    } else {
        echo -1;
    }
    exit;
}

if (isset($_POST['action']) and $_POST['action'] == 'delete-org') {//We will use the “isset” function the variable to determine if it has been set or not. We will use the function on the $_POST array to determine if the variable was posted or not. *This is often applied to the submit button value, but can be applied to any variable.  
    $id = $_POST['id']; //PHP $_POST is a PHP super global variable which is used to collect form data after submitting an HTML form with method="post". The id variable will be available in the global $_POST and we will use it to identify to organization that needed to be deletd from the Database
    if($conn->query("DELETE FROM organizations WHERE id='$id'")){ //
        echo 1;
    } else {
        echo -1;
    }
    exit;
}

if (isset($_POST['action']) and $_POST['action'] == 'fetch-subs') {
    $id = $_POST['o_id'];
    if ($res = $conn->query("SELECT * FROM signups WHERE o_id='$id'")) {
        $subs = $res->fetch_all(MYSQLI_ASSOC);
        ?>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th class="text-center">Participants</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
            <?php if(count($subs) < 1): ?>
            <tr>
                <td class="text-center" colspan="3">
                    No submissions found!
                </td>
            </tr>
            <?php endif; ?>
            <?php foreach ($subs as $sub): ?>
                <tr>
                    <td><?= $sub['fname'].' '.$sub['lname'] ?></td>
                    <td class="text-center"><?= $sub['participants'] ?></td>
                    <td><?= $sub['email'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php } else {
        echo -1;
    }
    exit;
}


if (isset($_POST['signup'])) {
    $o_id = mysqli_real_escape_string($conn, $_POST['o_id']);
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $participants = mysqli_real_escape_string($conn, $_POST['participants']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $sql = "INSERT INTO `signups` (`o_id`, `fname`, `lname`, `participants`, `email`) VALUES('$o_id', '$fname', '$lname', '$participants', '$email')";
    if ($conn->query($sql)){
        echo 1;
    }else{
        echo 'Something went wrong';
    }
    exit;
}