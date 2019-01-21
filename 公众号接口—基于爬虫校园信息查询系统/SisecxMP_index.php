<?php

safe();

define("TOKEN", "sisecxmp");
$wechatObj = new wechatCallbackapiTest();

if (isset($_GET['echostr'])) {
    $wechatObj->valid();
}else{
    $wechatObj->responseMsg();
}

class wechatCallbackapiTest
{
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            header('content-type:text');
            echo $echoStr;
            exit;
        }
    }

    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }

    public function responseMsg()
    {
		if(function_exists('file_get_contents')){
			$postStr = file_get_contents("php://input");
		} else if (!empty($GLOBALS["HTTP_RAW_POST_DATA"])) {
			$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		}
		if (!empty($postStr)){
			$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			$fromUsername = $postObj->FromUserName;
			$toUsername = $postObj->ToUserName;
			$keyword = trim($postObj->Content);
			$msgtypewx = $postObj->MsgType;
			$event = $postObj->Event;
			$EventKey = trim($postObj->EventKey);
			if($keyword==""){
				$keyword=$EventKey;
			}
			//$keyword=$EventKey临时解决菜单事件问题

			$time = time();
			$textTpl = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<Content><![CDATA[%s]]></Content>
						<FuncFlag>0</FuncFlag>
						</xml>";
			$msgType = "text";
			$textTplNews = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<Content><![CDATA[]]></Content>
						<ArticleCount>1</ArticleCount>
						<Articles>
							<item>
								<Title><![CDATA[%s]]></Title>
								<Description><![CDATA[%s]]></Description>
								<PicUrl><![CDATA[%s]]></PicUrl>
								<Url><![CDATA[%s]]></Url>
							</item>
						</Articles>
						<FuncFlag>0</FuncFlag>
					</xml>";

			if($msgtypewx=="event"){
				//关注或者取消关注事件，点击事件时
				if($event=="subscribe"){
					//关注事件
					$contentStr="感谢关注华软创协公众号~我们等您很久了~/亲亲\n公众号会不定期给您推送高质量文章~\n目前提供大量公益在线查询服务，希望您喜欢。\n如需查看菜单，请回复'菜单'。";
					$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
					echo $resultStr;
					exit;
				}else if($event=="CLICK"){
					//点击事件
					$contentStr=$this->reply_by_keyword($keyword,$fromUsername);
				}else{
					//其他事件，例如取消关注事件等
					$contentStr='';
				}

			}elseif($msgtypewx=="text"){
				//用户回复文本时
				$contentStr=$this->reply_by_keyword($keyword,$fromUsername);

			}else{
				//说明传来的不是event也不是text也不是语音
				$contentStr="创协机器人正在升级当中，相信在未来能回答你这个问题。\n\n回复\"？\"获取菜单";

			}

			if ( strstr($contentStr,"use_msgType_news") ){
				//news显示样式
				$contentStr = str_replace("use_msgType_news", "", $contentStr);
				#随机背景url
				$picurls = file('data/picurl.txt');
				$picurl = $picurls[rand(0,count($picurls)-1)];
				$resultStr = sprintf($textTplNews, $fromUsername, $toUsername, $time, "news", "【华软创协】\r\n  成绩查询 | 绩点统计", $contentStr, $picurl, '');
			}else{
				//普通的显示样式
				$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
			}
			echo $resultStr;
		}else{
			echo "";
			exit;
		}
    }

    private function reply_by_keyword($keyword,$fromUsername) {
        if ( $this->danger($keyword) || $this->danger($fromUsername) ){
            $contentStr = "亲，你刚刚说的话有本宝宝无法接受的敏感字符喔。";
        } else if (strpos($keyword,"口令")==0 && strstr($keyword,"口令")){
            //qq口令红包
            $qqhongbaokey = substr($keyword,6);
            //截取口令之后的字符
            $contentStr="\024 ".$qqhongbaokey."\024\n\000\n";
            $contentStr=rtrim($contentStr);
        } else {
            $ks = str_replace("\n", "==args==", $keyword);
            $ks = str_replace(" ", "==args_b==", $ks);
            $keyword_safe = $ks;
            $content = "python SisecxMP.py $fromUsername $keyword_safe";
            $contentStr = `$content`;
        }
        return $contentStr;
    }

    private function danger($str){
        $blockStr = array("&", "<", ">", ";", "|", "$", "'", "(", ")", "`", "*", '"', "\\", "#");
        //采用黑名单的形式，防止系统命令执行或者sql注入！
        foreach ($blockStr as $bs) {
            if (strstr($str, $bs)){
                return True;
            }
        }
        return False;
    }
}

function safe(){
    $httpbody=file_get_contents('php://input');
    if ( strstr($httpbody,"gh_bbec56f0be44") || strstr($httpbody,"gh_939aa3829493") || isset($_GET['echostr']) ){
        #当url含有echostr的时候(说明验证TOKEN)，或者当body含有微信公众号ID的时候(说明在转发用户的请求)，才能说明是微信服务器发来的请求。
    }else{
        #防止有人直接访问本链接，同时防止非微信公众号的人访问本链接
        @header("http/1.1 404 not found");
        @header("status: 404 not found");
        @header("X-Powered-By: none");
        $myfilename= end(explode('/',$_SERVER['PHP_SELF']));
        @header("location: ".str_replace("index", "lndex", $myfilename));
        #SisecxMP_index.php
        exit;
    }
}

?>