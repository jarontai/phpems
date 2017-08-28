<?php
session_start();
class app
{
	public $G;

	public function __construct(&$G)
	{
		$this->G = $G;
		$this->ev = $this->G->make('ev');
		$this->tpl = $this->G->make('tpl');
		$this->sql = $this->G->make('sql');
		$this->db = $this->G->make('pepdo');
		$this->pg = $this->G->make('pg');
		$this->html = $this->G->make('html');
		$this->module = $this->G->make('module');
		$this->session = $this->G->make('session');
		$this->user = $this->G->make('user','user');
		$this->order = $this->G->make('orders','bank');
		$this->_user = $_user = $this->session->getSessionUser();
		if(!$_user['sessionuserid'])
		{
			if($this->ev->get('userhash'))
			exit(json_encode(array(
				'statusCode' => 301,
				"message" => "请您重新登录",
			    "callbackType" => 'forward',
			    "forwardUrl" => "index.php?user-app-login"
			)));
			else
			{
				header("location:index.php?user-app-login");
				exit;
			}
		}
		$groups = $this->user->getUserGroups();
		$this->tpl->assign('groups',$groups);
		$this->tpl->assign('_user',$this->user->getUserById($_user['sessionuserid']));
		$this->tpl->assign('userhash',$this->ev->get('userhash'));
		$orderstatus = array(1=>'待付款',2=>'已完成',99=>'已撤单');
		$this->tpl->assign('orderstatus',$orderstatus);
	}
}

?>