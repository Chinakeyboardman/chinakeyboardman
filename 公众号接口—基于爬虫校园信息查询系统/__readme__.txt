#readme

����顿
������ο�΢�Ź���ƽ̨�ӿڿ�����Դ���룬������Լ��Ĺ�����ʵ��ѧ����Ϣ�ڹ��ں���һ����ѯ
���幦�ܣ�����ÿ�����ܶ�����ϸע�͡�


[�ļ�����]
__readme__.txt: �������
SisecxMP_index.php: ΢��ͨѶ�ӿ�
SisecxMP.py: ҵ����ű�
ip.txt: ��ǰ������ip��ַ(����ʵ������޸�)
sisestartdate.txt: ����ѧ��һ��ʱ��(ÿѧ�ڿ�ѧ���ֶ��޸ĸ��ļ�)
siseuser.txt: ���滪��ѧ��ѧ������
keyword.xlsx: ��ʦ��Ϣ�ͽ�����Ϣ(���������)
picurl.txt: ���ںŻظ���ʽ����(��ɼ�ʱ�õ�,���ӿ��������)
index.php: ��ٵ���ҳ(��ֹSisecxMPĿ¼������,���ļ������޸�)
mysisetime.txt: ������Ϣϵͳ��ϵͳʱ��(������Ϣϵͳ��¼��֤,���ļ������޸�)



[����������]
1)����linux������centos����������ʹ��ǰ�������ӦȨ�ޣ�chmod 666 data/siseuser.txt && chmod 666 data/mysisetime.txt����ȻҲ������selinux�Ȱ�ȫ���ƽ���Ȩ�����á�
2)�޸�ip.txtΪ��ǰ������ip���޸�sisestartdate.txtΪ��ѧʱ��
3)�޸�php�����ļ�php.ini����disable_functions�����shell_exec()ɾ������display_errors��ֵΪOn
4)����php����
5)�����ֱ�����SisecxMP_index.php�����ʾCan't use function return value in write context�������file_get_contents("php://input")������Ļ����Ǿͽ�������$GLOBALS["HTTP_RAW_POST_DATA"]
6)��װ��Ŀ�����pythonģ�飺pip install requests BeautifulSoup xlrd



[���ں�ƽ̨����]
(1)��¼https://mp.weixin.qq.com/
(2)���� -> �������� -> ����������
(3)
URL(��������ַ):http://���������ַ/�����·��/SisecxMP_index.php
*�����index.php��һ����ƭ�����úڿͽ��뵽����������ڡ�
Token(����):    sisecxmp
(4)�ύ
