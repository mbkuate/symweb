<?php

namespace App\Form;

use App\Entity\Ad;
use App\Form\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;


class AdType extends AbstractType
{
    /**
     * Permet d'avoir la configuration de base d'un champ (label, placeholder et class)!
     * Ajoute aussi une étoile pour les champs obligatoires (paramètre html "required" non surchargé à faux), 
     *
     * @param string $label
     * @param string $placeholder
     * @param string $class
     * @param string $label_format
     * @param boolean $label_html
     * @param array $options
     * @return array
     */
    private function getConfiguration($label, $placeholder, $class="", $label_format = "html", $label_html = true, $options = []): array
    {
        return array_merge([
            'label' => $options == false ? $label . " <span class=\"text-danger\">*</span>" : $label,
            'label_format' => $label_format,
            'label_html' => $label_html,
            'attr' => [
                'class' => $class,
                'placeholder' => $placeholder
            ]
        ], $options);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', 
                TextType::class, 
                $this->getConfiguration("Titre", "Tapez un super titre pour votre annonce!", "ps-5")
            )
                            
            ->add('slug', 
                TextType::class, 
                $this->getConfiguration("Adresse web", "Tapez l'adresse web (automatique)", "ps-5", "text", false, [
                    'required' => false
                ])
            )

            ->add('coverImage', 
                UrlType::class, 
                $this->getConfiguration("URL de l'image principale", "Donnez l'adresse d'une image qui donne vraiment envie", "ps-5")
            )

            ->add('introduction', 
                TextType::class, 
                $this->getConfiguration("Introduction", "Donnez une description globale de l'annonce", "ps-5")
            )

            ->add('content', 
                TextareaType::class, 
                $this->getConfiguration("Description détaillée", "Tapez une description qui donne vraiment envie de venir chez vous!", "ps-5")
            )

            ->add('rooms', 
                IntegerType::class, 
                $this->getConfiguration("Nomdre de chambres", "Le nombre de chambres disponibles", "ps-5")
            )

            ->add('price', 
                MoneyType::class, 
                $this->getConfiguration("Prix par nuit", "Indiquez le prix que vous voulez par nuit")
            )
            
            ->add('images',
                CollectionType::class,
                [
                    'entry_type' => ImageType::class,
                    'allow_add' => true,
                    'allow_delete' => true
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
