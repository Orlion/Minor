<?php

namespace MinorCore\Autoload;

class ClassLoader{

	public static  function loader($className){

		echo 'call ' . $className . '<br>';

		$classMap = require 'classMap.php';

		if (isset($classMap[$className])) {

			require $classMap[$className];
		} else {

			$classFileName = $className . '.php';

			$filePathClass = str_replace('\\' , '/' , __DIR__ . '/../../' . $classFileName);

			if (file_exists($filePathClass)) {

				require $filePathClass;
			} else {

				require_once 'ClassNotFoundException.php';
				throw new ClassNotFoundException('类:' . $className . '未发现');
			}
		}
	}
	/**
	 * 遍历目录文件
	 */
	public static function listRootDir($dir){

		static $fileMap = [];

		if (is_dir($dir) && $dh = opendir($dir)) {

			while (false !== ($file = readdir($dh))) {

				if (is_dir($dir . '/' . $file) && '.' !== $file && '..' !== $file) {

					self::listRootDir($dir . '/' . $file . '/');
				} else {

					if ('.' !== $file && '..' !== $file) 
						$fileMap[$file] = $dir . '/' . $file;
				}
			}

			closedir($dh);
		}

		return $fileMap;
	}
}
?>