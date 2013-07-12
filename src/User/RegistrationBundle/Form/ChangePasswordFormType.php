<?php
namespace User\RegistrationBundle\Form;

use Symfony\Component\Form\AbstractType;

class ChangePasswordFormType extends \Symfony\Component\Form\AbstractType
{
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options) {
        
        $builder
                ->add('current_password','password')
                ->add('new_password','password')
                ->add('conf_password','password')
                ->add('Change','submit')
                //->add('Close','button')
            ;
    }
    
    public function setDefaultOptions(\Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver) {
        
    }
    
    public function getName() {
        return 'change_password';
    }
}
?>
