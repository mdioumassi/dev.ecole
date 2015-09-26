<?php

namespace Ecole\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Ecole\AdminBundle\Form\CorrespondantType;

class EleveType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('age')
            ->add('cursus','entity', array(
                  'class'    => 'EcoleAdminBundle:Cursus',
                  'property' => 'nom',
                  'multiple' => false,
                  'expanded'=>true)
                )
            ->add('correspondant',new CorrespondantType());
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ecole\AdminBundle\Entity\Eleve'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ecole_adminbundle_eleve';
    }
}
