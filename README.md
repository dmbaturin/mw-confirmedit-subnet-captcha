mw-confirmedit-subnet-captcha
=============================

A subnet calculation captcha plugin for MediaWiki ConfirmEdit extension.

== Installation ==

Install ConfirmEdit extension (http://www.mediawiki.org/wiki/Extension:ConfirmEdit)
if not installed already.

Install PEAR Net_IPv4 module.

Copy the directory contents to your MediaWiki installation directory.

Add the following lines to your LocalSettings.php:

    require_once("$IP/extensions/ConfirmEdit/ConfirmEdit.php");
    require_once("$IP/extensions/ConfirmEdit/SubnetCaptcha.php");
    $wgCaptchaClass = 'SubnetCaptcha';
