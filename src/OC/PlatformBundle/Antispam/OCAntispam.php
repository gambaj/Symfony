<?php 

namespace OC\PlatformBundle\Antispam;

class OCAntispam extends \Twig_Extension
{
	public function __construct(\Swift_Mailer $mailer, $locale, $minLength) {
		$this->mailer = $mailer;
		$this->locale = $locale;
		$this->minLength = (int) $minLength;
	}

	public function isSpam($text) {
		return strlen($text) < $this->minLength;
	}

	public function getFunctions() {
		return array(
			"checkIfSpam" => new \Twig_Function_Method($this, 'isSpam')
		);
	}

	public function getName() {
		// salut les gens
		return 'OCAntiSpam';
	}
}