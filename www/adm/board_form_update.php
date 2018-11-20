<?php
$sub_menu = "300100";
include_once('./_common.php');

if ($w == 'u')
    check_demo();

auth_check($auth[$sub_menu], 'w');

check_admin_token();

if (!$_POST['gr_id']) { alert('그룹 ID는 반드시 선택하세요.'); }
if (!$bo_table) { alert('게시판 TABLE명은 반드시 입력하세요.'); }
if (!preg_match("/^([A-Za-z0-9_]{1,20})$/", $bo_table)) { alert('게시판 TABLE명은 공백없이 영문자, 숫자, _ 만 사용 가능합니다. (20자 이내)'); }
if (!$_POST['bo_subject']) { alert('게시판 제목을 입력하세요.'); }

$_POST['bo_include_head'] = preg_replace("#[\\\]+$#", "", substr($_POST['bo_include_head'], 0, 255));
$_POST['bo_include_tail'] = preg_replace("#[\\\]+$#", "", substr($_POST['bo_include_tail'], 0, 255));

if ($file = $_POST['bo_include_head']) {
    $purl = parse_url($file);
    $file = $purl['path'];
    if (!preg_match("/\.(php|htm['l']?)$/i", $file)) {
        alert('상단 파일 경로가 php, html 파일이 아닙니다.');
    }
    $_POST['bo_include_head'] = $file;
}

if ($file = $_POST['bo_include_tail']) {
    $purl = parse_url($file);
    $file = $purl['path'];
    if (!preg_match("/\.(php|htm['l']?)$/i", $file)) {
        alert('하단 파일 경로가 php, html 파일이 아닙니다.');
    }
    $_POST['bo_include_tail'] = $file;
}

if(!is_include_path_check($_POST['bo_include_head'])) {
    alert('/data/file/ 또는 /data/editor/ 포함된 문자를 상단 파일 경로에 포함시킬수 없습니다.');
}

if(!is_include_path_check($_POST['bo_include_tail'])) {
    alert('/data/file/ 또는 /data/editor/ 포함된 문자를 하단 파일 경로에 포함시킬수 없습니다.');
}

$board_path = G5_DATA_PATH.'/file/'.$bo_table;

// 게시판 디렉토리 생성
@mkdir($board_path, G5_DIR_PERMISSION);
@chmod($board_path, G5_DIR_PERMISSION);

// 디렉토리에 있는 파일의 목록을 보이지 않게 한다.
$file = $board_path . '/index.php';
$f = @fopen($file, 'w');
@fwrite($f, '');
@fclose($f);
@chmod($file, G5_FILE_PERMISSION);

// 분류에 & 나 = 는 사용이 불가하므로 2바이트로 바꾼다.
$src_char = array('&', '=');
$dst_char = array('＆', '〓');
$bo_category_list = str_replace($src_char, $dst_char, $bo_category_list);

$sql_common = " bo_subject          = '{$_POST['bo_subject']}',
                bo_list_level       = '{$_POST['bo_list_level']}',
                bo_read_level       = '{$_POST['bo_read_level']}',
                bo_write_level      = '{$_POST['bo_write_level']}',
                bo_reply_level      = '{$_POST['bo_reply_level']}',
                bo_comment_level    = '{$_POST['bo_comment_level']}',
                bo_html_level       = '{$_POST['bo_html_level']}',
                bo_link_level       = '{$_POST['bo_link_level']}',
                bo_upload_level     = '{$_POST['bo_upload_level']}',
                bo_download_level   = '{$_POST['bo_download_level']}',
                bo_use_category     = '{$_POST['bo_use_category']}',
                bo_category_list    = '{$_POST['bo_category_list']}',
                bo_use_secret       = '{$_POST['bo_use_secret']}',
                bo_use_dhtml_editor = '{$_POST['bo_use_dhtml_editor']}',
                bo_use_good         = '{$_POST['bo_use_good']}',
                bo_use_nogood       = '{$_POST['bo_use_nogood']}',
                bo_use_ip_view      = '{$_POST['bo_use_ip_view']}',
                bo_use_email        = '{$_POST['bo_use_email']}',
                bo_table_width      = '{$_POST['bo_table_width']}',
                bo_subject_len      = '{$_POST['bo_subject_len']}',
                bo_page_rows        = '{$_POST['bo_page_rows']}',
                bo_new              = '{$_POST['bo_new']}',
                bo_hot              = '{$_POST['bo_hot']}',
                bo_skin             = '{$_POST['bo_skin']}',
                bo_include_head     = '{$_POST['bo_include_head']}',
                bo_include_tail     = '{$_POST['bo_include_tail']}',
                bo_upload_count     = '{$_POST['bo_upload_count']}',
                bo_upload_size      = '{$_POST['bo_upload_size']}',
                bo_reply_order      = '{$_POST['bo_reply_order']}',
                bo_use_search       = '{$_POST['bo_use_search']}',
                bo_order            = '{$_POST['bo_order']}',
                bo_sort_field       = '{$_POST['bo_sort_field']}' ";

if ($w == '') {

    $row = sql_fetch(" select count(*) as cnt from {$g5['board_table']} where bo_table = '{$bo_table}' ");
    if ($row['cnt'])
        alert($bo_table.' 은(는) 이미 존재하는 TABLE 입니다.');

    $sql = " insert into {$g5['board_table']}
                set bo_table = '{$bo_table}',
                    bo_count_write = '0',
                    bo_count_comment = '0',
                    $sql_common ";
    sql_query($sql);

    // 게시판 테이블 생성
    $file = file('./sql_write.sql');
    $sql = implode($file, "\n");

    $create_table = $g5['write_prefix'] . $bo_table;

    // sql_board.sql 파일의 테이블명을 변환
    $source = array('/__TABLE_NAME__/', '/;/');
    $target = array($create_table, '');
    $sql = preg_replace($source, $target, $sql);
    sql_query($sql, FALSE);

} else if ($w == 'u') {

    // 게시판의 글 수
    $sql = " select count(*) as cnt from {$g5['write_prefix']}{$bo_table} where wr_is_comment = 0 ";
    $row = sql_fetch($sql);
    $bo_count_write = $row['cnt'];

    // 게시판의 코멘트 수
    $sql = " select count(*) as cnt from {$g5['write_prefix']}{$bo_table} where wr_is_comment = 1 ";
    $row = sql_fetch($sql);
    $bo_count_comment = $row['cnt'];

    // 글수 조정
    if (isset($_POST['proc_count'])) {
        // 원글을 얻습니다.
        $sql = " select a.wr_id, (count(b.wr_parent) - 1) as cnt from {$g5['write_prefix']}{$bo_table} a, {$g5['write_prefix']}{$bo_table} b where a.wr_id=b.wr_parent and a.wr_is_comment=0 group by a.wr_id ";
        $result = sql_query($sql);
        for ($i=0; $row=sql_fetch_array($result); $i++) {
            sql_query(" update {$g5['write_prefix']}{$bo_table} set wr_comment = '{$row['cnt']}' where wr_id = '{$row['wr_id']}' ");
        }
    }

    // 공지사항에는 등록되어 있지만 실제 존재하지 않는 글 아이디는 삭제합니다.
    $bo_notice = "";
    $lf = "";
    if ($board['bo_notice']) {
        $tmp_array = explode(",", $board['bo_notice']);
        for ($i=0; $i<count($tmp_array); $i++) {
            $tmp_wr_id = trim($tmp_array[$i]);
            $row = sql_fetch(" select count(*) as cnt from {$g5['write_prefix']}{$bo_table} where wr_id = '{$tmp_wr_id}' ");
            if ($row['cnt'])
            {
                $bo_notice .= $lf . $tmp_wr_id;
                $lf = ",";
            }
        }
    }

    $sql = " update {$g5['board_table']}
                set bo_notice = '{$bo_notice}',
                    bo_count_write = '{$bo_count_write}',
                    bo_count_comment = '{$bo_count_comment}',
                    {$sql_common}
              where bo_table = '{$bo_table}' ";
    sql_query($sql);

}

delete_cache_latest($bo_table);

goto_url("./board_form.php?w=u&bo_table={$bo_table}&amp;{$qstr}");
?>
