<?php

namespace App\Form;

namespace App\Form;

use App\Entity\Expenses;
use App\Entity\Tricounts;
use App\Entity\Users;
use App\Repository\UsersRepository;
use App\Service\GetUserByExpenses;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ExpensesFormType extends AbstractType
{

    private $getUserByExpenses;

    public function __construct(GetUserByExpenses $getUserByExpenses)
    {
        $this->getUserByExpenses = $getUserByExpenses;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $tricountId = $options['tricountId'];

        $builder
            ->add(
                'title',
                TextType::class,
                [
                    'label' => 'Titre',
                    'attr' => [
                        'class' => 'form_title',
                        'maxlength' => 32,
                        'placeholder' => 'Titre',

                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez saisir un titre',
                        ]),
                    ],
                    'property_path' => 'title',
                ]
            )
            ->add(
                'value',
                MoneyType::class,
                [
                    'label' => 'Valeur',
                    'required' => false,
                    'attr' => [
                        'class' => 'form_value',
                        'maxlength' => 8,
                        'placeholder' => 'Valeur',
                    ],
                    'property_path' => 'value',
                ]
            )
            ->add('user', EntityType::class, [
                'class' => Users::class,
                'choices' => $this->getUserByExpenses->getTable(Tricounts::class, $tricountId),
                'choice_label' => 'firstname',
                'multiple' => true,
                'expanded' => true,
                'property_path' => 'concerned_users',
            ])
            ->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'Créer une dépense',
                    'attr' => [
                        'class' => 'btn btn-primary',
                    ],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Expenses::class,
            'tricountId' => null,
        ]);
    }
}
