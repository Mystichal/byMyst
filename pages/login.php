<?php require_once("_header.php"); ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['inputEmail'];
    $password = $_POST['inputPassword'];

    if (empty($email) or empty($password)) {
        array_push($_SESSION['sessionMsg'], array('type' => 'danger', 'msg' => 'fill all required  data fields'));
    } else {
        $login = $objUsers->login($email, $password);
        if ($login) {
            header('Location: ?page=index');
        } else {
            array_push($_SESSION['sessionMsg'], array('type' => 'danger', 'msg' => 'no user with that data'));
        }
    }
}
?>

    <div class="container">
        <div class="card container-login">
            <img id="avatar-img" class="avatar-img-card" src="images/avatar-smal.png"/>
            <h1 class="form-h1">Sign in</h1>
            <form class="form-login" action="" method="POST">
                <label><span class="form-link"><?php echo $text['email-adress']; ?></span></label>
                <input type="email" id="inputEmail" name="inputEmail" required autofocus>
                <label><span class="form-link"><?php echo $text['password']; ?></span></label>
                <input type="password" id="inputPassword" name="inputPassword" required>
                <button type="submit"><?php echo $text['continue']; ?></button>
                <a class="form-link" href="#"><?php echo $text['forgot-password']; ?></a>
            </form>
            <div class="divider">
                <h5><?php echo $text['new']; ?></h5>
            </div>
            <a class="button" href="/byMyst/?page=register"><?php echo $text['create-account']; ?></a>
        </div>
    </div>

<?php require_once("_footer.php"); ?>