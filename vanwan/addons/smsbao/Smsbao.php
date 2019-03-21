<?php

namespace addons\smsbao;

use app\common\library\Menu;
use think\Addons;

// Use the REST API Client to make requests to the Twilio REST API
use Twilio\Rest\Client;

/**
 * Smsbao插件
 */
class Smsbao extends Addons
{

    /**
     * 插件安装方法
     * @return bool
     */
    public function install()
    {

        return true;
    }

    /**
     * 插件卸载方法
     * @return bool
     */
    public function uninstall()
    {

        return true;
    }

    /**
     * 插件启用方法
     * @return bool
     */
    public function enable()
    {

        return true;
    }

    /**
     * 插件禁用方法
     * @return bool
     */
    public function disable()
    {

        return true;
    }

    /**
     * 短信发送
     * @param Sms $params
     * @return mixed
     */
    public function smsSend(&$params)
    {
        // Your Account SID and Auth Token from twilio.com/console
       
        $sid = 'AC96f62189508816d46cf6188453dc44c1';
        $token = '8b3964668371d093e696d3b2025a72d9';
        $client = new Client($sid, $token);
        
        try {
            // Use the client to do fun stuff like send text messages!
            $result = $client->messages->create(
                // the number you'd like to send the message to
                $params['mobile'],
                array(
                    // A Twilio phone number you purchased at twilio.com/console
                    'from' => '+16042299404',
                    // the body of the text message you'd like to send
                    'body' => "你的短信验证码是：{$params['code']}"
                )
            );

        }catch(Exception $e){
            dump($e);
        }
        return ($result->status == "queued" ? true : false);
    }

    /**
     * 短信发送通知（msg参数直接构建实际短信内容即可）
     * @param   array $params
     * @return  boolean
     */
    public function smsNotice(&$params)
    {
        $smsbao = new library\Smsbao();
        $result = $smsbao->mobile($params['mobile'])->msg($params['msg'])->send();
        return $result;
    }

    /**
     * 检测验证是否正确
     * @param   Sms $params
     * @return  boolean
     */
    public function smsCheck(&$params)
    {
        return TRUE;
    }
}
