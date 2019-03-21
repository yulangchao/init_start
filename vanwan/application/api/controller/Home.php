<?php

namespace app\api\controller;

use app\common\controller\Api;

/**
 * 示例接口
 */
class Home extends Api
{

    //如果$noNeedLogin为空表示所有接口都需要登录才能请求
    //如果$noNeedRight为空表示所有接口都需要验证权限才能请求
    //如果接口已经设置无需登录,那也就无需鉴权了
    //
    // 无需登录的接口,*表示全部
    protected $noNeedLogin = ['*'];
    // 无需鉴权的接口,*表示全部
    protected $noNeedRight = [];

    /**
     * 注册会员
     * 
     * @param string $username 用户名
     * @param string $password 密码
     * @param string $email 邮箱
     * @param string $mobile 手机号
     */
     public function banner()
     {
        $username = $this->request->request('mobile');
        $this->success(__('Sign up successful'));
     }

    /**
     * 注册会员
     * 
     * @param string $username 用户名
     * @param string $password 密码
     * @param string $email 邮箱
     * @param string $mobile 手机号
     */
     public function juhuasuanlist()
     {
        $username = $this->request->request('mobile');
        $this->success(__('Sign up successful'));
     }

    /**
     * 注册会员
     * 
     * @param string $username 用户名
     * @param string $password 密码
     * @param string $email 邮箱
     * @param string $mobile 手机号
     */
     public function couponlist()
     {
        $username = $this->request->request('mobile');
        $this->success(__('Sign up successful'));
     }

    /**
     * 注册会员
     * 
     * @param string $username 用户名
     * @param string $password 密码
     * @param string $email 邮箱
     * @param string $mobile 手机号
     */
     public function navlist()
     {
        $username = $this->request->request('mobile');
        $this->success(__('Sign up successful'));
     }
}
