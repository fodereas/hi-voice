# hi-voice（百度（文字）语音合成ＡＰＩ接口@ＰＨＰ）
先声明一下，此文件太简单，不能称之为项目。不过好处就是熟悉了gethub的使用。莫笑我

##习惯的啰嗦
##百度，（文字）语音合成ＡＰＩ接口（ＰＨＰ）
有看强大的讯飞，多国语言多种方言，还有不同类型的发声，功能太强大用不到。
主要是他的ｓｄｋ都是移动或是ｈ５端不能做ａｐｉ接口，
若要用到微信中，就难办了

##正文
不写外文，让老外用google去翻译，反正他们不翻墙
1,百度语音合成，文档中心[link]http://yuyin.baidu.com/docs/tts/133
2,先拥有百度开放平台帐号
3,http://yuyin.baidu.com/app在这里新建应用 。然后申请开通语音，马上通过
	最后得到
	App ID: 这个在此用不着
	API Key: **********
	Secret Key: *************
4,用百度OAuth2.0，换回token
	这个请看最下面扩展阅读。
	本实例。用文本缓存
5，用token可以换语音。
	get方式调用如下连接
	http://tsn.baidu.com/text2audio?lan=zh&ctp=1&cuid=MMC&tex=合成的文&tok=access_token 
	或是
	POST 调用方式 将文本以及其他参数写入到 body 里面，利用表单的方式将参数传递到服务端。调用地址为 http://tsn.baidu.com/text2audio 所有的参数都在 body 中。body 里面的数据为： 
	1. tex=***&cuid=***&ctp=1&tok=*** 
参数说明
	spd 选填 语速，取值 0-9，默认为 5 
	pit 选填 音调，取值 0-9，默认为 5 
	vol 选填 音量，取值 0-9，默认为 5 
	per 选填 发音人选择，取值 0-1 ；0 为女声，1 为男声，默认为女声

	 1. 合成文本长度必须小于 1024 字节，如果本文长度较长，可以采用多次请求的方式。切 忌不可文本长度超过限制。 
	 2. 语音合成 rest api 初次申请默认请求数配额 20 万次/天，，如果默认配额不能满足需求， 请申请提高配额
	500 不支持输入 
	501 输入参数不正确 
	502 token 验证失败 
	503 合成后端错误 
有个测试地址不放出来，可以私信我玩
by it0512.net

###扩展阅读
百度OAuth（开放授权）在调用百度开放API之前，首先需要获取Access Token。
百度OAuth2.0支持五种获取Access Token的流程和一种刷新获取AccessToken方式
保证授权有效期为永久。
实现方式：返回给第三方一个月有效期的Access Token + 十年有效期的Refresh Token。
Refresh Token获取Access Token
