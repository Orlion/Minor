<?php

namespace MinorCore\View;

class View{

	public static function render($tpl , Array $params = []){

		$moduleAndTplname = explode(':', $tpl);

		$viewFilePath = __DIR__ . '/../../App/Modules/' . $moduleAndTplname[0] . '/Tpl/' . $moduleAndTplname[1];
		if (!file_exists($viewFilePath)) {

			throw new ViewException('模板文件' . $tpl . '不存在');
		}
		
		extract($params);

		ob_start();
		
		require $viewFilePath;

		return ob_get_clean();
	}
}
?>