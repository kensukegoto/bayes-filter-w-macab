<?php

define("MECAB_COMMAND","mecab");

function mecab_exec($input, $opt = false){

  $mecab_cmd = MECAB_COMMAND;

  $tmp_dir = sys_get_temp_dir();
  $file_in = tempnam($tmp_dir,'mecab-in-');
  $file_out = tempnam($tmp_dir,'mecab-out-');
  if(!$opt){
    $opt = "-b ".(1024 * 64);
  }

  file_put_contents($file_in,$input."\n");

  $cmd = "\"$mecab_cmd\" $opt \"$file_in\" -o \"$file_out\"";
  $res = exec($cmd);
  $out = file_get_contents($file_out);

  unlink($file_in);
  unlink($file_out);

  return $out;

}

function mecab_parse($input,$mecab_opt = false){
  $out = mecab_exec($input,$mecab_opt);
  $lines = explode("\n",trim($out));
  $result = [];
  foreach($lines as $line){
    list($word,$params) = explode("\t",$line."\t");
    $list = explode(",",trim($params));
    array_unshift($list,$word);
    $result[] = $list;
  }
  return $result;
}

function mecab_parse_simple($input,$mecab_opt = false){
  $out = mecab_exec($input,$mecab_opt);
  $lines = explode("\n",trim($out));
  $res = [];
  foreach($lines as $line){
    $res[] = trim(substr($line,0,strpos($line,"\t")));
  }
  return $res;
}