<?php
/**
 * Created by PhpStorm
 * FileName: SendMail.php
 * User: JianJia.Zhou
 * DateTime: 2018/5/14 14:08
 * @description
 */
require_once '../bootstrap/ini.php';
require_once '../libs/Log.php';
require_once '../libs/QQSendMail.php';
class SendMail
{
    private $_mail = null;

    /**
     * SendMail constructor.
     */
    public function __construct()
    {
        global $qq_mail_config;
        $this->_mail = new QQSendMail($qq_mail_config['account'],$qq_mail_config['auth_key']);
    }

    /**
     * @version             v1.0
     * @author              JianJia.Zhou
     * @changeTime          2018/5/14 14:47
     */
    public function run()
    {
        $title = "亲亲小媳妇儿哟，这是测试邮件哦";
        $content = "测试给你发送你的大姨妈哦<br><img src='http://demo.xiansin.com/images/2.jpg'>";
        //$address = '1358763480@qq.com';
        $address = '849841639@qq.com';
        $status = $this->_mail->send($address,$title,$content);
        $msg = '发送邮件:'.$address.ENTER.'发送标题:'.$title.ENTER.'发送内容:'.$content;
        Log::logWrite(4,$msg,'发送结果:'.json_encode($status),'send_mail');
    }
}
$sendMail = new SendMail();
$sendMail->run();