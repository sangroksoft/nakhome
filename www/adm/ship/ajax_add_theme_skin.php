<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
// 제품그룹 색상,디자인 추가

$colspan = 10;
?>
<div id="<?php echo $newId;?>" class="addedtheme">	
	<input type="hidden" name="chk[]" value="<?php echo $newId;?>">
	<input type="text" name="s_theme_subj[<?php echo $newId;?>]" class="required w30" value="" maxlength="255" required="required" placeholder="출조제목을 입력하세요 (입력예 : 광어다운샷 출조)" />
	<input type="text" name="s_theme_price[<?php echo $newId;?>]" class="required" value="" maxlength="7" required="required" placeholder="출조가격 (입력예 : 100000)" />
	<span class="deltheme">삭제</span>
</div>