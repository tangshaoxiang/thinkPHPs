<?php
namespace app\admin\controller;
use app\common\lib\Util;

class Image
{

    public function index() {
        $file = request()->file('file');
//        print_r($_FILES);
        $info = $file->move(__PUBLIC__.'/static/upload');
        print_r($info);
        if($info) {
            $data = [
                'image' => config('live.host')."/upload/".$info->getSaveName(),
            ];
            return Util::show(config('code.success'), 'OK', $data);
        }else {
            return Util::show(config('code.error'), 'error');
        }
    }

}
