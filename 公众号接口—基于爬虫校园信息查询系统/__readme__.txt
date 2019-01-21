#readme

【简介】
本程序参考微信公众平台接口开发开源代码，并添加自己的功能以实现学生信息在公众号中一键查询
具体功能，代码每个功能都有详细注释。


[文件介绍]
__readme__.txt: 程序介绍
SisecxMP_index.php: 微信通讯接口
SisecxMP.py: 业务处理脚本
ip.txt: 当前服务器ip地址(根据实际情况修改)
sisestartdate.txt: 华软开学第一天时间(每学期开学需手动修改该文件)
siseuser.txt: 储存华软学生学号密码
keyword.xlsx: 教师信息和教室信息(可自行添加)
picurl.txt: 公众号回复样式背景(查成绩时用到,链接可随意添加)
index.php: 虚假的主页(防止SisecxMP目录被发觉,本文件无需修改)
mysisetime.txt: 华软信息系统的系统时间(用于信息系统登录认证,本文件无需修改)



[服务器配置]
1)若是linux（包括centos）服务器，使用前需给予相应权限：chmod 666 data/siseuser.txt && chmod 666 data/mysisetime.txt；当然也可以用selinux等安全机制进行权限设置。
2)修改ip.txt为当前服务器ip，修改sisestartdate.txt为开学时间
3)修改php配置文件php.ini，将disable_functions后面的shell_exec()删掉，将display_errors赋值为On
4)重启php环境
5)浏览器直接浏览SisecxMP_index.php如果提示Can't use function return value in write context，如果是file_get_contents("php://input")的问题的话，那就将它换成$GLOBALS["HTTP_RAW_POST_DATA"]
6)安装项目所需的python模块：pip install requests BeautifulSoup xlrd



[公众号平台设置]
(1)登录https://mp.weixin.qq.com/
(2)开发 -> 基本配置 -> 服务器配置
(3)
URL(服务器地址):http://你服务器地址/程序的路径/SisecxMP_index.php
*这里的index.php是一个欺骗程序，让黑客进入到这个错误的入口。
Token(令牌):    sisecxmp
(4)提交
