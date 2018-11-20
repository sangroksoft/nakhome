<?php
$sub_menu = "100700";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'w');

if ($is_admin != 'super') alert('최고관리자만 접근 가능합니다.');

$g5['title'] = '텍스트 설정';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$frm_submit = '<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="확인" class="btn_submit" accesskey="s">
</div>';

?>

<form name="fconfigform" id="fconfigform" method="post" action="./config_txt_update.php" enctype="multipart/form-data" onsubmit="return fconfigform_submit(this);">
<input type="hidden" name="token" value="" id="token">

<section id="anc_cf_basic">

	<h2 class="h2_frm">메인 상단</h3>
    <div class="tbl_frm01 tbl_wrap">
	<table class="mobile_table">
        <colgroup>
            <col class="grid_4">
            <col>
            <col class="grid_4">
            <col>
        </colgroup>
		<tbody>
			<tr>
				<th scope="row">박스_1</th>
				<td colspan="3">
					제목 : <input type="text" name="txt1_title" value="<?php echo get_text($comfig[txt1_title]); ?>"  class=" frm_input" size="30" style="margin-right:20px;">
					<div class="clear lg-hidden"></div>
					설명 : <input type="text" name="txt1_cont" value="<?php echo get_text($comfig[txt1_cont],0); ?>"  class=" frm_input" size="80" style="margin-right:20px;">
					<div class="clear lg-hidden"></div>
					<span style="color:red;">※ 설명글 입력시 줄바꿈의 경우 '|' 로 구분해서 입력.</span>
				</td>
			</tr>
			<tr>
				<th scope="row">박스_2</th>
				<td colspan="3">
					제목 : <input type="text" name="txt2_title" value="<?php echo get_text($comfig[txt2_title]); ?>"  class=" frm_input" size="30" style="margin-right:20px;">
					<div class="clear lg-hidden"></div>
					설명 : <input type="text" name="txt2_cont" value="<?php echo get_text($comfig[txt2_cont],0); ?>"  class=" frm_input" size="80" style="margin-right:20px;">
					<div class="clear lg-hidden"></div>
					<span style="color:red;">※ 설명글 입력시 줄바꿈의 경우 '|' 로 구분해서 입력.</span>
				</td>
			</tr>
			<tr>
				<th scope="row">박스_3</th>
				<td colspan="3">
					제목 : <input type="text" name="txt3_title" value="<?php echo get_text($comfig[txt3_title]); ?>"  class=" frm_input" size="30" style="margin-right:20px;">
					<div class="clear lg-hidden"></div>
					설명 : <input type="text" name="txt3_cont" value="<?php echo get_text($comfig[txt3_cont],0); ?>"  class=" frm_input" size="80" style="margin-right:20px;">
					<div class="clear lg-hidden"></div>
					<span style="color:red;">※ 설명글 입력시 줄바꿈의 경우 '|' 로 구분해서 입력.</span>
				</td>
			</tr>
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
