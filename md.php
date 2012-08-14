<?php 

$templateFileName = './template.html';

require_once('./lib/markdown/markdown.php');

$contents = file($_SERVER['DOCUMENT_ROOT'].  preg_replace('/\.html$/', '.md', $_SERVER['REQUEST_URI']));

//メタデータの抜き出し
$re = '/^\s*\$(?<key>[a-zA-Z][a-zA-Z0-9_]*((\.|:)[a-zA-Z][a-zA-Z0-9_]*)*)\s*=\s*(?<val>.*)\s*$/';
$metas = array(); $match = array();
while (($row = array_shift($contents)) && preg_match($re, $row, $match))
	$metas[$match['key']] = trim($match['val']);
while (trim($row) == '') $row = array_shift($contents);
$title = trim($row, '#\n\r\t ');
array_unshift($contents, $row);//タイトル行を戻す
$body = Markdown(implode('', $contents));
$meta = '';
foreach ($metas as $key=>$val)
	$meta .= "<meta name=\"$key\" content=\"$val\" />";

//テンプレート読み込み
$html = file_get_contents($templateFileName);

//テンプレート変数の置換え
$html = str_replace('<!-- TITLE -->', $title, $html);
$html = str_replace('<!-- BODY -->', $body, $html);
$html = str_replace('<!-- META -->', $meta, $html);

echo $html;