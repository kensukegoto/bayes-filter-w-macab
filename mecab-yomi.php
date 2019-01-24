<?php

require 'mecab.inc.php';

$input = <<< EOS
喜びに満ちた心は治療薬として良く効き、
打ちひしがれた霊は骨を枯らす。
EOS;

$res = mecab_parse($input);

$bun = "";
foreach($res as $v){
  $word = $v[0];

  if(preg_match('/^[ぁ-ん]+$/',$word)){
    $bun .= $word; continue;
  }

  if($word=='EOS') continue;
  if(strpos(",.、。",$word)!==false){
    $bun .= $word; continue;
  }

  $yomi = isset($v[4]) ? $v[8] : "";
  $yomi = mb_convert_kana($yomi,"c"); // ひらがな変換
  $bun .= "<ruby>$word<rt>$yomi</rt></ruby>";
}

echo <<< HTML
<html><body>$bun</body></html>
HTML;
