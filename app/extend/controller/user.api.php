<?php
/*
 * Created on 2017-08-30
 * 扩展的用户模块
 * 路径: index.php?extend-api-user-*method*
 */

use M1\Env\Parser;

class action extends app
{
	public function display()
	{
		$action = $this->ev->url(3);
		$this->$action();
		exit;
	}

	private function fetchKey()
	{
		$env = Parser::parse(file_get_contents('.env'));
		return $env['EXTEND_API_KEY'];
	}

	// 用户注册
	private function register()
	{
		$key = $this->fetchKey(); //密钥，需修改双方一致
		$sign = $this->ev->get('sign');
		$username = $this->ev->get('username');
		$timestamp = $this->ev->get('timestamp');
		$useremail = $username . '@exam.com'; // email地址必须要有

		header('Content-type: application/json');
		$result = array();

		if (!$sign || !$username || !$timestamp) 
		{
			$result['error'] = 'Invalid or missing params!';
		}
		else
		{
			if (TIME - $timestamp < 30) // 检查时间戳超时
			{
				if ($sign == md5($username . $key . $timestamp))
				{
					$u = $this->user->getUserByUserName($username);
					if (!$u) // 检查用户是否已经存在
					{
						$defaultgroup = $this->user->getDefaultGroup();
						$pass = md5(rand(1000, 9999));
						$id = $this->user->insertUser(array('username' => $username, 'usergroupid' => $defaultgroup['groupid'], 'userpassword' => md5($pass), 'useremail' => $useremail));
						$result['data'] = array('id' => $id);
					}
					else
					{
						$result['data'] = array('id' => $u['userid']);
					}
				}
				else
				{
					$result['error'] = 'Invalid sign!';
				}
			}
			else
			{
				$result['error'] = 'Expired request!';
			}			
		}

		exit(json_encode($result));
	}
	
	// 测试
	private function test()
	{
		$username = 'jarontest';
		$key = $this->fetchKey(); //密钥，需修改双方一致
		$timestamp = TIME;
		$sign = md5($username . $key . $timestamp);
		$result = array('username' => $username, 'timestamp' => $timestamp, 'sign' => $sign);
		$result['params'] = '&'.http_build_query($result);
		header('Content-type: application/json');
		exit(json_encode($result));
	}
}

?>
