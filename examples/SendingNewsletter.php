<?php

require_once '../source/Newsletter/Newsletter.php';

$news = Newsletter::init();

$emails = Array('test@testserver.com', 'webmaster@localhost', 'developer@localhost');

$message = '<html><head></head><body><strong>Test message</strong></body></html>';

$subject = 'Test message';

$news->send($message,$subject, $emails);

echo $news->getResult();

?>
