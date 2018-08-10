<?php

namespace Navalex\ConfigBundle\Form;

use Navalex\ConfigBundle\Entity\Fieldset;
use Navalex\ConfigBundle\Repository\ConfigurationRepository;
use Navalex\ConfigBundle\Repository\FieldsetRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfigurationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'translation_domain' => 'NavalexConfigBundle',
                'attr' => ['placeholder' => 'navalex.config.admin.form.config.code']
            ])
            ->add('description', TextType::class, [
                'translation_domain' => 'NavalexConfigBundle',
                'attr' => ['placeholder' => 'navalex.config.admin.form.config.name']
            ])
            ->add('fieldset', EntityType::class, [
                'class' => 'Navalex\ConfigBundle\Entity\Fieldset',
                'query_builder' => function (FieldsetRepository $er) {
                    $qb = $er->createQueryBuilder('fieldset')->innerJoin('fieldset.category', 'category')->select('fieldset', 'category');

                    return $qb;
                },
                'empty_data' => false,
                'group_by' => function(Fieldset $field) {
                    return $field->getCategory()->getName();
                }
            ])
            ->add('field', ChoiceType::class, [
                'translation_domain' => 'NavalexConfigBundle',
                'choices' => [
                    'navalex.config.admin.form.config.types.string' => 'text',
                    'navalex.config.admin.form.config.types.long_text' => 'tinymce',
                    'navalex.config.admin.form.config.types.checkbox' => 'checkbox',
                    'navalex.config.admin.form.config.types.number' => 'number',
                    'navalex.config.admin.form.config.types.color' => 'color',
                    'navalex.config.admin.form.config.types.mail' => 'email',
                    'navalex.config.admin.form.config.types.date' => 'date',
                ]
            ])
            ->add('translation', null, [
                'data' => 'CoreBundle',
                'required' => false
            ])
            ->add('helper', null, [
                'data' => '',
                'required' => false
            ])
            ->add('value', null, [
                'data' => 'data',
                'required' => false
            ])
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Navalex\ConfigBundle\Entity\Configuration'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'navalex_configbundle_configuration';
    }


}
