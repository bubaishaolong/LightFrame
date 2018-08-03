<?php

/**
 * Created by PhpStorm.
 * User: wem
 * Date: 2016/12/13
 * Time: 16:41
 */
class Error
{
    public static function code($code)
    {
        $error = true;
        switch ($code)
        {
            case 'isv.OUT_OF_SERVICE':
                $error = '业务停机';
                break;
            case 'isv.PRODUCT_UNSUBSCRIBE':
                $error = '产品服务未开通';
                break;
            case 'isv.ACCOUNT_NOT_EXISTS':
                $error = '账户信息不存在';
                break;
            case 'isv.ACCOUNT_ABNORMAL':
                $error = '账户信息异常';
                break;
            case 'isv.SMS_TEMPLATE_ILLEGAL':
                $error = '模板不合法';
                break;
            case 'isv.SMS_SIGNATURE_ILLEGAL':
                $error = '签名不合法';
                break;
            case 'isv.MOBILE_NUMBER_ILLEGAL':
                $error = '手机号码格式错误';
                break;
            case 'isv.MOBILE_COUNT_OVER_LIMIT':
                $error = '手机号码数量超过限制';
                break;
            case 'isv.TEMPLATE_MISSING_PARAMETERS':
                $error = '短信模板变量缺少参数';
                break;
            case 'isv.INVALID_PARAMETERS':
                $error = '参数异常';
                break;
            case 'isv.BUSINESS_LIMIT_CONTROL':
                $error = '触发业务流控限制';
                break;
            case 'isv.INVALID_JSON_PARAM':
                $error = 'JSON参数不合法';
                break;
            case 'isp.SYSTEM_ERROR':
                $error = '系统错误';
                break;
            case 'isv.BLACK_KEY_CONTROL_LIMIT':
                $error = '	模板变量中存在黑名单关键字';
                break;
            case 'isv.PARAM_NOT_SUPPORT_URL':
                $error = '不支持url为变量';
                break;
            case 'isv.PARAM_LENGTH_LIMIT':
                $error = '变量长度受限';
                break;
            case 'isv.AMOUNT_NOT_ENOUGH':
                $error = '余额不足';
                break;
            default :
                $error = '出现未知错误';
                break;
        }
        return $error;
    }
}