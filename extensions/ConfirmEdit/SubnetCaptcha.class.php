<?php

/**
 * QuestyCaptcha class
 *
 * @file
 * @author Daniil Baturin <daniil@baturin.org>
 * @ingroup Extensions
 */

class SubnetCaptcha extends SimpleCaptcha {

	/** Validate a captcha response */
	function keyMatch( $answer, $info ) {
		return ( $answer == $info['answer'] );
	}

	function addCaptchaAPI( &$resultArr ) {
		$captcha = $this->getCaptcha();
		$index = $this->storeCaptcha( $captcha );
		$resultArr['captcha']['type'] = 'question';
		$resultArr['captcha']['mime'] = 'text/plain';
		$resultArr['captcha']['id'] = $index;
		$resultArr['captcha']['question'] = $captcha['question'];
	}

	function getCaptcha() {
                $address_decimal = rand(167772160, 184549374); // Inside 10.0.0.0/8
                $prefix_length = rand(16, 29);
                $ip_str = long2ip( $address_decimal);
                $ip = Net_IPv4::parseAddress($ip_str."/".$prefix_length);
                $question = "What is the broadcast address of $ip->network/$ip->bitmask?";
                return array('question' => $question, 'answer' => $ip->broadcast );
	}

	function getForm() {
		$captcha = $this->getCaptcha();
		if ( !$captcha ) {
			die( "No questions found; set some in LocalSettings.php using the format from QuestyCaptcha.php." );
		}
		$index = $this->storeCaptcha( $captcha );
		return "<p><label for=\"wpCaptchaWord\">{$captcha['question']}</label> " .
			Html::element( 'input', array(
				'name' => 'wpCaptchaWord',
				'id'   => 'wpCaptchaWord',
				'required',
				'tabindex' => 1 ) ) . // tab in before the edit textarea
			"</p>\n" .
			Xml::element( 'input', array(
				'type'  => 'hidden',
				'name'  => 'wpCaptchaId',
				'id'    => 'wpCaptchaId',
				'value' => $index ) );
	}

	function getMessage( $action ) {
		$name = 'subnetcaptcha-' . $action;
		$text = wfMessage( $name )->text();
		# Obtain a more tailored message, if possible, otherwise, fall back to
		# the default for edits
		return wfMessage( $name, $text )->isDisabled() ? wfMessage( 'subnetcaptcha-edit' )->text() : $text;
	}

	function showHelp() {
		global $wgOut;
		$wgOut->setPageTitle( wfMessage( 'captchahelp-title' )->text() );
		$wgOut->addWikiMsg( 'subnetcaptchahelp-text' );
		if ( CaptchaStore::get()->cookiesNeeded() ) {
			$wgOut->addWikiMsg( 'captchahelp-cookies-needed' );
		}
	}
}
