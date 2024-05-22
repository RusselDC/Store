<?php

namespace Core;

class Response {

  public static function json($data, $code = 200)
  {
    header('Content-Type: application/json');
    echo json_encode($data);
    http_response_code($code);
    exit();
  }

}
