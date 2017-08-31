<?php
/*
 * Created on 2017-08-30
 * 扩展的session类
 */
use \Firebase\JWT\JWT;

include 'lib/session.cls.php';

class session_extend extends session
{
    private $cookieName = 'jwt';

    // 重写父类的获取会话用户
    public function getSessionUser()
    {
        $user = parent::getSessionUser();

        if ($this->isLogout()) {
            // 如果手动退出则清除jwt cookie
            $this->ev->setCookie($this->cookieName, '', 0);
        }
        else {
            if (!$user) {
                // 检查cookie，从中抽取jwt用户信息并登录用户
                $jwt = $this->ev->getCookie($this->cookieName);
                if ($jwt) {
                    $helper = $this->G->make('helper', 'extend');
                    $key = $helper->fetchJwtKey();
                    $payload = (array)JWT::decode($jwt, $key, array('HS256'));
                    $username = $payload['username'];
                    $u = $this->getUserByUserName($username);
                    if ($username && $u) {
                        $args = array('sessionuserid' => $u['userid'], 'sessionpassword' => $u['userpassword'], 'sessionip' => $this->ev->getClientIp(), 'sessiongroupid' => $u['usergroupid'], 'sessionlogintime' => TIME, 'sessionusername' => $u['username']);
                        $this->setSessionUser($args);
                    }
                }
            }
        }
        return $user;
    }

    private function isLogout()
    {
        // 从url参数判断是否退出操作
        $ctrl = $this->ev->url[2];
        if ($ctrl === 'logout') {
            return true;
        }
        return false;
    }

    private function getUserByUserName($username)
    {
        $data = array(false, array('user', 'user_group'), array(array('AND', "user.username = :username", 'username', $username), array('AND', 'user.usergroupid = user_group.groupid')));
        $sql = $this->pdosql->makeSelect($data);
        return $this->db->fetch($sql, array('userinfo', 'groupright'));
    }
}

?>
