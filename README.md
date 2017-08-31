## PHPEMS

### 要求
* php版本 >= 5.3

### 安装依赖

```
php composer.phar install
```

### 对PHPEMS代码的改动
* 修改了启动脚本lib/init.cls.php的make方法
* 修改了配置文件lib/config.cls.php, 使之从.env导入数据库配置
* 添加了扩展应用 - app/extend
* 引入了Composer
* 添加了logs文件夹

### 用户注册接口说明

地址：index.php?extend-api-user-register&sign=55a71fe9415ff671c3aae8258cc341c7&username=jarontest&timestamp=1503990942

参数（约定密钥为key）：

* sign 签名 - md5(username + key + timestamp)
* username 用户名
* timestamp 时间戳（秒）
