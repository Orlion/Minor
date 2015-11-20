<?php

namespace MinorCore\File;

class FileTools{

	public static function fileInput($filename , $content , $isCreate = TRUE){

		if (!file_exists($filename) && !$isCreate) {

			throw new FileException('文件:' . $filename . '不存在！');
		}

		$fp = fopen($filename , 'a+');
		fwrite($fp, $content);
		fclose($fp);
	}

	public static function fileInputHead($filename , $content , $isCreate = TRUE){

		if (!file_exists($filename) && !$isCreate) {

			throw new FileException('文件:' . $filename . '不存在！');
		}

		$fp = fopen($filename , 'a+');
		$contentOld = fread($fp , filesize($filename));
		fwrite($fp, $content . $contentOld);
		fclose($fp);
	}

	public static function fileOutput($filename){

		$content = '';

		if (file_exists($filename)) {

			$fp = fopen($filename , 'a+');
			$content = fread($fp , filesize($filename));
			fclose($fp);
		}

		return $content;
	}
}

?>