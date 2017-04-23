<?php

namespace AppBundle\Form;

use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TagType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('tagName')->add('pending', ChoiceType::class, array(
                'choices' => array(
                    'Approve' => false,
                    'Pending' => true,
                ),
                'required' => true,
                'empty_data' => null
            ));

        //->add('save', SubmitType::class, array('label' => 'Submit Tag'));

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Tag'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_tag';
    }
}