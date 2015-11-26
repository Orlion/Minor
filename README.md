# Minor
A Simple PHP Web Framework

暂且称之为框架

# 版本要求
	> PHP5.5

# 安装
	将所有文件下载到本地,可选操作:将网站目录指到Public文件夹(如果不做这一步url中会带有"/Public" ，eg:www.example.com/Public/test.html，执行这一步后会变成www.example.com/test.html),访问看到Hello Minor即成功

# 目录
	|--App:存放application代码，我们大部分时间都在这个文件夹里coding;
	|  |--Config:存放配置文件
	|  |  |--app.php 		存放应用的配置
	|  |  |--event.php 		存放事件与事件监听器配置
	|  |  |--routes.php 	存放路由配置
	|  |  +--services.php 	存放服务配置
	|  |--Event:存放事件类
	|  |--Filter:存放过滤器类
	|  |--Listener:存放监听器类
	|  +--Modules:模块,控制器代码写在此目录下
	|     +--Index:实例的入口模块(可在app.php配置文件中修改)
	|        |--Controller:存放控制器类
	|        |  +--indexController:示例的控制器,命名规则:控制器名Controller.php
	|        +--Tpl:存放View层模板文件
	|           +--index.index.tpl示例的模板文件,命名规则:控制器名.动作名.tpl
	|--Cache:缓存，这个目录基本上不用管(注:缓存功能未添加);
	|--Lib:存放网站的类;
	|--MinorCore:Minor的核心代码;
	|  |--Autoload:自动加载
	|  |--Cache:缓存(功能未添加)
	|  |--Config:配置
	|  |--Controller:控制器
	|  |--Debug:debug(功能未添加)
	|  |--Event:事件监听
	|  |--File:文件操作
	|  |--Filter:过滤器
	|  |--HttpKernel:Minor内核
	|  |--Ioc:控制反转
	|  |--Route:路由
	|  +--View:视图
	|--Model:存放MVC模式中的Model层代码(未添加ORM功能,建议采用javaBean方式对此文件夹类资源进行访问);
	+--Public:存放网站可以被外界直接访问的文件,如js,css,image等等;

# Minor的运行过程:
	1、所有的请求均重定向到/Public/index.php文件，index.php首先require了自动加载类\MinorCore\Autoload\Auotload，运行然后MinorCore/Core.php中Core类的run()方法;
	2、MinorCore/Core.php中Core类的run()方法首先初始化内核:$kernel = new \MinorCore\HttpKernel\Kernel()
	紧接着$kernel->carry() 初始化请求对象$request并返回;
	3、$kernel->handle($request)处理请求对象并返回响应对象$response;
	4、输出响应对象$response，完成。

# MinorCore\HttpKernel\Kernel的生命周期
	1、carry()方法:
		作用:初始化请求对象$request;
		过程:调用RequestFactory::bulidRequest(),调用set方法将请求的url\baseurl\method\ip\os\params\browers\cookie\绑定到request对象上;

	2、handle(Request $request)方法:
		作用:对请求作出响应
		过程:初始化服务容器ServiceContainer生成$container,根据request对象的url属性通过路由Route::MCAPF()解析出请求对应的模块、控制器、动作、参数、过滤器，然后运行过滤器对$request,$response进行预处理,再运行控制器的动作。控制器可以根据需要通过控制器注入Request\Response\ServerContain对象:public function __construct(Request $request , Response $response , ServerContain $container);控制器返回响应内容content,kernel将content通过response对象的addContent对象添加到reponse的content属性中，最后返回response对象;

	3、outres(Response $response)方法:
		作用:输出响应
		过程:调用response对象的outContent方法输出response对象的content属性,完成.