<?php

namespace App\Form;

use App\Entity\ErpTypeMatierePremiere;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ErpTypeMatierePremiereType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code')
            ->add('nom')
            ->add('creepar')
            ->add('datecreation', null, [
                'widget' => 'single_text',
            ])
            ->add('datemodification', null, [
                'widget' => 'single_text',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ErpTypeMatierePremiere::class,
        ]);
    }
}
