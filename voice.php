<?php
/*	�ٶ������ϳ�api�ӿ�
	ͨ��URL��ֱ�Ӱ����ֱ��������
	������ο�readme.md
	gethub https://github.com/qcomdd/hi-voice	
	���÷�ʽ./voice.php?t=Ҫ�ϳ����������� 
	by it0512
*/
error_reporting(E_ALL ^ E_NOTICE);
header("content-type:audio/mp3;charset=utf-8");
//************��������
define( 'DS' , DIRECTORY_SEPARATOR );
define( 'AROOT' , dirname( __FILE__ ) . DS  );
//************�߼�����	
	$o = new OA2();
	$text = isset($_GET['t'])?$_GET['t']:"�ϳ�����������ϵit0512���net";
	$bb = $o->getVoice($text);
	echo ($bb);

/**************
 * �ٶ�OA2��֤
 * �д浽���س���15�죬��ȡ
 * ÿ�ε���token����֤ʱ�� 
****************/
class OA2
{
	private $appid= '���appid',
	$secret= '���secret',
	$Open_url = 'https://openapi.baidu.com/oauth/2.0/token?',
	$url_voice = 'http://tsn.baidu.com/text2audio?',
	$_logname='bd_log.txt',$_filename='bd_token.txt',
	$is_log = TRUE,$scope;
	public $access_token;
	function __construct(){
		global $n,$t;
	}
	function getVoice($txt){//�ٶ���������
		$params=array(
		'tex' => $txt,
		'tok' => $this->getToken(),
		'spd' =>5,//���٣�ȡֵ 0-9��Ĭ��Ϊ 5 
		'pit' =>5,//������ȡֵ 0-9��Ĭ��Ϊ 5 
		'vol' =>9,//������ȡֵ 0-9��Ĭ��Ϊ 5
		'per' =>1,//ȡֵ 0-1 ��0 ΪŮ����1 Ϊ������Ĭ��ΪŮ��
		
		'cuid' => 'it0512.net',
		'ctp' =>1,
		'lan'=>'zh');
		$c = $this->file_get_content($this->url_voice,$params);	
		if(!$c)$this->put('Oauth2����������ʧ��');
		return $c;
	}
	function _getToken(){//�ٶ�ֱ�ӷ���AccessToken
		$params=array(
		'client_id' => $this->appid,
		'client_secret' =>$this->secret,		
		'grant_type'=>'client_credentials');
		$c = $this->file_get_content($this->Open_url,$params);	
		if(!$c)$this->put('Oauth2����������ʧ��');
		return $c;
	}
	function getToken(){		//д��־
		$filename = AROOT.($this->_filename);
		$file = fopen($filename, 'a+') or die("Unable to open file!");
		$str = fread($file,1024);
		$arr = json_decode($str,true);
		if(!$arr && time()<intval($arr['_time']))
		{//����15����
			$str=$this->_getToken();
			$arr=(array)json_decode($str,true);
			$arr['_time']=time()+intval($arr['expires_in'])/2;
			
			$string = json_encode($arr);//֧������Ͷ���;
			fclose($file);
			$file = fopen($filename, 'w+');
			fwrite( $file,$string);
		}
		fclose($file); unset($file);
		$this->openid = $arr['refresh_token']; 
		$this->access_token = $arr['access_token'];
		
		return $this->access_token;
	}
	/*********************************/
	function put($par){//�����ʾ
		exit($par."����ϵ����Ա��лл");
	}
	function _log($data){		//д��־
		if($this->is_log)
		{
			$string = var_export($data, TRUE);//����true��VAR_DUMPһ��
			$file = fopen($this->_logname, 'a+'); 
			fwrite( $file,$string."\r\n");
			fclose($file); unset($file);
		}
	}	
	private function file_get_content($url,$par)
	{
		$ch = curl_init();
		$timeout = 30;
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_URL, $url);		
		curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt ( $ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($par));//
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$file_contents = curl_exec($ch);
		curl_close($ch);
		return $file_contents;
	}

}
?>