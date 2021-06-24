<?php
/**
 * Registration type.
 */

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class RegistrationFormType.
 */
class RegistrationFormType extends AbstractType
{
    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting from the
     * top most type. Type extensions can further modify the form.
     *
     * @see FormTypeExtensionInterface::buildForm()
     *
     * @param \Symfony\Component\Form\FormBuilderInterface $builder The form builder
     * @param array                                        $options The options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'username',
            TextType::class,
            [
                'label' => 'label_username',
                'required' => true,
                'attr' => ['max_length' => 32],
            ]
        );
        $builder->add(
            'email',
            EmailType::class,
            [
                'label' => 'label_email',
                'required' => true,
                'attr' => ['max_length' => 50],
            ]
        );
        $builder->add(
                'password',
            RepeatedType::class,
                [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                    'type' => PasswordType::class,
                    'mapped' => true,
                    'invalid_message' => 'Passwords must be the same',
                    'options' => ['attr' => ['class' => 'password-field']],
                    'first_options' => ['label' => 'label_password'],
                    'second_options' => ['label' => 'label_password_repeat'],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Please enter a password',
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Your password should be at least {{ limit }} characters',
                            // max length allowed by Symfony for security reasons
                            /*'max' => 4096,*/
                            'max' => 255,
                        ]),
                    ],
                ]);
    }

    /**
     * Configures the options for this type.
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver The resolver for the options
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
