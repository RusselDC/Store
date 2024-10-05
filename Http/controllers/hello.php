<?php 
use Core\Response;
use Core\ResponseCode;
use Core\App;

Response::json(['hello'=>"Hello Lang"], ResponseCode::OK);
