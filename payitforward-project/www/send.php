<?php
session_start();
require('admin/db.php');
if (isset($_SESSION['admin'])){
    $admin = 'Admin';
}
$organizations = $conn->query("SELECT * FROM `organizations`")->fetch_all(MYSQLI_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="plugins/datapicker/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Pay it forward</title>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-light bg-light py-0">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
                aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Explore Opportunities</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="send.php">Send Opportunity</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <?php if(isset($admin) AND !empty($admin)): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Welcome (Admin)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./admin">Admin Panel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin/logout.php"><i class="fa fa-sign-in-alt"></i></a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a href="#login" data-toggle="modal"><i class="fa fa-sign-in-alt"></i></a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<main role="main" class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 jumbotron">
            <div class="container">
                <h1><i class="fas fa-globe"></i> Pay it forward</h1>
                <p>We believe everyone has the power to do good, which is why we specialize in connecting individuals and groups to causes and organizations they’re passionate about, in order to help them to make a difference in the world.</p>
            </div>
        </div>
        <div class="col-12 text-center">
            <h4>Fill form to be sent to Pay it forward approval</h4><br>
        </div>
        <hr>
        <div class="col-md-5">
            <?php if(isset($_SESSION['alert'])): ?>
            <div class="alert <?= $_SESSION['alert-class'] ?>">
                <?= $_SESSION['alert'] ?>
            </div>
            <?php unset($_SESSION['alert']); endif; ?>
            <p class="mb-1 font-weight-bold">Opportunity Details:</p>
            <form action="server.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Organization *</label>
                    <select name="organization" class="form-control" required id="organization">
                        <option value="" disabled selected>Select Organization</option>
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
                    <textarea name="description" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label>Image</label>
                    <input type="file" class="form-control" accept="image/*" name="image">
                </div>
                <div class="form-group">
                    <button class="btn btn-success" type="submit" name="submit-opportunity">Send</button>
                </div>
            </form>
        </div>
    </div>
</main>
<div class="modal fade" id="login">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Login</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form action="" method="POST" id="login-form">
                    <div class="alert d-none"></div>
                    <div class="form-group">
                        <label class="small font-weight-bold">Email</label>
                        <input id="email" type="email" class="form-control" name="email" required>
                    </div>
                    <div class="form-group">
                        <label class="small font-weight-bold">Password</label>
                        <input id="password" type="password" class="form-control" name="password" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="login" class="btn btn-success" value="Login">
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="plugins/select2/js/select2.min.js"></script>
<script src="plugins/datapicker/js/bootstrap-datepicker.min.js"></script>
<script>
    $(document).ready(function() {
        // $('select').select2({});
        $('select#location').select2({
            'placeholder': 'Select Locations',
        });
        $('select#type').select2({
            'placeholder': 'Select Type',
        });
        $('select#organization').select2({
            'placeholder': 'Select Organization',
        });
        $('.datepicker').datepicker({
            format: 'mm/dd/yyyy',
            startDate: '-0d',
        });
    });
</script>
<script>
    $("#login-form").on('submit', (e)=>{
        e.preventDefault();
        email = $("#email").val(), password = $("#password").val();
        $.ajax({
            url: 'ajax.php',
            method: 'POST',
            data: {
                'email': email,
                'password': password,
                'login': 1
            },
            success: (r)=>{
                if (r == '1'){
                    $("#login-form .alert").removeClass('alert-danger').addClass('alert-success').text(`Logged In successfully`).removeClass('d-none');
                    setTimeout(()=>{window.location.href='./admin';},1200);
                }else{
                    $("#login-form .alert").removeClass('alert-success').addClass('alert-danger').text(r).removeClass('d-none');
                    setTimeout(()=>{$("#login-form .alert").addClass('d-none');},2000);
                }
            }
        });
    });
</script>
</body>
</html>