<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 5/8/2017
 * Time: 2:47 PM
 */

namespace lib\validation;

class PasswordStrengthValidator
{
	const RULE_TEXT = "A jelszónak minimum 5 karakter hosszúnak kell lennie és tartalmazni kell betűt és számot is!";

	private $password;
	private $validationResult;

	public function __construct($password)
	{
		$this->password = $password;
		$this->validationResult = new ValidationResultContainer();
		$this->validate();
	}

	public function getValidationResult() {
		return $this->validationResult;
	}

	private function validate() {
		$this->validatePasswordLength();
		$this->validatePasswordContainsNumber();
		$this->validatePasswordContainsLetter();
	}

	private function validatePasswordLength() {
		if (strlen($this->password) < 5) {
			$this->validationResult->addFailure("A megadott jelszó túl rövid!");
		}
	}

	private function validatePasswordContainsNumber() {
		if (preg_match('/\\d/', $this->password) == 0) {
			$this->validationResult->addFailure("A megadott jelszó nem tartalmaz számot!");
		}
	}

	private function validatePasswordContainsLetter() {
		if (preg_match('~[a-zA-Z]~', $this->password) == 0) {
			$this->validationResult->addFailure("A megadott jelszó nem tartalmaz betűt!");
		}
	}
}