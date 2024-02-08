<?php
$userEmpty = null;
$passEmpty = null;
$rulesEmpty = null;

if (isset($_POST['submit'])) {
    $user_pegawai = $_POST['user_pegawai'];
    $pass_pegawai = $_POST['pass_pegawai'];
    $rules = isset($_POST['rules']) ? $_POST['rules'] : '';

    if (empty($user_pegawai)) {
        echo $userEmpty = "Username tidak boleh kosong!";
    }

    if (empty($pass_pegawai)) {
        echo $passEmpty = "Password tidak boleh kosong!";
    }

    if (empty($rules)) {
        echo $rulesEmpty = "Rules tidak boleh kosong!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="css/login_page.css">
    <title>Halaman Masuk </title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="image/logo_navbar.png" type="image/x-icon">
</head>

<body>
    <div class="login-container">
        <div class="login-header">
            <img src="image/logo_login.png" alt="">
        </div>
        <div class="login-box-wrapper">
            <div class="login_text">
                <p>Silahkan masukan username dan password untuk masuk sistem inventory!</p>
            </div>
            <div class="login-box-content">
                <form action="login_proses/login_proses.php" method="post">
                    <div class="content1">
                        <label for="pegawai_username">
                            Username :
                        </label>
                        <input type="text" name="user_pegawai" id="pegawai_username">
                        <?php echo $userEmpty; ?>
                    </div>
                    <div class="content2">
                        <label for="pegawai_username">
                            Password :
                        </label>
                        <input type="password" name="pass_pegawai" id="pegawai_password">
                        <?php echo $passEmpty; ?>
                    </div>
                    <div class="content2">
                        <label for="roles">Roles</label>
                        <select name="rules">
                            <option disabled selected>-- Pilih Roles --</option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                        <?php echo $rulesEmpty; ?>
                    </div>
                    <input type="submit" value="Masuk" name="submit">
                </form>
            </div>
        </div>
    </div>
</body>

</html>