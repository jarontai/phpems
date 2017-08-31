<?php
/*
 * Created on 2017-08-30
 * 扩展的helper类
 */
use M1\Env\Parser;

class helper_extend
{
    public $G;
    private $env;

    public function __construct(&$G)
    {
        $this->G = $G;
    }

    private function fetchEnv($name)
    {
        $env = array();
        if ($this->env) {
            $env = $this->env;
        }
        else {
            $env = Parser::parse(file_get_contents('.env'));
            $this->env = $env;
        }
        return $env[$name];
    }

    public function fetchApiKey()
    {
        return $this->fetchEnv('EXTEND_API_KEY');
    }

    public function fetchJwtKey()
    {
        return $this->fetchEnv('EXTEND_JWT_KEY');
    }
}

?>
