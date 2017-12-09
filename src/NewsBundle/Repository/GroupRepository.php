<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 08.12.17
 * Time: 12:29
 */

namespace NewsBundle\Repository;


use Doctrine\ORM\EntityRepository;
use NewsBundle\Entity\Group;

/**
 * Class GroupRepository
 * @package NewsBundle\Repository
 */
class GroupRepository extends EntityRepository
{

    /**
     * @param mixed $id
     * @param null $lockMode
     * @param null $lockVersion
     * @return null|object|Group
     */
    public function find($id, $lockMode = null, $lockVersion = null)
    {
        return parent::find($id, $lockMode, $lockVersion);
    }

}