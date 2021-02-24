<?php

namespace App\Util;

class ConverterUtil {

  public static function s2d($str, $format) {
    if (!isset($str)) return "";

    $date = str_replace('/', '-', $str);
    return date('Y-m-d', strtotime($date));
  }

  // Convert datetime format from Y/m/d to Y-m-d
  public static function change_format($str) {
    if (empty($str)) return "";

    $date = str_replace('/', '-', $str);
    return date('Y-m-d', strtotime($date));
  }
}