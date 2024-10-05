<?php

namespace Core;

class Response {

  public static function json($data, $code = 200)
  {
    echo json_encode($data);
    exit();
  }

}
