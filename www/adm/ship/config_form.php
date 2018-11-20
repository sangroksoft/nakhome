<?php
$sub_menu = "100500";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'w');

if ($is_admin != 'super') alert('최고관리자만 접근 가능합니다.');

// 이미지
for($i=0;$i<1;$i++) {
	$_imgsql = "";
	$_imgsql = sql_fetch(" select bf_file from g5_board_file where bo_table = 'm_map' and bf_no = '{$i}' ");

	$_imgfile_alias = "imgfile".$i;
	$$_imgfile_alias = $_imgsql[bf_file];
	$_imgsrc_alias = "img".$i;
	$$_imgsrc_alias = G5_DATA_URL."/file/m_map/thumb/".$_imgsql[bf_file];
}

$g5['title'] = '선사환경설정';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$frm_submit = '<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="확인" class="btn_submit" accesskey="s">
</div>';

//echo $_SERVER['DOCUMENT_ROOT'];
?>
<style>
.tbl_frm01 th {min-width:160px;}
.tbl_frm01 td {width:40%;}
</style>

<form name="fconfigform" id="fconfigform" method="post" enctype="multipart/form-data" onsubmit="return fconfigform_submit(this);">
<input type="hidden" name="token" value="" id="token">
<input type="hidden" id="sea" name="sea" value="<?php echo $comfig[sea];?>">

<section id="anc_cf_basic">
    <h2 class="h2_frm">선사 기본환경 설정</h2>

    <div class="tbl_frm01 tbl_wrap">
        <table class="mobile_table">
			<colgroup>
				<col class="grid_4">
				<col>
				<col class="grid_4">
				<col>
			</colgroup>
			<tbody>
				<?php if($member[mb_id] == "nakadmin") { ?>
				<tr>
					<th scope="row"><label for="">사이트도메인<strong class="sound_only">필수</strong></label></th>
					<td>
						<?php echo help('도메인명 입력(ex : http://www.kyfish.com 인경우 http://www 를 제외한 kyfish.com 만 입력합니다.)') ?>
						<input type="text" name="sdom" value="<?php echo $comfig['sdom'] ?>" id="sdom" required="required"  class=" frm_input">
					</td>
				   <th scope="row"><label for="">템플릿선택</label></th>
					<td>
						<select name="tpn" class="selectbox" required="required">
							<option value="1" <?php if($comfig[tpn] == "1") echo " selected='selected' "; ?>>템플릿 A</option>
							<option value="2" <?php if($comfig[tpn] == "2") echo " selected='selected' "; ?>>템플릿 B</option>
							<option value="3" <?php if($comfig[tpn] == "3") echo " selected='selected' "; ?>>템플릿 C</option>
						</select>
					</td>
				</tr>
				<?php } ?>
				<tr>
					<th scope="row"><label for="">물때설정<strong class="sound_only">필수</strong></label></th>
					<td>
						<?php echo help('설정한 물때방식으로 물때를 가져옵니다.') ?>
						<select name="tide" class="selectbox" required="required">
							<option value="">물때선택</option>
							<option value="7" <?php if($comfig[tide] == "7") echo " selected='selected' "; ?>>7물 방식</option>
							<option value="8" <?php if($comfig[tide] == "8") echo " selected='selected' "; ?>>8물 방식</option>
						</select>
					</td>
					<th scope="row"><label for="">수역설정<strong class="sound_only">필수</strong></label></th>
					<td>
						<?php echo help('설정한 수역의 해상날씨를 가져옵니다..') ?>
						<select class="selectbox" onchange="setsea(this.value);">
							<option value="">수역선택</option>
							<?php for($i=0;$i<count($_sea_arr);$i++) { ?>
							<option value="<?php echo $_sea_arr[$i][1];?>" <?php if(get_text(trim($comfig['sea'])) == $_sea_arr[$i][1]) echo " selected='selected' "; ?>><?php echo $_sea_arr[$i][0];?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="">선사명<strong class="sound_only">필수</strong></label></th>
					<td>
						<input type="text" name="com_name" value="<?php echo $comfig['com_name'] ?>" id="com_name"  class=" frm_input"  required="required" size="40">
					</td>
					<th scope="row"><label for="">선사주소<strong class="sound_only">필수</strong></label></th>
					<td>
						<input type="text" name="com_addr" value="<?php echo $comfig['com_addr'] ?>" id="com_addr"  class=" frm_input" size="40">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="">사업자번호<strong class="sound_only">필수</strong></label></th>
					<td>
						<input type="text" name="com_saupja" value="<?php echo $comfig['com_saupja'] ?>" id="com_saupja"  class=" frm_input" size="40">
					</td>
					<th scope="row"><label for="">통신판매번호<strong class="sound_only">필수</strong></label></th>
					<td>
						<input type="text" name="com_tongsin" value="<?php echo $comfig['com_tongsin'] ?>" id="com_tongsin"  class=" frm_input" size="40">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="">대표핸드폰<strong class="sound_only">필수</strong></label></th>
					<td>
						<input type="text" name="com_hp" value="<?php echo $comfig['com_hp'] ?>" id="com_hp"  class=" frm_input" size="40">
					</td>
					<th scope="row"><label for="">대표전화<strong class="sound_only">필수</strong></label></th>
					<td>
						<input type="text" name="com_tel" value="<?php echo $comfig['com_tel'] ?>" id="com_tel"  class=" frm_input" size="40">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="">Fax<strong class="sound_only">필수</strong></label></th>
					<td>
						<input type="text" name="com_fax" value="<?php echo $comfig['com_fax'] ?>" id="com_fax"  class=" frm_input" size="40">
					</td>
					<th scope="row"><label for="">E-mail<strong class="sound_only">필수</strong></label></th>
					<td>
						<input type="text" name="com_email" value="<?php echo $comfig['com_email'] ?>" id="com_email"  class=" frm_input" size="40">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="">선사소개</label></th>
					<td colspan="3">
						<?php echo help('홈페이지 하단 선사소개에 사용됩니다. 100자 이내로 간략하게 작성하세요.'); ?>
						<textarea name="com_cont" id="com_cont" style="width:99.5%;height:50px;"><?php echo $comfig['com_cont']; ?></textarea>
					</td>
				</tr>
				<?php if($member[mb_id] == "nakadmin") { ?>
				<tr>
					<th scope="row"><label for="">선사지도</label></th>
					<td>
						<input type="radio" name="smap" value="0" id="smap_0" <?php if($comfig['smap'] == "0") echo " checked='checked' "; ?> class=" frm_input"> Naver 지도 API
						<input type="radio" name="smap" value="1" id="smap_1" <?php if($comfig['smap'] == "1") echo " checked='checked' "; ?> class=" frm_input"> 지도이미지 사용
						<input type="file" name="bf_file[]" title="지도이미지" class="frm_file frm_input">
						<?php if($imgfile0) { ?>
						<input type="checkbox" id="bf_file_del0" name="bf_file_del[0]" value="1"> 
						<img src="<?php echo $img0;?>" height="40px;"> ※체크시 파일삭제
						<?php } ?>
					</td>
				   <th scope="row"><label for="">이메일설정</label></th>
					<td>
						<?php echo help('회원가입시 이메일입력 필수/선택 여부를 설정합니다.'); ?>
						<input type="radio" name="semail" value="0" id="semail_0" <?php if($comfig['semail'] == "0") echo " checked='checked' "; ?> class=" frm_input"> 선택
						<input type="radio" name="semail" value="1" id="semail_1" <?php if($comfig['semail'] == "1") echo " checked='checked' "; ?> class=" frm_input"> 필수
					</td>
				</tr>
				<?php } ?>
			</tbody>
        </table>
    </div>
</section>

<section id="anc_cf_basic">
    <h2 class="h2_frm">예약관련 설정</h2>

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
            <th scope="row"><label for="">예약기능사용</label></th>
            <td colspan="3">
				<input type="radio" name="usebooking" value="0" id="usebooking_0" <?php if($comfig['usebooking'] == "0") echo " checked='checked' "; ?> class=" frm_input"> 사용함
				<input type="radio" name="usebooking" value="1" id="usebooking_1" <?php if($comfig['usebooking'] == "1") echo " checked='checked' "; ?> class=" frm_input"> 사용안함
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="">메인화면 캘린더</label></th>
            <td>
				<input type="radio" name="main_bkmode" value="month" id="main_bkmode_0" <?php if($comfig['main_bkmode'] == "month") echo " checked='checked' "; ?> class=" frm_input"> 월단위 달력
				<input type="radio" name="main_bkmode" value="week" id="main_bkmode_1" <?php if($comfig['main_bkmode'] == "week") echo " checked='checked' "; ?> class=" frm_input"> 선박별/주간 달력
            </td>
            <th scope="row"><label for="">예약화면모드</label></th>
            <td>
				<input type="radio" name="bkmode" value="ver1" id="bkmode_0" <?php if($comfig['bkmode'] == "ver1") echo " checked='checked' "; ?> class=" frm_input"> 캘린더형
				<input type="radio" name="bkmode" value="ver2" id="bkmode_1" <?php if($comfig['bkmode'] == "ver2") echo " checked='checked' "; ?> class=" frm_input"> 다이어리형
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="">입금계좌<strong class="sound_only">필수</strong></label></th>
            <td>
                <input type="text" name="com_account" value="<?php echo $comfig['com_account'] ?>" id="com_account" required class="required frm_input" size="40">
            </td>
            <th scope="row"><label for="">예금주<strong class="sound_only">필수</strong></label></th>
            <td>
                <input type="text" name="com_account_owner" value="<?php echo $comfig['com_account_owner'] ?>" id="com_account_owner" required class="required frm_input" size="40">
			</td>
        </tr>

        <tr>
            <th scope="row"><label for="">입금은행<strong class="sound_only">필수</strong></label></th>
            <td>
                <input type="text" name="com_bank" value="<?php echo $comfig['com_bank'] ?>" id="com_bank" required class="required frm_input" size="40">
            </td>
            <th scope="row"><label for="">예약비설정<strong class="sound_only">필수</strong></label></th>
            <td>
                <input type="text" name="book_fee" value="<?php echo $comfig['book_fee'] ?>" id="book_fee" required class="required frm_input" size="40"> %
			</td>
        </tr>

        <tr>
            <th scope="row"><label for="">입출항시간</label></th>
            <td colspan="3">
                <?php echo help('※ 입항'); ?>
                <textarea name="in_time" id="in_time" style="width:99.5%;height:50px;"><?php echo get_text($comfig['in_time'],0); ?></textarea>
                <?php echo help('※ 출항'); ?>
                <textarea name="out_time" id="out_time" style="width:99.5%;height:50px;"><?php echo get_text($comfig['out_time'],0); ?></textarea>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="">단체 및 독선예약</label></th>
            <td colspan="3">
                <?php echo help('※ 단체예약'); ?>
                <textarea name="book_group" id="book_group" style="width:99.5%;height:50px;"><?php echo get_text($comfig['book_group'],0); ?></textarea>
                <?php echo help('※ 단체이용료'); ?>
                <textarea name="book_group_fee" id="book_group_fee" style="width:99.5%;height:50px;"><?php echo get_text($comfig['book_group_fee'],0); ?></textarea>
                <?php echo help('※ 독선예약'); ?>
                <textarea name="book_solo" id="book_solo" style="width:99.5%;height:50px;"><?php echo get_text($comfig['book_solo'],0); ?></textarea>
                <?php echo help('※ 독선이용료'); ?>
                <textarea name="book_solo_fee" id="book_solo_fee" style="width:99.5%;height:50px;"><?php echo get_text($comfig['book_solo_fee'],0); ?></textarea>
            </td>
        </tr>

        <tr>
            <th scope="row"><label for="">예약 및 환불안내</label></th>
            <td colspan="3">
                <?php echo help('※ 예약처리절차'); ?>
                <textarea name="book_process" id="book_process" style="width:99.5%;height:50px;"><?php echo get_text($comfig['book_process'],0); ?></textarea>
                <?php echo help('※ 환불'); ?>
                <textarea name="refund_process" id="refund_process" style="width:99.5%;height:50px;"><?php echo get_text($comfig['refund_process'],0); ?></textarea>
            </td>
        </tr>

        <tr>
            <th scope="row"><label for="etc_notice">기타 유의사항</label></th>
            <td colspan="3">
                <?php echo help('※ 기타 유의사항'); ?>
                <textarea name="etc_notice" id="etc_notice" style="width:99.5%;height:50px;"><?php echo get_text($comfig['etc_notice'],0); ?></textarea>
            </td>
        </tr>

		</tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>

</form>

<script>
function setsea(sarea)
{
    $("#sea").val(sarea);
}

function fconfigform_submit(f)
{
    f.action = "./config_form_update.php";
    return true;
}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
