<?php

class action extends app
{
    public function display()
    {   
        // print_r($this->ev->get('param1'));
        // echo 1;
        $appname = "文件模块";
        $args = array('*',array('app'), array(array("AND", "appname = :appname", 'appname', $appname)),NULL,NULL,array(0, 3));
        $result = $this->db->fetchAll($this->pdosql->makeSelect($args));

        var_dump($result);

        $test = "test var";
        $this->tpl->assign('test', $test);        
        $this->tpl->display('index');
    }
}