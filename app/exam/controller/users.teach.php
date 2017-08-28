<?php
/*
 * Created on 2016-5-19
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class action extends app
{
	public function display()
	{
		$this->module = $this->G->make('module');
		$action = $this->ev->url(3);
		$search = $this->ev->get('search');
		$u = '';
		if($search)
		{
			$this->tpl->assign('search',$search);
			foreach($search as $key => $arg)
			{
				$u .= "&search[{$key}]={$arg}";
			}
		}
		$this->tpl->assign('u',$u);
		if(!method_exists($this,$action))
		$action = "index";
		$this->$action();
		exit;
	}

	private function stats()
	{
		$search = $this->ev->get('search');
		$page = $this->ev->get('page');
		if($page < 1)$page = 1;
		$this->tpl->assign('page',$page);
		$args = array();
		$basicid = $this->ev->get('basicid');
		$type = $this->ev->get('type');
		$this->tpl->assign('type',$type);
		$args[] =  array('AND',"ehbasicid = :ehbasicid",'ehbasicid',$basicid);
		if($search['stime'])
		{
			$stime = strtotime($search['stime']);
			$args[] = array('AND',"ehstarttime >= :stime",'stime',$stime);
		}
		if($search['etime'])
		{
			$etime = strtotime($search['etime']);
			$args[] = array('AND',"ehstarttime <= :etime",'etime',$etime);
		}
		if($search['sscore'])
		{
			$args[] = array('AND',"ehscore >= :sscore",'sscore',$search['sscore']);
		}
		if($search['escore'])
		{
			$args[] = array('AND',"ehscore <= :escore",'escore',$search['escore']);
		}
		if($search['examid'])
		{
			$args[] = array('AND',"ehexamid = :ehexamid",'ehexamid',$search['examid']);
		}
		$rs = $this->favor->getStatsAllExamHistoryByArgs($args);
		$number = count($rs);
		$stats = array();
		if(!$type)
		{
			$os = array('A','B','C','D','E','F','G','H');
			$questiontype = $this->basic->getQuestypeList();
			foreach($rs as $p)
			{
				foreach($p['ehquestion']['questions'] as $questions)
				{
					foreach($questions as $key => $question)
					{
						$stats[$question['questionid']]['title'] = $question['question'];
						$stats[$question['questionid']]['id'] = $question['questionid'];
						if($p['ehscorelist'][$question['questionid']] > 0)
						$stats[$question['questionid']]['right'] = intval($stats[$question['questionid']]['right']) + 1;
						$stats[$question['questionid']]['number'] = intval($stats[$question['questionid']]['number']) + 1;
						if($p['ehuseranswer'][$question['questionid']] && $questiontype[$question['questiontype']]['questsort'] == 0 && $questiontype[$question['questiontype']]['questchoice'] < 5)
						{
							foreach($os as $o)
							{
								if(strpos($p['ehuseranswer'][$question['questionid']],$o) !== false)
								$stats[$question['questionid']][$o] = intval($stats[$question['questionid']][$o]) + 1;
							}
						}
					}
				}
				foreach($p['ehquestion']['questionrows'] as $questionrows)
				{
					foreach($questionrows as $questionrow)
					{
						foreach($questionrow['data'] as $key => $question)
						{
							if(!$key)
							{
								$stats[$question['questionid']]['title'] = $questionrow['qrquestion'].'<br />'.$question['question'];
							}
							$stats[$question['questionid']]['id'] = $question['questionid'];
							if($p['ehscorelist'][$question['questionid']] > 0)
							$stats[$question['questionid']]['right'] = intval($stats[$question['questionid']]['right']) + 1;
							$stats[$question['questionid']]['number'] = intval($stats[$question['questionid']]['number']) + 1;
							if($p['ehuseranswer'][$question['questionid']] && $questiontype[$question['questiontype']]['questsort'] == 0 && $questiontype[$question['questiontype']]['questchoice'] < 5)
							{
								foreach($os as $o)
								{
									if(strpos($p['ehuseranswer'][$question['questionid']],$o) !== false)
									$stats[$question['questionid']][$o] = intval($stats[$question['questionid']][$o]) + 1;
								}
							}
						}
					}
				}
			}
			ksort($stats);
			$start = $page - 1;
			$start = $start >= 0?$start:0;
			$tmp = array_slice($stats,$start * 20,20);
			$pages = $this->pg->outPage($this->pg->getPagesNumber(count($stats),20),$page);
			$this->tpl->assign('stats',array('data' => $tmp,'pages' => $pages));
			$this->tpl->assign('basicid',$basicid);
			$this->tpl->display('users_stats');
		}
		else
		{
			foreach($rs as $p)
			{
				foreach($p['ehquestion']['questions'] as $questions)
				{
					foreach($questions as $key => $question)
					{
						foreach($question['questionknowsid'] as $knows)
						{
							$stats[$knows['knowsid']]['knowsid'] = $knows['knowsid'];
							$stats[$knows['knowsid']]['knows'] = $knows['knows'];
							$stats[$knows['knowsid']]['number'] = intval($stats[$knows['knowsid']]['number']) + 1;
							if($p['ehscorelist'][$question['questionid']] > 0)
							$stats[$knows['knowsid']]['right'] = intval($stats[$knows['knowsid']]['right']) + 1;
						}
					}
				}
				foreach($p['ehquestion']['questionrows'] as $questionrows)
				{
					foreach($questionrows as $questionrow)
					{
						foreach($questionrow['data'] as $key => $question)
						{

							foreach($questionrow['qrknowsid'] as $knows)
							{
								$stats[$knows['knowsid']]['knowsid'] = $knows['knowsid'];
								$stats[$knows['knowsid']]['knows'] = $knows['knows'];
								$stats[$knows['knowsid']]['number'] = intval($stats[$knows['knowsid']]['number']) + 1;
								if($p['ehscorelist'][$question['questionid']] > 0)
								$stats[$knows['knowsid']]['right'] = intval($stats[$knows['knowsid']]['right']) + 1;
							}
						}
					}
				}
			}
			ksort($stats);
			$start = $page - 1;
			$start = $start >= 0?$start:0;
			$tmp = array_slice($stats,$start * 20,20);
			$pages = $this->pg->outPage($this->pg->getPagesNumber(count($stats),20),$page);
			$this->tpl->assign('stats',array('data' => $tmp,'pages' => $pages));
			$this->tpl->assign('basicid',$basicid);
			$this->tpl->display('users_knowsstats');
		}
	}

	private function outscore()
	{
		$appid = 'user';
		$app = $this->G->make('apps','core')->getApp($appid);
		$this->tpl->assign('app',$app);
		$fields = array();
		$tpfields = explode(',',$app['appsetting']['regfields']);
		foreach($tpfields as $f)
		{
			$tf = $this->module->getFieldByNameAndModuleid($f);
			if($tf && $tf['fieldappid'] == 'user')
			{
				$fields[$tf['fieldid']] = $tf;
			}
		}

		$search = $this->ev->get('search');
		$args = array();
		$basicid = $this->ev->get('basicid');
		if($basicid)
		{
			$fname = 'data/score/'.TIME.'-'.$basicid.'-score.csv';
			$args[] =  array('AND',"ehbasicid = :ehbasicid",'ehbasicid',$basicid);
			$args[] =  array('AND',"ehneedresit = 0");
			$args[] =  array('AND',"ehtype = 2");
			if($search['stime'])
			{
				$stime = strtotime($search['stime']);
				$args[] = array('AND',"ehstarttime >= :stime",'stime',$stime);
			}
			if($search['etime'])
			{
				$etime = strtotime($search['etime']);
				$args[] = array('AND',"ehstarttime <= :etime",'etime',$etime);
			}
			if($search['sscore'])
			{
				$args[] = array('AND',"ehscore >= :sscore",'sscore',$search['sscore']);
			}
			if($search['escore'])
			{
				$args[] = array('AND',"ehscore <= :escore",'escore',$search['escore']);
			}
			if($search['examid'])
			{
				$args[] = array('AND',"ehexamid = :ehexamid",'ehexamid',$search['examid']);
			}
			$sf = array('ehusername','ehscore');
			foreach($fields as $p)
			{
				$sf[] = $p['field'];
			}
			$rs = $this->favor->getAllExamHistoryByArgs($args,$sf);
			$r = array();
			foreach($rs as $p)
			{
				$tmp = array('ehusername' => iconv("UTF-8","GBK",$p['ehusername']),'ehscore' => $p['ehscore']);
				foreach($fields as $ps)
				{
					$tmp[$ps['field']] = iconv("UTF-8","GBK",$p[$ps['field']]);
				}
				$r[] = $tmp;
			}
			if($this->files->outCsv($fname,$r))
			$message = array(
				'statusCode' => 200,
				"message" => "成绩导出成功，转入下载页面，如果浏览器没有相应，请<a href=\"{$fname}\">点此下载</a>",
			    "callbackType" => 'forward',
			    "forwardUrl" => "{$fname}"
			);
			else
			$message = array(
				'statusCode' => 300,
				"message" => "成绩导出失败"
			);
		}
		else
		$message = array(
			'statusCode' => 300,
			"message" => "请选择好考场"
		);
		exit(json_encode($message));
	}

	private function readpaper()
	{
		$ehid = $this->ev->get('ehid');
		$eh = $this->favor->getExamHistoryById($ehid);
		$questype = $this->basic->getQuestypeList();
		$sessionvars = array('examsession'=>$eh['ehexam'],'examsessionscore'=>$eh['ehscore'],'examsessionscorelist'=>$eh['ehscorelist'],'examsessionsetting'=>$eh['ehsetting'],'examsessionquestion'=>$eh['ehquestion'],'examsessionuseranswer'=>$eh['ehuseranswer']);
		$this->tpl->assign('eh',$eh);
		$this->tpl->assign('user',$this->user->getUserById($eh['ehuserid']));
		$this->tpl->assign('sessionvars',$sessionvars);
		$this->tpl->assign('questype',$questype);
		$this->tpl->display('exam_view');
	}

	private function makescore()
	{
		$questype = $this->basic->getQuestypeList();
		$ehid = $this->ev->get('ehid');
		$sessionvars = $this->favor->getExamHistoryById($ehid);
		if($this->ev->get('makescore'))
		{
			$score = $this->ev->get('score');
			$sumscore = 0;
			if(is_array($score))
			{
				foreach($score as $key => $p)
				{
					$sessionvars['ehscorelist'][$key] = $p;
				}
			}
			foreach($sessionvars['ehscorelist'] as $p)
			{
				$sumscore = $sumscore + floatval($p);
			}
			$sessionvars['ehscore'] = $sumscore;
			$args['ehscorelist'] = $sessionvars['ehscorelist'];
			$allnumber = floatval(count($sessionvars['ehscorelist']));
			$args['ehscore'] = $sessionvars['ehscore'];
			$args['ehstatus'] = 1;
			$this->favor->modifyExamHistory($args,$ehid);
			$message = array(
				'statusCode' => 200,
				"message" => "评分完成",
			    "forwardUrl" => "index.php?exam-teach-users-exams&basicid={$sessionvars['ehbasicid']}"
			);
			exit(json_encode($message));
		}
		else
		{
			$message = array(
				'statusCode' => 300,
				"message" => "非法参数"
			);
			exit(json_encode($message));
			$number = array();
			$right = array();
			$score = array();
			$allnumber = 0;
			$allright = 0;
			foreach($questype as $key => $q)
			{
				$number[$key] = 0;
				$right[$key] = 0;
				$score[$key] = 0;
				if($sessionvars['ehquestion']['questions'][$key])
				{
					foreach($sessionvars['ehquestion']['questions'][$key] as $p)
					{
						$number[$key]++;
						$allnumber++;
						if($sessionvars['ehscorelist'][$p['questionid']] == $sessionvars['ehsetting']['examsetting']['questype'][$key]['score'])
						{
							$right[$key]++;
							$allright++;
						}
						$score[$key] = $score[$key]+$sessionvars['ehscorelist'][$p['questionid']];
					}
				}
				if($sessionvars['ehquestion']['questionrows'][$key])
				{
					foreach($sessionvars['ehquestion']['questionrows'][$key] as $v)
					{
						foreach($v['data'] as $p)
						{
							$number[$key]++;
							$allnumber++;
							if($sessionvars['ehscorelist'][$p['questionid']] == $sessionvars['ehsetting']['examsetting']['questype'][$key]['score'])
							{
								$right[$key]++;
								$allright++;
							}
							$score[$key] = $score[$key]+$sessionvars['ehscorelist'][$p['questionid']];
						}
					}
				}
			}
			$this->tpl->assign('ehid',$ehid);
			$this->tpl->assign('allright',$allright);
			$this->tpl->assign('allnumber',$allnumber);
			$this->tpl->assign('right',$right);
			$this->tpl->assign('score',$score);
			$this->tpl->assign('number',$number);
			$this->tpl->assign('questype',$questype);
			$this->tpl->assign('sessionvars',$sessionvars);
			$this->tpl->display('exam_score');
		}
	}

	private function score()
	{
		$ehid = $this->ev->get('ehid');
		$sessionvars = $this->favor->getExamHistoryById($ehid);
		$questype = $this->basic->getQuestypeList();
		$this->tpl->assign('ehid',$ehid);
		$this->tpl->assign('sessionvars',$sessionvars);
		$this->tpl->assign('questype',$questype);
		$this->tpl->display('users_decide');
	}

	private function scorelist()
	{
		$appid = 'user';
		$app = $this->G->make('apps','core')->getApp($appid);
		$this->tpl->assign('app',$app);
		$fields = array();
		$tpfields = explode(',',$app['appsetting']['regfields']);
		foreach($tpfields as $f)
		{
			$tf = $this->module->getFieldByNameAndModuleid($f);
			if($tf && $tf['fieldappid'] == 'user')
			{
				$fields[$tf['fieldid']] = $tf;
			}
		}


		$page = $this->ev->get('page');
		$search = $this->ev->get('search');
		$basicid = intval($this->ev->get('basicid'));
		$basic = $this->basic->getBasicById($basicid);
		$page = $page > 0?$page:1;
		$args = array();
		$args[] = array('AND',"ehtype = '2'");
		$args[] = array('AND',"ehstatus = '1'");
		$args[] = array('AND',"ehbasicid = :ehbasicid",'ehbasicid',$basicid);
		if($search['stime'])
		{
			$stime = strtotime($search['stime']);
			$args[] = array('AND',"ehstarttime >= :stime",'stime',$stime);
		}
		if($search['etime'])
		{
			$etime = strtotime($search['etime']);
			$args[] = array('AND',"ehstarttime <= :etime",'etime',$etime);
		}
		if($search['sscore'])
		{
			$args[] = array('AND',"ehscore >= :sscore",'sscore',$search['sscore']);
		}
		if($search['escore'])
		{
			$args[] = array('AND',"ehscore <= :escore",'escore',$search['escore']);
		}
		if($search['examid'])
		{
			$args[] = array('AND',"ehexamid = :ehexamid",'ehexamid',$search['examid']);
		}
		$exams = $this->favor->getExamHistoryListByArgs($page,30,$args);
		$ids = trim($basic['basicexam']['self'],', ');
		if(!$ids)$ids = '0';
		$exampaper = $this->exam->getExamSettingsByArgs(array(array("AND","find_in_set(examid,:examid)",'examid',$ids)));
		$this->tpl->assign('basicid',$basicid);
		$this->tpl->assign('search',$search);
		$this->tpl->assign('basic',$basic);
		$this->tpl->assign('page',$page);
		$this->tpl->assign('fields',$fields);
		$this->tpl->assign('exampaper',$exampaper);
		$this->tpl->assign('exams',$exams);
		$this->tpl->display('users_scorelist');
	}

	private function setresit()
	{
		$ehid = $this->ev->get('ehid');
		$this->favor->modifyExamHistory(array('ehneedresit' => 1),$ehid);
		$message = array(
			'statusCode' => 200,
			"message" => "设置成功",
		    "forwardUrl" => "reload"
		);
		exit(json_encode($message));
	}

	private function exams()
	{
		$page = $this->ev->get('page');
		$basicid = intval($this->ev->get('basicid'));
		$page = $page > 0?$page:1;
		$exams = $this->favor->getExamHistoryListByArgs($page,10,array(array('AND',"ehstatus = '0'"),array('AND',"ehbasicid = :ehbasicid",'ehbasicid',$basicid)));
		$this->tpl->assign('page',$page);
		$this->tpl->assign('exams',$exams);
		$this->tpl->display('users_history');
	}

	private function index()
	{
		$page = $this->ev->get('page');
		$search = $this->ev->get('search');
		$page = $page > 1?$page:1;
		$subjects = $this->basic->getSubjectList(array(array('AND',"find_in_set(subjectid,:subjectid)",'subjectid',$this->teachsubjects)));
		$args = array(array('AND',"find_in_set(basicsubjectid,:basicsubjectid)",'basicsubjectid',$this->teachsubjects));
		if($search['basicid'])$args[] = array('AND',"basicid = :basicid",'basicid',$search['basicid']);
		else
		{
			if($search['keyword'])$args[] = array('AND',"basic LIKE :basic",'basic',"%{$search['keyword']}%");
			if($search['basicareaid'])$args[] = array('AND',"basicareaid = :basicareaid",'basicareaid',$search['basicareaid']);
			if($search['basicsubjectid'])$args[] = array('AND',"basicsubjectid = :basicsubjectid",'basicsubjectid',$search['basicsubjectid']);
			if($search['basicapi'])$args[] = array('AND',"basicapi = :basicapi",'basicapi',$search['basicapi']);
		}
		$basics = $this->basic->getBasicList($page,10,$args);
		$areas = $this->area->getAreaList();
		$this->tpl->assign('areas',$areas);
		$this->tpl->assign('subjects',$subjects);
		$this->tpl->assign('basics',$basics);
		$this->tpl->display('users_basic');
	}
}


?>
