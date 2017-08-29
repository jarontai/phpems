<?php

class action extends app
{
    public function display()
    {   
        // print_r($this->ev->get('param1'));
        // echo 1;
        // $appname = "文件模块";
        // $args = array('*',array('app'), array(array("AND", "appname = :appname", 'appname', $appname)),NULL,NULL,array(0, 3));
        // $result = $this->db->fetchAll($this->pdosql->makeSelect($args));

        // var_dump($result);

        $sc = 'JOAa4HeKdq52b7jJZYXo';//密钥，需修改双方一致
        $userid = 100;
        $username = "jarontest";
        $useremail = "test@126.com";
        $ts = TIME; 
        $sign = md5($userid . $username . $useremail . $sc . $ts);
        echo '<a href="index.php?exam-api-login&sign='.$sign.'&userid=' . $userid . '&username=' . $username . '&useremail=' . $useremail . '&ts=' . $ts . '">第三方用户登录</a>';

        $test = "test var";
        $this->tpl->assign('test', $test);        
        $this->tpl->display('index');
    }
}