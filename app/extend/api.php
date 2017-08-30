<?php
/*
 * Created on 2017-08-30
 * 扩展的api模块
 * 路径: index.php?extend-api-*controller*-*method*
 */
class app
{
	public $G;

	public function __construct(&$G)
	{
		$this->G = $G;
		$this->ev = $this->G->make('ev');
		$this->user = $this->G->make('user', 'user');
	}
}

?>
