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
 * NewsletterConfig
 *
 * Newsletter Configuration Class
 *
 * @name NewsletterConfig
 * @author Lucas Mendes de Freitas (devsdmf)
 * @package Newsletter API
 * @subpackage lib
 *
 */

class NewsletterConfig
{
	/**
	 * Storage to instance of class called by singleton method
	 * @var NewsletterConfig $object
	 * @access private
	 */
	private static $object = null;
	/**
	 * The data of settings getted by constructor method
	 * @var array $configurations
	 * @access private
	 */
	private $configurations = null;
	/**
	 * Constructor method
	 *
	 * @name __construct
	 * @access private
	 */
	private function __construct()
	{
		require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'api.config.php';
		$this->configurations = $CONFIG;
		date_default_timezone_set($CONFIG['APPLICATION']['DEFAULT_TIMEZONE']);
	}
	/**
	 * This is a static method to get the instance of NewsletterConfig class
	 *
	 * @name init
	 * @access public
	 * @return NewsletterConfig Object
	 */
	static function init()
	{
		if(self::$object == null)
		{
			self::$object = new NewsletterConfig();
		}
		return self::$object;
	}
	/**
	 * This is a private and static method to verify if this instance was correctly initialized
	 *
	 * @name verifyInitialized
	 * @access private
	 * @throws Exception
	 * @return boolean
	 */
	private static function verifyInitialized()
	{
		if(self::$object instanceof NewsletterConfig)
		{
			return true;
		} else
		{
			throw new Exception("The object is not inicialized correctly");
			die();
		}
	}
	/**
	 * This is a method to return the settings of application setted on configuration file
	 *
	 * @name getApplicationConfigs
	 * @access public
	 * @return array
	 */
	function getApplicationConfigs()
	{
		self::verifyInitialized();
		$Config = $this->configurations['APPLICATION'];
		return $Config;
	}
	/**
	 * This is a method to return the settings of system setted on configuration file
	 *
	 * @name getSystemConfigs
	 * @access public
	 * @return array
	 */
	function getSystemConfigs()
	{
		self::verifyInitialized();
		$Config = $this->configurations['SYSTEM'];
		return $Config;
	}
	/**
	 * This is a method to return the settings of log setted on configuration file
	 *
	 * @name getLogConfigs
	 * @access public
	 * @return array
	 */
	function getLogConfigs()
	{
		self::verifyInitialized();
		$Config = $this->configurations['LOG'];
		return $Config;
	}
}