<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 18/3/27
 * Time: 上午12:50
 */
class Ws {
    CONST HOST = "0.0.0.0";
    CONST PORT = 8811;

    public $ws = null;
    public function __construct() {
        $this->ws = new swoole_websocket_server(self::HOST, self::PORT);

        $this->ws->set(
            [
                'enable_static_handler' => true,
                'document_root' => "/home/wwwroot/default/thinkPHPs/public/static",
                'worker_num' => 4,
                'task_worker_num' => 4,
            ]
        );

        $this->ws->on("open", [$this, 'onOpen']);
        $this->ws->on("message", [$this, 'onMessage']);
        $this->ws->on("workerstart", [$this, 'onWorkerStart']);
        $this->ws->on("request", [$this, 'onRequest']);
        $this->ws->on("task", [$this, 'onTask']);
        $this->ws->on("finish", [$this, 'onFinish']);
        $this->ws->on("close", [$this, 'onClose']);

        $this->ws->start();
    }

    /**
     * @param $server
     * @param $worker_id
     */
    public function onWorkerStart($server,  $worker_id) {
        // 定义应用目录
        define('APP_PATH', __DIR__ . '/../../../application/');
        // 加载框架里面的文件
//        require __DIR__ . '/../../../thinkphp/base.php';
        require __DIR__ . '/../../../thinkphp/start.php';
    }

    /**
     * request回调
     * @param $request
     * @param $response
     */
    public function onRequest($request, $response) {
        $_SERVER  =  [];
        if(isset($request->server)) {
            foreach($request->server as $k => $v) {
                $_SERVER[strtoupper($k)] = $v;
            }
        }
        if(isset($request->header)) {
            foreach($request->header as $k => $v) {
                $_SERVER[strtoupper($k)] = $v;
            }
        }

        $_GET = [];
        if(isset($request->get)) {
            foreach($request->get as $k => $v) {
                $_GET[$k] = $v;
            }
        }
        $_POST = [];
        if(isset($request->post)) {
            foreach($request->post as $k => $v) {
                $_POST[$k] = $v;
            }
        }

        $_POST['http_server'] = $this->ws;

        ob_start();
        // 执行应用并响应
        try {
            think\Container::get('app', [APP_PATH])
                ->run()
                ->send();
        }catch (\Exception $e) {
            // todo
        }

        $res = ob_get_contents();
//        ob_end_clean();
        $response->end($res);
    }

    /**
     * @param $serv
     * @param $taskId
     * @param $workerId
     * @param $data
     */
    public function onTask($serv, $taskId, $workerId, $data) {
        // 分发 task 任务机制，让不同的任务 走不同的逻辑
        /**
         * 分发task任务
         */
        $obj = new app\common\lib\task\Task();

        $method = $data['method'];
        $flag = $obj->$method($data['data']);

        /**
         * 下面为单个task任务
         */
//        $objSms = new app\common\lib\ali\Sms();
//        try {
//            $response = $objSms::sendSms($data['phone'], $data['code']);
//        }catch (\Exception $e) {
//            // todo
//            echo $e->getMessage();
//        }
        return $flag; // 告诉worker
    }

    /**
     * @param $serv
     * @param $taskId
     * @param $data
     */
    public function onFinish($serv, $taskId, $data) {
        echo "taskId:{$taskId}\n";
        echo "finish-data-sucess:{$data}\n";
    }



    /**
     * 监听ws连接事件
     * @param $ws
     * @param $request
     */
    public function onOpen($ws, $request) {
        var_dump($request->fd);
    }

    /**
     * 监听ws消息事件
     * @param $ws
     * @param $frame
     */
    public function onMessage($ws, $frame) {
        echo "ser-push-message:{$frame->data}\n";
        $ws->push($frame->fd, "server-push:".date("Y-m-d H:i:s"));
    }
    /**
     * close
     * @param $ws
     * @param $fd
     */
    public function onClose($ws, $fd) {
        echo "clientid:{$fd}\n";
    }
}

new Ws();