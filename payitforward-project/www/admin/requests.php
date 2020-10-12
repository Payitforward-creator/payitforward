<?php
session_start();
require('db.php');
if (isset($_SESSION['admin'])) {
    $admin = 'Admin';
}else{
    header("Location: ../index.php");
    exit;
}
$organizations = $conn->query("SELECT * FROM `organizations`")->fetch_all(MYSQLI_ASSOC);
if (isset($_GET['approve'])){
    $id = $_GET['approve'];
    $sql = "UPDATE `opportunities` SET status='approved' WHERE id='$id'";
    if ($conn->query($sql)){
        $_SESSION['alert'] = 'Opportunity request accepted.';
        $_SESSION['alert-class'] = 'alert-success';
    }else{
        $_SESSION['alert'] = 'Something went wrong';
        $_SESSION['alert-class'] = 'alert-danger';
    }
    header("Location: requests.php");
    exit;
}

if (isset($_GET['reject'])){
    $id = $_GET['reject'];
    $sql = "UPDATE `opportunities` SET status='rejected' WHERE id='$id'";
    if ($conn->query($sql)){
        $_SESSION['alert'] = 'Opportunity request rejected.';
        $_SESSION['alert-class'] = 'alert-success';
    }else{
        $_SESSION['alert'] = 'Something went wrong';
        $_SESSION['alert-class'] = 'alert-danger';
    }
    header("Location: requests.php");
    exit;
}

if (isset($_POST['search'])){
    $q = $_POST['q'];
    $date = $_POST['date'];
    if (!empty($date)){
        $date = date('m/d/Y', strtotime($date));
        $opportunities = $conn->query("SELECT * FROM `opportunities` WHERE `locations` LIKE '%$q%' AND dates='$date'")->fetch_all(MYSQLI_ASSOC);
    }else{
        $opportunities = $conn->query("SELECT * FROM `opportunities` WHERE `locations` LIKE '%$q%'")->fetch_all(MYSQLI_ASSOC);
    }
}else{
    $opportunities = $conn->query("SELECT * FROM `opportunities`")->fetch_all(MYSQLI_ASSOC);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../plugins/datapicker/css/bootstrap-datepicker.min.css">
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
            <li class="nav-item">
                <a class="nav-link" href="index.php">Manage Organizations</a>
            </li>
            <li class="nav-item active">
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
                <h4 class="mb-3">Seach for Request</h4>
                <form class="form-inline" method="POST">
                    <div class="input-group mb-3">
                        <input type="search" name="q" value="<?= isset($_POST['q'])?$_POST['q']:'' ?>" class="form-control" placeholder="Find name or place">
                        <div class="input-group-append">
                            <input type="date" name="date" class="form-control" value="<?= isset($_POST['date'])?$_POST['date']:'' ?>">
                        </div>
                        <div class="input-group-append">
                            <button type="submit" name="search" class="btn-success text-white input-group-text"><i class="fa fa-search"></i></button>
                        </div>
                        <?php if (isset($_POST['q'])): ?>
                            <div class="input-group-append">
                                <a href="./requests.php" class="btn bg-danger text-white input-group-text"><i class="fa fa-times"></i></a>
                            </div>
                        <?php endif; ?>
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
                    <th>Organization</th>
                    <th>Vol. Type</th>
                    <th>Locations</th>
                    <th>Date</th>
                    <th>Description</th>
                    <th class="text-center">Image</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($opportunities as $opportunity): ?>
                <tr>
                    <td><?= $conn->query("SELECT `name` FROM `organizations` WHERE id='".$opportunity['o_id']."'")->fetch_assoc()['name'] ?></td>
                    <td><?= $opportunity['v_type'] ?></td>
                    <td><?= $opportunity['locations'] ?></td>
                    <td><?= $opportunity['dates'] ?></td>
                    <td><?= $opportunity['description'] ?></td>
                    <td class="text-center"><a target="_blank" class="text-primary" href="../uploads/<?= $opportunity['image'] ?>"><i class="fa fa-lg fa-download"></i></a></td>
                    <?php
                        $colors = [
                            'pending' => 'info',
                            'approved' => 'success',
                            'rejected' => 'danger'
                        ]
                    ?>
                    <td class="text-center"><div class="badge badge-<?= $colors[$opportunity['status']] ?>"><?= $opportunity['status'] ?></div></td>
                    <td class="text-center">
                        <a class="text-warning opps mr-2" data-toggle="modal" href="#edit-opps" data-id="<?= $opportunity['id'] ?>"><i class="fa fa-lg fa-pencil-alt"></i></a>
                        <a class="text-dark mr-2 submissions" data-toggle="modal" href="#submissions" data-id="<?= $opportunity['id'] ?>"><i class="fa fa-lg fa-eye"></i></a>
                        <a class="text-success" href="<?= $_SERVER['PHP_SELF'] ?>?approve=<?= $opportunity['id'] ?>"><i class="fa fa-lg fa-check"></i></a>
                        <a class="text-danger ml-2" href="<?= $_SERVER['PHP_SELF'] ?>?reject=<?= $opportunity['id'] ?>"><i class="fa fa-lg fa-times"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<div class="modal fade" id="edit-opps">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Update Opportunity</h4>
            </div>
            <div class="modal-body">
                <form action="server.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="opp-id">
                    <div class="form-group">
                        <label>Organization *</label>
                        <select name="organization" class="form-control" required id="organization">
                            <option value="" disabled selected>Select Location</option>
                            <?php foreach ($organizations as $organization): ?>
                                <option value="<?= $organization['id'] ?>"><?= $organization['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Volunteering Type *</label>
                        <select name="type" class="form-control" required id="type">
                            <option value="" disabled selected>Select Location</option>
                            <option value="Animals">Animals</option>
                            <option value="Elderly">Elderly</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Location *</label>
                        <select name="location" class="form-control" required id="location">
                            <option value="" disabled selected>Select Location</option>
                            <option value="Afula">Afula</option>
                            <option value="Akko">Akko</option>
                            <option value="Arad">Arad</option>
                            <option value="Ariel">Ariel</option>
                            <option value="Ashdod">Ashdod</option>
                            <option value="Ashkelon">Ashkelon</option>
                            <option value="Baqa al-Gharbiyye">Baqa al-Gharbiyye</option>
                            <option value="Bat Yam">Bat Yam</option>
                            <option value="Beer Sheva">Beer Sheva</option>
                            <option value="Beit Shean">Beit Shean</option>
                            <option value="Beit Shemesh">Beit Shemesh</option>
                            <option value="Betar Illit">Betar Illit</option>
                            <option value="Bnei Berak">Bnei Berak</option>
                            <option value="Dimona">Dimona</option>
                            <option value="Eilat">Eilat</option>
                            <option value="Elad">Elad</option>
                            <option value="Givatayim">Givatayim</option>
                            <option value="Hadera">Hadera</option>
                            <option value="Haifa">Haifa</option>
                            <option value="Harish">Harish</option>
                            <option value="Herzliya">Herzliya</option>
                            <option value="Hod HaSharon">Hod HaSharon</option>
                            <option value="Holon">Holon</option>
                            <option value="Jerusalem">Jerusalem</option>
                            <option value="Karmiel">Karmiel</option>
                            <option value="Kfar Sava">Kfar Sava</option>
                            <option value="Kiryat Ata">Kiryat Ata</option>
                            <option value="Kiryat Bialik">Kiryat Bialik</option>
                            <option value="Kiryat Gat">Kiryat Gat</option>
                            <option value="Kiryat Malachi">Kiryat Malachi</option>
                            <option value="Kiryat Motzkin">Kiryat Motzkin</option>
                            <option value="Kiryat Ono">Kiryat Ono</option>
                            <option value="Kiryat Shemone">Kiryat Shemone</option>
                            <option value="Kiryat Yam">Kiryat Yam</option>
                            <option value="Lod">Lod</option>
                            <option value="Maale Adumim">Maale Adumim</option>
                            <option value="Maalot Tarshiha">Maalot Tarshiha</option>
                            <option value="Migdal HaEmek">Migdal HaEmek</option>
                            <option value="Modiin">Modiin</option>
                            <option value="Nahariya">Nahariya</option>
                            <option value="Nazareth">Nazareth</option>
                            <option value="Nes Ziona">Nes Ziona</option>
                            <option value="Nesher">Nesher</option>
                            <option value="Netanya">Netanya</option>
                            <option value="Netivot">Netivot</option>
                            <option value="Nof Hagalil">Nof Hagalil</option>
                            <option value="Ofakim">Ofakim</option>
                            <option value="Or Akiva">Or Akiva</option>
                            <option value="Or Yehuda">Or Yehuda</option>
                            <option value="Petah Tikva">Petah Tikva</option>
                            <option value="Qalansawe">Qalansawe</option>
                            <option value="Raanana">Raanana</option>
                            <option value="Rahat">Rahat</option>
                            <option value="Ramat Hasharon">Ramat Hasharon</option>
                            <option value="Ramat-Gan">Ramat-Gan</option>
                            <option value="Ramla">Ramla</option>
                            <option value="Rehovot">Rehovot</option>
                            <option value="Rishon Lezion">Rishon Lezion</option>
                            <option value="Rosh Ha'ayin">Rosh Ha'ayin</option>
                            <option value="Sakhnin">Sakhnin</option>
                            <option value="Sderot">Sderot</option>
                            <option value="Shefaram">Shefaram</option>
                            <option value="Taibeh">Taibeh</option>
                            <option value="Tamra">Tamra</option>
                            <option value="Tel Aviv">Tel Aviv</option>
                            <option value="Tiberias">Tiberias</option>
                            <option value="Tira">Tira</option>
                            <option value="Tirat Carmel">Tirat Carmel</option>
                            <option value="Tsfat (Safed)">Tsfat (Safed)</option>
                            <option value="Umm al-Fahm">Umm al-Fahm</option>
                            <option value="Yavne">Yavne</option>
                            <option value="Yehud-Monosson">Yehud-Monosson</option>
                            <option value="Yokneam">Yokneam</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Date *</label>
                        <input class="form-control datepicker" autocomplete="off" name="date" required>
                    </div>
                    <div class="form-group">
                        <label>Description *</label>
                        <textarea name="description" id="description" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" class="form-control" accept="image/*" name="image">
                        <a href="#" id="current-img" target="_blank">
                            <img src="" style="height: 40px;width: 50px;" alt="">
                        </a>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success" type="submit" name="update-opportunity">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="submissions">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header border-bottom-0">
                <h5 class="mb-0 modal-title">Submission Received</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body p-0">

            </div>

        </div>
    </div>
</div>

<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../plugins/datapicker/js/bootstrap-datepicker.min.js"></script>
<script>
    $(document).ready(function() {
        $('.datepicker').datepicker({
            format: 'mm/dd/yyyy',
            startDate: '-0d',
        });
    });
</script>
<script>
    $('.opps').on('click', (e)=>{
        let id = $(e.target).data('id');
        if (id == undefined){
            id = $(e.target).closest('.opps').attr('data-id');
        }
        $.ajax({
            url: '../ajax.php',
            method: 'POST',
            data: {
                action: 'fetch-opp',
                id: id
            },
            success: (r)=>{
                if(r == '-1'){
                    $("#submissions .modal-body").html(`<p class="text-center">Something went wrong.</p>`);
                }else{
                    r = JSON.parse(r);
                    $("#opp-id").val(r.id);
                    $("#organization").val(r.o_id);
                    $("#type").val(r.v_type);
                    $("#location").val(r.locations);
                    $(".datepicker").val(r.dates);
                    $("#description").val(r.description);
                    $("#current-img").attr('href','../uploads/'+r.image);
                    $("#current-img img").attr('src','../uploads/'+r.image);
                }
            }
        })
    });
    $('.submissions').on('click', (e)=>{
        let id = $(e.target).data('id');
        if (id == undefined){
            id = $(e.target).closest('.submissions').attr('data-id');
        }
        $.ajax({
            url: '../ajax.php',
            method: 'POST',
            data: {
                action: 'fetch-subs',
                o_id: id
            },
            success: (r)=>{
                if(r == '-1'){
                    $("#submissions .modal-body").html(`<p class="text-center">Something went wrong.</p>`);
                }else{
                    $("#submissions .modal-body").html(r);
                }
            }
        })
    });
</script>
</body>
</html>
