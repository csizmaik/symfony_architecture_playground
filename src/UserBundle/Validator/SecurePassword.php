<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 5/8/2017
 * Time: 2:32 PM
 */

namespace UserBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class SecurePassword extends Constraint
{
	public $message = '{{error}} Szabályok: {{rules}}';
}