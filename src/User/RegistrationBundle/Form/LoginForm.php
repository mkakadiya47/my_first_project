<?php
namespace User\RegistrationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginForm extends AbstractType
{
    public function getName() {
        return 'login';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder->add('email','email',array('required'=>true))
                ->add('password','password',array('required'=>true))
                                ;
    }
    
}
?>
