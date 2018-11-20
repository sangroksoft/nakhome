<?php
$sub_menu = "300100";
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], 'w');

$sql = " select count(*) as cnt from {$g5['group_table']} ";
$row = sql_fetch($sql);
if (!$row['cnt'])  alert('게시판그룹이 한개 이상 생성되어야 합니다.', './boardgroup_form.php');

$html_title = '게시판';

if (!isset($board['bo_device'])) {
    // 게시판 사용 필드 추가
    // both : pc, mobile 둘다 사용
    // pc : pc 전용 사용
    // mobile : mobile 전용 사용
    // none : 사용 안함
    sql_query(" ALTER TABLE  `{$g5['board_table']}` ADD  `bo_device` ENUM(  'both',  'pc',  'mobile' ) NOT NULL DEFAULT  'both' AFTER  `bo_subject` ", false);
}

if (!isset($board['bo_mobile_skin'])) {
    sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `bo_mobile_skin` VARCHAR(255) NOT NULL DEFAULT '' AFTER `bo_skin` ", false);
}

if (!isset($board['bo_gallery_width'])) {
    sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `bo_gallery_width` INT NOT NULL AFTER `bo_gallery_cols`,  ADD `bo_gallery_height` INT NOT NULL DEFAULT '0' AFTER `bo_gallery_width`,  ADD `bo_mobile_gallery_width` INT NOT NULL DEFAULT '0' AFTER `bo_gallery_height`,  ADD `bo_mobile_gallery_height` INT NOT NULL DEFAULT '0' AFTER `bo_mobile_gallery_width` ", false);
}

if (!isset($board['bo_mobile_subject_len'])) {
    sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `bo_mobile_subject_len` INT(11) NOT NULL DEFAULT '0' AFTER `bo_subject_len` ", false);
}

if (!isset($board['bo_mobile_page_rows'])) {
    sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `bo_mobile_page_rows` INT(11) NOT NULL DEFAULT '0' AFTER `bo_page_rows` ", false);
}

if (!isset($board['bo_mobile_content_head'])) {
    sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `bo_mobile_content_head` TEXT NOT NULL AFTER `bo_content_head`, ADD `bo_mobile_content_tail` TEXT NOT NULL AFTER `bo_content_tail`", false);
}

if (!isset($board['bo_use_cert'])) {
    sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `bo_use_cert` ENUM('','cert','adult') NOT NULL DEFAULT '' AFTER `bo_use_email` ", false);
}

if (!isset($board['bo_use_sns'])) {
    sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `bo_use_sns` TINYINT NOT NULL DEFAULT '0' AFTER `bo_use_cert` ", false);

    $result = sql_query(" select bo_table from `{$g5['board_table']}` ");
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        sql_query(" ALTER TABLE `{$g5['write_prefix']}{$row['bo_table']}`
                    ADD `wr_facebook_user` VARCHAR(255) NOT NULL DEFAULT '' AFTER `wr_ip`,
                    ADD `wr_twitter_user` VARCHAR(255) NOT NULL DEFAULT '' AFTER `wr_facebook_user` ", false);
    }
}

$sql = " SHOW COLUMNS FROM `{$g5['board_table']}` LIKE 'bo_use_cert' ";
$row = sql_fetch($sql);
if(strpos($row['Type'], 'hp-') === false) {
    sql_query(" ALTER TABLE `{$g5['board_table']}` CHANGE `bo_use_cert` `bo_use_cert` ENUM('','cert','adult','hp-cert','hp-adult') NOT NULL DEFAULT '' ", false);
}

if (!isset($board['bo_use_list_file'])) {
    sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `bo_use_list_file` TINYINT NOT NULL DEFAULT '0' AFTER `bo_use_list_view` ", false);

    $result = sql_query(" select bo_table from `{$g5['board_table']}` ");
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        sql_query(" ALTER TABLE `{$g5['write_prefix']}{$row['bo_table']}`
                    ADD `wr_file` TINYINT NOT NULL DEFAULT '0' AFTER `wr_datetime` ", false);
    }
}

if (!isset($board['bo_mobile_subject'])) {
    sql_query(" ALTER TABLE `{$g5['board_table']}` ADD `bo_mobile_subject` VARCHAR(255) NOT NULL DEFAULT '' AFTER `bo_subject` ", false);
}

$required = "";
$readonly = "";
if ($w == '') {

    $html_title .= ' 생성';

    $required = 'required';
    $required_valid = 'alnum_';
    $sound_only = '<strong class="sound_only">필수</strong>';

    $board['bo_count_delete'] = 1;
    $board['bo_count_modify'] = 1;
    $board['bo_read_point'] = $config['cf_read_point'];
    $board['bo_write_point'] = $config['cf_write_point'];
    $board['bo_comment_point'] = $config['cf_comment_point'];
    $board['bo_download_point'] = $config['cf_download_point'];

    $board['bo_gallery_cols'] = 4;
    $board['bo_gallery_width'] = 174;
    $board['bo_gallery_height'] = 124;
    $board['bo_mobile_gallery_width'] = 125;
    $board['bo_mobile_gallery_height'] = 100;
    $board['bo_table_width'] = 100;
    $board['bo_page_rows'] = $config['cf_page_rows'];
    $board['bo_mobile_page_rows'] = $config['cf_page_rows'];
    $board['bo_subject_len'] = 60;
    $board['bo_mobile_subject_len'] = 30;
    $board['bo_new'] = 24;
    $board['bo_hot'] = 100;
    $board['bo_image_width'] = 600;
    $board['bo_upload_count'] = 2;
    $board['bo_upload_size'] = 1048576;
    $board['bo_reply_order'] = 1;
    $board['bo_use_search'] = 1;
    $board['bo_skin'] = 'basic';
    $board['bo_mobile_skin'] = 'basic';
    $board['gr_id'] = $gr_id;
    $board['bo_use_secret'] = 0;
    $board['bo_include_head'] = '_head.php';
    $board['bo_include_tail'] = '_tail.php';

} else if ($w == 'u') {

    $html_title .= ' 수정';

    if (!$board['bo_table'])
        alert('존재하지 않은 게시판 입니다.');

    if ($is_admin == 'group') {
        if ($member['mb_id'] != $group['gr_admin'])
            alert('그룹이 틀립니다.');
    }

    $readonly = 'readonly';

}

if ($is_admin != 'super') {
    $group = get_group($board['gr_id']);
    $is_admin = is_admin($member['mb_id']);
}

$g5['title'] = $html_title;
include_once ('./admin.head.php');

$pg_anchor = '<ul class="anchor">
    <li><a href="#anc_bo_basic">기본 설정</a></li>
    <li><a href="#anc_bo_auth">권한 설정</a></li>
    <li><a href="#anc_bo_function">기능 설정</a></li>
    <li><a href="#anc_bo_design">디자인/양식</a></li>
</ul>';

$frm_submit = '<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="확인" class="btn_submit" accesskey="s">
    <a href="./board_list.php?'.$qstr.'">목록</a>'.PHP_EOL;
if ($w == 'u') $frm_submit .= '<a href="./board_copy.php?bo_table='.$bo_table.'" id="board_copy" target="win_board_copy">게시판복사</a>
    <a href="'.G5_BBS_URL.'/board.php?bo_table='.$board['bo_table'].'" class="btn_frmline">게시판 바로가기</a>
    <a href="./board_thumbnail_delete.php?bo_table='.$board['bo_table'].'&amp;'.$qstr.'" onclick="return delete_confirm2(\'게시판 썸네일 파일을 삭제하시겠습니까?\');">게시판 썸네일 삭제</a>'.PHP_EOL;
$frm_submit .= '</div>';
?>
<style>
select{height:24px; border:1px solid #ccc;}
</style>

<form name="fboardform" id="fboardform" action="./board_form_update.php" onsubmit="return fboardform_submit(this)" method="post" enctype="multipart/form-data">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">
<input type="hidden" name="gr_id" value="nakhome">
<input type="hidden" name="bo_count_modify" value="1">
<input type="hidden" name="bo_count_delete" value="1">
<input type="hidden" name="bo_table_width" value="100">

<section id="anc_bo_basic">
    <h2 class="h2_frm">게시판 기본 설정</h2>
    <?php echo $pg_anchor ?>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>게시판 기본 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
            <col class="grid_3">
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="bo_table">TABLE<?php echo $sound_only ?></label></th>
            <td colspan="2">
                <input type="text" name="bo_table" value="<?php echo $board['bo_table'] ?>" id="bo_table" <?php echo $required ?> <?php echo $readonly ?> class="frm_input <?php echo $reaonly ?> <?php echo $required ?> <?php echo $required_valid ?>" maxlength="20">
                <?php if ($w == '') { ?>
                    영문자, 숫자, _ 만 가능 (공백없이 20자 이내)
                <?php } else { ?>
                    <a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $board['bo_table'] ?>" class="btn_frmline">게시판 바로가기</a>
                    <a href="./board_list.php" class="btn_frmline">목록으로</a>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="bo_subject">게시판 제목<strong class="sound_only">필수</strong></label></th>
            <td colspan="2">
                <input type="text" name="bo_subject" value="<?php echo get_text($board['bo_subject']) ?>" id="bo_subject" required class="required frm_input" size="80" maxlength="120">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="bo_category_list">분류</label></th>
            <td colspan="2">
                <?php echo help('분류와 분류 사이는 | 로 구분하세요. (예: 질문|답변) 첫자로 #은 입력하지 마세요. (예: #질문|#답변 [X])') ?>
                <input type="text" name="bo_category_list" value="<?php echo get_text($board['bo_category_list']) ?>" id="bo_category_list" class="frm_input" size="70">
                <input type="checkbox" name="bo_use_category" value="1" id="bo_use_category" <?php echo $board['bo_use_category']?'checked':''; ?>>
                <label for="bo_use_category">사용</label>
            </td>
        </tr>
        <?php if ($w == 'u') { ?>
        <tr>
            <th scope="row"><label for="proc_count">카운트 조정</label></th>
            <td colspan="2">
                <?php echo help('게시판 목록에서 글의 번호가 맞지 않을 경우에 체크하십시오.') ?>
                <input type="checkbox" name="proc_count" value="1" id="proc_count">
            </td>
        </tr>
        <?php } ?>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>

<section id="anc_bo_auth">
    <h2 class="h2_frm">게시판 권한 설정</h2>
    <?php echo $pg_anchor ?>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>게시판 권한 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
            <col class="grid_3">
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="bo_list_level">목록보기 권한</label></th>
            <td>
                <?php echo help('권한 1은 비회원, 2 이상 회원입니다. 권한은 10 이 가장 높습니다.') ?>
                <?php echo get_member_level_select('bo_list_level', 1, 10, $board['bo_list_level']) ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="bo_read_level">글읽기 권한</label></th>
            <td>
                <?php echo get_member_level_select('bo_read_level', 1, 10, $board['bo_read_level']) ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="bo_write_level">글쓰기 권한</label></th>
            <td>
                <?php echo get_member_level_select('bo_write_level', 1, 10, $board['bo_write_level']) ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="bo_reply_level">글답변 권한</label></th>
            <td>
                <?php echo get_member_level_select('bo_reply_level', 1, 10, $board['bo_reply_level']) ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="bo_comment_level">댓글쓰기 권한</label></th>
            <td>
                <?php echo get_member_level_select('bo_comment_level', 1, 10, $board['bo_comment_level']) ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="bo_link_level">링크 권한</label></th>
            <td>
                <?php echo get_member_level_select('bo_link_level', 1, 10, $board['bo_link_level']) ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="bo_upload_level">업로드 권한</label></th>
            <td>
                <?php echo get_member_level_select('bo_upload_level', 1, 10, $board['bo_upload_level']) ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="bo_download_level">다운로드 권한</label></th>
            <td>
                <?php echo get_member_level_select('bo_download_level', 1, 10, $board['bo_download_level']) ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="bo_html_level">HTML 쓰기 권한</label></th>
            <td>
                <?php echo get_member_level_select('bo_html_level', 1, 10, $board['bo_html_level']) ?>
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>

<section id="anc_bo_function">
    <h2 class="h2_frm">게시판 기능 설정</h2>
    <?php echo $pg_anchor ?>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>게시판 기능 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
            <col class="grid_3">
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="bo_use_secret">비밀글 사용</label></th>
            <td>
                <?php echo help('"체크박스"는 글작성시 비밀글 체크가 가능합니다. "무조건"은 작성되는 모든글을 비밀글로 작성합니다. (관리자는 체크박스로 출력합니다.) 스킨에 따라 적용되지 않을 수 있습니다.') ?>
                <select id="bo_use_secret" name="bo_use_secret">
                    <?php echo option_selected(0, $board['bo_use_secret'], "사용하지 않음"); ?>
                    <?php echo option_selected(1, $board['bo_use_secret'], "체크박스"); ?>
                    <?php echo option_selected(2, $board['bo_use_secret'], "무조건"); ?>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="bo_use_dhtml_editor">DHTML 에디터 사용</label></th>
            <td>
                <?php echo help('글작성시 내용을 DHTML 에디터 기능으로 사용할 것인지 설정합니다. 스킨에 따라 적용되지 않을 수 있습니다.') ?>
                <input type="checkbox" name="bo_use_dhtml_editor" value="1" <?php echo $board['bo_use_dhtml_editor']?'checked':''; ?> id="bo_use_dhtml_editor">
                사용
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="bo_use_good">추천 사용</label></th>
            <td>
                <input type="checkbox" name="bo_use_good" value="1" <?php echo $board['bo_use_good']?'checked':''; ?> id="bo_use_good">
                사용
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="bo_use_nogood">비추천 사용</label></th>
            <td>
                <input type="checkbox" name="bo_use_nogood" value="1" id="bo_use_nogood" <?php echo $board['bo_use_nogood']?'checked':''; ?>>
                사용
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="bo_use_ip_view">IP 보이기 사용</label></th>
            <td>
                <input type="checkbox" name="bo_use_ip_view" value="1" id="bo_use_ip_view" <?php echo $board['bo_use_ip_view']?'checked':''; ?>>
                사용
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="bo_use_email">메일발송 사용</label></th>
            <td>
                <input type="checkbox" name="bo_use_email" value="1" id="bo_use_email" <?php echo $board['bo_use_email']?'checked':''; ?>>
                사용
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="bo_upload_count">파일 업로드 개수<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo help('게시물 한건당 업로드 할 수 있는 파일의 최대 개수 (0 은 파일첨부 사용하지 않음)') ?>
                <input type="text" name="bo_upload_count" value="<?php echo $board['bo_upload_count'] ?>" id="bo_upload_count" required class="required numeric frm_input" size="4">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="bo_upload_size">파일 업로드 용량<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo help('최대 '.ini_get("upload_max_filesize").' 이하 업로드 가능, 1 MB = 1,048,576 bytes') ?>
                업로드 파일 한개당 <input type="text" name="bo_upload_size" value="<?php echo $board['bo_upload_size'] ?>" id="bo_upload_size" required class="required numeric frm_input"  size="10"> bytes 이하
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="bo_use_search">전체 검색 사용</label></th>
            <td>
                <input type="checkbox" name="bo_use_search" value="1" id="bo_use_search" <?php echo $board['bo_use_search']?'checked':''; ?>>
                사용
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="bo_order">출력 순서</label></th>
            <td>
                <?php echo help('숫자가 낮은 게시판 부터 메뉴나 검색시 우선 출력합니다.') ?>
                <input type="text" name="bo_order" value="<?php echo $board['bo_order'] ?>" id="bo_order" class="frm_input" size="4">
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>

<section id="anc_bo_design">
    <h2 class="h2_frm">게시판 디자인/양식</h2>
    <?php echo $pg_anchor ?>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>게시판 디자인/양식</caption>
        <colgroup>
            <col class="grid_4">
            <col>
            <col class="grid_3">
        </colgroup>
        <tbody>
            <tr>
            <th scope="row"><label for="bo_skin">스킨 디렉토리<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo get_skin_select('board', 'bo_skin', 'bo_skin', $board['bo_skin'], 'required'); ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="bo_include_head">상단 파일 경로</label></th>
            <td>
                <input type="text" name="bo_include_head" value="<?php echo $board['bo_include_head'] ?>" id="bo_include_head" class="frm_input" size="50">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="bo_include_tail">하단 파일 경로</label></th>
            <td>
                <input type="text" name="bo_include_tail" value="<?php echo $board['bo_include_tail'] ?>" id="bo_include_tail" class="frm_input" size="50">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="bo_subject_len">제목 길이<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo help('목록에서의 제목 글자수. 잘리는 글은 … 로 표시') ?>
                <input type="text" name="bo_subject_len" value="<?php echo $board['bo_subject_len'] ?>" id="bo_subject_len" required class="required numeric frm_input" size="4">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="bo_page_rows">페이지당 목록 수<strong class="sound_only">필수</strong></label></th>
            <td>
                <input type="text" name="bo_page_rows" value="<?php echo $board['bo_page_rows'] ?>" id="bo_page_rows" required class="required numeric frm_input" size="4">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="bo_new">새글 아이콘<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo help('글 입력후 new 이미지를 출력하는 시간. 0을 입력하시면 아이콘을 출력하지 않습니다.') ?>
                <input type="text" name="bo_new" value="<?php echo $board['bo_new'] ?>" id="bo_new" required class="required numeric frm_input" size="4">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="bo_hot">인기글 아이콘<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo help('조회수가 설정값 이상이면 hot 이미지 출력. 0을 입력하시면 아이콘을 출력하지 않습니다.') ?>
                <input type="text" name="bo_hot" value="<?php echo $board['bo_hot'] ?>" id="bo_hot" required class="required numeric frm_input" size="4">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="bo_reply_order">답변 달기</label></th>
            <td>
                <select id="bo_reply_order" name="bo_reply_order">
                    <option value="1"<?php echo get_selected($board['bo_reply_order'], 1, true); ?>>나중에 쓴 답변 아래로 달기 (기본)
                    <option value="0"<?php echo get_selected($board['bo_reply_order'], 0); ?>>나중에 쓴 답변 위로 달기
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="bo_sort_field">리스트 정렬 필드</label></th>
            <td>
                <?php echo help('리스트에서 기본으로 정렬에 사용할 필드를 선택합니다. "기본"으로 사용하지 않으시는 경우 속도가 느려질 수 있습니다.') ?>
                <select id="bo_sort_field" name="bo_sort_field">
                    <option value="" <?php echo get_selected($board['bo_sort_field'], ""); ?>>wr_num, wr_reply : 기본</option>
                    <option value="wr_datetime asc" <?php echo get_selected($board['bo_sort_field'], "wr_datetime asc"); ?>>wr_datetime asc : 날짜 이전것 부터</option>
                    <option value="wr_datetime desc" <?php echo get_selected($board['bo_sort_field'], "wr_datetime desc"); ?>>wr_datetime desc : 날짜 최근것 부터</option>
                    <option value="wr_hit asc, wr_num, wr_reply" <?php echo get_selected($board['bo_sort_field'], "wr_hit asc, wr_num, wr_reply"); ?>>wr_hit asc : 조회수 낮은것 부터</option>
                    <option value="wr_hit desc, wr_num, wr_reply" <?php echo get_selected($board['bo_sort_field'], "wr_hit desc, wr_num, wr_reply"); ?>>wr_hit desc : 조회수 높은것 부터</option>
                    <option value="wr_last asc" <?php echo get_selected($board['bo_sort_field'], "wr_last asc"); ?>>wr_last asc : 최근글 이전것 부터</option>
                    <option value="wr_last desc" <?php echo get_selected($board['bo_sort_field'], "wr_last desc"); ?>>wr_last desc : 최근글 최근것 부터</option>
                    <option value="wr_comment asc, wr_num, wr_reply" <?php echo get_selected($board['bo_sort_field'], "wr_comment asc, wr_num, wr_reply"); ?>>wr_comment asc : 댓글수 낮은것 부터</option>
                    <option value="wr_comment desc, wr_num, wr_reply" <?php echo get_selected($board['bo_sort_field'], "wr_comment desc, wr_num, wr_reply"); ?>>wr_comment desc : 댓글수 높은것 부터</option>
                    <option value="wr_good asc, wr_num, wr_reply" <?php echo get_selected($board['bo_sort_field'], "wr_good asc, wr_num, wr_reply"); ?>>wr_good asc : 추천수 낮은것 부터</option>
                    <option value="wr_good desc, wr_num, wr_reply" <?php echo get_selected($board['bo_sort_field'], "wr_good desc, wr_num, wr_reply"); ?>>wr_good desc : 추천수 높은것 부터</option>
                    <option value="wr_nogood asc, wr_num, wr_reply" <?php echo get_selected($board['bo_sort_field'], "wr_nogood asc, wr_num, wr_reply"); ?>>wr_nogood asc : 비추천수 낮은것 부터</option>
                    <option value="wr_nogood desc, wr_num, wr_reply" <?php echo get_selected($board['bo_sort_field'], "wr_nogood desc, wr_num, wr_reply"); ?>>wr_nogood desc : 비추천수 높은것 부터</option>
                    <option value="wr_subject asc, wr_num, wr_reply" <?php echo get_selected($board['bo_sort_field'], "wr_subject asc, wr_num, wr_reply"); ?>>wr_subject asc : 제목 오름차순</option>
                    <option value="wr_subject desc, wr_num, wr_reply" <?php echo get_selected($board['bo_sort_field'], "wr_subject desc, wr_num, wr_reply"); ?>>wr_subject desc : 제목 내림차순</option>
                    <option value="wr_name asc, wr_num, wr_reply" <?php echo get_selected($board['bo_sort_field'], "wr_name asc, wr_num, wr_reply"); ?>>wr_name asc : 글쓴이 오름차순</option>
                    <option value="wr_name desc, wr_num, wr_reply" <?php echo get_selected($board['bo_sort_field'], "wr_name desc, wr_num, wr_reply"); ?>>wr_name desc : 글쓴이 내림차순</option>
                    <option value="ca_name asc, wr_num, wr_reply" <?php echo get_selected($board['bo_sort_field'], "ca_name asc, wr_num, wr_reply"); ?>>ca_name asc : 분류명 오름차순</option>
                    <option value="ca_name desc, wr_num, wr_reply" <?php echo get_selected($board['bo_sort_field'], "ca_name desc, wr_num, wr_reply"); ?>>ca_name desc : 분류명 내림차순</option>
                </select>
            </td>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>

</form>

<script>
$(function(){
    $("#board_copy").click(function(){
        window.open(this.href, "win_board_copy", "left=10,top=10,width=500,height=400");
        return false;
    });
});

function board_copy(bo_table) {
    window.open("./board_copy.php?bo_table="+bo_table, "BoardCopy", "left=10,top=10,width=500,height=200");
}

function fboardform_submit(f)
{
    if (parseInt(f.bo_count_modify.value) < 0) {
        alert("원글 수정 불가 댓글수는 0 이상 입력하셔야 합니다.");
        f.bo_count_modify.focus();
        return false;
    }

    if (parseInt(f.bo_count_delete.value) < 1) {
        alert("원글 삭제 불가 댓글수는 1 이상 입력하셔야 합니다.");
        f.bo_count_delete.focus();
        return false;
    }

    return true;
}
</script>

<?php
include_once ('./admin.tail.php');
?>
