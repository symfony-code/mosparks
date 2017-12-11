<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 11.12.17
 * Time: 15:43
 */

namespace NewsBundle\Constraint;


use Doctrine\ORM\EntityManagerInterface;
use NewsBundle\Entity\Group;
use NewsBundle\Repository\GroupRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueGroupValidator extends ConstraintValidator
{
    /** @var GroupRepository */
    private $groupRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->groupRepository = $entityManager->getRepository(Group::class);
    }

    /**
     * @param mixed $value
     * @param UniqueGroup|Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        $model = $this->groupRepository->findOneBy(['title' => $value]);

        if (!is_null($model)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{value}', $value)
                ->addViolation();
        }
    }
}