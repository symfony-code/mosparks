<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 11.12.17
 * Time: 15:40
 */

namespace NewsBundle\Constraint;


use Symfony\Component\Validator\Constraint;

/**
 * Class UniqueGroup
 * @package NewsBundle\Constraint
 * @Annotation
 */
class UniqueGroup extends Constraint
{
    public $message = 'Title "{value}" has already been taken';
}