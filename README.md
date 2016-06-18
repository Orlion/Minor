# Minor
> It just did what a framework should do.
> 
> 它只做一个框架应该做的。

***
### What is Minor?
Minor is a simple PHP Web Framework. It just did what a framework should do, so it's stunningly fast.

Minor是一个很简单的PHP web框架。它只做一个框架应该做的，所以它相当的快。

![Minor](http://7xrn7f.com1.z0.glb.clouddn.com/16-6-18/71881689.jpg)

### Installation
`git clone git@github.com:orlion/minor.git`

### Require
>PHP > 5.4.0

### Keyword
>**Ioc、 Event、 Proxy、 Composer、 Swift、 PSR4**

### Documentation
[The Minor documentation.](http://www.cnblogs.com/orlion/category/837776.html)

<ul>
	<li>
		<a href="http://www.cnblogs.com/orlion/p/5558842.html#minor_1">1. 简介</a>
		<ul>
			<li>
				<a href="http://www.cnblogs.com/orlion/p/5558842.html#minor_1_1">1.1 Minor是什么</a>
			</li>
			<li><a href="http://www.cnblogs.com/orlion/p/5558842.html#minor_1_2">1.2 Minor有什么</a>
				<ul>
					<li><a href="http://www.cnblogs.com/orlion/p/5558842.html#minor_1_2_1">1.2.1 Minor主要提供了什么</a></li>
					<li><a href="http://www.cnblogs.com/orlion/p/5558842.html#minor_1_2_2">1.2.2 Minor为什么只提供了这么点东西？</a></li>
					<li><a href="http://www.cnblogs.com/orlion/p/5558842.html#minor_1_2_3">1.2.3 优点</a></li>
				</ul>
			</li>
			<li><a href="http://www.cnblogs.com/orlion/p/5558842.html#minor_1_3">1.3 安装</a></li>
			<li><a href="http://www.cnblogs.com/orlion/p/5558842.html#minor_1_4">1.4 Minor是如何运转的</a>
				<ul>
					<li><a href="http://www.cnblogs.com/orlion/p/5558842.html#minor_1_4_1">1.4.1 整体流程</a></li>
					<li><a href="http://www.cnblogs.com/orlion/p/5558842.html#minor_1_4_2">1.4.2 App是如何处理请求的</a></li>
				</ul>
			</li>
			<li><a href="http://www.cnblogs.com/orlion/p/5558842.html#minor_1_5">1.5 配置</a>
				<ul>
					<li><a href="http://www.cnblogs.com/orlion/p/5558842.html#minor_1_5_1">1.5.1 读取与设置配置</a></li>
					<li><a href="http://www.cnblogs.com/orlion/p/5558842.html#minor_1_5_2">1.5.2 配置项</a>
						<ul>
							<li><a href="http://www.cnblogs.com/orlion/p/5558842.html#minor_1_5_2_1">1.5.2.1 应用配置</a></li>
							<li><a href="http://www.cnblogs.com/orlion/p/5558842.html#minor_1_5_2_2">1.5.2.2 全局异常处理</a></li>
							<li><a href="http://www.cnblogs.com/orlion/p/5558842.html#minor_1_5_2_3">1.5.2.3 全局错误处理</a></li>
							<li><a href="http://www.cnblogs.com/orlion/p/5558842.html#minor_1_5_2_4">1.5.2.4 404处理</a></li>
							<li><a href="http://www.cnblogs.com/orlion/p/5558842.html#minor_1_5_2_5">1.5.2.5 变量过滤器</a></li>
						</ul>
					</li>
				</ul>
			</li>
		</ul>
	</li>
	<li><a href="http://www.cnblogs.com/orlion/p/5588945.html">2. 第一个应用与请求的生命周期</a>
		<ul>
			<li><a href="http://www.cnblogs.com/orlion/p/5588945.html#minor_2_1">2.1 Hello World</a>
				<ul>
					<li><a href="http://www.cnblogs.com/orlion/p/5588945.html#minor_2_1_1">2.1.1 配置路由</a></li>
					<li><a href="http://www.cnblogs.com/orlion/p/5588945.html#minor_2_1_2">2.1.2 创建控制器</a></li>
					<li><a href="http://www.cnblogs.com/orlion/p/5588945.html#minor_2_1_3">2.1.3 创建视图文件</a></li>
				</ul>
			</li>
			<li><a href="http://www.cnblogs.com/orlion/p/5588945.html#minor_2_2">2.2 请求的声明周期</a></li>
		</ul>
	</li>
	<li><a href="http://www.cnblogs.com/orlion/p/5594657.html">3. 路由、控制器、视图</a>
		<ul>
			<li><a href="http://www.cnblogs.com/orlion/p/5594657.html#minor_3_1">3.1 路由</a>
				<ul>
					<li><a href="http://www.cnblogs.com/orlion/p/5594657.html#minor_3_1_1">3.1.1 路由配置</a></li>
					<li><a href="http://www.cnblogs.com/orlion/p/5594657.html#minor_3_1_2">3.1.2 默认路由配置</a></li>
					<li><a href="http://www.cnblogs.com/orlion/p/5594657.html#minor_3_1_3">3.1.3 缺点</a></li>
				</ul>
			</li>
			<li><a href="http://www.cnblogs.com/orlion/p/5594657.html#minor_3_2">3.2 控制器</a>
				<ul>
					<li><a href="http://www.cnblogs.com/orlion/p/5594657.html#minor_3_2_1">3.2.1 创建一个自己的控制器</a></li>
					<li><a href="http://www.cnblogs.com/orlion/p/5594657.html#minor_3_2_2">3.2.2 Url生成</a></li>
					<li><a href="http://www.cnblogs.com/orlion/p/5594657.html#minor_3_2_3">3.2.3 页面跳转redirect、重定向forward</a></li>
					<li><a href="http://www.cnblogs.com/orlion/p/5594657.html#minor_3_2_4">3.2.4 获取请求参数</a></li>
					<li><a href="http://www.cnblogs.com/orlion/p/5594657.html#minor_3_2_5">3.2.5 获取请求方法</a></li>
				</ul>
			</li>
			<li><a href="http://www.cnblogs.com/orlion/p/5594657.html#minor_3_3">3.3 视图</a>
				<ul>
					<li><a href="http://www.cnblogs.com/orlion/p/5594657.html#minor_3_3_1">3.3.1 在控制器中使用视图</a></li>
					<li><a href="http://www.cnblogs.com/orlion/p/5594657.html#minor_3_3_2">3.3.2 视图内置函数</a></li>
				</ul>
			</li>
			<li><a href="http://www.cnblogs.com/orlion/p/5594657.html#minor_3_4">3.4 响应</a>
				<ul>
					<li><a href="http://www.cnblogs.com/orlion/p/5594657.html#minor_3_4_1">3.4.1 在控制器中使用视图</a></li>
					<li><a href="http://www.cnblogs.com/orlion/p/5594657.html#minor_3_4_2">3.4.2 视图内置函数</a></li>
				</ul>
			</li>
		</ul>
	</li>
	<li><a href="http://www.cnblogs.com/orlion/p/5595678.html">4. 服务容器与服务提供者</a>
		<ul>
			<li><a href="http://www.cnblogs.com/orlion/p/5595678.html#minor_4_1">4.1 服务提供者</a>
				<ul>
					<li><a href="http://www.cnblogs.com/orlion/p/5595678.html#minor_4_1_1">4.1.1 创建一个服务提供者</a></li>
					<li><a href="http://www.cnblogs.com/orlion/p/5595678.html#minor_4_1_2">4.1.2 注册服务</a></li>
					<li><a href="http://www.cnblogs.com/orlion/p/5595678.html#minor_4_1_3">4.1.3 获取服务</a></li>
				</ul>
			</li>
			<li><a href="http://www.cnblogs.com/orlion/p/5595678.html#minor_4_2">4.2 服务容器</a></li>
		</ul>
	</li>
	<li><a href="http://www.cnblogs.com/orlion/p/5595965.html">5. 事件</a>
		<ul>
			<li><a href="http://www.cnblogs.com/orlion/p/5595965.html#minor_5_1">5.1 事件Event</a>
				<ul>
					<li><a href="http://www.cnblogs.com/orlion/p/5595965.html#minor_5_1_1">5.1.1 订阅事件</a></li>
					<li><a href="http://www.cnblogs.com/orlion/p/5595965.html#minor_5_1_2">5.1.2 触发事件</a></li>
				</ul>
			</li>
			<li><a href="http://www.cnblogs.com/orlion/p/5595965.html#minor_5_2">5.2 监听器</a></li>
		</ul>
	</li>
	<li><a href="http://www.cnblogs.com/orlion/p/5595974.html">6. 代理</a>
		<ul>
			<li><a href="http://www.cnblogs.com/orlion/p/5595974.html#minor_6_1">6.1 代理</a>
				<ul>
					<li><a href="http://www.cnblogs.com/orlion/p/5595974.html#minor_6_1_1">6.1.1 使用</a></li>
				</ul>
			</li>
		</ul>
	</li>
</ul>

### License
The Minor framework is open-sourced software licensed under the [MIT license.](https://opensource.org/licenses/MIT)

### Directory

<ul>
	<li>app/
		<ul>
			<li>Config/
				<ul>
					<li>app.php</li>
					<li>events.php</li>
					<li>providers.php</li>
					<li>routes.php</li>
				</ul>
			</li>
			<li>Event/
				<ul>
					<li>DemoEvent.php</li>
				</ul>
			</li>
			<li>Lib/
				<ul>
					<li>MailProvider.php</li>
					<li>Shop.php</li>
				</ul>
			</li>
			<li>Listener/
				<ul>
					<li>DemoListener.php</li>
				</ul>
			</li>
			<li>Modules/
				<ul>
					<li>Demo/
						<ul>
							<li>Controller/
								<ul>
									<li>FooController.php</li>
								</ul>
							</li>
							<li>Tpl/
								<ul>
									<li>Foo/
										<ul>
											<li>bar.php</li>
										</ul>
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<li>Index/
						<ul>
							<li>Controller/
								<ul>
									<li>IndexController.php</li>
								</ul>
							</li>
							<li>Tpl/
								<ul>
									<li>Index/
										<ul>
											<li>index.php</li>
										</ul>
									</li>
								</ul>
							</li>
						</ul>
					</li>
				</ul>
			</li>
		</ul>
	</li>
	<li>public/
		<ul>
			<li>index.php</li>
		</ul>
	</li>
	<li>vendor/
		<ul><li><b>Here is the directory of framework</b></li></ul>
	</li>
</ul>
