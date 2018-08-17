const im = {
    //ws_ip: 'ws://127.0.0.1:7272',
    ws: null,
    ws_ip: 'ws://test.z9168.com:7272',
    $vue_this: '导入文件时设置为Vue.prototype',
    reconnTimes: 0, // 异常断开重连次数10次
    opt: {},
    // 初始化im聊天
    init_chat: function($this, options) {
        var timer = false;
        im.opt = options;
        im.$vue_this = $this;
        /**
         * 与GatewayWorker建立websocket连接，域名和端口改为你实际的域名端口，
         * 其中端口为Gateway端口，即start_gateway.php指定的端口。
         * start_gateway.php 中需要指定websocket协议，像这样
         * $gateway = new Gateway(websocket://0.0.0.0:8282);
         */
        var ws = new WebSocket(im.ws_ip);
        // 服务端主动推送消息时会触发这里的onmessage
        ws.onmessage = function(e) {
            // json数据转换成js对象
            var data = eval('(' + e.data + ')');
            var type = data.type || '';

            switch(type) {
                // Events.php中返回的init类型的消息，将client_id发给后台进行uid绑定
                case 'init':
                    // 绑定当前登录用户的client_id;
                    //console.log('链接ws成功:', data);
                    im.bindUser(data.client_id);
                    break;
                case "cmd_notice":
                    //console.log('服务器推送消息通知:', data);
                    break;
                case "bindUser":
                    //im.$vue_this.$alert_dlg(data.msg);
                    break;
                case "text_msg":
                    // serverIMData.data = data.data
                    //console.log('服务器推送信息', data)

                    //im.$vue_this.$warn(data.data);
                    break;
                case "SingleChat":

                    break;
                case "GroupChat":

                    break;
                case "LiveBroadcastChat":

                    break;
                default:
                    if(im.opt.hasOwnProperty("onmessage") && im.opt.onmessage) {
                        im.opt.onmessage(type, data);
                    } else {
                        console.error("需要传递参数 方法onmessage监听回调");
                    }
                    break;
            }
        };

        ws.onclose = function(e) {

            if(im.opt.hasOwnProperty("onclose") && im.opt.onclose) {
                im.opt.onclose(e);
            } else {
                // 重连10次不再重连，予以提示
                if(im.reconnTimes >= 10) {
                    $this.$message({
                        showClose: false,
                        message: '网络已断开，网络恢复后请刷新页面'
                    })
                } else {
                    timer = setTimeout(function() {
                        console.log('异常断开链接！', ws.readyState, e);
                        im.reconnTimes++;
                        im.init_chat($this)
                    }, 5000)
                }
            }
        };
        ws.onopen = function(e) {
            if(im.opt.hasOwnProperty("onopen") && im.opt.onopen) {
                im.opt.onopen(e);
            } else {
                console.log('重新链接！');
                im.reconnTimes = 0;
                if(timer) {
                    window.clearTimeout(timer)
                }
            }
        };
        this.ws = ws;
    },
    // 绑定用户client_id
    bindUser: function(client_id) {
        var login_info = im.$vue_this.$login_info();
        if(login_info) {
            this.ws.send(JSON.stringify({
                type: "bindUser",
                client_id: client_id,
                user_token: login_info.user_token
            }));

            login_info.client_id = client_id;
            im.$vue_this.$login_info(login_info);
        }
    }
};

