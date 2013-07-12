<?php

namespace User\RegistrationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationForm extends AbstractType
{
    private $registrationType;
    
    public function __construct($type=null) {
        $this->registrationType = $type;
    }

    public function getName() {
        return 'registration';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder
                ->add('email','email',array('required'=>true));
        
                if($this->registrationType==1)
                {
                    $builder
                            ->add('password', 'repeated', array(
                            'type' => 'password',
                            'invalid_message' => 'The password fields must match.',
                            'required' => true,
                            'first_options'  => array('label' => 'Password'),
                            'second_options' => array('label' => 'Repeat Password'),
                        ));
                }
                
                $builder
                        ->add('firstname','text',array('required'=>true))
                        ->add('lastname','text',array('required'=>true))
                        ->add('address',null,array('required'=>true))
                        ->add('gender','choice',array(
                             'choices'=>array(
                                        0=>'Male',
                                        1=>'Female'
                                        )
                            ,'required'=>true
                            ))
                        ;
                
                if($this->registrationType==1)
                {
                    $builder
                        ->add('Registration','submit');
                }
                else
                {
                    $builder
                        ->add('Save','submit');
                }
                
        
                
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array('data-class'=>'User\RegistrationBundle\RegistrationBundle'));
        
    }
}
?>
