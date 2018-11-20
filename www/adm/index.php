<?php
include_once('./_common.php');

$g5['title'] = '관리자메인';
include_once ('./admin.head.php');
//물때api
//선사설정(계약금, 남해,서해,동해 설정)
//집계
//프론트 달력ui

$new_member_rows = 5;
$new_point_rows = 5;
$new_write_rows = 5;

$sql_common = " from {$g5['member_table']} ";

$sql_search = " where (1) and mb_level < '10' " ;

if ($is_admin != 'super')
    $sql_search .= " and mb_level <= '{$member['mb_level']}' ";

if (!$sst) {
    $sst = "mb_datetime";
    $sod = "desc";
}

$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

// 탈퇴회원수
$sql = " select count(*) as cnt {$sql_common} {$sql_search} and mb_leave_date <> '' {$sql_order} ";
$row = sql_fetch($sql);
$leave_count = $row['cnt'];

// 차단회원수
$sql = " select count(*) as cnt {$sql_common} {$sql_search} and mb_intercept_date <> '' {$sql_order} ";
$row = sql_fetch($sql);
$intercept_count = $row['cnt'];

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$new_member_rows} ";
$result = sql_query($sql);

$colspan = 12;
?>

<section>
    <h2>최근 가입회원 <?php echo $new_member_rows ?>건 목록</h2>
    <div class="local_desc02 local_desc">
        총회원수 <?php echo number_format($total_count) ?>명 중 차단 <?php echo number_format($intercept_count) ?>명, 탈퇴 : <?php echo number_format($leave_count) ?>명
    </div>

    <div class="tbl_head01 tbl_wrap">
        <table>
        <caption>최근 가입회원</caption>
        <thead>
        <tr>
            <th scope="col">회원아이디</th>
            <th scope="col">이름</th>
            <th scope="col">닉네임</th>
            <th scope="col">권한</th>
            <th scope="col">가입일</th>
        </tr>
        </thead>
        <tbody>
        <?php
        for ($i=0; $row=sql_fetch_array($result); $i++)
        {
            $leave_date = $row['mb_leave_date'] ? $row['mb_leave_date'] : date("Ymd", G5_SERVER_TIME);
            $intercept_date = $row['mb_intercept_date'] ? $row['mb_intercept_date'] : date("Ymd", G5_SERVER_TIME);

            $mb_nick = get_text($row['mb_nick']);
            $mb_nick = get_text($row['mb_nick']);

            $mb_id = $row['mb_id'];
            if ($row['mb_leave_date'])
                $mb_id = $mb_id;
            else if ($row['mb_intercept_date'])
                $mb_id = $mb_id;

        ?>
        <tr>
            <td class="td_mbid"><?php echo $mb_id ?></td>
            <td class="td_mbname"><?php echo get_text($row['mb_name']); ?></td>
            <td class="td_mbname"><div><?php echo $mb_nick ?></div></td>
            <td class="td_num"><?php echo $row['mb_level'] ?></td>
            <td class="td_datetime"><?php echo $row['mb_datetime']; ?></td>
        </tr>
        <?php
            }
        if ($i == 0)
            echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
        ?>
        </tbody>
        </table>
    </div>

    <div class="btn_list03 btn_list">
        <a href="./member_list.php">회원 전체보기</a>
    </div>

</section>

<?php
$today_start = G5_TIME_YMD." 00:00:00";
$today_end = G5_TIME_YMD." 23:59:59";

$sql_common = " from m_bookdata ";
$sql_search = " where bk_status = '0' and bk_datetime > '{$today_start}' and bk_datetime <= '{$today_end}'  ";
$sql_order = " order by bk_datetime desc ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$new_point_rows} ";
$result = sql_query($sql);

$colspan = 10;
?>

<section>
    <h2>금일 예약접수현황</h2>
    <div class="local_desc02 local_desc">
        전체 <?php echo number_format($total_count) ?> 건 중 <?php echo $new_point_rows ?>건 목록
    </div>

    <div class="tbl_head01 tbl_wrap">
        <table data-tablesaw-mode="swipe" class="tablesaw tablesaw-swipe">
        <caption>금일 예약접수현황</caption>
        <thead>
        <tr>
            <th scope="col" class="xs-hidden">예약자ID</th>
            <th scope="col" >예약자명</th>
            <th scope="col" class="xs-hidden">연락처</th>
            <th scope="col" class="xs-width30">예약어선/출조테마</th>
            <th scope="col" >출조일</th>
            <th scope="col" >출조인원</th>
            <th scope="col" class="xs-hidden">총출조비용</th>
            <th scope="col" class="xs-hidden">예약메모</th>
            <th scope="col" class="xs-hidden">예약접수일</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $row2['mb_id'] = '';
        for ($i=0; $row=sql_fetch_array($result); $i++)
        {
			// 회원ID
			$bk_mb_id = $row[bk_mb_id];
			// 회원명
			$bk_mb_name = get_text($row[bk_mb_name]);
			// 예약자(입금자)명
			$bk_banker = get_text($row[bk_banker]);
			// 예약자연락처
			$bk_tel = get_text($row[bk_tel]);
			// 어선명
			$s_name = get_text($row[s_name]);
			// 출조테마
			$bk_theme = get_text($row[bk_theme]);
			// 출조일
			$bk_ymd = $row[bk_y]."-".$row[bk_m]."-".$row[bk_d];
			// 출조인원
			$bk_member_cnt = number_format($row[bk_member_cnt]);
			// 예약메모
			$bk_memo = get_text($row[bk_memo]);
			// 예약접수일
			$bk_datetime = $row[bk_datetime];
			// 총출조비용
			$bk_price_total = number_format($row[bk_price_total]);
        ?>

        <tr>
            <td class="td_mbid xs-hidden"><a href="./ship/book_list_all.php"><?php echo $bk_mb_id ?></a></td>
            <td class="td_mbname"><a href="./ship/book_list_all.php"><?php echo $bk_mb_name; ?></a></td>
            <td class="td_name sv_use xs-hidden"><div><?php echo $bk_tel ?></div></td>
            <td><a href="./ship/book_list_all.php"><?php echo $s_name; ?> - <?php echo $bk_theme; ?></a></td>
            <td class="td_datetime"><?php echo $bk_ymd ?></td>
            <td class="td_numbig"><?php echo $bk_member_cnt ?></td>
            <td class="td_numbig xs-hidden"><?php echo $bk_price_total ?></td>
            <td class="xs-hidden"><a href="./ship/book_list_all.php"><?php echo $bk_memo ?></a></td>
            <td class="td_datetime xs-hidden"><?php echo $bk_datetime ?></td>
        </tr>

        <?php
        }

        if ($i == 0)
            echo '<tr><td colspan="'.$colspan.'" class="empty_table">금일 예약접수된 내역이 없습니다.</td></tr>';
        ?>
        </tbody>
        </table>
    </div>

    <div class="btn_list03 btn_list">
        <a href="./ship/book_list_all.php">예약 전체보기</a>
    </div>
</section>

<?php
$sql_common = " from {$g5['board_new_table']} a, {$g5['board_table']} b, {$g5['group_table']} c where a.bo_table = b.bo_table and b.gr_id = c.gr_id ";

if ($gr_id)
    $sql_common .= " and b.gr_id = '$gr_id' ";
if ($view) {
    if ($view == 'w')
        $sql_common .= " and a.wr_id = a.wr_parent ";
    else if ($view == 'c')
        $sql_common .= " and a.wr_id <> a.wr_parent ";
}
$sql_order = " order by a.bn_id desc ";

$sql = " select count(*) as cnt {$sql_common} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$colspan = 5;
?>

<section>
    <h2>최근게시물</h2>

    <div class="tbl_head01 tbl_wrap">
        <table>
        <caption>최근게시물</caption>
        <thead>
        <tr>
            <th scope="col">게시판</th>
            <th scope="col" class="xs-width30">제목</th>
            <th scope="col">이름</th>
            <th scope="col">일시</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sql = " select a.*, b.bo_subject, c.gr_subject, c.gr_id {$sql_common} {$sql_order} limit {$new_write_rows} ";
        $result = sql_query($sql);
        for ($i=0; $row=sql_fetch_array($result); $i++)
        {
            $tmp_write_table = $g5['write_prefix'] . $row['bo_table'];

            if ($row['wr_id'] == $row['wr_parent']) // 원글
            {
                $comment = "";
                $comment_link = "";
                $row2 = sql_fetch(" select * from $tmp_write_table where wr_id = '{$row['wr_id']}' ");

                $name = get_text(cut_str($row2['wr_name'], $config['cf_cut_name']));
                // 당일인 경우 시간으로 표시함
                $datetime = substr($row2['wr_datetime'],0,10);
                $datetime2 = $row2['wr_datetime'];
                if ($datetime == G5_TIME_YMD)
                    $datetime2 = substr($datetime2,11,5);
                else
                    $datetime2 = substr($datetime2,5,5);

            }
            else // 코멘트
            {
                $comment = '댓글. ';
                $comment_link = '#c_'.$row['wr_id'];
                $row2 = sql_fetch(" select * from {$tmp_write_table} where wr_id = '{$row['wr_parent']}' ");
                $row3 = sql_fetch(" select mb_id, wr_name, wr_email, wr_homepage, wr_datetime from {$tmp_write_table} where wr_id = '{$row['wr_id']}' ");

                $name = get_text(cut_str($row3['wr_name'], $config['cf_cut_name']));
                // 당일인 경우 시간으로 표시함
                $datetime = substr($row3['wr_datetime'],0,10);
                $datetime2 = $row3['wr_datetime'];
                if ($datetime == G5_TIME_YMD)
                    $datetime2 = substr($datetime2,11,5);
                else
                    $datetime2 = substr($datetime2,5,5);
            }
        ?>

        <tr>
            <td class="td_category"><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $row['bo_table'] ?>"><?php echo cut_str($row['bo_subject'],20) ?></a></td>
            <td><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $row['bo_table'] ?>&amp;wr_id=<?php echo $row2['wr_id'] ?><?php echo $comment_link ?>"><?php echo $comment ?><?php echo conv_subject($row2['wr_subject'], 100) ?></a></td>
            <td class="td_mbname"><div><?php echo $name ?></div></td>
            <td class="td_datetime"><?php echo $datetime ?></td>
        </tr>

        <?php
        }
        if ($i == 0)
            echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
        ?>
        </tbody>
        </table>
    </div>

	
    <div class="btn_list03 btn_list">
        <!--<a href="<?php echo G5_BBS_URL ?>/new.php">최근게시물 더보기</a>-->
    </div>
	
</section>


<?php
include_once ('./admin.tail.php');
?>
