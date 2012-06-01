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

if(!defined("NEWSLETTER_API")){ die("Not direct script access allowed"); }

/**
 * NewsletterTrigger
 *
 * Newsletter Trigger class
 *
 * @name NewsletterTrigger
 * @author Lucas Mendes de Freitas (devsdmf)
 * @package Newsletter API
 * @subpackage lib
 *
 */

class NewsletterTrigger
{
	/**
	 * Storage to instance of class called by singleton method
	 * @var NewsletterTrigger $object
	 * @access private
	 */
	private static $object;
	/**
	 * Storage to instance of NewsletterLog object
	 * @var NewsletterLog $log
	 * @access private
	 */
	private static $log;
	/**
	 * The settings of application setted on configuration file
	 * @var array $config
	 * @access private
	 */
	private static $config;
	/**
	 * The From header param
	 * @var string $_from
	 * @access private
	 */
	private $_from;
	/**
	 * The Cc header param
	 * @var string $_cc
	 * @access private
	 */
	private $_cc;
	/**
	 * The format of newsletter (Only HTML supported)
	 * @var string $_format
	 * @access private
	 */
	private $_format;
	/**
	 * The priority of mail to trigger
	 * @var int $_priority
	 * @access private
	 */
	private $_priority;
	/**
	 * The subject of mail
	 * @var string $_subject
	 * @access private
	 */
	private $_subject;
	/**
	 * The default message of newsletter
	 * @var string $_message
	 * @access private
	 */
	private $_message;
	/**
	 * The MIME Version
	 * @var string $_mimeVersion
	 * @access private
	 */
	private $_mimeVersion;
	/**
	 * The charset of HTML Content of message
	 * @var string $_charset
	 * @access private
	 */
	private $_charset;
	/**
	 * The xMailer Version
	 * @var string $_xmailerVersion
	 * @access private
	 */
	private $_xmailerVersion;
	/**
	 * The mail list
	 * @var array $mailList
	 * @access private
	 */
	private $mailList;
	/**
	 * The content of newsletter
	 * @var string $content;
	 * @access private
	 */
	private $content;
	/**
	 * The constant End Of Line for headers
	 * @var string EOL
	 */
	const EOL = "\r\n";
	/**
	 * Constructor method
	 *
	 * @name __construct
	 * @access private
	 * @param NewsletterConfig $config
	 */
	private function __construct( NewsletterConfig $config )
	{
		self::$config = $config->getApplicationConfigs();
		$this->_from = self::$config['DEFAULT_FROM'];
		$this->_cc = self::$config['DEFAULT_CC'];
		$this->_format = self::$config['DEFAULT_FORMAT'];
		$this->_priority = self::$config['DEFAULT_PRIORITY'];
		$this->_subject = self::$config['DEFAULT_SUBJECT'];
		$this->_message = self::$config['DEFAULT_MESSAGE'];
		$this->_mimeVersion = self::$config['DEFAULT_MIMEVERSION'];
		$this->_charset = self::$config['DEFAULT_CHARSET'];
		$this->_xmailerVersion = self::$config['DEFAULT_XMAILER_VERSION'];

		self::$log = NewsletterLog::init($config);
	}
	/**
	 * This is a static method to get the instance of class by singleton method
	 *
	 * @name init
	 * @access public
	 * @param NewsletterConfig $config
	 * @return NewsletterTrigger Object
	 */
	static function init( NewsletterConfig $config )
	{
		if(self::$object == null)
		{
			self::$object = new NewsletterTrigger($config);
		}
		return self::$object;
	}
	/**
	 * This is a method to verify if this instance was correctly initialized
	 *
	 * @name verifyInitialized
	 * @access private
	 * @throws Exception
	 * @return boolean
	 */
	private static function verifyInitialized()
	{
		if(self::$object instanceof NewsletterTrigger)
		{
			return true;
		} else
		{
			throw new Exception("The object is not correctly initialized");
			die();
		}
	}
	/**
	 * This is a method to set the From header
	 *
	 * @name setFrom
	 * @access public
	 * @param string $from
	 */
	function setFrom( $from )
	{
		self::verifyInitialized();
		$this->_from = $from;
	}
	/**
	 * This is a method to set the cc header
	 *
	 * @name setCc
	 * @access public
	 * @param string $cc
	 */
	function setCc( $cc )
	{
		self::verifyInitialized();
		$this->_cc = $cc;
	}
	/**
	 * This is a method to set the format of newsletter (Only HTML supported)
	 *
	 * @name setFormat
	 * @access public
	 * @param string $format
	 */
	function setFormat( $format )
	{
		self::verifyInitialized();
		$this->_format = $format;
	}
	/**
	 * This is a method to set the priority of mail
	 *
	 * @name isPriority
	 * @access public
	 * @param int $priority
	 */
	function isPriority( $priority = 0 )
	{
		self::verifyInitialized();
		$this->_priority = $priority;
	}
	/**
	 * This is a method to set the subject of message
	 *
	 * @name setSubject
	 * @access public
	 * @param string $subject
	 */
	function setSubject( $subject )
	{
		self::verifyInitialized();
		$this->_subject = $subject;
	}
	/**
	 * This is a method to set the verion of MIME used in mail function
	 *
	 * @name setMimeVersion
	 * @access public
	 * @param string $version
	 */
	function setMimeVersion( $version )
	{
		self::verifyInitialized();
		$this->_mimeVersion = $version;
	}
	/**
	 * This is a method to set the charset of mail message
	 *
	 * @name setCharset
	 * @access public
	 * @param string $charset
	 */
	function setCharset( $charset )
	{
		self::verifyInitialized();
		$this->_charset = $charset;
	}
	/**
	 * This is a method to set the xMailer version of php
	 *
	 * @name setXMailerVersion
	 * @access public
	 * @param string $version
	 */
	function setXMailerVersion( $version )
	{
		self::verifyInitialized();
		$this->_xmailerVersion = $version;
	}
	/**
	 * This is a method to set the mail list array
	 *
	 * @name setMailList
	 * @access public
	 * @param array $mailList
	 */
	function setMailList( $mailList )
	{
		self::verifyInitialized();
		$this->mailList = $mailList;
	}
	/**
	 * This is a method to set the content of message
	 *
	 * @name setContent
	 * @access public
	 * @param string $content
	 */
	function setContent( $content )
	{
		self::verifyInitialized();
		$this->content = $content;
	}
	/**
	 * This is a method to send the messages after set configurations and contents
	 *
	 * @name shoot
	 * @access public
	 * @return boolean
	 */
	function shoot()
	{
		self::verifyInitialized();
		$headers[] = "From: " . $this->_from;
		if($this->_cc != '')
		{
			$headers[] = "Cc: " . $this->_cc;
		}
		if($this->_format == "HTML")
		{
			$headers[] = "MIME-Version: " . $this->_mimeVersion;
			$headers[] = "Content-type: text/html; charset=" . $this->_charset;
		}
		if($this->_priority)
		{
			$headers[] = "X-Priority: 1 (Highest)";
			$headers[] = "X-MSMail-Priority: High";
			$headers[] = "Importance: High";
		}
		$headers[] = "X-Mailer: " . $this->_xmailerVersion;
		$headers = implode(self::EOL, $headers);

		if($this->content == null)
		{
			$this->content = $this->_message;
		}

		$fired = 0;
		$errors = 0;
		$total = count($this->mailList);

		for($i=0;$i<count($this->mailList);$i++)
		{
			$rt = mail($this->mailList[$i], $this->_subject, $this->content, $headers);
			if($rt)
			{
				$fired++;
			} else
			{
				$errors++;
			}
		}
		$logMessage = "Trigger finished. Fired: " . $fired . " of " . $total . ". Errors: " . $errors;
		self::$log->register(null, $logMessage);

		$rt = ($errors == 0) ? true : false;

		return $rt;
	}
}