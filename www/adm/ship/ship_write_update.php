<?php
$sub_menu = "400000";
include_once("./_common.php");
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

auth_check($auth[$sub_menu], 'w');

/********************************************************************에러체크*********************************************************************/
if (!($w == '' || $w == 'u')) alert("작성구분값 오류입니다.");

$upload_max_filesize = ini_get('upload_max_filesize');
if (empty($_POST)) alert("파일 또는 글내용의 크기가 서버에서 설정한 값을 넘어 오류가 발생하였습니다.");

if ($w == 'u')
{
	$s_idx = (int)preg_replace('/[^0-9]/', '', $_POST['s_idx']);
	if(!$s_idx || $s_idx < 1) alert("키값이 유효하지 않습니다.");

	$shipsql = " select * from m_ship where s_idx = '{$s_idx}' ";
	$ship = sql_fetch($shipsql);

	if (!$ship['s_idx']) alert("어선이 존재하지 않습니다.");
    if (get_session('ss_db_table') != "m_ship" || get_session('ss_s_idx') != $s_idx) alert("작성세션오류입니다.");

	$s_uidx = $ship[s_uidx];
}
/********************************************************************에러체크*********************************************************************/

//어선노출설정
$s_expose = $_POST['s_expose'];
if(!($s_expose == "n" || $s_expose == "y")) $s_expose = "n";

//선주명
$s_owner = '';
if (isset($_POST['s_owner'])) 
{
    $s_owner = substr(trim($_POST['s_owner']),0,255);
    $s_owner = preg_replace("#[\\\]+$#", "", $s_owner);
}
if ($s_owner == '') alert("선주명이 입력되지 않았습니다.");

//어선명
$s_name = '';
if (isset($_POST['s_name'])) 
{
    $s_name = substr(trim($_POST['s_name']),0,255);
    $s_name = preg_replace("#[\\\]+$#", "", $s_name);
}
if ($s_name == '') alert("어선명이 입력되지 않았습니다.");

// 신규등록시 동일어선명 체크
if ($w == '')
{
	$dupchk = sql_fetch(" select s_idx from m_ship where s_name = '{$s_name}' ");
	if($dupchk[s_idx]) alert("동일한 이름의 어선이 이미 등록되었습니다.");
}

// 최대승선가능인원
$s_max = (int)preg_replace('/[^0-9]/', '', $_POST['s_max']);
if(!$s_max || $s_max < 1) alert("최대승선가능인원 오류입니다.");

// 최소출항인원
$s_min = (int)preg_replace('/[^0-9]/', '', $_POST['s_min']);
if(!$s_min || $s_min < 1) alert("최소출항인원 오류입니다.");

// 출조테마체크
$s_theme = clean_xss_tags(trim($_POST['s_theme']));
$s_theme = clean_spchars($s_theme);
if($s_theme == "") alert("출조제목에 오류가 있습니다.");

// 출조가격체크
$s_price = preg_replace('/[^0-9]/', '', $_POST['s_price']);
$s_price = (int)$s_price;
if($s_price == "" || $s_price < 1)  alert("출조가격에 오류가 있습니다.");

// 어선소개
$s_cont = '';
if (isset($_POST['s_cont'])) 
{
    $s_cont = substr(trim($_POST['s_cont']),0,65536);
    $s_cont = preg_replace("#[\\\]+$#", "", $s_cont);
}

// 출조시간정보
$s_schedule = '';
if (isset($_POST['s_schedule'])) 
{
    $s_schedule = substr(trim($_POST['s_schedule']),0,65536);
    $s_schedule = preg_replace("#[\\\]+$#", "", $s_schedule);
}

// 어선 서비스항목
$svccnt = count($_POST['s_service']);
$s_service_arr = "";
if($svccnt > 0)
{
	for ($i=0; $i<$svccnt; $i++)
	{
		$svcval = $_POST['s_service'][$i];
		if($s_service_arr == "") $s_service_arr .= $svcval;
		else $s_service_arr .= "|".$svcval; 
	}
}

//배타는곳 주소
$s_addr = '';
if (isset($_POST['s_addr'])) 
{
    $s_addr = substr(trim($_POST['s_addr']),0,255);
    $s_addr = preg_replace("#[\\\]+$#", "", $s_addr);
}

// 어선 위치
$mapx = clean_xss_tags(trim($_POST['mapx']));
$mapy = clean_xss_tags(trim($_POST['mapy']));

if($w == "")
{
	$sql = " insert into m_ship
				set s_uidx = '{$s_uidx}',
					 s_owner = '{$s_owner}',
					 s_name = '{$s_name}',
					 s_max = '{$s_max}',
					 s_min = '{$s_min}',
					 s_theme = '{$s_theme}',
					 s_price = '{$s_price}',
					 s_cont = '{$s_cont}',
					 s_addr = '{$s_addr}',
					 s_schedule = '{$s_schedule}',
					 s_service = '{$s_service_arr}',
					 mapx = '{$mapx}',
					 mapy = '{$mapy}',
					 regdate = '".G5_TIME_YMDHIS."',
					 regip = '{$_SERVER['REMOTE_ADDR']}' ";
	sql_query($sql);
    $s_idx = sql_insert_id();

	$s_uidx =  md5($_SERVER['DOCUMENT_ROOT'].$s_idx);
	sql_query(" update m_ship set s_uidx = '{$s_uidx}' where s_idx = '{$s_idx}' ");
}
else if($w == "u")
{
	$sql = " update m_ship
				set s_expose = '{$s_expose}', 
					 s_owner = '{$s_owner}',
					 s_name = '{$s_name}',
					 s_max = '{$s_max}',
					 s_min = '{$s_min}',
					 s_theme = '{$s_theme}',
					 s_price = '{$s_price}',
					 s_cont = '{$s_cont}',
					 s_addr = '{$s_addr}',
					 s_schedule = '{$s_schedule}',
					 s_service = '{$s_service_arr}',
					 mapx = '{$mapx}',
					 mapy = '{$mapy}'
				 where s_idx = '{$s_idx}'  ";
	sql_query($sql);
}

//기본데이터 설정
if($w == "")
{
	$startYear = date("Y");
	$startMonth = date("m");
	$dataMonth = date("Ym", strtotime("+2 month")); // 기본데이터를 입력할 개월수 추출 - 현재 2017년 7월 이라면 2017년 8월까지는 기본데이터가 입력됨.

	$endYear = $startYear+2;  // 생성할 스케쥴 데이터 년도수. 현재 2017년이면 2018년까지 생성

	for($i=$startYear; $i<$endYear; $i++)
	{
		if($i==$startYear) 
		{
			$startMonth = date("m"); //07
			$startMonth2 = date("n"); //7
			$startYmd = $i.$startMonth."01";
		}
		else  
		{
			$startMonth = "01";
			$startMonth2 = "1";
			$startYmd = $i."0101";
		}

		for($k=$startMonth2;$k<13;$k++) {

			$_year = $i;
			$_month = $k; if($_month < 10) $_month = "0".$_month;
			$_day = $k+1; if($_day < 10) $_day = "0".$_day;

			$insertYmd = $_year.$_month.$_day;
			$lastday = date('t', strtotime($insertYmd));

			for($t=1;$t<$lastday+1;$t++) {

				$_insertDay = $t;
				if($_insertDay < 10) $_insertDay = "0".$_insertDay;
				$_insertYmd = $_year.$_month.$_insertDay;
				$_dataMonth = $_year.$_month;

				$sc_theme = $sc_price = $sc_max = "";
				if($_dataMonth < $dataMonth)
				{
					$sc_theme = $s_theme;
					$sc_price = $s_price;
					$sc_max = $s_max;
				}

				$sql = " insert into m_schedule
							set s_idx = '{$s_idx}',
								 sc_status = '',
								 sc_ymd = '{$_insertYmd}',
								 sc_y = '{$_year}',
								 sc_m = '{$_month}',
								 sc_d = '{$_insertDay}',
								 sc_theme = '{$sc_theme}',
								 sc_point = '{$sc_point}',
								 sc_price = '{$sc_price}',
								 sc_desc = '',
								 sc_max = '{$sc_max}' ";
				sql_query($sql);
			}
		}
	}
}

$upload_max_filesize = ini_get('upload_max_filesize');
$upload_max_pd = 20485760;
$thumb_w = 800; //썸네일 가로사이즈
$thumb_h = 600; //썸네일 세로사이즈

$thumb_w2 = 320; //썸네일 가로사이즈
$thumb_h2 = 240; //썸네일 세로사이즈

// 디렉토리가 없다면 생성합니다. (퍼미션도 변경하구요.)
@mkdir(G5_DATA_PATH.'/file/m_ship', G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH.'/file/m_ship', G5_DIR_PERMISSION);
@mkdir(G5_DATA_PATH.'/file/m_ship/thumb', G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH.'/file/m_ship/thumb', G5_DIR_PERMISSION);
@mkdir(G5_DATA_PATH.'/file/m_ship/thumb2', G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH.'/file/m_ship/thumb2', G5_DIR_PERMISSION);

$chars_array = array_merge(range(0,9), range('a','z'), range('A','Z'));

// 가변 파일 업로드
$file_upload_msg = '';
$upload = array();
for ($i=0; $i<count($_FILES['bf_file']['name']); $i++) {
    $upload[$i]['file']     = '';
    $upload[$i]['source']   = '';
    $upload[$i]['filesize'] = 0;
    $upload[$i]['image']    = array();
    $upload[$i]['image'][0] = '';
    $upload[$i]['image'][1] = '';
    $upload[$i]['image'][2] = '';

    // 삭제에 체크가 되어있다면 파일을 삭제합니다.
    if (isset($_POST['bf_file_del'][$i]) && $_POST['bf_file_del'][$i]) {
        $upload[$i]['del_check'] = true;

        $row = sql_fetch(" select bf_file from {$g5['board_file_table']} where bo_table = 'm_ship' and wr_id = '{$s_idx}' and bf_no = '{$i}' ");
        @unlink(G5_DATA_PATH.'/file/m_ship/'.$row['bf_file']);
    }
    else
        $upload[$i]['del_check'] = false;

    $tmp_file  = $_FILES['bf_file']['tmp_name'][$i];
	set_image_rotate($tmp_file);
    $filesize  = $_FILES['bf_file']['size'][$i];
    $filename  = $_FILES['bf_file']['name'][$i];
    $filename  = get_safe_filename($filename);

    // 서버에 설정된 값보다 큰파일을 업로드 한다면
    if ($filename) {
        if ($_FILES['bf_file']['error'][$i] == 1) {
            $file_upload_msg .= '\"'.$filename.'\" 파일의 용량이 서버에 설정('.$upload_max_filesize.')된 값보다 크므로 업로드 할 수 없습니다.\\n';
            continue;
        }
        else if ($_FILES['bf_file']['error'][$i] != 0) {
            $file_upload_msg .= '\"'.$filename.'\" 파일이 정상적으로 업로드 되지 않았습니다.\\n';
            continue;
        }
    }

    if (is_uploaded_file($tmp_file)) {
        // 관리자가 아니면서 설정한 업로드 사이즈보다 크다면 건너뜀
        if (!$is_admin && $filesize > $board['bo_upload_size']) {
            $file_upload_msg .= '\"'.$filename.'\" 파일의 용량('.number_format($filesize).' 바이트)이 게시판에 설정('.number_format($board['bo_upload_size']).' 바이트)된 값보다 크므로 업로드 하지 않습니다.\\n';
            continue;
        }
        $timg = @getimagesize($tmp_file);
        // image type
        if ( preg_match("/\.({$config['cf_image_extension']})$/i", $filename) ||
             preg_match("/\.({$config['cf_flash_extension']})$/i", $filename) ) {
            if ($timg['2'] < 1 || $timg['2'] > 16)
                continue;
        }
        $upload[$i]['image'] = $timg;

		// 존재하는 파일이 있다면 삭제합니다.
		$row = sql_fetch(" select bf_file from {$g5['board_file_table']} where bo_table = 'm_ship' and wr_id = '{$s_idx}' and bf_no = '{$i}' ");
		@unlink(G5_DATA_PATH.'/file/m_ship/'.$row['bf_file']);

        // 프로그램 원래 파일명
        $upload[$i]['source'] = $filename;
        $upload[$i]['filesize'] = $filesize;

        // 아래의 문자열이 들어간 파일은 -x 를 붙여서 웹경로를 알더라도 실행을 하지 못하도록 함
        $filename = preg_replace("/\.(php|phtm|htm|cgi|pl|exe|jsp|asp|inc)/i", "$0-x", $filename);

        shuffle($chars_array);
        $shuffle = implode('', $chars_array);

        // 첨부파일 첨부시 첨부파일명에 공백이 포함되어 있으면 일부 PC에서 보이지 않거나 다운로드 되지 않는 현상이 있습니다. (길상여의 님 090925)
        $upload[$i]['file'] = abs(ip2long($_SERVER['REMOTE_ADDR'])).'_'.substr($shuffle,0,8).'_'.replace_filename($filename);
		// 아래 확장자명 체크필터링 해줘야 imgrescale 함수 제대로 적용됨.
		$upload[$i]['file'] = str_replace('.PNG', '.png', $upload[$i]['file']);
		$upload[$i]['file'] = str_replace('.JPG', '.jpg', $upload[$i]['file']);
		$upload[$i]['file'] = str_replace('.jpeg', '.jpg', $upload[$i]['file']);
		$upload[$i]['file'] = str_replace('.JPEG', '.jpg', $upload[$i]['file']);

		$dest_file_path = G5_DATA_PATH.'/file/m_ship';
		$dest_file = G5_DATA_PATH.'/file/m_ship/'.$upload[$i]['file'];
		$dest_thumb_file_path = G5_DATA_PATH.'/file/m_ship/thumb';
		$dest_thumb_file = G5_DATA_PATH.'/file/m_ship/thumb/'.$upload[$i]['file'];
		$dest_thumb_file_path2 = G5_DATA_PATH.'/file/m_ship/thumb2';
		$dest_thumb_file2 = G5_DATA_PATH.'/file/m_ship/thumb2/'.$upload[$i]['file'];

        // 업로드가 안된다면 에러메세지 출력하고 죽어버립니다.
        $error_code = move_uploaded_file($tmp_file, $dest_file) or die($_FILES['bf_file']['error'][$i]);

		$imgWidth = $upload[$i]['image']['0'];
		$imgHeight = $upload[$i]['image']['1'];
		
		//업로드된 파일이 큰 이미지라면 잘라냄
		if($imgWidth > 1200)
		{
			imgrescale($upload[$i]['file'], $dest_file_path, $dest_file_path, 1200, "", $is_create, $is_crop, $crop_mode, $is_sharpen, $um_value);
			$newtimg = @getimagesize($dest_file);
			$imgWidth = $newtimg['0'];
			$imgHeight = $newtimg['1'];
		}
		
		//썸네일 생성
		//center_crop
		center_crop($dest_file,$dest_thumb_file,$thumb_w,$thumb_h,$quality=80);
		center_crop($dest_file,$dest_thumb_file2,$thumb_w2,$thumb_h2,$quality=80);
		
		chmod($dest_file, G5_FILE_PERMISSION);
		chmod($dest_thumb_file, G5_FILE_PERMISSION);
		chmod($dest_thumb_file2, G5_FILE_PERMISSION);
    }
}

// 나중에 테이블에 저장하는 이유는 $wr_id 값을 저장해야 하기 때문입니다.
for ($i=0; $i<count($upload); $i++)
{
    if (!get_magic_quotes_gpc()) {
        $upload[$i]['source'] = addslashes($upload[$i]['source']);
    }

    $row = sql_fetch(" select count(*) as cnt from {$g5['board_file_table']} where bo_table = 'm_ship' and wr_id = '{$s_idx}' and bf_no = '{$i}' ");
    if ($row['cnt'])
    {
        // 삭제에 체크가 있거나 파일이 있다면 업데이트를 합니다.
        // 그렇지 않다면 내용만 업데이트 합니다.
        if ($upload[$i]['del_check'] || $upload[$i]['file'])
        {
            $sql = " update {$g5['board_file_table']}
                        set bf_source = '{$upload[$i]['source']}',
                             bf_file = '{$upload[$i]['file']}',
                             bf_content = '{$bf_content[$i]}',
                             bf_filesize = '{$upload[$i]['filesize']}',
                             bf_width = '{$upload[$i]['image']['0']}',
                             bf_height = '{$upload[$i]['image']['1']}',
                             bf_type = '{$upload[$i]['image']['2']}',
                             bf_datetime = '".G5_TIME_YMDHIS."'
                      where bo_table = 'm_ship'
                                and wr_id = '{$s_idx}'
                                and bf_no = '{$i}' ";
            sql_query($sql);
        }
        else
        {
            $sql = " update {$g5['board_file_table']}
                        set bf_content = '{$bf_content[$i]}'
                        where bo_table = 'm_ship'
                                  and wr_id = '{$s_idx}'
                                  and bf_no = '{$i}' ";
            sql_query($sql);
        }
    }
    else
    {
        $sql = " insert into {$g5['board_file_table']}
                    set bo_table = 'm_ship',
                         wr_id = '{$s_idx}',
                         bf_no = '{$i}',
                         bf_source = '{$upload[$i]['source']}',
                         bf_file = '{$upload[$i]['file']}',
                         bf_content = '{$bf_content[$i]}',
                         bf_download = 0,
                         bf_filesize = '{$upload[$i]['filesize']}',
                         bf_width = '{$upload[$i]['image']['0']}',
                         bf_height = '{$upload[$i]['image']['1']}',
                         bf_type = '{$upload[$i]['image']['2']}',
                         bf_datetime = '".G5_TIME_YMDHIS."' ";
        sql_query($sql);
    }
}

// 업로드된 파일 내용에서 가장 큰 번호를 얻어 거꾸로 확인해 가면서
// 파일 정보가 없다면 테이블의 내용을 삭제합니다.
$row = sql_fetch(" select max(bf_no) as max_bf_no from {$g5['board_file_table']} where bo_table = 'm_ship' and wr_id = '{$s_idx}' ");
for ($i=(int)$row['max_bf_no']; $i>=0; $i--)
{
    $row2 = sql_fetch(" select bf_file from {$g5['board_file_table']} where bo_table = 'm_ship' and wr_id = '{$s_idx}' and bf_no = '{$i}' ");

    // 정보가 있다면 빠집니다.
    if ($row2['bf_file']) break;

    // 그렇지 않다면 정보를 삭제합니다.
    sql_query(" delete from {$g5['board_file_table']} where bo_table = 'm_ship' and wr_id = '{$s_idx}' and bf_no = '{$i}' ");
}

//===== API 실행 ======
/*
$_data = array();
$_data["s_idx"] = $s_idx;
$_data["s_uidx"] = $s_uidx;
$_data["s_expose"] = $s_expose;
$_data["s_owner"] = $s_owner;
$_data["s_name"] = $s_name;
$_data["s_max"] = $s_max;
$_data["s_min"] = $s_min;
$_data["s_theme"] = $s_theme;
$_data["s_price"] = $s_price;
$_data["s_cont"] = $s_cont;
$_data["s_addr"] = $s_addr;
$_data["s_schedule"] = $s_schedule;
$_data["s_service_arr"] = $s_service_arr;
$_data["mapx"] = $mapx;
$_data["mapy"] = $mapy;
$_data["regip"] = $_SERVER['REMOTE_ADDR'];

$arr = array();
$arr[com_uidx]   = $comfig[com_uidx];
$arr[com_name] = $comfig[com_name];
$arr[sdom]        = $comfig[sdom];
$arr[data]	       = $_data;

$curlData = http_build_query($arr);
$curlUrl = "https://monak.kr/api/_ship_save.php";
//$curlUrl = "https://www.monak.co.kr/api/_ship_save.php";
curl_api($curlUrl, $curlData);
*/
//===== API 종료 ======

//print_r2($arr); exit;
goto_url(G5_ADMINSHIP_URL."/ship_list.php");
?>