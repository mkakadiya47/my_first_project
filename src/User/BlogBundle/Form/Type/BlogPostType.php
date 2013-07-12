<?php
namespace User\BlogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BlogPostType extends AbstractType
{
    public function getName() {
        return 'blogpost';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder->add('title')
                ->add('content')
                ;
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array('data-class' => "User/BlogBundle/Entity/BlogPost"));
    }
    public function getDefaultOptions(array $options)
    {
        $options = parent::getDefaultOptions($options);
        $options['csrf_protection'] = false;

        return $options;
    }
}
?>
