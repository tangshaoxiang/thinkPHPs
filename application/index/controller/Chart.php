<?php
namespace app\index\controller;
use app\common\lib\Util;
class Chart
{
    public function index()
    {
        // 登录

        //  todo
        foreach($_POST['http_server']->ports[1]->connections as $fd) {
            $_POST['http_server']->push($fd, $fd);
        }

        echo 222;


    }


}
