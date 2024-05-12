<?php

namespace Core\Middleware;

class Guest
{
    public function handle()
    {
        if($_SESSION['user'] ?? false)
        {
            echo "<script>window.location.href='/'</script>";
            exit();
        }
    }
}