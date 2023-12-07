<?php
// Language script
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

$lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en';

if ($lang === 'sk') {
    include './lang/sk.php';
} else {
    include './lang/en.php';
}
?>