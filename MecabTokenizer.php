<?php
require_once 'vendor/autoload.php';
require_once 'mecab.inc.php';

use Fieg\Bayes\TokenizerInterface;

class MecabTokenizer implements TokenizerInterface{
  public function tokenize($string){
    // mecab.inc.php内の関数
    return mecab_parse_simple($string);
  }
}