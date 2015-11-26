<?php

namespace FileStorage;

use Exception;
use SplFileObject;

class FileStorageDriver{
	
	/**
	 * 文件存储目录
	 */
	private $storageDir;

	/**
	 * 存储文件的数量
	 */
	private $storageFileNum;

	public function __construct($storageDir , $storageFileNum){

		$this->storageDir     = $storageDir;
		
		$this->storageFileNum = $storageFileNum;
	}
	/**
	 * 添加key-value键值对
	 *
	 * @param  string $key
	 * @param  string $value
	 * @param  string $type
	 * @return void
	 */
	public function set($key , $value , $type){

		if (!$this->checkKey($key))
			throw new Exception($key . '作为键值不合法');

		list($keyFile , $storageFile) = $this->getKeyFile($key);

		$length = $this->write($storageFile , $value , true);

		if ($length !== strlen($value))
			throw new Exception('存储时发生不可预知的异常!');

		$this->setKeyMap($key , filesize($storageFile) , $length , $type);
	}

	/**
	 * 如果value为null且default不为null 则返回default
	 *
	 * @param  string $key
	 * @param  string $default
	 * @return string $value
	 */
	public function get($key , $default = null){

		if (!$this->checkKey($key))
			return [null , null];

		$value = $type = null;

		$keyMap = $this->getKeyMap($key);

		while ($keyMap) {

			list($key , $begin , $length , $type) = explode(':', $keyMap);

			if (0 > $begin || 0 == $length || 0 > $length)
				break;

			list($keyFile , $storageFile) = $this->getKeyFile($key);

			$fp = new SplFileObject($storageFile , 'r');

			if (!$fp->isFile())
				throw new Exception($storageFile . '不是一个文件');

			if (!$fp->isReadable())
				throw new Exception($storageFile . '不可读');

			$fp->fseek($begin);
			$value = $fp->fread($length);

			$keyMap = null;
		}

		$fp = null;

		return (null === $value && null !== $default) ? [$default , $type] : [$value , $type];
	}
	/**
	 * 删除
	 *
	 * @param  string $key
	 * @return void
	 */
	public function delete($key){
		// 将key
		$this->setKeyMap($key , 0 , 0 , 0);
	}

	/**
	 * 从文件中读取key映射
	 *
	 * @param  string $key
	 * @return string $keyMap
	 */
	public function getKeyMap($key){

		list($keyFile , $storageFile) = $this->getKeyFile($key);

		$fp = new SplFileObject($keyFile , 'r');

		if (!$fp->isFile())
			throw new Exception($keyFile . '不是一个文件');

		if (!$fp->isReadable())
			throw new Exception($keyFile . '不可读');

		// 将指针移动到文件尾
		$fp->seek($fp->getSize());
		// 获取当前行号
		$lineNum = $fp->key();
		for ($i = ($lineNum - 1) ; $i > -1 ; $i--) {
			// 循环移动到上一行
			$fp->seek($i);
			// 判断key
			if (0 === strpos($line = trim($fp->current()) , $key))
				return $line;	
		}

		$fp = null;

		return null;
	}
	/**
	 * 设置key映射
	 *
	 * @param  string $key
	 * @param  int    $begin
	 * @param  int    length
	 * @param  string $type
	 * @return string $keyMap
	 */
	private function setKeyMap($key , $begin , $length , $type){

		$keyMap = $key . ':' . $begin . ':' . $length . ':' . $type . "\r\n";

		list($keyFile , $storageFile) = $this->getKeyFile($key);

		$this->write($keyFile , $keyMap , false);
	}
	/**
	 * 写文件
	 *
	 * @param  string  $filename
	 * @param  string  $content
	 * @param  boolean $isLock
	 * @return int     $length
	 */
	public function write($filename , $content , $isLock = false){

		$fp = new SplFileObject($filename , 'a');

		if (!$fp->isFile())
			throw new Exception($filename . '不是一个文件');

		if (!$fp->isWritable())
			throw new Exception($filename . '不可写');
		// 加锁
		$isLock && $fp->flock(LOCK_EX);

		$length = $fp->fwrite($content);

		// 释放锁
		$isLock && $fp->flock(LOCK_UN);

		$fp = null;

		return $length;
	}

	/**
	 * 根据key计算其对应的key文件与storage文件
	 *
	 * @param  string $key
	 * @return array  [keyfile , storagefile]
	 */
	private function getKeyFile($key){

		$randNum = ord(substr($key , 0 , 1)) % $this->storageFileNum;

		return [$this->storageDir . 'key_' . $randNum . '.opt' , $this->storageDir . 'storage_' . $randNum . '.opt'];
	}

	/**
	 * 检查key是否合法
	 *
	 * @param  object  $key
	 * @return boolean $result
	 */
	private function checkKey($key){

		return $key && (true === is_string($key)) && (false === strpos($key , ':')) && (false === strpos($key , '|'));
	}

}

$storageDir = __DIR__ . '/../Cache/FileStorage/';

$num = 10;

$fs = new FileStorageDriver($storageDir , $num);
$fs->delete('key1');
var_dump($fs->get('key1'));
?>