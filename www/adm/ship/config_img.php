<?php
$sub_menu = "100600";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'w');

if ($is_admin != 'super') alert('최고관리자만 접근 가능합니다.');

/*
메인슬라이더 - 1;
선박소개 - 2;
조황정보 - 3;
출조안내 - 4;
예약하기,예약결과 - 5;
커뮤니티 - 6;
오시는길 - 7;
마이페이지 - 8;
로그인,회원가입 - 9;
기본이미지 - 10;
*/
// 메인슬라이더 이미지
for($i=0;$i<3;$i++) {
	$_imgsql = "";
	$_imgsql = sql_fetch(" select * from g5_board_file where bo_table = 'mainslider' and wr_id='1' and bf_no = '{$i}' ");

	$_imgfile_alias = "imgfile".$i;
	$$_imgfile_alias = $_imgsql[bf_file];
	$_imgsrc_alias = "img".$i;
	$$_imgsrc_alias = G5_DATA_URL."/file/mainslider/thumb2/".$_imgsql[bf_file];
	$_imgcont_alias = "imgcont".$i;
	$$_imgcont_alias = get_text($_imgsql[bf_content]);
}

$g5['title'] = '이미지 설정';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$frm_submit = '<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="확인" class="btn_submit" accesskey="s">
</div>';

?>

<form name="fconfigform" id="fconfigform" method="post" action="./config_img_update.php" enctype="multipart/form-data" onsubmit="return fconfigform_submit(this);">
<input type="hidden" name="token" value="" id="token">

<section id="anc_cf_basic">

	<h2 class="h2_frm">메인 슬라이더</h3>
    <div class="tbl_frm01 tbl_wrap">
	<table class="mobile_table">
        <colgroup>
            <col class="grid_4">
            <col>
            <col class="grid_4">
            <col>
        </colgroup>
		<tbody>
			<?php for($i=0;$i<3;$i++) { ?>
			<?php
				$j=$i+1;
				$imgfile_alias = "imgfile".$i;
				$imgfile = $$imgfile_alias;
				$imgsrc_alias = "img".$i;
				$imgsrc = $$imgsrc_alias;
				$imgcont_alias = "imgcont".$i;
				$imgcont = $$imgcont_alias;
			?>
			<tr>
				<th scope="row"><label for="">이미지_<?php echo $j;?></label></th>
				<td colspan="3">
					타이틀 : <input type="text" name="bf_content[]" value="<?php echo $imgcont ?>"  class=" frm_input" size="80" style="margin-right:20px;">
					<div class="clear lg-hidden"></div>
					이미지 : <input type="file" name="bf_file[]" title="메인슬라이더<?php echo $j;?>" class="frm_file frm_input">
					<?php if($imgfile) { ?>
					<div class="clear lg-hidden tb-margin"></div>
					<input type="checkbox" id="bf_file_del<?php echo $i;?>" name="bf_file_del[<?php echo $i;?>]" value="1"> 
					<img src="<?php echo $imgsrc;?>" height="40px;"> ※체크시 파일삭제
					<?php } ?>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
    </div>
</section>


<?php echo $frm_submit; ?>

</form>

<script>
function fconfigform_submit(f)
{
    return true;
}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
