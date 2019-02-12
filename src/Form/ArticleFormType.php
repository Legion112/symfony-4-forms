<?php
/**
 * Created by PhpStorm.
 * User: Max
 * Date: 11.02.2019
 * Time: 20:26
 */

namespace App\Form;


use App\Entity\Article;
use App\Entity\User;
use App\Repository\UserRepository;
use function Clue\StreamFilter\fun;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFormType extends AbstractType
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, [
                'help' => 'Choose something catchy!'
            ])
            ->add('content', null, [
                'rows' => 15
            ])
            ->add('publishedAt', DateTimeType::class, [
                'widget' => 'single_text'
            ])
            ->add('author', UserSelectTextType::class, [
                'attr' => ['class' => 'foo']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}