<?php
namespace plugins\Ipspay\controller;
use app\common\controller\Common;

/**
 * 环讯支付控制器
 * @package plugins\Ipspay\controller
 */
class Ipspay extends Common
{ 
    public function __construct()  
    {
        $config = plugin_config('ipspay');
        $this->pMerCode = $config['mer_code'];
        $this->pAccount = $config['account'];
        $this->pMerCert = $config['mer_cert'];
        $this->pMerName = $config['mer_name'];
    } 
    /**
     * 示例：
     *   $payment_data = [
     *           'GoodsName'         => '充值',
     *           'MerBillNo'         => '订单号',
     *           'Amount'            => '金额',
     *           'Attach'            => '备注',
     *           'Merchanturl'       => '',
     *           'ServerUrl'         => '',
     *           'UserRealName'      => '',//自动注册
     *           'UserId'            => '',//自动注册
     *  ];
     *   plugin_action('Ipspay/Ipspay/payment', [$payment_data, 'h5']);
     */
    public function payment($input = [], $paytype = 'h5')
    {
        $pMsgId = 'msg'.rand(1000,9999); //消息唯一标示，交易必输，查询可选 
        $pReqDate = date("Ymdhis");//商户请求时间
        $pDate = date("Ymd");//订单日期
        $pGoodsName = $input['GoodsName'];//商品名称
        $pMerBillNo = $input['MerBillNo'];//商户订单号
        $pAmount = $input['Amount'];//订单金额 
        $pAttach = $input['Attach'];//商户数据包 附加信息
        $pMerchanturl = $input['Merchanturl'];//支付结果成功返回的商户URL 
        $pFailUrl = "";//支付结果失败返回的商户URL 
        $pServerUrl = $input['ServerUrl'];//Server to Server返回页面 
        $pUserRealName = $input['UserRealName'];
        $pUserId = $input['UserId'];

        if($pUserRealName && $pUserId){
            $autoXml = "<IsCredit>1</IsCredit><BankCode>1100</BankCode><ProductType>1</ProductType><UserRealName>".$pUserRealName."</UserRealName><UserId>".$pUserId."</UserId>";
        }else{
            $autoXml = "<IsCredit>0</IsCredit><BankCode></BankCode><ProductType></ProductType>";
        }

        if($paytype == 'wx'){
            //微信支付
            $serverUrl = "https://thumbpay.e-years.com/psfp-webscan/onlinePay.do";
            $serverPost = "wxPayReq";
            $pBillEXP = '';
            $strbodyxml = "<body>"
                ."<MerBillno>".$pMerBillNo."</MerBillno>"
                ."<GoodsInfo>"
                ."<GoodsName>".$pGoodsName."</GoodsName>"
                ."<GoodsCount>1</GoodsCount>"
                ."</GoodsInfo>"
                ."<OrdAmt>".$pAmount."</OrdAmt>"
                ."<OrdTime>".date("Y-m-d H:i:s")."</OrdTime>"
                ."<MerchantUrl>".$pMerchanturl."</MerchantUrl>"
                ."<ServerUrl>".$pServerUrl."</ServerUrl>"
                ."<BillEXP>".$pBillEXP."</BillEXP>"
                ."<ReachBy></ReachBy>"
                ."<ReachAddress></ReachAddress>"
                ."<CurrencyType>156</CurrencyType>"
                ."<Attach>".$pAttach."</Attach>"
                ."<RetEncodeType>17</RetEncodeType>"
            ."</body>";
            //签名明文
            $pSignature = md5($strbodyxml.$this->pMerCode.$this->pMerCert);
            //请求报文的消息头
            $strheaderxml= "<head>"
                ."<Version>v1.0.0</Version>"
                ."<MerCode>".$this->pMerCode."</MerCode>"
                ."<MerName>".$this->pMerName."</MerName>"
                ."<Account>".$this->pAccount."</Account>"
                ."<MsgId>".$pMsgId."</MsgId>"
                ."<ReqDate>".$pReqDate."</ReqDate>"
                ."<Signature>".$pSignature."</Signature>"
            ."</head>";
            //提交给网关的报文
            $strsubmitxml =  "<Ips>"
                ."<WxPayReq>"
                .$strheaderxml
                .$strbodyxml
                ."</WxPayReq>"
            ."</Ips>";
        }else{
            //H5支付
            $serverUrl = "https://mobilegw.ips.com.cn/psfp-mgw/paymenth5.do";
            $serverPost = "pGateWayReq";
            $pBillEXP = 1;//订单有效期(过期时间设置为1小时)
            $strbodyxml = "<body>"
                ."<MerBillNo>".$pMerBillNo."</MerBillNo>"
                ."<Amount>".$pAmount."</Amount>"
                ."<Date>".$pDate."</Date>"
                ."<CurrencyType>GB</CurrencyType>"
                ."<GatewayType>01</GatewayType>"
                ."<Lang>156</Lang>"
                ."<Merchanturl>".$pMerchanturl."</Merchanturl>"
                ."<FailUrl>".$pFailUrl."</FailUrl>"
                ."<Attach>".$pAttach."</Attach>"
                ."<OrderEncodeType>5</OrderEncodeType>"
                ."<RetEncodeType>17</RetEncodeType>"
                ."<RetType>3</RetType>"
                ."<ServerUrl>".$pServerUrl."</ServerUrl>"
                ."<BillEXP>".$pBillEXP."</BillEXP>"
                ."<GoodsName>".$pGoodsName."</GoodsName>"
                .$autoXml
            ."</body>";
            //签名明文
            $pSignature = md5($strbodyxml.$this->pMerCode.$this->pMerCert);
            //请求报文的消息头
            $strheaderxml= "<head>"
                ."<Version>v1.0.0</Version>"
                ."<MerCode>".$this->pMerCode."</MerCode>"
                ."<MerName>".$this->pMerName."</MerName>"
                ."<Account>".$this->pAccount."</Account>"
                ."<MsgId>".$pMsgId."</MsgId>"
                ."<ReqDate>".$pReqDate."</ReqDate>"
                ."<Signature>".$pSignature."</Signature>"
            ."</head>";
            //提交给网关的报文
            $strsubmitxml =  "<Ips>"
                ."<GateWayReq>"
                .$strheaderxml
                .$strbodyxml
                ."</GateWayReq>"
            ."</Ips>";
        }
        //echo $strsubmitxml;exit;
        ?>
        <html>
          <head>
            <title>......</title>
            <meta http-equiv="content-Type" content="text/html; charset=gb2312" />
          </head>
          <body>
            <form name="form1" id="form1" method="post" action="<?php echo $serverUrl;?>" target="_self">
                <input type="hidden" name="<?php echo $serverPost;?>" value="<?php echo $strsubmitxml ?>" />
            </form>
            <script language="javascript">document.form1.submit();</script>
          </body>
        </html>
        <?php
    }
    
    //支付返回
    public function ipsreturn($input, $paytype = 'wx')
    {
        $BASE_PATH = str_replace( '\\' , '/' , realpath(dirname(__FILE__).'/../../../../'))."/log";
        $PATH_LOG_FILE = $BASE_PATH.'/newPayDemo-'.date('Y-m-j').'.log';

        if(!$input){
            return '参数不全！';exit; //input空错误
        }

        $xml = simplexml_load_string($input, 'SimpleXMLElement', LIBXML_NOCDATA);

        if($paytype == 'wx'){
            //微信接收
            $ReferenceIDs = $xml->xpath("WxPayRsp/head/ReferenceID");//关联号
            //var_dump($ReferenceIDs); 
            $ReferenceID = $ReferenceIDs[0];//关联号
            $RspCodes = $xml->xpath("WxPayRsp/head/RspCode");//响应编码
            $RspCode = $RspCodes[0];
            $RspMsgs = $xml->xpath("WxPayRsp/head/RspMsg"); //响应说明
            $RspMsg = $RspMsgs[0];
            $ReqDates = $xml->xpath("WxPayRsp/head/ReqDate"); // 接受时间
            $ReqDate = $ReqDates[0];
            $RspDates = $xml->xpath("WxPayRsp/head/RspDate");// 响应时间
            $RspDate = $RspDates[0];
            $Signatures = $xml->xpath("WxPayRsp/head/Signature"); //数字签名
            $Signature = $Signatures[0];

            $MerBillNos = $xml->xpath("WxPayRsp/body/MerBillno"); // 商户订单号
            $MerBillNo = $MerBillNos[0];
            $MerCodes = $xml->xpath("WxPayRsp/body/MerCode");//IPS商户号
            $MerCode = $MerCodes[0];
            $Accounts = $xml->xpath("WxPayRsp/body/Account"); //IPS二级交易账户号 
            $Account = $Accounts[0];
            $IpsBillNos = $xml->xpath("WxPayRsp/body/IpsBillno"); //IPS订单号
            $IpsBillNo = $IpsBillNos[0];
            $IpsBillTimes = $xml->xpath("WxPayRsp/body/IpsBillTime"); //IPS处理时间
            $IpsBillTime = $IpsBillTimes[0];
            $OrdAmts = $xml->xpath("WxPayRsp/body/OrdAmt");    //完成支付的订单金额 
            $Amount = $OrdAmts[0];
            $Statuss = $xml->xpath("WxPayRsp/body/Status");  //交易状态
            $Status = $Statuss[0];
            $RetEncodeTypes = $xml->xpath("WxPayRsp/body/RetEncodeType");    //交易返回方式
            $RetEncodeType = $RetEncodeTypes[0];
            $Attachs = $xml->xpath("WxPayRsp/body/Attach");    //数据包
            $Attach = $Attachs[0];
            
            //Status Y#交易成功；N#交易失败；P#交易处理中 
            $sbReq = "<body>"
                    . "<MerBillno>" . $MerBillNo . "</MerBillno>"
                    . "<MerCode>" . $MerCode . "</MerCode>"
                    . "<Account>" . $Account . "</Account>"
                    . "<IpsBillno>" . $IpsBillNo . "</IpsBillno>"
                    . "<IpsBillTime>" . $IpsBillTime . "</IpsBillTime>"
                    . "<OrdAmt>" . $Amount . "</OrdAmt>"
                    . "<Status>" . $Status . "</Status>"
                    . "<RetEncodeType>" . $RetEncodeType . "</RetEncodeType>"
            . "</body>";
        }else{
            //H5接收
            $ReferenceIDs = $xml->xpath("GateWayRsp/head/ReferenceID");//关联号
            $ReferenceID = $ReferenceIDs[0];//关联号
            $RspCodes = $xml->xpath("GateWayRsp/head/RspCode");//响应编码
            $RspCode = $RspCodes[0];
            $RspMsgs = $xml->xpath("GateWayRsp/head/RspMsg"); //响应说明
            $RspMsg = $RspMsgs[0];
            $ReqDates = $xml->xpath("GateWayRsp/head/ReqDate"); // 接受时间
            $ReqDate = $ReqDates[0];
            $RspDates = $xml->xpath("GateWayRsp/head/RspDate");// 响应时间
            $RspDate = $RspDates[0];
            $Signatures = $xml->xpath("GateWayRsp/head/Signature"); //数字签名
            $Signature = $Signatures[0];
            $MerBillNos = $xml->xpath("GateWayRsp/body/MerBillNo"); // 商户订单号
            $MerBillNo = $MerBillNos[0];
            $CurrencyTypes = $xml->xpath("GateWayRsp/body/CurrencyType");//币种
            $CurrencyType = $CurrencyTypes[0];
            $Amounts = $xml->xpath("GateWayRsp/body/Amount"); //订单金额
            $Amount = $Amounts[0];
            $Dates = $xml->xpath("GateWayRsp/body/Date");    //订单日期
            $Date = $Dates[0];
            $Statuss = $xml->xpath("GateWayRsp/body/Status");  //交易状态
            $Status = $Statuss[0];
            $Msgs = $xml->xpath("GateWayRsp/body/Msg");    //发卡行返回信息
            $Msg = $Msgs[0];
            $Attachs = $xml->xpath("GateWayRsp/body/Attach");    //数据包
            $Attach = $Attachs[0];
            $IpsBillNos = $xml->xpath("GateWayRsp/body/IpsBillNo"); //IPS订单号
            $IpsBillNo = $IpsBillNos[0];
            $IpsTradeNos = $xml->xpath("GateWayRsp/body/IpsTradeNo"); //IPS交易流水号
            $IpsTradeNo = $IpsTradeNos[0];
            $RetEncodeTypes = $xml->xpath("GateWayRsp/body/RetEncodeType");    //交易返回方式
            $RetEncodeType = $RetEncodeTypes[0];
            $BankBillNos = $xml->xpath("GateWayRsp/body/BankBillNo"); //银行订单号
            $BankBillNo = $BankBillNos[0];
            $ResultTypes = $xml->xpath("GateWayRsp/body/ResultType"); //支付返回方式
            $ResultType = $ResultTypes[0];
            $IpsBillTimes = $xml->xpath("GateWayRsp/body/IpsBillTime"); //IPS处理时间
            $IpsBillTime = $IpsBillTimes[0];

            $sbReq = "<body>"
                    . "<MerBillNo>" . $MerBillNo . "</MerBillNo>"
                    . "<CurrencyType>" . $CurrencyType . "</CurrencyType>"
                    . "<Amount>" . $Amount . "</Amount>"
                    . "<Date>" . $Date . "</Date>"
                    . "<Status>" . $Status . "</Status>"
                    . "<Msg><![CDATA[" . $Msg . "]]></Msg>"
                    . "<Attach><![CDATA[" . $Attach . "]]></Attach>"
                    . "<IpsBillNo>" . $IpsBillNo . "</IpsBillNo>"
                    . "<IpsTradeNo>" . $IpsTradeNo . "</IpsTradeNo>"
                    . "<RetEncodeType>" . $RetEncodeType . "</RetEncodeType>"
                    . "<BankBillNo>" . $BankBillNo . "</BankBillNo>"
                    . "<ResultType>" . $ResultType . "</ResultType>"
                    . "<IpsBillTime>" . $IpsBillTime . "</IpsBillTime>"
            . "</body>";
        }

        $sign = $sbReq.$this->pMerCode.$this->pMerCert;
        file_put_contents($PATH_LOG_FILE,"\r\n".date('y-m-d H:i:s').'验签明文:'.$sign."\r\n",FILE_APPEND);
        $md5sign = md5($sign);
        //判断签名
        $data = array();
        $report['RspCode'] = $RspCode;
        $report['MerBillNo'] = $MerBillNo;
        $report['IpsBillNo'] = $IpsBillNo;
        $report['Amount'] = $Amount;
        $report['Status'] = $Status;
        $report['Attach'] = $Attach;
        $report['IpsBillTime'] = $IpsBillTime;
        $report['Signature'] = $Signature;
        $report['md5sign'] = $md5sign;

        if($Signature == $md5sign)
        {
            file_put_contents($PATH_LOG_FILE,date('y-m-d H:i:s')."验签成功：".$RspCode." 金额：".$Amount."---".$paytype."\r\n",FILE_APPEND);
            if($RspCode == '000000')
            {
                file_put_contents($PATH_LOG_FILE,date('y-m-d H:i:s')."订单号：".$MerBillNo.".\r\n",FILE_APPEND);
                file_put_contents($PATH_LOG_FILE,"\r\n",FILE_APPEND);
                $data['status'] = 1;
                $data['info'] = $report;
            }else{
                $data['status'] = 0;
                $data['info'] = $report;
            }
        }else{
            $data['status'] = 0;
            $data['info'] = $report;
        }

        return $data;
    }

    //按商户订单时间查询 
    public function getOrderByTime($input = array())
    {
        $Status = $input['Status'];//订单状态 
        $TradeType = $input['TradeType']; //交易类型 
        $StartTime = $input['StartTime']; //开始时间 
        $EndTime = $input['EndTime']; //结束时间
        $Page = $input['Page']; //当前页
        $PageSize = $input['PageSize']; //分页步长

        $strbodyxml= "<body>"
            ."<Status>".$Status."</Status>"
            ."<TradeType>".$TradeType."</TradeType>"
            ."<StartTime>".$StartTime."</StartTime>"
            ."<EndTime>".$EndTime."</EndTime>"
            ."<Page>".$Page."</Page>"
            ."<PageSize>".$PageSize."</PageSize>"
        ."</body>";
        //签名
        $pSignature = md5($strbodyxml.$this->pMerCode.$this->pMerCert);
        //请求报文的消息头
        $strheaderxml= "<head>"
            ."<Version>v1.0.0</Version>"
            ."<MerCode>".$this->pMerCode."</MerCode>"
            ."<MerName>".$this->pMerName."</MerName>"
            ."<Account>".$this->pAccount."</Account>"
            ."<ReqDate>".date('YmdHis')."</ReqDate>"
            ."<Signature>".$pSignature."</Signature>"
        ."</head>";
        //提交给网关的报文
        $strsubmitxml = "<Ips><OrderQueryReq>"
            .$strheaderxml
            .$strbodyxml
        ."</OrderQueryReq></Ips>";

        $client = new \SoapClient("https://newpay.ips.com.cn/psfp-entry/services/order?wsdl");
        $addResult = $client->getOrderByTime($strsubmitxml);
        $out_array = $this->simplest_xml_to_array($addResult);

        return $out_array['OrderQueryRsp']['body'];
    }

    //下发
    public function issued($input = array())
    {
        $key = $input['key'];//key
        $iv = $input['iv']; //向量; 
        
        $pAttach = $input['pAttach']; //备注信息
        $pMerBillNo = $input['pMerBillNo']; //商户订单号
        $pAccountName = $input['pAccountName']; //收款人姓名
        $pAccountNumber = $input['pAccountNumber']; //收款银行账户号
        $pBankName = $input['pBankName']; //银行名称
        $pBranchBankName = $input['pBranchBankName']; //支行名称
        $pBankCity = $input['pBankCity']; //银行卡卡户行所属城市
        $pBankProvince = $input['pBankProvince']; //银行卡开户行所属省份
        $pBillAmount = $input['pBillAmount']; //下发金额 
        $pIdCard = $input['pIdCard']; //身份证号
        $pMobilePhone = $input['pMobilePhone']; //手机号码

        $strdetailxml = "<MerBillNo>".$pMerBillNo."</MerBillNo>"
            ."<AccountName><![CDATA[".$pAccountName."]]></AccountName>"
            ."<AccountNumber>".$pAccountNumber."</AccountNumber>"
            ."<BankName><![CDATA[".$pBankName."]]></BankName>"
            ."<BranchBankName><![CDATA[".$pBranchBankName."]]></BranchBankName>"
            ."<BankCity><![CDATA[".$pBankCity."]]></BankCity>"
            ."<BankProvince><![CDATA[".$pBankProvince."]]></BankProvince>"
            ."<BillAmount>".$pBillAmount."</BillAmount>"
            ."<IdCard>".$pIdCard."</IdCard>"
            ."<MobilePhone>".$pMobilePhone."</MobilePhone>"
            ."<Remark><![CDATA[".$pAttach."]]></Remark>";

        import("Org.Net.STD3Des");
        $des = new \STD3Des($key, $iv);
        
        $pIssuedDetails = $des->encrypt($strdetailxml);
        //echo $pIssuedDetails = $des->decrypt($pIssuedDetails);

        $strbodyxml= "<Body>"
            ."<BizId>1</BizId>"
            ."<ChannelId>1</ChannelId>"
            ."<Currency>156</Currency>"
            ."<Date>".date('Ymdhis')."</Date>"
            ."<Attach><![CDATA[".$pAttach."]]></Attach>"
            ."<IssuedDetails><Detail>".$pIssuedDetails."</Detail></IssuedDetails>"
        ."</Body>";
        //签名
        $pSignature = md5($strbodyxml.$this->pMerCert);
        //请求报文的消息头
        $strheaderxml= "<Head>"
            ."<Version>v1.0.0</Version>"
            ."<MerCode>".$this->pMerCode."</MerCode>"
            ."<MerName>".$this->pMerName."</MerName>"
            ."<Account>".$this->pAccount."</Account>"
            ."<MsgId>msg".rand(1000,9999)."</MsgId>"
            ."<ReqDate>".date('Ymdhis')."</ReqDate>"
            ."<Signature>".$pSignature."</Signature>"
        ."</Head>";
        //提交给网关的报文
        $strsubmitxml = "<Req>"
            .$strheaderxml
            .$strbodyxml
        ."</Req>";
        $client = new \SoapClient("https://merservice.ips.com.cn/pfas-merws/services/issued?wsdl");
        $param["arg0"] = $strsubmitxml;
        $addResult = $client->issued($param);
        $out_array = $this->simplest_xml_to_array($addResult->return);

        return $out_array['Head']['RspCode'];
    }

    private function simplest_xml_to_array($xmlstring) {
        return json_decode(json_encode((array) simplexml_load_string($xmlstring)), true);
    }
}