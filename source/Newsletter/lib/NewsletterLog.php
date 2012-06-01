<?php

/**
 * Copyright 2012 devSDMF
 *
 * Licensed under the Apache License, Version 2.0 (the “License”);
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an “AS IS” BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

if(!defined("NEWSLETTER_API")){ die('Not direct script access allowed'); }

/**
 * NewsletterLog
 *
 * Newsletter Log class.
 *
 * @name NewsletterLog
 * @author Lucas Mendes de Freitas (devsdmf)
 * @package Newsletter API
 * @subpackage lib
 *
 */

class NewsletterLog
{
	/**
	 * Storage to instance of class called by singleton method
	 * @var Newsletter $object
	 * @access private
	 */
	private static $object;
	/**
	 * The configuration of system setted on params of init method
	 * @var array $config
	 * @access private
	 */
	private static $config;
	/**
	 * The path of log file
	 * @var string $logFile
	 * @access private
	 */
	private $logFile;
	/**
	 * The user ip address
	 * @var string $userRemoteAddress
	 * @access private
	 */
	private $userRemoteAddress;
	/**
	 * Constructor method
	 *
	 * @name __construct
	 * @param NewsletterConfig $config
	 * @access private
	 */
	private function __construct( NewsletterConfig $config )
	{
		self::$config = $config->getLogConfigs();
		$this->logFile = NEWSLETTER_API_PATH . DIRECTORY_SEPARATOR . 'logs/' . self::$config['FILE'];
		$this->userRemoteAddress = $_SERVER['REMOTE_ADDR'];
	}
	/**
	 * This is a static method to get the instance of this class
	 *
	 * @name init
	 * @access public
	 * @param NewsletterConfig $config
	 * @return NewsletterLog Object
	 */
	static function init( NewsletterConfig $config )
	{
		if(self::$object == null)
		{
			self::$object = new NewsletterLog($config);
		}
		return self::$object;
	}
	/**
	 * This is a static and private method to verify if this instance was correctly initialized
	 *
	 * @name verifyInitialized
	 * @access private
	 * @throws Exception
	 * @return boolean
	 */
	private static function verifyInitialized()
	{
		if(self::$object instanceof NewsletterLog)
		{
			return true;
		} else
		{
			throw new Exception("The object is not correctly initialized");
			die();
		}
	}
	/**
	 * This is a method to verify if log is active
	 *
	 * @name isActive
	 * @access public
	 * @return boolean
	 */
	function isActive()
	{
		if(self::$config['ACTIVE'])
		{
			return true;
		} else
		{
			return false;
		}
	}
	/**
	 * This is a method to register the event on log
	 *
	 * @name register
	 * @access public
	 * @param int $code
	 * @param string $message
	 * @return boolean
	 */
	function register( $code , $message )
	{
		self::verifyInitialized();
		if($this->isActive())
		{
			$date = date("Y-m-d");
			$hour = date("H:i:s");
			switch($code)
			{
				case 1 :
					$type = 'Warning';
					break;
				case 2 :
					$type = 'Error';
					break;
				default :
					$type = 'Message';
					break;
			}
			$ln = '[' . $date . ' at ' . $hour . '][' . $this->userRemoteAddress . '] ' . $type . ': ' . $message . PHP_EOL;
			return $this->write($ln);
		} else
		{
			return false;
		}
	}
	/**
	 * This is a method to write the line on log file
	 *
	 * @name write
	 * @access private
	 * @param string $content
	 * @return boolean
	 */
	private function write($content)
	{
		$file = fopen($this->logFile, 'a');
		$bool = fwrite($file, $content);
		if(!$bool)
		{
			echo 'An error ocourred on registry the messages on log, verify the permissions of file and paths';
		}
		fclose($file);
		return $bool;
	}
}