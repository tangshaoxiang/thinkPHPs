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
    html = '<div class="frame">';
    html += '<h3 class="frame-header">';
    html += '<i class="icon iconfont icon-shijian"></i>第一节 01：30';
    html += '</h3>';
    html += '<div class="frame-item">';
    html += '<span class="frame-dot"></span>';
    html += '<div class="frame-item-author">';
    html += '<img src="./imgs/team1.png" width="20px" height="20px" /> 马刺';
    html += '</div>';
    html += '<p>08:44 暂停 常规暂停</p>';
    html += '<p>08:44 帕克 犯规 个人犯规 2次</p>';
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