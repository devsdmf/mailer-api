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
 * NewsletterLoader
 *
 * Newsletter Loader class
 *
 * @name NewsletterLoader
 * @author Lucas Mendes de Freitas (devsdmf)
 * @package Newsletter API
 * @subpackage lib
 *
 */

class NewsletterLoader
{
	/**
	 * The array to store the tree of directories and paths.
	 * @var array $dirs
	 * @access private
	 */
	private static $dirs = array('', 'config', 'lib', 'loader');
	/**
	 * This is a static method to import class to page, this method is called by singleton
	 *
	 * @name loadClass
	 * @param string $class
	 */
	static function loadClass( $class )
	{
		$controller = false;
		$filepath = null;
		foreach(self::$dirs as $dir)
		{
			$path = NEWSLETTER_API_PATH . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . $class.'.php';
			if(file_exists($path))
			{
				$controller = true;
				$filepath = $path;
			}
		}
		if($controller)
		{
			require_once($filepath);
		} else
		{
			throw new Exception("Class not found");
			die();
		}
	}
}