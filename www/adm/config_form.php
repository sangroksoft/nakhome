<?php
$sub_menu = "100100";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

if ($is_admin != 'super') alert('최고관리자만 접근 가능합니다.');

$g5['title'] = '기본환경설정';
include_once ('./admin.head.php');

$frm_submit = '<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="확인" class="btn_submit" accesskey="s">
</div>';
?>

<form name="fconfigform" id="fconfigform" method="post" onsubmit="return fconfigform_submit(this);">
<input type="hidden" name="token" value="" id="token">
<input type="hidden" id="cf_sea_area" name="cf_sea_area" value="<?php echo $config[cf_sea_area];?>">

<section id="anc_cf_basic">

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
            <th scope="row"><label for="cf_title">사이트 제목<strong class="sound_only">필수</strong></label></th>
            <td colspan="3"><input type="text" name="cf_title" value="<?php echo $config['cf_title'] ?>" id="cf_title" required class="required frm_input" size="40"></td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_admin">최고관리자<strong class="sound_only">필수</strong></label></th>
            <td>admin</td>
            <th scope="row"><label for="cf_admin_pwd">최고관리자 비밀번호<strong class="sound_only">필수</strong></label></th>
            <td>
				<?php echo help('기존 비밀번호 변경시에만 입력하세요. 미입력시 기존 비밀번호 유지됩니다.') ?>	
				<input type="password" name="mb_password" id="mb_password" class="frm_input " size="30" maxlength="20">
			</td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_admin_email">관리자 메일 주소<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo help('관리자가 보내고 받는 용도로 사용하는 메일 주소를 입력합니다. (회원가입, 인증메일, 테스트, 회원메일발송 등에서 사용)') ?>
                <input type="text" name="cf_admin_email" value="<?php echo $config['cf_admin_email'] ?>" id="cf_admin_email" required class="required email frm_input" size="40">
            </td>
            <th scope="row"><label for="cf_admin_email_name">관리자 메일 발송이름<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo help('관리자가 보내고 받는 용도로 사용하는 메일의 발송이름을 입력합니다. (회원가입, 인증메일, 테스트, 회원메일발송 등에서 사용)') ?>
                <input type="text" name="cf_admin_email_name" value="<?php echo $config['cf_admin_email_name'] ?>" id="cf_admin_email_name" required class="required frm_input" size="40">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_admin_tel">관리자 연락처<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo help('관리자가 보내고 받는 용도로 사용하는 전화번호를 입력합니다.') ?>
                <input type="text" name="cf_admin_tel" value="<?php echo $config['cf_admin_tel'] ?>" id="cf_admin_tel" required class="required frm_input" size="40">
            </td>
            <th scope="row"><label for="cf_delay_sec">글쓰기 간격<strong class="sound_only">필수</strong></label></th>
            <td><input type="text" name="cf_delay_sec" value="<?php echo $config['cf_delay_sec'] ?>" id="cf_delay_sec" required class="required numeric frm_input" size="3"> 초 지난후 가능</td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_filter">단어 필터링</label></th>
            <td colspan="3">
                <?php echo help('입력된 단어가 포함된 내용은 게시할 수 없습니다. 단어와 단어 사이는 ,로 구분합니다.') ?>
                <textarea name="cf_filter" id="cf_filter" rows="7" style="width:99%;"><?php echo $config['cf_filter'] ?></textarea>
             </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_prohibit_id">아이디,닉네임 금지단어</label></th>
            <td>
                <?php echo help('회원아이디, 닉네임으로 사용할 수 없는 단어를 정합니다. 쉼표 (,) 로 구분') ?>
                <textarea name="cf_prohibit_id" id="cf_prohibit_id" rows="5" style="width:99%;"><?php echo $config['cf_prohibit_id'] ?></textarea>
            </td>
            <th scope="row"><label for="cf_prohibit_email">입력 금지 메일</label></th>
            <td>
                <?php echo help('입력 받지 않을 도메인을 지정합니다. 엔터로 구분 ex) hotmail.com') ?>
                <textarea name="cf_prohibit_email" id="cf_prohibit_email" rows="5" style="width:99%;"><?php echo $config['cf_prohibit_email'] ?></textarea>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_possible_ip">접근가능 IP</label></th>
            <td>
                <?php echo help('입력된 IP의 컴퓨터만 접근할 수 있습니다.<br>123.123.+ 도 입력 가능. (엔터로 구분)') ?>
                <textarea name="cf_possible_ip" id="cf_possible_ip" style="width:99%;"><?php echo $config['cf_possible_ip'] ?></textarea>
            </td>
            <th scope="row"><label for="cf_intercept_ip">접근차단 IP</label></th>
            <td>
                <?php echo help('입력된 IP의 컴퓨터는 접근할 수 없음.<br>123.123.+ 도 입력 가능. (엔터로 구분)') ?>
                <textarea name="cf_intercept_ip" id="cf_intercept_ip" style="width:99%;"><?php echo $config['cf_intercept_ip'] ?></textarea>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_analytics">방문자분석 스크립트</label></th>
            <td colspan="3">
                <?php echo help('방문자분석 스크립트 코드를 입력합니다. 예) 구글 애널리틱스'); ?>
                <textarea name="cf_analytics" id="cf_analytics" style="width:99.5%;"><?php echo $config['cf_analytics']; ?></textarea>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_add_meta">추가 메타태그</label></th>
            <td colspan="3">
                <?php echo help('추가로 사용하실 meta 태그를 입력합니다.'); ?>
                <textarea name="cf_add_meta" id="cf_add_meta" style="width:99.5%;"><?php echo $config['cf_add_meta']; ?></textarea>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_stipulation">이용약관</label></th>
            <td colspan="3"><textarea name="cf_stipulation" id="cf_stipulation" rows="10" style="width:99.5%;"><?php echo $config['cf_stipulation'] ?></textarea></td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_privacy">개인정보처리방침</label></th>
            <td colspan="3"><textarea id="cf_privacy" name="cf_privacy" rows="10" style="width:99.5%;"><?php echo $config['cf_privacy'] ?></textarea></td>
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
    f.action = "./config_form_update.php";
    return true;
}
</script>

<?php
include_once ('./admin.tail.php');
?>
