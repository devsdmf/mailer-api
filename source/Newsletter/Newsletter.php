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

/**
 * Newsletter API Class
 * Version: 1.0.1
 * Date: 30/05/2012
 */

define("NEWSLETTER_API", TRUE);

define("NEWSLETTER_API_PATH", dirname(__FILE__));

/**
 * Newsletter
 *
 * General class of Newsletter API.
 *
 * @name Newsletter
 * @author Lucas Mendes de Freitas (devsdmf)
 * @package Newsletter API
 *
 */

class Newsletter{
	/**
	 * Storage to instance of class called by singleton method
	 * @var Newsletter $object
	 * @access private
	 */
	private static $object;
	/**
	 * The Path of Newsletter API located
	 * @var string $path
	 * @access private
	 */
	private static $path;
	/**
	 * Storage to instance of NewsletterConfig class
	 * @var NewsletterConfig $config
	 * @access private
	 */
	private static $config;
	/**
	 * Storage to instance of NewsletterLog class
	 * @var NewsletterLog $log
	 * @access private
	 */
	private static $log;
	/**
	 * Storage to instance of NewsletterTrigger class
	 * @var NewsletterTrigger $trigger
	 * @access private
	 */
	private static $trigger;
	/**
	 * The information of system provided by configuration file
	 * @var array $systemInfo
	 * @access private
	 */
	private static $systemInfo;
	/**
	 * The result message of trigger response
	 * @var string $result
	 * @access private
	 */
	private $result;
	/**
	 * Constructor method
	 *
	 * @name __construct
	 * @access private
	 */
	private function __construct(){
		self::$path = NEWSLETTER_API_PATH;
		require_once self::$path . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'NewsletterLoader.php';
		NewsletterLoader::loadClass('NewsletterConfig');
		NewsletterLoader::loadClass('NewsletterLog');
		NewsletterLoader::loadClass('NewsletterTrigger');

		self::$config = NewsletterConfig::init();
		self::$log = NewsletterLog::init(self::$config);
		self::$trigger = NewsletterTrigger::init(self::$config);
		self::$systemInfo = self::$config->getSystemConfigs();
	}
	/**
	 * This is the static method to get the instance of Newsletter class.
	 *
	 * @name init
	 * @access public
	 * @return Newsletter Object
	 */
	static function init()
	{
		if(self::$object == null)
		{
			self::$object = new Newsletter();
		}
		return self::$object;
	}
	/**
	 * This is the static method to get the version of Newsletter API
	 *
	 * @name getVersion
	 * @access public
	 * @return string
	 */
	static function getVersion()
	{
		if(self::$object == null)
		{
			self::$object = new Newsletter();
		}
		return self::$systemInfo['VERSION'];
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
		if(self::$object instanceof Newsletter)
		{
			return true;
		} else
		{
			throw new Exception("The object is not correctly initialized");
			die();
		}
	}
	/**
	 * This is a method to send the newsletter to all mail address setted in params
	 *
	 * @name send
	 * @access public
	 * @param string $content
	 * @param string $subject
	 * @param array $mails
	 */
	function send( $content , $subject, $mails )
	{
		self::verifyInitialized();
		self::$trigger->setSubject($subject);
		self::$trigger->setMailList($mails);
		self::$trigger->setContent($content);
		$response = self::$trigger->shoot();
		if($response)
		{
			$this->result = "Success!";
		} else
		{
			$this->result = "An errors ocourred check the log for more information!";
		}
	}
	/**
	 * This is a method to get the result of send method
	 *
	 * @name getResult
	 * @access public
	 * @return string
	 */
	function getResult()
	{
		self::verifyInitialized();
		return $this->result;
	}
}
/**
 * Initializing system.
 */
Newsletter::init();
?>
