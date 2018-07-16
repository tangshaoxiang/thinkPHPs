var wsUrl = "ws://106.14.14.231:8811";

var websocket = new WebSocket(wsUrl);

//实例对象的onopen属性
websocket.onopen = function(evt) {
    console.log("conected-swoole-success");
}

// 实例化 onmessage
websocket.onmessage = function(evt) {
    push(evt.data);
    console.log("ws-server-return-data:" + evt.data);
}

//onclose
websocket.onclose = function(evt) {
    console.log("close");
}
//onerror

websocket.onerror = function(evt, e) {
    console.log("error:" + evt.data);
}

function push(data) {
    data = JSON.parse(data);
    console.log(data);
    html = '<div class="frame">';
    html += '<h3 class="frame-header">';
    html += '<i class="icon iconfont icon-shijian"></i>第'+data.type+'节'.date('Y-m-d');
    html += '</h3>';
    html += '<div class="frame-item">';
    html += '<span class="frame-dot"></span>';
    html += '<div class="frame-item-author">';
    if(data.logo){
        html += '<img src="'+data.logo+'" width="20px" height="20px" /> data.';
    }
    html += data.title;
    html += '</div>';
    html += '<p><?php echo date("Y-m-d",time()) ?>+ '+data.content+'</p>';
    html += '</div>';
    // html += '<div class="frame-item">';
    // html += '<span class="frame-dot"></span>';
    // html += '<div class="frame-item-author">';
    // html += 'singwa(评论员)';
    // html += '</div>';
    // html += '<p>01:44 </p>';
    // html += '<p>01:46 犯规 个人犯规 Ruan</p>';
    // html += '</div>';
    html += '</div>';

    $('#match-result').prepend(html);







}