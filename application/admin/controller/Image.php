<?php
namespace app\admin\controller;
use app\common\lib\Util;

class Image
{

    public function index() {
        $file = request()->file('file');
         return print_r($_FILES);
        $info = $file->move('/static/upload');
//        print_r($file);
        if($info) {
            $data = [
                'image' => config('live.host')."/upload/".$info->getSaveName(),
            ];
            echo 111;
            return Util::show(config('code.success'), 'OK', $data);
        }else {
            echo 222;
            return Util::show(config('code.error'), 'error');
        }
    }

}
