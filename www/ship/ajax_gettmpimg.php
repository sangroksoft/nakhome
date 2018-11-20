<?php
include_once('./_common.php');

$returnVal = "";

$imgfile_fetch = sql_fetch(" select * from tmpimg where idx = '{$_POST[fseq]}' ");
$imgsr = G5_DATA_URL."/file/tmpimg/".$imgfile_fetch[bf_file];


$returnVal = $imgsr;

echo $returnVal;

?>