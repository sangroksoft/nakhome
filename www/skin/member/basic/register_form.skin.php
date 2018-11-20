<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);

$email_required = $email_required_attr = "" ;
if ($comfig['semail'] == "1") { $email_required = " required='required' "; $email_required_attr = "required" ; }
?>
<script src="<?php echo G5_URL; ?>/assets/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo G5_URL; ?>/assets/plugins/jquery/jquery-migrate.min.js"></script>
<!--페이지 CSS Include 영역-->
<link rel="stylesheet" href="<?php echo $member_skin_url;?>/style.css">
<style>
input.frm_input{width: 100%;height: 34px;border: 1px solid #ccc;padding: 10px;outline:none !important;}
</style>
<!--페이지 CSS Include 영역-->
<!-- Interactive Slider v2 -->
<div class="interactive-slider-v2 img-v3">
	<div class="container">
		<p style="font-size:36px;font-weight:bolder;color:#fff;opacity:1;">회원가입</p>
	</div>
</div>
<!-- End Interactive Slider v2 -->

<div class="container content lsh-toggle-fluid">
    <script src="<?php echo G5_JS_URL ?>/jquery.register_form.js"></script>
    <?php if($config['cf_cert_use'] && ($config['cf_cert_ipin'] || $config['cf_cert_hp'])) { ?>
    <script src="<?php echo G5_JS_URL ?>/certify.js"></script>
    <?php } ?>

    <form id="fregisterform" name="fregisterform" action="<?php echo $register_action_url ?>" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="w" value="<?php echo $w ?>">
    <input type="hidden" name="url" value="<?php echo $urlencode ?>">
    <input type="hidden" name="agree" value="<?php echo $agree ?>">
    <input type="hidden" name="agree2" value="<?php echo $agree2 ?>">
    <input type="hidden" name="cert_type" value="<?php echo $member['mb_certify']; ?>">
    <input type="hidden" name="cert_no" value="">
    <?php if (isset($member['mb_sex'])) {  ?><input type="hidden" name="mb_sex" value="<?php echo $member['mb_sex'] ?>"><?php }  ?>
    <?php if (isset($member['mb_nick_date']) && $member['mb_nick_date'] > date("Y-m-d", G5_SERVER_TIME - ($config['cf_nick_modify'] * 86400))) { // 닉네임수정일이 지나지 않았다면  ?>
    <input type="hidden" name="mb_nick_default" value="<?php echo $member['mb_nick'] ?>">
    <input type="hidden" name="mb_nick" value="<?php echo $member['mb_nick'] ?>">
    <?php }  ?>
	<input type="hidden" name="sp" value="<?php echo $sp;?>">

	<div class="row">
		<!-- Begin Content -->
		<div class="col-xs-12">
			<!-- Review Form-->
			<table class="table table-bordered">
				<caption style="font-size:16px;font-weight:bolder;color:#222;"><i class="fa fa-check" style="padding-right:10px;"></i>사이트 이용정보입력</caption>
				<tbody>
					<tr>
						<th scope="row" class="hidden-xs hidden-sm lsh-th1">
							<label for="reg_mb_id" class="lsh-label">ID<strong class="sound_only">필수</strong></label>
						</th>
						<td class="lsh-td1">
							<span class="frm_info">영문자, 숫자, _ 만 입력 가능. 최소 3자이상 입력하세요.</span>
							<div class="note visible-sm visible-xs"><strong>※</strong> ID를 입력하세요.</div>
                            <div class="col-sm-3 input-group lsh-form-nopadding">
								<span class="input-group-addon">@</span>
								<input type="text" name="mb_id" value="<?php echo $member['mb_id'] ?>" id="reg_mb_id" <?php echo $required ?> <?php echo $readonly ?> class="frm_input <?php echo $required ?> <?php echo $readonly ?>" minlength="3" maxlength="20" placeholder="ID 입력">
                            </div>
							<span id="msg_mb_id"></span>
						</td>
					</tr>
					<tr>
						<th scope="row" class="hidden-xs hidden-sm lsh-th1">
							<label for="reg_mb_password" class="lsh-label">비밀번호<strong class="sound_only">필수</strong></label>
						</th>
						<td class="lsh-td1">
							<div class="note visible-sm visible-xs"><strong>※</strong> 비밀번호를 입력하세요.</div>
                            <div class="col-sm-5 input-group lsh-form-nopadding">
								<span class="input-group-addon"><i class="fa fa-info-circle"></i></span>
								<input type="password" name="mb_password" id="reg_mb_password" <?php echo $required ?> class="frm_input <?php echo $required ?> " minlength="3" maxlength="20" placeholder="비밀번호 입력">
                            </div>
						</td>
					</tr>
					<tr>
						<th scope="row" class="hidden-xs hidden-sm lsh-th1">
							<label for="reg_mb_password_re" class="lsh-label">비밀번호확인<strong class="sound_only">필수</strong></label>
						</th>
						<td class="lsh-td1">
							<div class="note visible-sm visible-xs"><strong>※</strong> 비밀번호 확인.</div>
							<div class="col-sm-5 input-group lsh-form-nopadding">
								<span class="input-group-addon"><i class="fa fa-info-circle"></i></span>
								<input type="password" name="mb_password_re" id="reg_mb_password_re" <?php echo $required ?> class="frm_input <?php echo $required ?> " minlength="3" maxlength="20" placeholder="비밀번호 확인">
                            </div>
						</td>
					</tr>

				</tbody>
			</table>
			<!-- End Review Form-->
		</div>
		<!-- End Content -->
	</div>        
	
	<div class="row">
		<!-- Begin Content -->
		<div class="col-xs-12">
			<!-- Review Form-->
			<table class="table table-bordered">
				<caption style="font-size:16px;font-weight:bolder;color:#222;"><i class="fa fa-check" style="padding-right:10px;"></i>개인정보 입력</caption>
				<tbody>
					<tr>
						<th scope="row" class="hidden-xs hidden-sm lsh-th1">
							<label for="reg_mb_name" class="lsh-label">이름<strong class="sound_only">필수</strong></label>
						</th>
						<td class="lsh-td1">
							<?php if ($config['cf_cert_use']) { ?>
							<span class="frm_info">아이핀 본인확인 후에는 이름이 자동 입력되고 휴대폰 본인확인 후에는 이름과 휴대폰번호가 자동 입력되어 수동으로 입력할수 없게 됩니다.</span>
							<?php } ?>
							<div class="note visible-sm visible-xs"><strong>※</strong> 이름</div>
                            <div class="col-sm-5 input-group lsh-form-nopadding">
								<span class="input-group-addon">@</span>
								<input type="text" id="reg_mb_name" name="mb_name" value="<?php echo $member['mb_name'] ?>" <?php echo $required ?> <?php echo $readonly; ?> class="frm_input <?php echo $required ?> <?php echo $readonly ?> " placeholder="이름 입력">
                            </div>
							<?php
							if($config['cf_cert_use']) {
								if($config['cf_cert_ipin'])
									echo '<button type="button" id="win_ipin_cert" class="btn_frmline">아이핀 본인확인</button>'.PHP_EOL;
								if($config['cf_cert_hp'])
									echo '<button type="button" id="win_hp_cert" class="btn_frmline">휴대폰 본인확인</button>'.PHP_EOL;

								echo '<noscript>본인확인을 위해서는 자바스크립트 사용이 가능해야합니다.</noscript>'.PHP_EOL;
							}
							?>
							<?php
							if ($config['cf_cert_use'] && $member['mb_certify']) {
								if($member['mb_certify'] == 'ipin')
									$mb_cert = '아이핀';
								else
									$mb_cert = '휴대폰';
							?>
							<div id="msg_certify">
								<strong><?php echo $mb_cert; ?> 본인확인</strong><?php if ($member['mb_adult']) { ?> 및 <strong>성인인증</strong><?php } ?> 완료
							</div>
							<?php } ?>
						</td>
					</tr>
					<?php if ($req_nick) {  ?>
					<tr>
						<th scope="row" class="hidden-xs hidden-sm lsh-th1">
							<label for="reg_mb_nick" class="lsh-label">닉네임<strong class="sound_only">필수</strong></label>
						</th>
						<td class="lsh-td1">
							<span class="frm_info">
								공백없이 한글,영문,숫자만 입력 가능 (한글2자, 영문4자 이상)<br>
								닉네임을 바꾸시면 앞으로 <?php echo (int)$config['cf_nick_modify'] ?>일 이내에는 변경 할 수 없습니다.
							</span>
							<div class="note visible-sm visible-xs"><strong>※</strong> 닉네임</div>
                            <div class="col-sm-5 input-group lsh-form-nopadding">
								<span class="input-group-addon"><i class="fa fa-info-circle"></i></span>
								<input type="hidden" name="mb_nick_default" value="<?php echo isset($member['mb_nick'])?$member['mb_nick']:''; ?>">
								<input type="text" name="mb_nick" value="<?php echo isset($member['mb_nick'])?$member['mb_nick']:''; ?>" id="reg_mb_nick" required class="frm_input required nospace " maxlength="20" placeholder="닉네임 입력">
                            </div>
							<span id="msg_mb_nick"></span>
						</td>
					</tr>
					<?php } ?>
					<tr>
						<th scope="row" class="hidden-xs hidden-sm lsh-th1">
							<label for="reg_mb_email" class="lsh-label">E-mail</label>
						</th>
						<td class="lsh-td1">
							<?php if ($config['cf_use_email_certify']) {  ?>
							<span class="frm_info">
								<?php if ($w=='') { echo "E-mail 로 발송된 내용을 확인한 후 인증하셔야 회원가입이 완료됩니다."; }  ?>
								<?php if ($w=='u') { echo "E-mail 주소를 변경하시면 다시 인증하셔야 합니다."; }  ?>
							</span>
							<?php }  ?>
							<div class="note visible-sm visible-xs"><strong>※</strong> E-mail</div>
							<div class="col-sm-6 input-group lsh-form-nopadding">
								<span class="input-group-addon"><i class="fa fa-info-circle"></i></span>
								<input type="hidden" name="old_email" value="<?php echo $member['mb_email'] ?>">
								<input type="text" name="mb_email" value="<?php echo isset($member['mb_email'])?$member['mb_email']:''; ?>" id="reg_mb_email" <?php echo $email_required;?> class="frm_input email <?php echo $email_required_attr;?>" maxlength="100" placeholder="E-mail 입력">
                            </div>
						</td>
					</tr>
					<?php if ($config['cf_use_homepage']) {  ?>
					<tr>
						<th scope="row" class="hidden-xs hidden-sm lsh-th1">
							<label for="reg_mb_homepage" class="lsh-label">홈페이지<?php if ($config['cf_req_homepage']){ ?><strong class="sound_only">필수</strong><?php } ?></label>
						</th>
						<td class="lsh-td1">
							<div class="note visible-sm visible-xs"><strong>※</strong> 홈페이지</div>
							<div class="col-sm-6 input-group lsh-form-nopadding">
								<span class="input-group-addon"><i class="fa fa-info-circle"></i></span>
								<input type="text" name="mb_homepage" value="<?php echo $member['mb_homepage'] ?>" id="reg_mb_homepage" <?php echo $config['cf_req_homepage']?"required":""; ?> class="frm_input <?php echo $config['cf_req_homepage']?"required":""; ?> " maxlength="255" placeholder="홈페이지 입력">
                            </div>
						</td>
					</tr>
					<?php }  ?>
					<?php if ($config['cf_use_tel']) {  ?>
					<tr>
						<th scope="row" class="hidden-xs hidden-sm lsh-th1">
							<label for="reg_mb_tel" class="lsh-label">전화번호<?php if ($config['cf_req_tel']) { ?><strong class="sound_only">필수</strong><?php } ?></label>
						</th>
						<td class="lsh-td1">
							<div class="note visible-sm visible-xs"><strong>※</strong> 전화번호</div>
							<div class="col-sm-4 input-group lsh-form-nopadding">
								<span class="input-group-addon"><i class="fa fa-info-circle"></i></span>
								<input type="text" name="mb_tel" value="<?php echo $member['mb_tel'] ?>" id="reg_mb_tel" <?php echo $config['cf_req_tel']?"required":""; ?> class="frm_input <?php echo $config['cf_req_tel']?"required":""; ?> " maxlength="20" placeholder="전화번호 입력">
                            </div>
						</td>
					</tr>
					<?php }  ?>
					<?php if ($config['cf_use_hp'] || $config['cf_cert_hp']) {  ?>
					<tr>
						<th scope="row" class="hidden-xs hidden-sm lsh-th1">
							<label for="reg_mb_hp" class="lsh-label">휴대폰번호<?php if ($config['cf_req_hp']) { ?><strong class="sound_only">필수</strong><?php } ?></label>
						</th>
						<td class="lsh-td1">
							<div class="note visible-sm visible-xs"><strong>※</strong> 휴대폰번호</div>
							<div class="col-sm-4 input-group lsh-form-nopadding">
								<span class="input-group-addon"><i class="fa fa-info-circle"></i></span>
								<input type="text" name="mb_hp" value="<?php echo $member['mb_hp'] ?>" id="reg_mb_hp" <?php echo ($config['cf_req_hp'])?"required":""; ?> class="frm_input <?php echo ($config['cf_req_hp'])?"required":""; ?> " maxlength="20" placeholder="휴대폰번호 입력">
								<?php if ($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
								<input type="hidden" name="old_mb_hp" value="<?php echo $member['mb_hp'] ?>">
								<?php } ?>
                            </div>
						</td>
					</tr>
					<?php }  ?>
					<?php if ($config['cf_use_addr']) { ?>
					<tr>
						<th scope="row" class="hidden-xs hidden-sm lsh-th1">
							<label for="" class="lsh-label">주소<?php if ($config['cf_req_addr']) { ?><strong class="sound_only">필수</strong><?php }  ?></label>
						</th>
						<td class="lsh-td1">
							<div class="note visible-sm visible-xs"><strong>※</strong> 주소</div>
							<div class="form-inline lsh-form-nopadding">
								<div class="form-group">
									<label for="reg_mb_zip1" class="sound_only">우편번호 앞자리<?php echo $config['cf_req_addr']?'<strong class="sound_only"> 필수</strong>':''; ?></label>
									<input type="text" name="mb_zip1" value="<?php echo $member['mb_zip1'] ?>" id="reg_mb_zip1" <?php echo $config['cf_req_addr']?"required":""; ?> class="frm_input <?php echo $config['cf_req_addr']?"required":""; ?> " maxlength="3" size="3">
								</div> -
								<div class="form-group">
									<label for="reg_mb_zip2" class="sound_only">우편번호 뒷자리<?php echo $config['cf_req_addr']?'<strong class="sound_only"> 필수</strong>':''; ?></label>
									<input type="text" name="mb_zip2" value="<?php echo $member['mb_zip2'] ?>" id="reg_mb_zip2" <?php echo $config['cf_req_addr']?"required":""; ?> class="frm_input <?php echo $config['cf_req_addr']?"required":""; ?> "  maxlength="3" size="3">
								</div>
								<div class="form-group">
									<a href="javascript:;" onclick="win_zip('fregisterform', 'mb_zip1', 'mb_zip2', 'mb_addr1', 'mb_addr2', 'mb_addr3', 'mb_addr_jibeon');" style="padding-left:10px;">
										<i class="fa fa-search-plus" style="font-size:24px; color:#aaa;"></i>
									</a>
								</div>
							</div>
							<div class="col-sm-8 input-group lsh-form-nopadding" style="display:block;">
								<input type="text" name="mb_addr1" value="<?php echo $member['mb_addr1'] ?>" id="reg_mb_addr1" <?php echo $config['cf_req_addr']?"required":""; ?> class="frm_input frm_address <?php echo $config['cf_req_addr']?"required":""; ?> ">
							</div>
							<div class="col-sm-8 input-group lsh-form-nopadding" style="display:block;">
								<input type="text" name="mb_addr2" value="<?php echo $member['mb_addr2'] ?>" id="reg_mb_addr2" class="frm_input frm_address ">
							</div>
							<div class="col-sm-8 input-group lsh-form-nopadding" style="display:block;">
								<input type="text" name="mb_addr3" value="<?php echo $member['mb_addr3'] ?>" id="reg_mb_addr3" class="frm_input frm_address " readonly="readonly">
								<input type="hidden" name="mb_addr_jibeon" value="<?php echo $member['mb_addr_jibeon']; ?>">
                            </div>
						</td>
					</tr>
					<?php }  ?>
					<tr>
						<th scope="row" class="hidden-xs hidden-sm lsh-th1">
							<label for="wr_subject" class="lsh-label">보안문자입력</label>
						</th>
						<td class="lsh-td1">
							<div class="note visible-sm visible-xs"><strong>※</strong> 보안문자입력</div>
							<div class="col-xs-12 input-group lsh-form-nopadding">
								<?php echo captcha_html(); ?>
                            </div>
						</td>
					</tr>
				</tbody>
			</table>

			<div class="lsh-write-btn-right">
				<button type="submit" id="btn_submit" accesskey="s" class="btn-u">회원가입</button>
				<button type="button" class="btn-u btn-u-default" onclick="window.history.back();">취소</button>
			</div>

		</div>
		<!-- End Content -->
	</div>          
	
	</form>         
</div>

<!-- } 회원정보 입력/수정 끝 -->

<!--//=========== 페이지하단 공통파일 Include =============-->
<?php include_once(G5_PATH.'/footer'.$sp.'.php');?>
<?php include_once(G5_PATH.'/jquery_load'.$sp.'.php'); // jquery 관련 코드가 반드시 페이지 상단에 노출되어야 하는 경우는 페이지 상단에 위치시킴.?>
<?php include_once(G5_PATH.'/tail'.$sp.'.php');?>
<!--페이지 스크립트 영역-->
<script>
$(function() {
	$("#reg_zip_find").css("display", "inline-block");

	<?php if($config['cf_cert_use'] && $config['cf_cert_ipin']) { ?>
	// 아이핀인증
	$("#win_ipin_cert").click(function() {
		if(!cert_confirm())
			return false;

		var url = "<?php echo G5_OKNAME_URL; ?>/ipin1.php";
		certify_win_open('kcb-ipin', url);
		return;
	});

	<?php } ?>
	<?php if($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
	// 휴대폰인증
	$("#win_hp_cert").click(function() {
		if(!cert_confirm())
			return false;

		<?php
		switch($config['cf_cert_hp']) {
			case 'kcb':
				$cert_url = G5_OKNAME_URL.'/hpcert1.php';
				$cert_type = 'kcb-hp';
				break;
			case 'kcp':
				$cert_url = G5_KCPCERT_URL.'/kcpcert_form.php';
				$cert_type = 'kcp-hp';
				break;
			case 'lg':
				$cert_url = G5_LGXPAY_URL.'/AuthOnlyReq.php';
				$cert_type = 'lg-hp';
				break;
			default:
				echo 'alert("기본환경설정에서 휴대폰 본인확인 설정을 해주십시오");';
				echo 'return false;';
				break;
		}
		?>

		certify_win_open("<?php echo $cert_type; ?>", "<?php echo $cert_url; ?>");
		return;
	});
	<?php } ?>
});

// submit 최종 폼체크
function fregisterform_submit(f)
{
	// 회원아이디 검사
	if (f.w.value == "") {
		var msg = reg_mb_id_check();
		if (msg) {
			alert(msg);
			f.mb_id.select();
			return false;
		}
	}

	if (f.w.value == "") {
		if (f.mb_password.value.length < 3) {
			alert("비밀번호를 3글자 이상 입력하십시오.");
			f.mb_password.focus();
			return false;
		}
	}

	if (f.mb_password.value != f.mb_password_re.value) {
		alert("비밀번호가 같지 않습니다.");
		f.mb_password_re.focus();
		return false;
	}

	if (f.mb_password.value.length > 0) {
		if (f.mb_password_re.value.length < 3) {
			alert("비밀번호를 3글자 이상 입력하십시오.");
			f.mb_password_re.focus();
			return false;
		}
	}

	// 이름 검사
	if (f.w.value=="") {
		if (f.mb_name.value.length < 1) {
			alert("이름을 입력하십시오.");
			f.mb_name.focus();
			return false;
		}

		/*
		var pattern = /([^가-힣\x20])/i;
		if (pattern.test(f.mb_name.value)) {
			alert("이름은 한글로 입력하십시오.");
			f.mb_name.select();
			return false;
		}
		*/
	}

	<?php if($w == '' && $config['cf_cert_use'] && $config['cf_cert_req']) { ?>
	// 본인확인 체크
	if(f.cert_no.value=="") {
		alert("회원가입을 위해서는 본인확인을 해주셔야 합니다.");
		return false;
	}
	<?php } ?>

	// 닉네임 검사
	if ((f.w.value == "") || (f.w.value == "u" && f.mb_nick.defaultValue != f.mb_nick.value)) {
		var msg = reg_mb_nick_check();
		if (msg) {
			alert(msg);
			f.reg_mb_nick.select();
			return false;
		}
	}

	// E-mail 검사
	if ((f.w.value == "") || (f.w.value == "u" && f.mb_email.defaultValue != f.mb_email.value)) {
		var msg = reg_mb_email_check();
		if (msg) {
			alert(msg);
			f.reg_mb_email.select();
			return false;
		}
	}

	<?php if (($config['cf_use_hp'] || $config['cf_cert_hp']) && $config['cf_req_hp']) {  ?>
	// 휴대폰번호 체크
	var msg = reg_mb_hp_check();
	if (msg) {
		alert(msg);
		f.reg_mb_hp.select();
		return false;
	}
	<?php } ?>

	if (typeof f.mb_icon != "undefined") {
		if (f.mb_icon.value) {
			if (!f.mb_icon.value.toLowerCase().match(/.(gif)$/i)) {
				alert("회원아이콘이 gif 파일이 아닙니다.");
				f.mb_icon.focus();
				return false;
			}
		}
	}

	if (typeof(f.mb_recommend) != "undefined" && f.mb_recommend.value) {
		if (f.mb_id.value == f.mb_recommend.value) {
			alert("본인을 추천할 수 없습니다.");
			f.mb_recommend.focus();
			return false;
		}

		var msg = reg_mb_recommend_check();
		if (msg) {
			alert(msg);
			f.mb_recommend.select();
			return false;
		}
	}

	<?php echo chk_captcha_js();  ?>

	document.getElementById("btn_submit").disabled = "disabled";

	return true;
}
</script>
<!--페이지 스크립트 영역-->
<?php include_once(G5_PATH.'/tail'.$sp.'.sub.php'); ?>
<!--//=========== 페이지하단 공통파일 Include =============-->