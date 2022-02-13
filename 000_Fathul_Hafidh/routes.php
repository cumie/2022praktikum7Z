<?php
if (isset($_GET['page'])) {
$page = $_GET['page'];
switch($page) {
    case '':
        case 'home':
            file_exists('pages/home.php') ? include 'pages/home.php' : include 'pages/404.php';
            break;
      case 'lokasiread':
            file_exists('pages/lokasi/lokasiread.php') ? include 'pages/lokasi/lokasiread.php' : include "pages/404.php";
            break;

        case 'lokasicreate':
            file_exists('pages/lokasi/lokasicreate.php') ? include 'pages/lokasi/lokasicreate.php' : include "pages/404.php";
            break;

        case 'lokasiupdate':
            file_exists('pages/lokasi/lokasiupdate.php') ? include 'pages/lokasi/lokasiupdate.php' : include "pages/404.php";
            break;

        case 'lokasidelete':
            file_exists('pages/lokasi/lokasidelete.php') ? include 'pages/lokasi/lokasidelete.php' : include "pages/404.php";
            break;  
    default:
    include 'pages/404.php';
}
} else {
    include 'pages/home.php';
}

?>