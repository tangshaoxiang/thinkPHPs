<?php
namespace app\admin\controller;
use app\common\lib\Util;

class Image
{

    public function index() {
        $file = request()->file('file');

        $info = $file->move('../../../public/static/upload');

       print_r($info);
    }

}
