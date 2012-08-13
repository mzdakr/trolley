<?php 

$templateFileName = './template.html';

require_once('./lib/markdown/markdown.php');

$contents = file($_SERVER['DOCUMENT_ROOT'].  preg_replace('/\.html$/', '.md', $_SERVER['REQUEST_URI']));

$html = file_get_contents($templateFileName);

$title = array_shift($contents);
$body  =  Markdown(implode('', $contents));

$html = str_replace('<!-- TITLE -->', $title, $html);
$html = str_replace('<!-- BODY -->', $body, $html);

echo $html;