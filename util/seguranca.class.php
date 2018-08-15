<?php
class Seguranca {
  public static function criptografar($v){
    return md5('Sis'.$v.'PHP');
  }
}
