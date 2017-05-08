<?php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterUserForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$builder
			->add('name')
			->add('loginName')
			->add('password', PasswordType::class)
			->add('save', SubmitType::class, array('label' => 'Create User'));
	}

    public function configureOptions(OptionsResolver $resolver)
    {
		$resolver->setDefaults([
			'csrf_protection' => false
		]);
	}

    public function getBlockPrefix()
    {
        return 'user_bundle_register_user_form';
    }
}
