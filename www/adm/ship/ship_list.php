<?php
$sub_menu = "400000";
include_once("./_common.php");

auth_check($auth[$sub_menu], 'r');

$sql_common = " from m_ship ";
$sql_search = " where (1) ";

if ($sca) $sql_search .= " and ca_name = '$sca' ";
$sop = 'and';

$stx = trim($stx);
if($stx) 	
{
	//$sql_search .= get_sql_search_lsh("pd_name||bcode4", $stx, $sop); // 중복필드에서 검색의 경우 ' || ' 로 구분함.
	$sql_search .= get_sql_search_lsh("s_name", $stx, $sop);
}

if (!$sst) { $sst  = "regdate"; $sod = "desc";}
$sql_order = " order by $sst $sod ";

//=========== 페이징을 위한 Query 시작=================

$sqlcnt = " select s_idx $sql_common $sql_search ";
$result = sql_query($sqlcnt);
$total_count = sql_num_rows($result);
//$page_rows = $config[cf_page_rows];
$page_rows = 15;
$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
if (!$page) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)

// 검색시 검색리스트로 돌아오기 위한 로직추가
if($pgchk)
{
  if($pgchk > $total_page) $page = $total_page;
	if($total_page == 0) $page = 1;
}
$from_record = ($page - 1) * $page_rows; // 시작 열을 구함
$nListorder = $total_count - (($page-1) * $page_rows) + 1; //게시물 일련번호추출

$pagelist = get_paging($config[cf_write_pages], $page, $total_page, "?$qstr&page=");
//=========== 페이징을 위한 Query 끝===================

//=========== 리스트를 뽑아오는 Query 시작=============
$sql = " select * $sql_common $sql_search $sql_order limit $from_record, $page_rows ";
$result = sql_query($sql);
//=========== 리스트를 뽑아오는 Query 끝===============

//=========== 정렬에 사용하는 QUERY_STRING=============
$qstr2 = "sop=$sop";
//=========== 정렬에 사용하는 QUERY_STRING=============

$g5['title'] = "어선관리";
include_once(G5_ADMIN_PATH.'/admin.head.php');
$colspan = 18;

?>
<style>
.pcntinput{text-align:center;width:50px;height:24px;border:1px solid #ccc;color:red;}
.selectbox100{width:100px;height:24px;}
.tbl_head01 thead th, .tbl_head01 tbody td {text-align:center;}
.tbl_head01 tbody td {padding:2px 4px;}
.tbl_head01 td input {border: 1px solid #ddd;padding: 1px 5px;}
.tbl_head01 tbody td.td-img {position:relative;}
.detail-img{display:none;position: absolute;top: 2px;left: 52px;border:1px solid #ccc;}
.btn-issue{border: 1px solid #ccc;padding: 6px;background: #999;color: #fff;}

#fpdsearch input[type="submit"] {height: 26px;padding: 2px 20px;}

.tbl_head01 th.sch-th {background:#e5ecef;width:150px;}
.divfloat{float:left;padding-right:4px;width:170px;}
.tbl_head01 tbody td.ta-left {text-align:left;}
.btn_list01 {margin-bottom: 20px;}

.local_desc01 {
	clear:both;
    margin: 10px 0px;
    padding: 10px 20px 0;
    min-width: 920px;
    border: 1px solid #f2f2f2;
    background: #f9f9f9;
}

#excelfile_upload {
    margin: 0px;
    padding: 20px;
    border: 1px solid #e9e9e9;
    background: #fff;
	margin-bottom: 10px;
}
</style>
<div class="tbl_head01 tbl_wrap">
	<!--
	<form id="fsearch" name="fsearch" method="get" onsubmit="return fsearch_submit(this);">
	<input type="hidden" name="sst" value="<?php echo $sst ?>">
	<input type="hidden" name="sod" value="<?php echo $sod ?>">
	<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
	<table>
		<tbody>
			<tr>
				<th scope="row" class="sch-th"><?php echo $_txtArray[1][$sesslang];//카테고리?></th>
				<td colspan="3">
					<?php
					// 제품카테고리1
					$sql_ca1 = " select * from er_cate where ca_level='1' and ca_gubun = 'p' order by ca_idx asc ";
					$result_ca1 = sql_query($sql_ca1);
					?>
					<div id="cate1_wrap" class="divfloat">
						<select id="pd_cate1" name="pd_cate1" class="selectbox w100" onchange="get_subcate('p','1',this.value)">
							<option value=""><?php echo $_txtArray[2][$sesslang];//선택하세요?></option>
							<?php for($i=0;$row_ca1 = sql_fetch_array($result_ca1);$i++) {?>
							<option value="<?php echo $row_ca1[ca_idx] ;?>" <?php if($pd_cate1 == $row_ca1[ca_idx]) echo "selected='selected'"; ?>><?php echo get_text($row_ca1[ca_subj]); ?></option>
							<?php } ?>
						</select>
					</div>
					<?php if($pd_cate2 > 0) { ?>
					<?php
					// 브랜드
					$sql_ca2 = " select * from er_cate where ca_level='2' and ca_level1_idx = '{$pd_cate1}' order by ca_idx asc ";
					$result_ca2 = sql_query($sql_ca2);
					?>
					<div id="cate2_wrap" class="divfloat">
						<select id="pd_cate2" name="pd_cate2" class="selectbox w100">
							<option value=""><?php echo $_txtArray[2][$sesslang];//선택하세요?></option>
							<?php for($i=0;$row_ca2 = sql_fetch_array($result_ca2);$i++) {?>
							<option value="<?php echo $row_ca2[ca_idx] ;?>" <?php if($pd_cate2 == $row_ca2[ca_idx]) echo "selected='selected'"; ?>><?php echo get_text($row_ca2[ca_subj]); ?></option>
							<?php } ?>
						</select>
					</div>
					<?php } else { ?>
					<div id="cate2_wrap" class="divfloat">
						<select class="selectbox w100">
							<option value=""><?php echo $_txtArray[2][$sesslang];//선택하세요?></option>
						</select>
					</div>
					<?php } ?>
				</td>
			</tr>
			<tr>
				<th scope="row" class="sch-th"><?php echo $_txtArray[3][$sesslang];//적용기기?></th>
				<td colspan="3">
					<?php
					// 제품카테고리1
					$sql_dv1 = " select * from er_cate where ca_level='1' and ca_gubun = 'd' order by ca_idx asc ";
					$result_dv1 = sql_query($sql_dv1);
					?>
					<div id="device1_wrap" class="divfloat">
						<select id="pd_device1" name="pd_device1" class="selectbox w100" onchange="get_subcate('d','1',this.value)" >
							<option value=""><?php echo $_txtArray[2][$sesslang];//선택하세요?></option>
							<?php for($i=0;$row_dv1 = sql_fetch_array($result_dv1);$i++) {?>
							<option value="<?php echo $row_dv1[ca_idx] ;?>" <?php if($pd_device1 == $row_dv1[ca_idx]) echo "selected='selected'"; ?>><?php echo get_text($row_dv1[ca_subj]); ?></option>
							<?php } ?>
						</select>
					</div>
					<?php if($pd_device2 > 0) { ?>
					<?php
					// 적용기기
					$sql_dv2 = " select * from er_cate where ca_level='2' and ca_level1_idx = '{$pd_device1}' order by ca_idx asc ";
					$result_dv2 = sql_query($sql_dv2);
					?>
					<div id="device2_wrap" class="divfloat">
						<select id="pd_device2" name="pd_device2" class="selectbox w100" onchange="get_subcate('d','2',this.value)">
							<option value=""><?php echo $_txtArray[2][$sesslang];//선택하세요?></option>
							<?php for($i=0;$row_dv2 = sql_fetch_array($result_dv2);$i++) {?>
							<option value="<?php echo $row_dv2[ca_idx] ;?>" <?php if($pd_device2 == $row_dv2[ca_idx]) echo "selected='selected'"; ?>><?php echo get_text($row_dv2[ca_subj]); ?></option>
							<?php } ?>
						</select>
					</div>
					<?php } else { ?>
					<div id="device2_wrap" class="divfloat">
						<select class="selectbox w100">
							<option value=""><?php echo $_txtArray[2][$sesslang];//선택하세요?></option>
						</select>
					</div>
					<?php } ?>
					<?php if($pd_device3 > 0) { ?>
					<?php
					// 적용기기
					$sql_dv3 = " select * from er_cate where ca_level='3' and ca_level2_idx = '{$pd_device2}' order by ca_idx asc ";
					$result_dv3 = sql_query($sql_dv3);
					?>
					<div id="device3_wrap" class="divfloat">
						<select id="pd_device3" name="pd_device3" class="selectbox w100">
							<option value=""><?php echo $_txtArray[2][$sesslang];//선택하세요?></option>
							<?php for($i=0;$row_dv3 = sql_fetch_array($result_dv3);$i++) {?>
							<option value="<?php echo $row_dv3[ca_idx] ;?>" <?php if($pd_device3 == $row_dv3[ca_idx]) echo "selected='selected'"; ?>><?php echo get_text($row_dv3[ca_subj]); ?></option>
							<?php } ?>
						</select>
					</div>
					<?php } else { ?>
					<div id="device3_wrap" class="divfloat">
						<select class="selectbox w100">
							<option value=""><?php echo $_txtArray[2][$sesslang];//선택하세요?></option>
						</select>
					</div>
					<?php } ?>
				</td>
			</tr>
			<tr>
				<th scope="row" class="sch-th"><?php echo $_txtArray[4][$sesslang];//가격대?></th>
				<td colspan="3" class="ta-left">
					<input type="number" name="price_low" id="price_low" value="<?php echo $price_low;?>" placeholder="" /> ~ 
					<input type="number" name="price_high" id="price_high" value="<?php echo $price_high;?>" placeholder="" /> 
				</td>
			</tr>
			<tr>
				<th scope="row" class="sch-th"><?php echo $_txtArray[5][$sesslang];//판매옵션?></th>
				<td colspan="3" class="ta-left">
					<input type="checkbox" name="pd_opt1" id="pd_opt1" value="b" <?php if($pd_opt1 == "b") echo "checked='checked'"; ?> class="pdopt" />
					<label for="pd_opt1"><?php echo $_txtArray[6][$sesslang];//반품허용?></label>&nbsp;&nbsp;&nbsp;
					<input type="checkbox" name="pd_opt2" id="pd_opt2" value="o" <?php if($pd_opt2 == "o") echo "checked='checked'"; ?> class="pdopt" />
					<label for="pd_opt2"><?php echo $_txtArray[7][$sesslang];//오픈마켓판매허용?></label>&nbsp;&nbsp;&nbsp;
					<input type="checkbox" name="pd_opt3" id="pd_opt3" value="m" <?php if($pd_opt3 == "m") echo "checked='checked'"; ?> class="pdopt" />
					<label for="pd_opt3"><?php echo $_txtArray[8][$sesslang];//브랜드상품?></label>&nbsp;&nbsp;&nbsp;
					<input type="checkbox" name="pd_opt4" id="pd_opt4" value="p" <?php if($pd_opt4 == "p") echo "checked='checked'"; ?> class="pdopt" />
					<label for="pd_opt4"><?php echo $_txtArray[9][$sesslang];//소비자가준수?></label>
				</td>
			</tr>
			<tr>
				<th scope="row" class="sch-th"><?php echo $_txtArray[10][$sesslang];//상품옵션?></th>
				<td colspan="3" class="ta-left">
					<input type="checkbox" name="pd_icon1" id="pd_icon1" value="p" <?php if($pd_icon1 == "p") echo "checked='checked'"; ?> class="pdicon" />
					<label for="pd_icon1"><?php echo $_txtArray[11][$sesslang];//인기상품?></label>&nbsp;&nbsp;&nbsp;
					<input type="checkbox" name="pd_icon2" id="pd_icon2" value="n" <?php if($pd_icon2 == "n") echo "checked='checked'"; ?> class="pdicon" />
					<label for="pd_icon2"><?php echo $_txtArray[12][$sesslang];//신상품?></label>&nbsp;&nbsp;&nbsp;
					<input type="checkbox" name="pd_icon3" id="pd_icon3" value="r" <?php if($pd_icon3 == "r") echo "checked='checked'"; ?> class="pdicon" />
					<label for="pd_icon3"><?php echo $_txtArray[13][$sesslang];//추천상품?></label>&nbsp;&nbsp;&nbsp;
					<input type="checkbox" name="pd_icon4" id="pd_icon4" value="s" <?php if($pd_icon4 == "s") echo "checked='checked'"; ?> class="pdicon" />
					<label for="pd_icon4"><?php echo $_txtArray[14][$sesslang];//매장특가?></label>
				</td>
			</tr>
			<tr>
				<th scope="row" class="sch-th"><?php echo $_txtArray[15][$sesslang];// 검색어?></th>
				<td colspan="3" class="ta-left">
					<input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" id="stx" class="frm_input" style="width:200px" maxlength="20" placeholder="<?php echo $_txtArray[16][$sesslang];//키워드 입력?>">
					<input type="submit" value="<?php echo $_txtArray[17][$sesslang];// 검색?>" class="btn_submit" style="background-color:#ccc;padding:0 10px;">
					<?php if($sch) { ?>
					<span style="padding:6px 6px;background-color:#128700;vertical-align:middle;">
						<a href="./pd_list.php?s=1" style="color:#ffffff;"><?php echo $_txtArray[18][$sesslang];//검색초기화?></a>
					</span>
					<?php } ?>
				</td>
			</tr>

		</tbody>
	</table>
	</form>
	-->

	<form name="fshiplist" id="fshiplist" onsubmit="return fshiplist_submit(this);" method="post">
	<input type="hidden" name="sst" value="<?php echo $sst ?>">
	<input type="hidden" name="sod" value="<?php echo $sod ?>">
	<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
	<input type="hidden" name="stx" value="<?php echo $stx ?>">
	<input type="hidden" name="page" value="<?php echo $page ?>">
	<input type="hidden" name="token" value="">

	<div class="tbl_head01" style="padding: 18px 0;">

		<table>
			<caption><?php echo $g5['title']; ?> 목록</caption>
			<thead>
				<tr>
					<th scope="col" class="xs-hidden">
						<input type="checkbox" name="chkall" value="1" id="chkall" title="현재 페이지 목록 전체선택" onclick="check_all(this.form)">
					</th>
					<th scope="col" class="xs-hidden">번호</th>
					<th scope="col" class="xs-hidden">이미지</th>
					<th scope="col">어선명</th>
					<th scope="col">노출상태</th>
					<th scope="col">최대승선인원</th>
					<th scope="col" class="xs-hidden">이용금액</th>
					<th scope="col" class="xs-hidden">예약금액</th>
				</tr>
			</thead>
			<tbody>
				<?php for ($i=0; $row=sql_fetch_array($result); $i++) { ?>
				<?php
					$list = $i%2;
					$nListorder--; //게시물 일련번호
					$bg = 'bg'.($i%2);
					// 이미지 추출
					$imgsql = sql_fetch(" select bf_file from g5_board_file where bo_table='m_ship' and wr_id = '{$row[s_idx]}' and bf_no='0' ");
					if($imgsql[bf_file])
					{
						$imgsrc = G5_DATA_URL."/file/m_ship/thumb2/".$imgsql[bf_file];
						$imgdetail = G5_DATA_URL."/file/m_ship/thumb/".$imgsql[bf_file];
					}
					else
					{
						$imgsrc = G5_IMG_URL."/no_image.jpg";
						$imgdetail = G5_IMG_URL."/no_image.jpg";
					}
					// 어선명
					$s_name = get_text($row[s_name]);
					// 노출상태
					switch($row[s_expose])
					{
						case("n") : $s_expose = "<span style='color:red;font-weight:bolder;'>미노출</span>"; break;
						case("y") : $s_expose = "<span style='color:gray;font-weight:bolder;'>노출중</span>"; break;
						default : $s_expose = "<span>노출상태</span>"; break;
					}
					// 최대승선인원
					$s_max = number_format($row[s_max]);
					// 이용금액
					$s_price_join = number_format($row[s_price_join]);
					// 예약금액
					$s_price_book = number_format($row[s_price_book]);

					$shref = "./ship_write.php?w=u&s_idx=".$row[s_idx]."&".$qstr;
				?>	
				<tr class="tr-hover">
					<td class="td_chk td30 xs-hidden">
						<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
						<input type="hidden" name="s_idx[<?php echo $i ?>]" value="<?php echo $row['s_idx'] ?>" id="s_idx_<?php echo $i ?>">
					</td>
					<td class="td60 xs-hidden"><?php echo $nListorder; ?></td>
					<td class="td40 td-img xs-hidden">
						<a href="<?php echo $shref;?>" class="listimg"><img src="<?php echo $imgsrc; ?>" width="40"></a>
						<div class="detail-img"><img src="<?php echo $imgdetail; ?>"></div>
					</td>
					<td class="tdmin200"><a href="<?php echo $shref;?>"><?php echo $s_name; ?></a></td>
					<td class="td100">
						<select name="s_expose[<?php echo $i ?>]" class="sexpose selectbox w100">
							<option value="n" <?php if($row[s_expose] == "n") echo "selected='selected'";?>>미노출</option>
							<option value="y" <?php if($row[s_expose] == "y") echo "selected='selected'";?>>노출중</option>
						</select>
					</td>
					<td class="td100"><a href="<?php echo $shref;?>"><?php echo $s_max; ?></a></td>
					<td class="td100 xs-hidden"><a href="<?php echo $shref;?>"><?php echo $s_price_join; ?></a></td>
					<td class="td100 xs-hidden"><a href="<?php echo $shref;?>"><?php echo $s_price_book; ?></a></td>
				</tr>
				<?php } ?>

				<?php if (!$i) echo "<tr><td colspan=\"".$colspan."\" class=\"empty_table\">등록된 어선이 없습니다.</td></tr>"; ?>
			</tbody>
		</table>
		</div>

		<div class="btn_list01" style="float:right;">
			<a href="./ship_write.php">어선등록</a>
		</div>

	</form>

</div>

<?php
	if ($pagelist) {
		echo "<div style='width:100%;padding:20px 0;text-align:center;'>$pagelist</div>";
	}
?>

<script>
// 바코드발행 숫자 입력시 체크박스 체크처리
$(document).off("input",".issuecnt").on("input",".issuecnt",function(){
});

// 상품리스트 적용
function fshiplist_submit(f)
{
	ajax_fshiplist_submit();
	return false;
}

// 상품리스트 적용 AJAX 처리
function ajax_fshiplist_submit()
{
    if (!is_checked("chk[]")) {
        alert("어선을 선택하십시오.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if(!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
            return false;
        }
		else $("#listact").val("d");
    }

	var formData = $("#fshiplist").serialize();

	$.ajax({ 
		type: "POST",
		url: "./ajax_shiplist_modify.php",
		data: formData, 
		beforeSend: function(){
			loadstart();
		},
		success: function(msg){ 
			var msgarray = $.parseJSON(msg);
			if(msgarray.rslt == "error")
			{
				alert(msgarray.errcode); 
				if(msgarray.errurl) {document.location.replace(msgarray.errurl);}
				else {	loadend(); return false;}
			}
			else
			{
				document.location.reload();
			}
		},
		complete: function(){
			loadend();
		}
	});
}

</script>

<?php
include_once(G5_ADMIN_PATH.'/admin.tail.php');
?>