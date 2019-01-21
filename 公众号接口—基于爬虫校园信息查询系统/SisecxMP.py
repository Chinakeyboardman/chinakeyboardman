#!/usr/bin/env python
# -- coding: utf-8 --

# chmod 666 data/siseuser.txt && chmod 666 data/mysisetime.txt


import requests
import HTMLParser
import xlrd
import os, sys, time, datetime
from random import Random
from BeautifulSoup import BeautifulSoup




def getBetween(strStart, strEnd, strDefault):
    start = strDefault.find(strStart)
    if start >= 0:
        start += len(strStart)
        end = strDefault.find(strEnd, start)
        if end >= 0:
            return strDefault[start:end]


#解决登录问题，学生信息管理系统中登录需要进行md5加密
def md5(str):
    import hashlib
    m = hashlib.md5()   
    m.update(str)
    return m.hexdigest()

def read_excel_keyword(keyword):
    xlsfile="data/keyword.xlsx"
    workbook = xlrd.open_workbook(xlsfile)
    # 读取xls文件
    sheet1 = workbook.sheet_by_index(0)
    # 指定工作表
    nrows_tmp=0
    for nrows_tmp in range(1,sheet1.nrows):
        if ( keyword==sheet1.cell_value(nrows_tmp,0) ):
            # 若第一列的数据和它相等
            return sheet1.cell_value(nrows_tmp,1).encode('utf-8')
            # 则返回第二列的数据
            break
    return ""
    # 查询不到则返回空


#模拟登录
def logoutsise(cookie):
    headers = { 'Cookie': 'JSESSIONID=' + cookie,
                'User-Agent': 'Mozilla/4.0 (Windows NT 5.1)'
               }
    r = requests.get('http://class.sise.com.cn:7001/sise/common/logout.jsp', headers=headers)
    #print r.content

def getToken(sisecookie,siserandom):
    # 计算token值
    linkCookieRandom = md5('http://class.sise.com.cn:7001/sise/'+sisecookie+siserandom).upper()
    #print linkCookieRandom
    rdlens= len(siserandom)
    token = ''
    rdl = 0
    for lcr in linkCookieRandom:
        token = token + lcr
        if rdl < rdlens:
            token = token + siserandom[rdl]
            rdl = rdl + 1
    return token

def getMySiseTime():
    # 不存在data/mysisetime.txt时,获取mysisetime
    # 存在data/mysisetime.txt时,每四个小时更新一次mysisetime
    localtime = int(round(time.time() * 1000))
    if (os.path.exists('data/mysisetime.txt')):
        readmysisetimetxt = open('data/mysisetime.txt', 'r')
        mysisetimetxt = readmysisetimetxt.readlines()
        readmysisetimetxt.close()
        old_localtime = int(mysisetimetxt[1])
        if abs(old_localtime-localtime)<14400000 :
            #print 'getoldtime'
            old_difftime = int(mysisetimetxt[2])
            mysisetime = localtime+old_difftime
            return mysisetime
    #print 'getnewtime'
    headers = { 'User-Agent': 'Mozilla/4.0 (Windows NT 5.1)'
           }
    try:
        r = requests.get('http://class.sise.com.cn:7001/sise/', headers=headers, timeout=4.2)
    except Exception,e:
        if str(e).find('timed out') > -1:
            return 'time out'
    new_mysisetime = int(getBetween('random"   type="hidden"  value="', '"', r.content))
    new_difftime = new_mysisetime - localtime
    savemysisetimetxt = open('data/mysisetime.txt', 'w')
    savemysisetimetxt.write( '%s\r\n%s\r\n%s\r\n' % (new_mysisetime, localtime, new_difftime) )
    savemysisetimetxt.close()
    mysisetime = new_mysisetime
    return mysisetime

def getRandomCookie():
    # 自主生成随机cookie
    payloads='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    randomCookie = ''
    for i in range(52):
        randomCookie += payloads[Random().randint(0, len(payloads)-1)]
    randomCookie += '!2004122192'
    return randomCookie

#提交data中用户提交的账号密码和加密id登录，某大佬破解了学校网站的登陆机制
def loginsise(username,password):
    mysisetime = getMySiseTime()
    if mysisetime == 'time out':
        return None, 'time out'
    siserandom = str(mysisetime-1000)
    sisecookie_tmp = getRandomCookie()
    sisecookieshort = sisecookie_tmp[0:sisecookie_tmp.find('!')]
    token = getToken(sisecookieshort,siserandom)
    readip = open('data/ip.txt', 'r')
    ip = readip.readlines()[0].strip()
    readip.close()
    ipmd5 = md5(ip)
    ipsisemd5 = md5(md5(ip)+'sise')

    datas = {   ipmd5: ipsisemd5,
                'password': password,
                'username': username,
                'token': token,
                'random': siserandom
               }
    headers = { 'Content-Type': 'application/x-www-form-urlencoded',
                'Cookie': 'JSESSIONID=' + sisecookie_tmp,
                'Referer': 'http://class.sise.com.cn:7001/sise/',
                'User-Agent': 'Mozilla/4.0 (Windows NT 5.1)'
               }
    try:
        r = requests.post('http://class.sise.com.cn:7001/sise/login_check_login.jsp', data=datas, headers=headers, timeout = 4.2)
    except Exception,e:
        if str(e).find('timed out') > -1:
            return None, 'time out'
    sisecookie = getBetween('JSESSIONID=', ';', str(r.headers))
    #print sisecookie, r.content
    return sisecookie, r.content

def getIndex(cookie):
    headers = { 'Cookie': 'JSESSIONID=' + cookie
                }
    r = requests.get('http://class.sise.com.cn:7001/sise/module/student_states/student_select_class/main.jsp', headers=headers)
    return r.content

def getScoresHtml(indexsoup):
    indexScoresTds1 = indexsoup.find('tr',{'title':u'个人信息查询'}).findAll('td')[0]
    indexScoreslink =  HTMLParser.HTMLParser().unescape('http://class.sise.com.cn:7001' + getBetween("../../../../..", "'", str(indexScoresTds1)))
    #print indexScoreslink
    r = requests.get(indexScoreslink)
    scoresdata = r.content
    scoressoup = BeautifulSoup(scoresdata.decode('gbk'))

    scoreresult1 = ""
    cdgptotal1 = 0
    creditstotal1 = 0
    scoreresult0, cdgptotal0, creditstotal0 =  getScores(scoressoup, 0)
    if ( len(scoressoup.findAll('tbody'))>1 ):
        scoreresult1, cdgptotal1, creditstotal1 =  getScores(scoressoup, 1)

    mysisegradepoint = getBetween(u"平均学分绩点：", u"本专业本年级毕业需修满学分：", scoressoup.text)
    #获取系统自带绩点
    if ( creditstotal0+creditstotal1!=0 ):
        #在线计算最新绩点
        newgradepoint = str(round((cdgptotal0+cdgptotal1)/(creditstotal0+creditstotal1),1))
    else:
        newgradepoint = u"0 (该生当前学期~之前学期均无成绩)"
    
    scoreresult = u"【成绩】：\n"
    scoreresult = scoreresult + scoreresult0 + scoreresult1
    scoreresult = scoreresult + u"\n\n\n【绩点】：\n（一）学生系统当前绩点为：" + mysisegradepoint + u"\n\n（二）创协统计最新绩点为：" + newgradepoint + u"\n\n\n【>  <】：\n  明明大家这么爱用创协的查询服务，\n  可是小编发现大家居然都在私藏好东西！\n  亲们，动起手来把创协君推荐出去吧~~\n  ٩(๑`^´๑)۶ 喵~   ヽ(#`Д´)ノ哄哄哄哄!!!"
    scoreresult += u"use_msgType_news"
    return scoreresult

def getScores(scoressoup, classtype):
    #classtype: 0必修课,1选修课
    scoreresult = u""
    scorerenum = 0
    scorerenumnull = 0
    cdgptotal = 0
    creditstotal = 0
    scorestrs = scoressoup.findAll('tbody')[classtype].findAll('tr')
    for trs2 in scorestrs:
        tds2 = trs2.findAll('td')
        credits = tds2[9-classtype].text
        score = tds2[8-classtype].text
        termname = tds2[7-classtype].text

        #进行当前学期的成绩处理
        yearNum = int(time.strftime("%Y",time.localtime()))
        monthNum = int(time.strftime("%m",time.localtime()))
        if 9 <= monthNum <= 12:
            year = str(yearNum)
            month = u'一'
        elif 1 <= monthNum < 3:
            year = str(yearNum - 1)
            month = u'一'
        elif 3 <= monthNum < 9:
            year = str(yearNum - 1)
            month = u'二'
        currentTermname = u'%s年第%s学期' % (year, month)
        if ( termname == currentTermname ):
            if ( credits != "" or str(tds2[2-classtype]).find("FF0000")>-1 ):
                #已得学分不为空说明及格了有成绩，课程名称红色说明不及格了也有成绩
                scorerenum = scorerenum + 1
                cid = tds2[1-classtype].text
                cnm = tds2[2-classtype].text
                scoreresult = scoreresult + u"（" + str(scorerenum) + u"）【" + cnm + u"】：" + score + "\n"
                #课程代码暂不显示： + cid + " "
            else:
                scorerenumnull = scorerenumnull + 1

        #进行所有学期的绩点处理
        if not ( termname == u"修读学年学期" or termname == u"" ):
            if ( credits != "" ):
                #已得学分不为空说明及格了有成绩
                if ( score.find("(")>-1 ):
                    scorenumstr = getBetween("","(",score)
                else:
                    scorenumstr = score
                if ( scorenumstr >= u'\u4e00' and scorenumstr<=u'\u9fa5' ):
                    #判断第一个字是否中文，如果成绩是中文的时候
                    #课程成绩=(优95，良85，中75，合格65, 不合格50)
                    if ( scorenumstr==u"优" ):
                        scorenum = 95
                    elif ( scorenumstr==u"良" ):
                        scorenum = 85
                    elif ( scorenumstr==u"中" ):
                        scorenum = 75
                    elif ( scorenumstr==u"及格" or scorenumstr==u"合格" ):
                        scorenum = 65
                elif ( scorenumstr >= u'\u0030' and scorenumstr<=u'\u0040' ):
                    #判断第一个字是否数字，如果成绩是数字的时候
                    scorenum = int(scorenumstr.encode("utf-8"))
                else:
                    #既不是数字又不是中文的字符
                    pass
                gradepoint = (scorenum-50)/10.0
                cdgptotal = cdgptotal + float(credits)*gradepoint
                creditstotal = creditstotal + float(credits)
    scoreresult_title = u''
    if ( classtype==0 ):
        scoreresult_title = u"（一）必修课"
    elif ( classtype==1 ):
        scoreresult_title = u"\n（二）选修课"
    if ( scorerenumnull>0 ):
        scoreresult_title += u"  (本类课程还有" + str(scorerenumnull) + u"科成绩未出)：\n"
    else:
        scoreresult_title += u"  (本类课程的成绩已显示完整)：\n"
    # if ( scorerenum == 0 ):
    #     scoreresult = scoreresult + u"此类课程暂无成绩。\n"
    scoreresult = scoreresult_title + scoreresult
    return scoreresult, cdgptotal, creditstotal#.text#.strip()

def getXExamHtml(indexsoup,action):
    if (action=='getexam'):
        XExamFile = 'studentexamAction.do'
        tip_tmp = u'当前用户暂无考试信息。'
    elif(action=='getreexam'):
        XExamFile = 'studentReExamAction.do'
        tip_tmp = u'当前用户无需补考。'
    indexexamTds2 = indexsoup.find('tr',{'title':u'考试时间查看'}).findAll('td')[0]
    indexxexamlink =  'http://class.sise.com.cn:7001/SISEWeb/pub/exam/' + XExamFile + '?method=doMain&studentid=' + getBetween("studentid=", "'", str(indexexamTds2))
    #print indexxexamlink
    r = requests.get(indexxexamlink)
    xexamdata = r.content
    if (xexamdata.find('tbody')>-1):
        xexamsoup = BeautifulSoup(xexamdata.decode('gbk'))
        xexamtrs = xexamsoup.findAll('tbody')[0].findAll('tr')
        xexamstr = u''
        xexamnum = 0
        for trs2 in xexamtrs:
            xexamnum += 1
            tds2 = trs2.findAll('td')
            classid = tds2[0].text
            classname = tds2[1].text
            xexamdate = tds2[2].text
            xexamdate = xexamdate[5:]
            xexamtime = tds2[3].text
            xexamtime = xexamtime[0:-3].replace(u':00-',u'-')
            xexamtime = xexamdate+'('+xexamtime+')'
            xexamroomid = tds2[4].text
            xexamroomname = tds2[5].text
            xexamseat = tds2[6].text
            xexamstatus = tds2[7].text
            #xexamstr += u'（%s）\n课程代码：%s\n课程名称：%s\n考试日期：%s\n考试时间：%s\n考场编码：%s\n考场名称：%s\n考试座位：%s\n考试状态：%s\n\n' % (str(xexamnum),classid,classname,xexamdate,xexamtime,xexamroomid,xexamroomname,xexamseat,xexamstatus)
            xexamstr += u'（%s）\n课程：%s\n时间：%s\n考场：%s\n座位：%s\n' % (str(xexamnum),classname,xexamtime,xexamroomname,xexamseat)
        return xexamstr
    else:
        return tip_tmp

def getSchedular(sisecookie,otherkey):
    schedulartips = '查询格式为：\n回复"课表"可获取今日课表，如：课表\n回复"课表"+数字1~7可获取对应的星期数的课表，如：课表5'#\n回复"课表"+0可获取完整课表，如：课表0'
    if ( len(otherkey)>1 or ((otherkey<u'\u0031' or otherkey>u'\u0037') and otherkey!='') ):
        #otherkey超过1个字符，或者不是数字也不是为空时，说明格式错误
        print '格式错误！\n\n'+schedulartips
        return ''
    elif (otherkey==u''):
        #获取当天星期几，然后获取当天课表
        print schedulartips+'\n'
        weeks = time.strftime("%w",time.localtime())
        if (weeks=='0'):
            #为星期天
            weeks='7'
    elif ( 1 <= int(otherkey) <=7 ):
        #为数字时赋值为星期数
        weeks = str(int(otherkey))
    # elif (otherkey==u'0'):
    #     #获取整个星期的课表
    #     pass

    headers = { 'Cookie': 'JSESSIONID=' + sisecookie,
                'Referer': 'http://class.sise.com.cn:7001/sise/',
                'User-Agent': 'Mozilla/4.0 (Windows NT 5.1)'
               }
    r = requests.get('http://class.sise.com.cn:7001/sise/module/student_schedular/student_schedular.jsp', headers=headers)
    #print r.content.strip()
    soup = BeautifulSoup(r.content.decode('gbk'))
    trs = soup.findAll('table')[6].findAll('tr')
    #print trs[2].findAll('td')[1].text.encode('utf-8')

    readstartdate = open('data/sisestartdate.txt', 'r')
    termstartStr = readstartdate.readlines()[0].strip()
    readstartdate.close()
    year, month, day = termstartStr.split('-')
    year = int(year)
    month = int(month)
    day = int(day)
    termstart = datetime.datetime(year, month, day)
    nowadays = datetime.datetime.now()
    termweeks = ( (nowadays - termstart).days / 7 ) + 1
    schedularaday = '当前结果为第'+str(termweeks)+'周的星期'+weeks+'的课表：\n-   -   -   -   -   -   -   -   -   -   -   -'

    for classnum in range(1,9):
        times = (u'【'+trs[classnum].findAll('td')[0].text.replace(u'节',u'】')).encode('utf-8')
        if (weeks=='5'):
            #学院规定周五下午两节课提前40分钟
            times = times.replace('14:00 - 15:20','13:20 - 14:40').replace('15:30 - 16:50','14:50 - 16:10')
        oneclass = trs[classnum].findAll('td')[int(weeks)].text.encode('utf-8')
        
        if (oneclass=='&nbsp;'):
            oneclass_tmp = '无'
        else:
            import re
            #oneclass = u'大学生心身健康教育 I(AAN 曹璐婷 9 10 11 12 13 14 15 16 17周 [A202]), 形势与政策 I(ASF 陈世凤 1 2 3 4 5周 [E101])'
            getoneclass_tmp = '0'
            for oc in oneclass.split(', '):
                if (getoneclass_tmp=='1'):
                    break
                reoneclass = re.search( r'(.*)\(([A-Za-z0-9]+) ([^ ]+) (.*) \[(.*)\]\)', oc)
                if reoneclass:
                    classtimeslot = reoneclass.group(4)
                    if ( (' '+classtimeslot.replace('周',' ')).find(' '+str(termweeks)+' ')>-1 ):
                        #说明当前周有该门课程
                        getoneclass_tmp = '1'
                        classname = reoneclass.group(1)
                        teachingclassid = reoneclass.group(2)
                        teachername = reoneclass.group(3)
                        classroom = reoneclass.group(5)
                        oneclass_tmp = '[%s] %s' % (classroom,classname)
                    else:
                        oneclass_tmp = '无'
                else:
                    oneclass_tmp = '【这门课比较特殊无法处理，请回复"课表有误"，我们将会第一时间修复】'

        schedularaday += '\n' + times + '：' + '\n   ' + oneclass_tmp + '\n'
        if ( times.find('12:00')>-1 or times.find('18:20')>-1 or times.find('21:50')>-1 ):
            schedularaday += '-   -   -   -   -   -   -   -   -   -   -   -'
    return schedularaday

def getAttendanceViewHtml(indexsoup):
    #有 学年学期无免听免修课程信息 的人可能有出错，记得研究下！

    indexexamTds3 = indexsoup.find('tr',{'title':u'考勤'}).findAll('td')[0]
    indexattendanceviewlink =  HTMLParser.HTMLParser().unescape('http://class.sise.com.cn:7001' + getBetween("../../../../..", "'", str(indexexamTds3)))
    #print indexattendanceviewlink
    r = requests.post(indexattendanceviewlink)
    attendanceviewdata = r.content
    if (attendanceviewdata.find('tbody')==-1):
        return u'你的考勤信息为空，因为你课程的老师全都还未录入考勤信息，静静地等待吧。'
    attendanceviewsoup = BeautifulSoup(attendanceviewdata.decode('gbk'))
    attendanceviewtrs = attendanceviewsoup.findAll('tbody')[0].findAll('tr')
    attendanceviewstr = u''
    attendanceviewnum = 0
    for trs in attendanceviewtrs:
        attendanceviewnum += 1
        tds = trs.findAll('td')
        classid = tds[0].text
        classname = tds[1].text
        attendanceviewstatus = HTMLParser.HTMLParser().unescape(tds[2].text)
        attendanceviewstr += u'（%s）\n课程代码：%s\n课程名称：%s\n详细信息：%s\n' % (str(attendanceviewnum),classid,classname,attendanceviewstatus)
    #return u'（一）本学期的考勤信息：\n' + attendanceviewstr + u'\n\n（二）今日考勤变动情况：\n今日考勤统计功能刚开放就访问过多，暂停提供，待用户不密集使用时错峰提供。'
    #############mysise并发不好###############

    todayavstatusstr = u''
    if (attendanceviewdata.find('doSelect')>-1):
        attendanceviewas = attendanceviewsoup.findAll('tbody')[0].findAll('a')
        todayavstatusnum = 0
        nowadays = datetime.datetime.now()
        today = nowadays.strftime("%Y-%m-%d")
        for as_tmp in attendanceviewas:
            avdetailurl = HTMLParser.HTMLParser().unescape('http://class.sise.com.cn:7001' + getBetween('../../../../..', '"', str(as_tmp)))
            r2 = requests.get(avdetailurl)
            avdetaildata = r2.content
            #print r2.content
            if (avdetaildata.find('javax.servlet.ServletException')>-1):
                todayavstatusstr = u'cant todayavstatus'
            else:
                avdetailsoup = BeautifulSoup(avdetaildata.decode('gbk'))
                avdetailtrs = avdetailsoup.findAll('tbody')[0].findAll('tr')
                for trs2 in avdetailtrs:
                    tds2 = trs2.findAll('td')
                    if (len(tds2)<7):
                        #说明是非课程的表格
                        break
                    if (tds2[1].text!=''):
                        classname2 = tds2[1].text
                    classtime2 = tds2[4].text.replace(u'[',u'').replace(u']',u'')
                    avdetailstatus2 = tds2[5].text
                    avdetailchangetim2 = tds2[6].text
                    if (avdetailchangetim2==today):
                        todayavstatusnum += 1
                        todayavstatusstr += u'（%s）\n/:break被登记的课程：%s\n/:break该课程被登记的课时：\n%s\n/:break该课程被登记的状态：\n%s\n' % (str(todayavstatusnum),classname2,classtime2,avdetailstatus2)

    if (todayavstatusstr==u''):
        todayavstatusstr = u'今天没有课程考勤变动，请继续保持此良好的学习风范！\n'
    elif (todayavstatusstr==u'cant todayavstatus'):
        todayavstatusstr = u'【小通知】：mysise目前暂时无法显示考勤的具体时间，这属于不可控的外部因素。临时的解决方案有两个：\n(1)等待mysise修复以后再查询考勤。\n(2)用户每天查询一次考勤，对比上一次考勤数据是否相同。\n'
    else:
        todayavstatusstr = u'/:break    /:break    /:break    /:break    /:break\n' + todayavstatusstr
    return u'（一）本学期的考勤信息：\n' + attendanceviewstr + u'\n\n（二）今日考勤变动情况：\n' + todayavstatusstr

def mysise(action,useropenid,savekey,otherkey):
    if (savekey.find('==args==')>-1):
        schoolnmoropenid,username,password=savekey.split('==args==')
    elif (savekey.find('====')>-1):
        schoolnmoropenid,username,password=savekey.split('====')

    cookie, content = loginsise(username,password)
    #print cookie# + '<br />'
    if (content == 'time out'):
        print '学生系统正在维护中，请稍后再来查询，谢谢~'
        return 0
    elif (content.find("error.jsp")>-1):
        print '账号或者密码错误！\n\n请直接回复学号密码进行绑定，绑定的格式有两种喔：\n(1)第一种，直接一行文字即可，4个等于号(是半角=不是全角＝)分隔，例如：\n华软====154098765====ab\n\n(2)第二种，只需三行文字(第一行"华软"两个字,第二行学号,第三行密码),如:\n\n华软\n1540987654\nabcdefg'
    elif (content.find("index.jsp")>-1):
        if (action=="getscores"):
            indexcontent = getIndex(cookie)
            indexsoup = BeautifulSoup(indexcontent.decode('gbk'))

            #下面是举例获取成绩数据
            scores1 = getScoresHtml(indexsoup).encode('utf-8')
            print scores1.strip()# + '<br />'
        elif (action=="getteacher"):
            pass
        elif (action=="getexam" or action=="getreexam"):
            indexcontent = getIndex(cookie)
            indexsoup = BeautifulSoup(indexcontent.decode('gbk'))

            #下面是举例获取考试/补考信息
            xexamstr = getXExamHtml(indexsoup,action).encode('utf-8')
            print xexamstr.strip()# + '<br />'
        elif (action=="getattendanceview"):
            indexcontent = getIndex(cookie)
            indexsoup = BeautifulSoup(indexcontent.decode('gbk'))

            #下面是举例获取考勤信息
            attendanceviewstr = getAttendanceViewHtml(indexsoup).encode('utf-8')
            print attendanceviewstr.strip()# + '<br />'
        elif (action=="getschedular"):
            print getSchedular(cookie,otherkey)
        elif (action=="savesise"):
            #保存账号密码savekey
            if (savekey.find('==args==')>-1):
                saveschoolnm,saveum,savepsd=savekey.split('==args==')
            elif (savekey.find('====')>-1):
                saveschoolnm,saveum,savepsd=savekey.split('====')

            sisereadtxt = open('data/siseuser.txt', 'r')
            userinfostr=sisereadtxt.readlines()
            sisereadtxt.close()

            issave=0
            auser = useropenid + '==args==' + saveum + '==args==' + savepsd + '==args==\r\n'
            sisesavetxt = open('data/siseuser.txt', 'w')
            for ausertmp in userinfostr:
                if (ausertmp.find(useropenid)>-1):
                    ausertmp = auser
                    issave=1
                sisesavetxt.write(ausertmp)
            if (issave==0):
                sisesavetxt.write(auser)
            sisesavetxt.close()

            # sisesavetxt = open('data/siseuser.txt', 'a')
            # sisesavetxt.write(useropenid + '==args==' + saveum + '==args==' + savepsd + '==args==\r\n')
            # sisesavetxt.closed
            if (sys.platform.find('win')>-1):
                savekey = savekey.encode("gbk")
            elif (sys.platform.find('linux')>-1):
                savekey = savekey.encode("utf-8")
            print '账号绑定成功！\n请回复"成绩"，进行查询。\n\n(若绑定成功且查询失败，则回复"成绩查询失败" ，我们将会及时修复错误。)'#+savekey

        #释放session
        logoutsise(cookie)

def cet46(cet46key):
    if (cet46key.find('==args==')>-1):
        cet46nm,cet46id,cet46um=cet46key.split('==args==')
    elif (cet46key.find('====')>-1):
        cet46nm,cet46id,cet46um=cet46key.split('====')
    cet46um = cet46um.encode('gb2312')
    #进行姓名编码
    datas = {   'id': cet46id,
                'name': cet46um
               }
    headers = { 'Content-Type': 'application/x-www-form-urlencoded',
                'User-Agent': 'Mozilla/4.0 (Windows NT 5.1)',
                'Referer': 'http://cet.99sushe.com/',
                'X-Forwarded-For': '127.0.0.1'#黑技术！这样传递参数绕过了99宿舍的ip限制
               }
    try:
        r = requests.post('http://cet.99sushe.com/getscore', data=datas, headers=headers, timeout=4)
    except Exception,e:
        #print str(e)
        if ( str(e).find("timed out")>-1 ):
            print "查询失败！现在查询的人数过多，请晚些时间再来查询。"
            pass
        return
    #print r.content.decode('gb2312')

    if ( r.content.find(',')>-1 and r.content.find("<")<0 ):
        _, _, listen, read, write, total, school, name, _, _,_=r.content.split(',')
        print "查询成功。结果为：\n总成绩:%s分\n听力:%s分\n阅读:%s分\n翻译写作:%s分\n" % (total, listen, read, write)
    else:
        print "查询失败！请检查下准考证号或者姓名是否填写错误。"

def keywordaboutmysise(useropenid, key, otherkey):
    #和mysise有关的查询功能
    # print '用户访问过多，请稍后再使用。感谢支持'
    # return 0
    # print '【小公告】：\n\n由于近期查成绩需求过大，导致一些问题使得本公众号暂时无法提供查询服务，问题正在排查中。\n\n如需查询成绩，请移步到华软mysise：http://class.sise.com.cn:7001/sise/\n\n感谢对创协的支持'
    # return 0
    sisereadtxt = open('data/siseuser.txt', 'r')
    userinfostr=sisereadtxt.readlines()
    sisereadtxt.close()
    shouldbinding=1
    for ausertmp in userinfostr:
        if (ausertmp.find(useropenid)>-1):
            if (key=='getscores'):
                mysise(key, useropenid, ausertmp[0:len(ausertmp.strip())-len('==args==')],'')
            elif (key=='getschedular'):
                mysise(key, useropenid, ausertmp[0:len(ausertmp.strip())-len('==args==')],otherkey)
            elif (key=='getexam' or key=='getreexam'):
                mysise(key, useropenid, ausertmp[0:len(ausertmp.strip())-len('==args==')],'')
            elif (key=='getattendanceview'):
                mysise(key, useropenid, ausertmp[0:len(ausertmp.strip())-len('==args==')],'')
            shouldbinding=0
            break
    if (shouldbinding==1):
        #说明未绑定，则提示绑定账号密码
        print '无法查询，因为你还未绑定学号密码，以下是绑定方式：\n\n(1)已采用多种防护和加密防止一切数据泄露，且能保证一切数据不被利用于其他任何方面;\n\n(2)请直接回复学号密码进行绑定，绑定的格式有两种喔。\n\n(3)第一种，直接一行文字即可，4个等于号(是半角=不是全角＝)分隔，例如：\n华软====154098765====ab\n\n(4)第二种，只需三行文字(第一行"华软"两个字,第二行学号,第三行密码),如:\n\n华软\n1540987654\nabcdefg'

def main():
    if ( len(sys.argv)>=2 ):
        useropenid=sys.argv[1]
        #用户openid

        if ( len(sys.argv)>=3 ):
            # import chardet
            # print chardet.detect(sys.argv[2])
            if (sys.platform.find('win')>-1):
                keyword_safe = sys.argv[2].decode("gbk")
            elif (sys.platform.find('linux')>-1):
                keyword_safe = sys.argv[2].decode("utf-8")

            keyword_safe = keyword_safe.replace('==args_b==',' ')

            if (keyword_safe == u"成绩" or keyword_safe==u"绩点"):
                keywordaboutmysise(useropenid,'getscores','')
            elif ( keyword_safe == u"成绩查询失败" ):
                print "收到！我们的工作人员已在处理。"
            elif ( keyword_safe.find(u"课表")==0 ):
                otherkey = keyword_safe[2:]
                keywordaboutmysise(useropenid,'getschedular',otherkey)
            elif ( keyword_safe == u"补考" ):
                keywordaboutmysise(useropenid,'getreexam','')
            elif ( keyword_safe == u"考试" or keyword_safe == u"期末" or keyword_safe == u"考试时间" ):
                keywordaboutmysise(useropenid,'getexam','')
            elif ( keyword_safe == u"考勤" ):
                keywordaboutmysise(useropenid,'getattendanceview','')
            elif ( keyword_safe == u"查询教师" or keyword_safe == u"查询教室" ):
                print "请手动输入相关名称\n\n查询教师时请回复：\n教师李六六\n\n查询教室时请回复：\n教室S301"
            elif ( keyword_safe.find(u"教师")==0 or keyword_safe.find(u"教室")==0 ):
                # 这里的关键词均指的是xlsx表的批量关键词
                returnstr = read_excel_keyword(keyword_safe)
                if ( returnstr.strip() != "" ):
                    print returnstr
                else:
                    print "无结果!\n可能是你的查询方式不对\n\n正确的格式是：\n教师李六六   或   教室S301"
            elif ( keyword_safe.find(u"华软==args==")==0 and keyword_safe.count("==args==")==2 ):
                #开始绑定账号，判断密码对错，对则保持密码并且回复成功。错则回复密码错误。
                savekey=keyword_safe
                mysise("savesise",useropenid,savekey,'')
            elif ( keyword_safe.find(u"华软====")==0 and keyword_safe.count("====")==2 ):
                #开始绑定账号，判断密码对错，对则保持密码并且回复成功。错则回复密码错误。
                savekey=keyword_safe
                mysise("savesise",useropenid,savekey,'')
            elif ( (keyword_safe.find(u"四六级==args==")==0 and keyword_safe.count("==args==")==2 ) or ( keyword_safe.find(u"四六级====")==0 and keyword_safe.count("====")==2 ) ):
                cet46key=keyword_safe
                cet46(cet46key)
            elif ( keyword_safe == u"家庭报告书" ):
                print '<a href="http://www.sise.com.cn/SISEWeb/pub/familyReportAction.do?method=doMain">家庭报告书</a>'
            elif ( keyword_safe==u"4" or keyword_safe == u"充值" ):
                print '<a href="http://ecard.scse.com.cn:8070/">（1）饭卡充值</a>\n\n<a href="http://ecard.scse.com.cn:8070/AutoPay/NetFee/Index">（2）网费充值(创协独家首发)</a>'
            elif ( keyword_safe==u"四六级" or keyword_safe==u"四级" or keyword_safe==u"六级" ):
                print '(1)官方接口安全可靠，且公众号不存储一切和四六级查询有关的数据;\n\n(2)请直接回复准考证号和姓名进行查询，查询的格式有两种喔。\n\n(3)第一种，直接一行文字即可，4个等于号(是半角=不是全角＝)分隔，无需任何换行，例如：\n四六级====441040152100101====陈九九\n\n(4)第二种，只需三行文字(第一行"四六级"三个字,第二行准考证号,第三行姓名),如:\n\n四六级\n441040152100101\n陈九九'
            elif ( keyword_safe==u"cx" or keyword_safe == u"?" or keyword_safe == u"？" or keyword_safe == u"菜单" ):
                print '【简约版菜单】：\n-   -   -   -   -   -   -   -   -   -   -   -\n（0）/:<W>回复"菜单?"：获取详细版菜单\n\n（1）回复"1"：创协简介\n（2）回复"2"：创协部门简介\n（3）回复"3"：FTP课件\n（4）回复"4"：充值\n\n（5）回复"教师"+教师名\n（6）回复"教室"+大写教室号\n（7）回复"绑定"\n（8）回复"课表"\n（9）回复"考勤"\n（10）回复"考试"\n（11）回复"成绩"\n（12）回复"绩点"\n（13）回复"补考"\n（14）回复"家庭报告书"\n（15）回复"口令"+口令内容\n（16）回复"四六级"\n'
            elif ( keyword_safe==u"菜单？" or keyword_safe == u"菜单?" ):
                print '【详细版菜单】：\n-   -   -   -   -   -   -   -   -   -   -   -\n（0）回复"菜单"：可获取简约版的菜单\n\n（1）回复"1"：创协简介\n（2）回复"2"：创协部门简介\n（3）回复"3"：FTP课件\n（4）回复"4"：网费饭卡充值，创协首发的掌上校园手机网页版\n\n（5）回复"教师"+教师名：可查询教师信息，如：教师李六六\n（6）回复"教室"+大写的教室号：可查询教室信息，如：教室S301\n（7）回复"绑定"：可进行教务系统的个人绑定\n（8）回复"课表"：可查询课表信息\n（9）回复"考勤"：可查询考勤信息\n（10）回复"考试"：可查询考试信息\n（11）回复"成绩"：可查询成绩信息\n（12）回复"绩点"：可查询当前绩点和创协独家提供的最新绩点信息喔\n（13）回复"补考"：可查询补考信息\n（14）回复"家庭报告书"：父母的考试信息查询查询通道\n（15）回复"口令"+口令内容：可生成安卓qq无法领取的红包口令，如：\n口令你就是拿不了\n（16）回复"四六级"：可查询四六级成绩\n-   -   -   -   -   -   -   -   -   -   -   -\n\n【小邀请】：\n/可爱 若您对创协提供的查询服务感到满意，请推荐给身边的同学。\n\n'
            elif ( keyword_safe==u"绑定"):
                print '(1)已采用多种防护和加密防止一切数据泄露，且能保证一切数据不被利用于其他任何方面;\n\n(2)请直接回复学号密码进行绑定，绑定的格式有两种喔。\n\n(3)第一种，直接一行文字即可，4个等于号(是半角=不是全角＝)分隔，例如：\n华软====154098765====ab\n\n(4)第二种，只需三行文字(第一行"华软"两个字,第二行学号,第三行密码),如:\n\n华软\n1540987654\nabcdefg'
            elif ( keyword_safe==u"1" or keyword_safe==u"2"):
                print '<a href="http://mp.weixin.qq.com/s?__biz=MzIwMjExMTUwMQ==&mid=400413543&idx=1&sn=c61bff8a19810c869c3012e29cbbe218">传送门</a>'
            elif ( keyword_safe==u"3" or keyword_safe==u"课件" ):
                print '外网课件：\nftp://kj.sise.com.cn\n和ftp://kj1.sise.com.cn\n账号 kj\n密码 kj'
            elif ( keyword_safe==u"创协" or keyword_safe==u"华软创协" or keyword_safe==u"创新与创业服务协会" or keyword_safe==u"广州大学华软软件学院创新与创业服务协会" or keyword_safe==u"简介"):
                print '嘿！我仿佛听到有人在说我帅！\n\n华软创协：\n全名：广州大学华软软件学院创新与创业服务协会。\n本协会是在我校团委，社团联合会的领导下，学生自主创办的学生综合类组织。\n我们的口号：带你创新，为你服务。\n相关链接：<a href="http://mp.weixin.qq.com/s?__biz=MzIwMjExMTUwMQ==&mid=400413543&idx=1&sn=c61bff8a19810c869c3012e29cbbe218">传送门</a>\n\n本协会长期为广大学子提供多项在线公益服务，感谢大家的关注。'
            elif ( keyword_safe==u"蛤蟆"):
                print '请勿尝试回复敏感词汇，否则将以法律的形式追究。'
            else:
                print '创协机器人正在升级当中，相信在未来能回答你这个问题。\n\n回复"？"获取菜单'
        else:
            print '呵呵，就问你想干嘛。'
            time.sleep(20)
            pass
            #用户传的数据呢？
    else:
        print '呵呵，就问你还想干嘛。'
        time.sleep(20)
        pass
        #微信用户的id呢？


if __name__ == "__main__":
    main()


