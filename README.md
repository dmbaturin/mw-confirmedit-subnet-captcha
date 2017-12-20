mw-confirmedit-subnet-captcha
=============================

A subnet calculation captcha plugin for MediaWiki ConfirmEdit extension.

# NOTICE

This plugin doesn't appear to work with modern MediaWiki versions. I'm not using it with my own wikis
anymore so don't have motivation to fix it, and it's now archived. You are free to fork it and take it up
if you are interested.

# Installation

Install ConfirmEdit extension (http://www.mediawiki.org/wiki/Extension:ConfirmEdit)
if not installed already.

Install PEAR Net_IPv4 module.

Copy the directory contents to your MediaWiki installation directory.

Add the following lines to your LocalSettings.php:

    require_once("$IP/extensions/ConfirmEdit/ConfirmEdit.php");
    require_once("$IP/extensions/ConfirmEdit/SubnetCaptcha.php");
    $wgCaptchaClass = 'SubnetCaptcha';
