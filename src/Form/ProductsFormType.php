<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Products;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Repository\CategoriesRepository;

class ProductsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', options:[
                'label' => 'Name'
            ])
            ->add('description')
            ->add('price', options:[
                'label' => 'Price'
            ])
            ->add('stock', options:[
                'label' => 'Piece'
            ])
            ->add('categories', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'name',
                'label' => 'Category',
                'group_by' => 'parent.name', //regroupe les resultats par le nom du parent de la categorie
                'query_builder' => function(CategoriesRepository $cr)
                {
                    return $cr->createQueryBuilder('c')
                        ->where("c.parent IS NOT NULL") //n'affiche pas les categories parentes ou le parent_id est null et ainsi faire s'effacer les doublons generes par le regroupement 
                        ->orderBy('c.name', 'ASC'); //trie par ordre alphabetique
                }
            ]) //gestion des problemes avec la categorie resolus ainsi precedement
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Products::class,
        ]);
    }
}
