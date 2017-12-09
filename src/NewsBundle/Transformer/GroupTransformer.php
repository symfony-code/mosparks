<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 09.12.17
 * Time: 15:16
 */

namespace NewsBundle\Transformer;


use Doctrine\ORM\EntityManagerInterface;
use NewsBundle\Entity\Group;
use NewsBundle\Repository\GroupRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * Class GroupTransformer
 * @package NewsBundle\Transformer
 */
class GroupTransformer implements DataTransformerInterface
{
    /**
     * @var GroupRepository
     */
    private $groupRepository;

    /**
     * GroupTransformer constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->groupRepository = $entityManager->getRepository(Group::class);
    }


    /**
     * @param mixed $value
     * @return string|int
     */
    public function transform($value)
    {
        if (is_null($value)) {
            return '';
        }
    }


    /**
     * @param mixed $value
     * @return Group
     */
    public function reverseTransform($value)
    {
        $model = $this->groupRepository->find($value);
        if (is_null($model)) {
            throw new TransformationFailedException(sprintf('A group with number "%s" does not exist', $value));
        }
        return $model;
    }

}