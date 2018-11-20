<?php
if (!defined('_GNUBOARD_')) exit;

$begin_time = get_microtime();

include_once(G5_PATH.'/head.adm.sub.php');

function print_menu1($key, $no)
{
    global $menu;

    $str = print_menu2($key, $no);

    return $str;
}

function print_menu2($key, $no)
{
    global $menu, $auth_menu, $is_admin, $auth, $g5;

    $str .= "<ul class=\"gnb_2dul\">";
    for($i=1; $i<count($menu[$key]); $i++)
    {
        if ($is_admin != 'super' && (!array_key_exists($menu[$key][$i][0],$auth) || !strstr($auth[$menu[$key][$i][0]], 'r')))
            continue;

        if (($menu[$key][$i][4] == 1 && $gnb_grp_style == false) || ($menu[$key][$i][4] != 1 && $gnb_grp_style == true)) $gnb_grp_div = 'gnb_grp_div';
        else $gnb_grp_div = '';

        if ($menu[$key][$i][4] == 1) $gnb_grp_style = 'gnb_grp_style';
        else $gnb_grp_style = '';

        $str .= '<li class="gnb_2dli"><a href="'.$menu[$key][$i][2].'" class="gnb_2da '.$gnb_grp_style.' '.$gnb_grp_div.'">'.$menu[$key][$i][1].'</a></li>';

        $auth_menu[$menu[$key][$i][0]] = $menu[$key][$i][1];
    }
    $str .= "</ul>";

    return $str;
}

// 오늘이전 날짜 예약상태 마감으로 변경
$sqlStatusEnd = " update m_schedule set sc_status = '1' where sc_status != '1' and sc_ymd < '".date("Ymd")."' ";
sql_query($sqlStatusEnd);

// 등록어선추출
if($pgubun == "ship_write" || $pgubun == "book_config" || $pgubun == "book_list" || $pgubun == "book_list_calendar" || $pgubun == "book_write")
{
	$sqlhs = " select * from m_ship where (1) ";
	$resulths = sql_query($sqlhs);
	$shipshs = "";
	$s_idx_hs = $_REQUEST[s_idx];

	if(!$s_idx_hs)
	{
		$fhsshipFetch = sql_fetch(" select s_idx from m_ship where (1) order by regdate desc limit 1 ");
		$s_idx_hs = $fhsshipFetch[s_idx];
	}

	for($i=0;$rowhs=sql_fetch_array($resulths);$i++) {
		// 셀렉트박스
		$sh_selected = "";
		if($rowhs[s_idx]==$s_idx_hs) $sh_selected = " selected='selected' ";
		$shipshs .= "<option value='".$rowhs[s_idx]."' ".$sh_selected.">".get_text($rowhs[s_name])."</option>";
	}
}
?>

<script>
var tempX = 0;
var tempY = 0;

function imageview(id, w, h)
{

    menu(id);

    var el_id = document.getElementById(id);

    //submenu = eval(name+".style");
    submenu = el_id.style;
    submenu.left = tempX - ( w + 11 );
    submenu.top  = tempY - ( h / 2 );

    selectBoxVisible();

    if (el_id.style.display != 'none')
        selectBoxHidden(id);
}
</script>
<div id="layermask"></div>
<div id="to_content"><a href="#container">본문 바로가기</a></div>

<header id="hd">
    <div id="hd_wrap">
        <h1><?php echo $config['cf_title'] ?></h1>

        <div id="logo"><a href="<?php echo G5_ADMIN_URL ?>"><img src="<?php echo G5_ADMIN_URL ?>/img/logo.jpg" alt="<?php echo $config['cf_title'] ?> 관리자"></a></div>

        <ul id="tnb">
            <!--<li><a href="<?php echo G5_ADMINERP_URL ?>/choolgo.php" class="tnb-red"><?php echo $_menuArray[100][$sesslang];// 매장출고요청?> ( <?php echo $agodreqcnt;?> )</a></li>-->
            <li class="xs-hidden"><a href="<?php echo G5_ADMIN_URL ?>/member_form.php?w=u&amp;mb_id=<?php echo $member['mb_id'] ?>">관리자정보</a></li>
            <li><a href="<?php echo G5_URL ?>/">홈으로</a></li>
            <li id="tnb_logout"><a href="<?php echo G5_BBS_URL ?>/logout.php">로그아웃</a></li>
        </ul>

        <nav id="gnb">
            <h2>관리자 주메뉴</h2>
            <?php
            $gnb_str = "<ul id=\"gnb_1dul\">";
            foreach($amenu as $key=>$value) {
                $href1 = $href2 = '';
                if ($menu['menu'.$key][0][2]) {
                    $href1 = '<a href="'.$menu['menu'.$key][0][2].'" class="gnb_1da">';
                    $href2 = '</a>';
                } else {
                    continue;
                }
                $current_class = "";
                if (isset($sub_menu) && (substr($sub_menu, 0, 3) == substr($menu['menu'.$key][0][0], 0, 3)))
                    $current_class = " gnb_1dli_air";
                $gnb_str .= '<li class="gnb_1dli'.$current_class.$menu['menu'.$key][0][4].'">'.PHP_EOL;
                $gnb_str .=  $href1 . $menu['menu'.$key][0][1] . $href2;
                //$gnb_str .=  print_menu1('menu'.$key, 1);
				if($menu['menu'.$key][1][1]) $gnb_str .=  print_menu1('menu'.$key, 1);
                $gnb_str .=  "</li>";
            }
            $gnb_str .= "</ul>";
            echo $gnb_str;
            ?>
        </nav>

    </div>
</header>

<?php if($sub_menu) { ?>
<ul id="lnb">
<?php
$menu_key = substr($sub_menu, 0, 3);
$nl = '';
foreach($menu['menu'.$menu_key] as $key=>$value) {
    if($key > 0) {
        if ($is_admin != 'super' && (!array_key_exists($value[0],$auth) || !strstr($auth[$value[0]], 'r')))
            continue;

        if($value[3] == 'cf_service')
            $svc_class = ' class="lnb_svc"';
        else
            $svc_class = '';

        echo $nl.'<li><a href="'.$value[2].'"'.$svc_class.'>'.$value[1].'</a></li>';
        $nl = PHP_EOL;
    }
}
?>
</ul>
<?php } ?>

<div id="wrapper">

    <div id="container">
        <div id="text_size">
            <!-- font_resize('엘리먼트id', '제거할 class', '추가할 class'); -->
            <button onclick="font_resize('container', 'ts_up ts_up2', '');"><img src="<?php echo G5_ADMIN_URL ?>/img/ts01.gif" alt="기본"></button>
            <button onclick="font_resize('container', 'ts_up ts_up2', 'ts_up');"><img src="<?php echo G5_ADMIN_URL ?>/img/ts02.gif" alt="크게"></button>
            <button onclick="font_resize('container', 'ts_up ts_up2', 'ts_up2');"><img src="<?php echo G5_ADMIN_URL ?>/img/ts03.gif" alt="더크게"></button>
        </div>
        <h1>
		<?php echo $g5['title'] ?>
		<?php if($pgubun == "ship_write" || $pgubun == "book_config" || $pgubun == "book_list" || $pgubun == "book_list_calendar") {?>
		<div class="clear lg-hidden"></div>
		<select name="bk_status[<?php echo $i ?>]" class="selectbox-header m_nomargin" onchange="hschg(this.value);">
			<?php echo $shipshs;?>
		</select>
		<?php } ?>
		</h1>

