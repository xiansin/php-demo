<?php
/**
 * Created by PhpStorm
 * FileName: SendMail.php
 * User: JianJia.Zhou
 * DateTime: 2018/5/14 14:08
 * @description
 */
require_once __DIR__.'/../bootstrap/ini.php';
require_once __DIR__.'/../libs/Log.php';
require_once __DIR__.'/../libs/QQSendMail.php';
class SendMail
{
    private $_mail = null;

    private $_startDt = '2018-05-05';

    private $_spaceDays = 26;

    private $_address = '1358763480@qq.com';

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
        if($this->isSend()){
            try{
                $title = "亲亲小媳妇儿哟，你的大姨妈要来了哦";
                $next_time = date('Y-m-d',strtotime($this->_startDt."+{$this->_spaceDays}days"));
                $content = "预计时间:<b style='color: red'>$next_time</b><br><img src='http://demo.xiansin.com/images/2.jpg'>";
                $status = $this->_mail->send($this->_address,$title,$content);
                $msg = '发送邮件:'.$this->_address.ENTER.'发送标题:'.$title.ENTER.'发送内容:'.$content;
                Log::logWrite(4,$msg,'发送结果:'.json_encode($status),'send_mail');
            }catch (\Exception $e){
                Log::logWrite(4,'发送异常',$e->getMessage(),'error');
            }
        }
    }

    private function isSend()
    {
    	$s = strtotime($this->_startDt);
    	$n = time();
        $e = strtotime($this->_startDt."+{$this->_spaceDays}days");
    	$m = $e - $n;
    	$t = 1 * 60 * 60* 24; #4天
    	if($m <= $t && $t >= $t){
    	    return true;
        }
        return false;
    }
}

$sendMail = new SendMail();
$sendMail->run();