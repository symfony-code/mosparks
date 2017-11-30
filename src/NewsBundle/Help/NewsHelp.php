<?php
/**
 * Created by PhpStorm.
 * User: cherem
 * Date: 30.11.17
 * Time: 20:07
 */

namespace NewsBundle\Help;


use NewsBundle\Entity\News;

/**
 * Class NewsHelp
 * @package NewsBundle\Help
 */
class NewsHelp
{
    /**
     * @return array
     */
    public static function getHiddenDropDown()
    {
        return [
            'Нет' => News::HIDDEN_NO,
            'Да' => News::HIDDEN_YES,
        ];
    }
}