<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$begin_time = get_microtime();

if (!isset($g5['title'])) {$g5['title'] = $config['cf_title']; $g5_head_title = $g5['title'];}
else { $g5_head_title = $g5['title']; $g5_head_title .= " | ".$config['cf_title'];}

// 현재 접속자 -  게시판 제목에 ' 포함되면 오류 발생
$g5['lo_location'] = addslashes($g5['title']);
if (!$g5['lo_location'])  $g5['lo_location'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));

$g5['lo_url'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
if (strstr($g5['lo_url'], '/'.G5_ADMIN_DIR.'/') || $is_admin == 'super') $g5['lo_url'] = '';

?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="ko" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="ko" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="ko"> <!--<![endif]-->
<head>
<!-- Meta -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge, chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0, maximum-scale=10, user-scalable=yes">-->
<meta name="HandheldFriendly" content="true">
<meta name="format-detection" content="telephone=no">
<meta name="description" content="홍성 죽도항 선상낚시 천일호입니다.">
<meta name="author" content="천일호">
<meta property="og:type" content="website">
<meta property="og:title" content="천일호 - 홍성 죽도항 선상낚시">
<meta property="og:description" content="홍성 죽도항 선상낚시 천일호입니다.">
<meta property="og:image" content="http://dkfish.co.kr/assets/img/banners/ban06.jpg">
<meta property="og:url" content="http://dkfish.co.kr">
<?php if($config['cf_add_meta'])  echo $config['cf_add_meta'].PHP_EOL;?>
<title><?php echo $g5_head_title; ?></title>
<?php if (defined('G5_IS_ADMIN')) { ?>
<link rel="stylesheet" href="<?php echo G5_ADMIN_URL;?>/css/admin.css">
<?php } else { ?>
<!-- Favicon -->
<!--<link rel="shortcut icon" href="../favicon.ico">-->
<!-- Web Fonts -->
<link rel="stylesheet" href="//fonts.googleapis.com/earlyaccess/nanumgothic.css">
<!-- CSS Global Compulsory -->
<link rel="stylesheet" href="<?php echo G5_URL;?>/assets/plugins/bootstrap/css/bootstrap.css">
<link rel="stylesheet" href="<?php echo G5_URL;?>/assets/css/style.css">
<!-- CSS Header and Footer -->
<link rel="stylesheet" href="<?php echo G5_URL;?>/assets/css/headers/header-v6.css">
<link rel="stylesheet" href="<?php echo G5_URL;?>/assets/css/footers/footer-v1.css">
<!-- CSS Implementing Plugins -->
<link rel="stylesheet" href="<?php echo G5_URL;?>/assets/plugins/animate.css">
<link rel="stylesheet" href="<?php echo G5_URL;?>/assets/plugins/line-icons/line-icons.css">
<link rel="stylesheet" href="<?php echo G5_URL;?>/assets/plugins/font-awesome/css/font-awesome.min.css">
<!-- CSS Customization -->
<?php include_once(G5_PATH.'/include/inc_css.php');?>
<?php } ?>

<?php if(!defined('G5_IS_ADMIN')) echo $config['cf_add_script'];	?>
</head>
<?php if($_tpn == "3") { ?>
<body class="header-fixed boxed-layout container">
<?php } else { ?>
<body class="header-fixed">
<?php } ?>
