<?php
# new language object
$objLang = new language();

# new business object
$objBusiness = new business();
$business = $objBusiness->getBusiness();

# new user object
$objUsers = new users();

# if not session var is set send to login page
if (!$objUsers->getSession() && url::getCurrentUrl() != "/?page=login") {
    if (!$objUsers->getSession() && url::getCurrentUrl() != "/?page=register") {
        header('Location: ?page=login');
        exit();
    };
};

# if session is set and url is login send to index
if ($objUsers->getSession() && url::getCurrentUrl() == "/?page=login") {
    header('Location: ?page=index');
    exit();
};


if ($objUsers->getSession()) {
    # new navigation object
    $objNav = new nav();
    # get nav categories
    $navCats = json_encode($objNav->getCategories());
    # set lang by session language
    $text = $objLang->getLangText($_SESSION['sessionLang']);
    $sessionMail = $objUsers->emailById($_SESSION['sessionId']);
} else {
    # set navCats to null
    $navCats = null;
    $text = $objLang->getLangText(0);
}
?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $business[0]['name']; ?></title>
    <meta name="description" content="<?php echo $business[0]['discription']; ?>"/>
    <meta name="keywords" content=""/>
    <link rel="icon" type="image/x-icon" href="favicon.ico"/>
    <meta name="theme-color" content="#ffffff">
    <meta http-equiv="imagetoolbar" content="no"/>
    <link rel="stylesheet" href="css/style.css"/>
    <link rel="stylesheet" href="css/font-awesome.css">
</head>
<body>
<!-- build:js scripts -->
<!-- bower:js -->
<script src="js/jquery-3.2.1.js"></script>
<script src="js/mustache.js"></script>
<script src="js/loader.js"></script>
<!-- endbower -->
<!-- endbuild -->

<header>
    <div id="logo-container">
        <a href="?page=index"><img src="images/logo.png"/></a>
    </div>
    <nav role="navigation">
        <ul style="float: right!important;">
            <li>
                <a href="">
                    <h5><?php echo $sessionMail[0]['email']; ?><span class="">&#9660;</span></h5>
                </a>
                <div>
                    <ul>
                        <li>
                            <a href="">Test</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>

    </nav>
</header>

<section id="content">
    <?php
    if (is_array($_SESSION['sessionMsg'])) {
        for ($i = 0; $i < count($_SESSION['sessionMsg']); $i++) {
            echo ($_SESSION['sessionMsg'][$i]['msg']);
            array_pop($_SESSION['sessionMsg']);
        }

    }
    ?>
