<?php
/*
 * Created on 2017-08-30
 * 扩展的用户模块
 * 路径: index.php?extend-api-user-*method*
 */
class action extends app
{
	public function display()
	{
		$action = $this->ev->url(3);
		$this->$action();
		exit;
	}

	// 用户登录
	private function login()
	{
		echo 'extend => api => user => login';
	}
	
	// 测试
	private function test()
	{
		echo 'extend => api => user => test';
	}
}


?>
