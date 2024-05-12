<?php
use Core\Response;
function dd($value)
{

echo "<pre>";
var_dump($value);
echo "</pre>";


die();
}

//dd($_SERVER["REQUEST_URI"]);

function uri($value)
{
   return $_SERVER['REQUEST_URI'] == $value;
}

function authorize($con,$status = RESPONSE::FORBIDDEN)
{
   if(!$con)
   {
      abort($status);
   }
}
function abort($code = 404)
{
    http_response_code($code);

    require base_path("views/{$code}.php");

    die();
}



function base_path($path)
{
    return BASE_PATH . $path;
}

function view($path,$attr = [])
{
    extract($attr);
    require base_path('views/'.$path);
}

function login($user)
{
    $_SESSION['user'] = [
        'Email'=>$user['Email'],
        'ID'=>$user['ID']
    ];

    session_regenerate_id(true);
}

function logout()
{
    $_SESSION = [];
    session_destroy();

    $params = session_get_cookie_params();
    setcookie('PHPSESSID','',time()-3600, $params['path'],$params['domain'],$params['httponly']);
}


function user()
{
    if(isset($_SESSION['user']))
    {
        $var = $_SESSION['user']['Email'];
    }
    else
    {
        $var = 'Guest';
    }
    return 'Hello '.$var;
}

function redirect($path)
{
    header("location: {$path}");
    exit();
}




?>