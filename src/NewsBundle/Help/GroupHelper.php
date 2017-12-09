<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 08.12.17
 * Time: 19:29
 */

namespace NewsBundle\Help;


class GroupHelper
{
    /**
     *
     */
    const HIDDEN_NO = 0;
    /**
     *
     */
    const HIDDEN_YES = 1;


    /**
     * @return array
     */
    public static function getHiddenDropDown()
    {
        return [
            'Нет' => static::HIDDEN_NO,
            'Да' => static::HIDDEN_YES,
        ];
    }
}