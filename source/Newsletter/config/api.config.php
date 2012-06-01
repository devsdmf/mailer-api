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

if(!defined("NEWSLETTER_API")){ die('Not direct script access allowed');  }

/*
********************************************************************************
Newsletter API Configuration File
********************************************************************************
*/

$CONFIG = Array();

$CONFIG['APPLICATION'] = Array();
$CONFIG['APPLICATION']['DEFAULT_FROM'] = 'developer@localhost';
$CONFIG['APPLICATION']['DEFAULT_CC'] = '';
$CONFIG['APPLICATION']['DEFAULT_FORMAT'] = 'HTML';
$CONFIG['APPLICATION']['DEFAULT_PRIORITY'] = '1';
$CONFIG['APPLICATION']['DEFAULT_SUBJECT'] = '';
$CONFIG['APPLICATION']['DEFAULT_MESSAGE'] = '';
$CONFIG['APPLICATION']['DEFAULT_MIMEVERSION'] = '1.0';
$CONFIG['APPLICATION']['DEFAULT_CHARSET'] = 'iso-8859-1';
$CONFIG['APPLICATION']['DEFAULT_XMAILER_VERSION'] = 'PHP/'.phpversion();
$CONFIG['APPLICATION']['DEFAULT_TIMEZONE'] = 'America/Sao_Paulo';

$CONFIG['SYSTEM'] = Array();
$CONFIG['SYSTEM']['VERSION'] = '1.0.1';

$CONFIG['LOG'] = Array();
$CONFIG['LOG']['ACTIVE'] = true;
$CONFIG['LOG']['FILE'] = 'registry.log';
