## PHPEMS

### 要求
* php版本 >= 5.3

### 安装依赖

```
php composer.phar install
```

### 用户注册接口说明

地址：index.php?extend-api-user-register&sign=55a71fe9415ff671c3aae8258cc341c7&username=jarontest&timestamp=1503990942

参数（约定密钥为key）：

* sign 签名 - md5(username + key + timestamp)
* username 用户名
* timestamp 时间戳（秒）
