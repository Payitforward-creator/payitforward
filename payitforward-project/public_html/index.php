<?php
session_start();
if (isset($_SESSION['admin'])) {
    $admin = 'Admin';
}
require('admin/db.php');
if (isset($_POST['search'])) {
    $organization = mysqli_real_escape_string($conn, $_POST['organization']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $sql = "SELECT * FROM `opportunities` WHERE status='approved' ";
    if (!empty($organization)) {
        $sql .= " AND `o_id`='$organization'";
    }
    if (!empty($location)) {
        $sql .= " AND locations LIKE '%$location%' ";
    }
    if (!empty($date)) {
        $date = date('m/d/Y', strtotime($date));
        $sql .= " AND dates='$date'";
    }
    $opportunities = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);
} else {
    $opportunities = $conn->query("SELECT * FROM `opportunities` WHERE status='approved'")->fetch_all(MYSQLI_ASSOC);
}
$organizations = $conn->query("SELECT * FROM `organizations`")->fetch_all(MYSQLI_ASSOC);
$locations = $conn->query("SELECT DISTINCT locations FROM `opportunities` WHERE  status='approved'")->fetch_all(MYSQLI_ASSOC);
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
    <link rel="stylesheet" href="css/bootstrap.min.css">
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
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Explore Opportunities</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="send.php">Send Opportunity</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <?php if (isset($admin) and !empty($admin)): ?>
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
    <div class="row">
        <div class="col-12 jumbotron">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h1><i class="fas fa-globe"></i> Pay it forward</h1>
                        <p>We believe everyone has the power to do good, which is why we specialize in connecting individuals and groups to causes and organizations they’re passionate about, in order to help them to make a difference in the world.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<main class="container">
    <div class="row">
        <div class="col-12">
            <form action="" method="POST">
                <div class="row justify-content-center">
                    <div class="form-group col-md-4">
                        <label class="font-weight-bold small">Who would you like to help today?</label>
                        <select name="organization" class="form-control" id="organization">
                            <option value="" disabled selected>Select</option>
                            <?php foreach ($organizations as $organization): ?>
                                <option <?= (isset($_POST['organization']) and $_POST['organization'] == $organization['id']) ? 'selected' : '' ?>
                                        value="<?= $organization['id'] ?>"><?= $organization['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="font-weight-bold small">Where would you like to volunteer?</label>
                        <select name="location" class="form-control" id="location">
                            <option value="" disabled selected>Select</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Afula">Afula</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Akko">Akko</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Arad">Arad</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Ariel">Ariel</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Ashdod">Ashdod</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Ashkelon">Ashkelon</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Baqa al-Gharbiyye">Baqa al-Gharbiyye</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Bat Yam">Bat Yam</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Beer Sheva">Beer Sheva</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Beit Shean">Beit Shean</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Beit Shemesh">Beit Shemesh</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Betar Illit">Betar Illit</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Bnei Berak">Bnei Berak</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Dimona">Dimona</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Eilat">Eilat</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Elad">Elad</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Givatayim">Givatayim</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Hadera">Hadera</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Haifa">Haifa</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Harish">Harish</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Herzliya">Herzliya</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Hod HaSharon">Hod HaSharon</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Holon">Holon</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Jerusalem">Jerusalem</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Karmiel">Karmiel</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Kfar Sava">Kfar Sava</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Kiryat Ata">Kiryat Ata</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Kiryat Bialik">Kiryat Bialik</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Kiryat Gat">Kiryat Gat</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Kiryat Malachi">Kiryat Malachi</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Kiryat Motzkin">Kiryat Motzkin</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Kiryat Ono">Kiryat Ono</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Kiryat Shemone">Kiryat Shemone</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Kiryat Yam">Kiryat Yam</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Lod">Lod</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Maale Adumim">Maale Adumim</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Maalot Tarshiha">Maalot Tarshiha</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Migdal HaEmek">Migdal HaEmek</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Modiin">Modiin</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Nahariya">Nahariya</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Nazareth">Nazareth</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Nes Ziona">Nes Ziona</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Nesher">Nesher</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Netanya">Netanya</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Netivot">Netivot</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Nof Hagalil">Nof Hagalil</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Ofakim">Ofakim</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Or Akiva">Or Akiva</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Or Yehuda">Or Yehuda</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Petah Tikva">Petah Tikva</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Qalansawe">Qalansawe</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Raanana">Raanana</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Rahat">Rahat</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Ramat Hasharon">Ramat Hasharon</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Ramat-Gan">Ramat-Gan</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Ramla">Ramla</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Rehovot">Rehovot</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Rishon Lezion">Rishon Lezion</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Rosh Ha'ayin">Rosh Ha'ayin</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Sakhnin">Sakhnin</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Sderot">Sderot</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Shefaram">Shefaram</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Taibeh">Taibeh</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Tamra">Tamra</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Tel Aviv">Tel Aviv</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Tiberias">Tiberias</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Tira">Tira</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Tirat Carmel">Tirat Carmel</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Tsfat (Safed)">Tsfat (Safed)</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Umm al-Fahm">Umm al-Fahm</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Yavne">Yavne</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Yehud-Monosson">Yehud-Monosson</option>
                            <option <?= (isset($_POST['location']) and $_POST['location'] == $location['locations']) ? 'selected' : '' ?> value="Yokneam">Yokneam</option>
                        </select>
                        <div class="mt-2" id="map" style="height: 300px;"></div>
                    </div>
                    <div class="form-group col-md-3">
                        <label class="font-weight-bold small">When would you like to volunteer?</label>
                        <input type="date" name="date" class="form-control"
                               value="<?= isset($_POST['date']) ? $_POST['date'] : '' ?>">
                    </div>
                    <div class="form-group col-md-1 pt-md-4">
                        <input type="submit" name="search" class="btn mt-md-2 btn-success" value="Filter">
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-12">
            <h4><?= count($opportunities) ?> available places to volunteer</h4>
            <hr>
            <div class="row">
                <?php foreach ($opportunities as $opportunity): ?>
                    <div class="col-md-4 col-sm-6">
                        <div class="row justify-content-center">
                            <div class="col-md-12 py-4">
                                <img src="uploads/<?= $opportunity['image'] ?>" alt="" class="img-fluid">
                                <p class="mb-1 small"><?= $opportunity['description'] ?></p>
                                <button data-id="<?= $opportunity['id'] ?>"
                                        data-name="<?= $conn->query("SELECT `name` FROM `organizations` WHERE id='" . $opportunity['o_id'] . "'")->fetch_assoc()['name'] ?>"
                                        class="signup btn btn-sm btn-success" data-toggle="modal"
                                        data-target="#signup-modal">Sign up
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php if (count($opportunities) < 1): ?>
                    <div class="col-12">
                        <p class="text-center">
                            No records found!
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</main>

<div class="modal fade" id="signup-modal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Sign up to volunteer at <span>{Organization}</span></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form action="" method="POST" id="signup-form">
                    <div class="alert d-none"></div>
                    <div class="form-group">
                        <input type="hidden" id="o_id" name="o_id">
                        <label class="small font-weight-bold">First Name *</label>
                        <input type="text" class="form-control" name="fname" id="fname" required>
                    </div>
                    <div class="form-group">
                        <label class="small font-weight-bold">Last Name *</label>
                        <input type="text" class="form-control" name="lname" id="lname" required>
                    </div>
                    <div class="form-group">
                        <label class="small font-weight-bold">Number of participants *</label>
                        <input type="number" class="form-control" name="participants" id="participants" required>
                    </div>
                    <div class="form-group">
                        <label class="small font-weight-bold">Email *</label>
                        <input type="email" class="form-control" name="email" id="email2" required>
                    </div>
                    <div class="form-group text-center">
                        <label class="small"><input required type="checkbox">&nbsp;&nbsp;I agree to the <a href="#">Terms of
                                use</a> and <a href="#">Privacy Policy</a></label>
                        <br>
                        <input type="submit" name="signup" class="btn btn-success" value="Sign up">
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
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
<script>
    $("#login-form").on('submit', (e) => {
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
            success: (r) => {
                if (r == '1') {
                    $("#login-form .alert").removeClass('alert-danger').addClass('alert-success').text(`Logged In successfully`).removeClass('d-none');
                    setTimeout(() => {
                        window.location.href = './admin';
                    }, 1200);
                } else {
                    $("#login-form .alert").removeClass('alert-success').addClass('alert-danger').text(r).removeClass('d-none');
                    setTimeout(() => {
                        $("#login-form .alert").addClass('d-none');
                    }, 2000);
                }
            }
        });
    });

    $(".signup").on('click', (e) => {
        o_name = $(e.target).data('name');
        o_id = $(e.target).data('id');
        $("#signup-modal .modal-title span").text(o_name);
        $("#o_id").val(o_id);

    });

    $("#signup-form").on('submit', (e) => {
        e.preventDefault();
        o_id = $("#o_id").val(), fname = $("#fname").val(), lname = $("#lname").val(), participants = $("#participants").val(), email = $("#email2").val();
        r_data = {
            o_id: o_id,
            fname: fname,
            lname: lname,
            participants: participants,
            email: email,
            signup: 1
        };
        $.ajax({
            url: 'ajax.php',
            method: 'POST',
            data: r_data,
            success: (r) => {
                if (r == '1') {
                    $("#signup-form")[0].reset();
                    $("#signup-form .alert").removeClass('alert-danger').addClass('alert-success').text(`Request submitted successfully`).removeClass('d-none');
                    setTimeout(() => {
                        $("#signup-modal").modal('toggle');
                    }, 1200);
                } else {
                    $("#login-form .alert").removeClass('alert-success').addClass('alert-danger').text(r).removeClass('d-none');
                    setTimeout(() => {
                        $("#login-form .alert").addClass('d-none');
                    }, 2000);
                }
            }
        });
    });
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDG-9iRNQSW7YtzI62snTo_aAaGAqPRbn4&callback=initMap&libraries=&v=weekly" defer></script>
<script type="text/javascript">
let map, infoWindow;
function initMap() {
  map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: -34.397, lng: 150.644 },
    zoom: 6,
  });
  infoWindow = new google.maps.InfoWindow();
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      (position) => {
        const pos = {
          lat: position.coords.latitude,
          lng: position.coords.longitude,
        };
        map.setCenter(pos);
        new google.maps.Marker({position: pos, map: map});
      },
      () => {
        handleLocationError(true, infoWindow, map.getCenter());
      }
    );
  } else {
    handleLocationError(false, infoWindow, map.getCenter());
  }
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
  infoWindow.setPosition(pos);
  infoWindow.setContent(
    browserHasGeolocation
      ? "Error: The Geolocation service failed."
      : "Error: Your browser doesn't support geolocation."
  );
  infoWindow.open(map);
}
</script>
</body>
</html>
