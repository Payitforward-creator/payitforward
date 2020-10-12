<?php
session_start();
require('db.php');
if (isset($_SESSION['admin'])) {
    $admin = 'Admin';
}else{
    header("Location: ../index.php");
    exit;
}
if (isset($_POST['search'])){
    $q = $_POST['q'];
    $organizations = $conn->query("SELECT * FROM `organizations` WHERE `name` LIKE '%$q%'")->fetch_all(MYSQLI_ASSOC);
}else{
    $organizations = $conn->query("SELECT * FROM `organizations`")->fetch_all(MYSQLI_ASSOC);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
          integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
          crossorigin="anonymous"/>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>Pay it forward</title>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-light bg-light py-0">
    <!--    <a class="navbar-brand" href="#"><i class="fas fa-globe"></i> Pay it forward</a>-->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
            aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="../index.php" class="nav-link"><i class="fa fa-home text-dark fa-lg"></i></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Manage Organizations</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="requests.php">Manage Requests</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="#">Welcome (Admin)</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../">Main Site</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php"><i class="fa fa-sign-out-alt"></i></a>
            </li>
        </ul>
    </div>
</nav>

<main role="main" class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="py-5">
                <h4 class="mb-3">Seach for Organization</h4>
                <form class="form-inline" method="POST">
                    <div class="input-group mb-3">
                        <input type="search" class="form-control" placeholder="Search.." name="q" value="<?= isset($_POST['q'])?$_POST['q']:'' ?>" required>
                        <div class="input-group-append">
                            <button type="submit" name="search" class="btn-success text-white input-group-text"><i class="fa fa-search"></i>
                            </button>
                        </div>
                        <?php if (isset($_POST['q'])): ?>
                            <div class="input-group-append">
                                <a href="./index.php" class="btn bg-danger text-white input-group-text"><i class="fa fa-times"></i></a>
                            </div>
                        <?php endif; ?>
                        <div class="input-group-append">
                            <button type="button" data-toggle="modal" data-target="#add" class="bg-info btn text-white input-group-text">
                                <i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            <?php if(isset($_SESSION['alert'])): ?>
            <div class="alert <?= $_SESSION['alert-class'] ?>">
                <?= $_SESSION['alert'] ?>
            </div>
            <?php unset($_SESSION['alert']); endif; ?>
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>Organization Name</th>
                    <th>Email</th>
                    <th>Description</th>
                    <th class="text-center">File</th>
                    <th class="text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($organizations as $organization): ?>
                <tr>
                    <td><?= $organization['name'] ?></td>
                    <td><?= $organization['email'] ?></td>
                    <td><?= $organization['description'] ?></td>
                    <td class="text-center">
                        <a target="_blank" class="text-primary" href="../uploads/<?= $organization['file'] ?>"><i class="fa fa-lg fa-download"></i></a>
                    </td>
                    <td class="text-center">
                        <a class="update-organization text-warning" data-toggle="modal" href="#edit" data-id="<?= $organization['id'] ?>"><i class="fa fa-lg fa-pencil-alt"></i></a>
                        <a data-id="<?= $organization['id'] ?>" class="delete-organization text-danger ml-2" href="#"><i class="fa fa-lg fa-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<div class="modal fade" id="add">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add New Organization</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form action="server.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="small font-weight-bold">Name *</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="form-group">
                        <label class="small font-weight-bold">Point of contact Email Address *</label>
                        <input type="text" class="form-control" name="email" required>
                    </div>
                    <div class="form-group">
                        <label class="small font-weight-bold">Description *</label>
                        <textarea name="description" required class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="small font-weight-bold">Attach file</label>
                        <input type="file" accept="image/*" class="form-control" name="image">
                    </div>
                    <div class="form-group">
                        <input type="submit" name="add-organization" class="btn btn-success" value="Save">
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="update-title">Update Organization</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form action="server.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="small font-weight-bold">Name *</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label class="small font-weight-bold">Point of contact Email Address *</label>
                        <input type="text" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label class="small font-weight-bold">Description *</label>
                        <textarea name="description" id="description" required class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="small font-weight-bold">Attach file <small>(Leave empty if you wanna use old file)</small></label>
                        <a href="#" target="_blank" id="file"><i class="fa fa-link"></i></a>
                        <input type="file" accept="image/*" class="form-control" name="image">
                    </div>
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <input type="submit" name="upd-organization" class="btn btn-success" value="Update">
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/jquery.min.js"></script>
<script>
    $(".update-organization").on('click', (e)=>{
        $("#update-title").append(`<i class="fa fa-spinner fa-spin ml-2"></i>`);
        o_id = $(e.target).data('id');
        if (o_id == undefined || o_id == null || o_id == ''){
            o_id = $(e.target).closest('.update-organization').data('id');
        }
        $.ajax({
            url: '../ajax.php',
            method: 'POST',
            data: {
                'action': 'fetch-org',
                'id': o_id
            },
            success: (r)=>{
                if (r == '-1'){
                    alert('Invalid organization id.');
                    e.preventDefault();
                    return;
                }else{
                    org = JSON.parse(r);
                    $("#id").val(org.id);
                    $("#name").val(org.name);
                    $("#email").val(org.email);
                    $("#description").val(org.description);
                    $("#file").attr("href", "../uploads/"+org.file);
                    $("#update-title i").fadeOut();
                }
            }
        })
    });
    $(".delete-organization").on('click', (e)=>{
        if(!confirm('Are you sure you wanna delete this?')){
            return;
        }
        $this = $(e.target);
        o_id = $(e.target).data('id');
        if (o_id == undefined || o_id == null || o_id == ''){
            o_id = $(e.target).closest('.delete-organization').data('id');
        }
        $.ajax({
            url: '../ajax.php',
            method: 'POST',
            data: {
                'action': 'delete-org',
                'id': o_id
            },
            success: (r)=>{
                if (r == '-1'){
                    alert('Invalid could not be deleted.');
                    e.preventDefault();
                    return;
                }else{
                    $($this).closest('tr').fadeOut();
                }
            }
        })
    });

</script>
</body>
</html>