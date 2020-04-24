<?php

function clearXSS($string)
{
	require_once './htmlpurifier-4.10.0/HTMLPurifier.auto.php';
	// 生成配置物件
	$_clean_xss_config = HTMLPurifier_Config::createDefault();
	// 以下就是配置：
	$_clean_xss_config->set('Core.Encoding', 'UTF-8');
	// 設定允許使用的HTML標籤
	$_clean_xss_config->set('HTML.Allowed','div,b,strong,i,em,a[href|title],ul,ol,li,p[style],br,span[style],img[width|height|alt|src]');
	// 設定允許出現的CSS樣式屬性
	$_clean_xss_config->set('CSS.AllowedProperties', 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align');
	// 設定a標籤上是否允許使用target="_blank"
	$_clean_xss_config->set('HTML.TargetBlank', TRUE);
	// 使用配置生成過濾用的物件
	$_clean_xss_obj = new HTMLPurifier($_clean_xss_config);
	// 過濾字串
	//將script標籤和其裡面的內容都過濾掉
	return $_clean_xss_obj->purify($string);
}

?>