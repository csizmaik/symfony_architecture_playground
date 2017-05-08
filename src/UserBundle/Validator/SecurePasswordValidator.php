<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 5/8/2017
 * Time: 2:34 PM
 */

namespace UserBundle\Validator;

use lib\validation\PasswordStrengthValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class SecurePasswordValidator extends ConstraintValidator
{

	/**
	 * Checks if the passed value is valid.
	 *
	 * @param mixed $value The value that should be validated
	 * @param Constraint $constraint The constraint for the validation
	 */
	public function validate($value, Constraint $constraint)
	{
		$validator = new PasswordStrengthValidator($value);
		$validationResult = $validator->getValidationResult();
		if (!$validationResult->isSuccess())
		{
			$this->context->buildViolation($constraint->message)
				->setParameter('{{error}}',implode(" ",$validationResult->getFailureReasons()))
				->setParameter('{{rules}}',PasswordStrengthValidator::RULE_TEXT)
				->addViolation();
		}
	}
}