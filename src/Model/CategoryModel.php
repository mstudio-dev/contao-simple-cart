<?php

declare(strict_types=1);

namespace Mstudio\ContaoSimpleCart\Model;

use Contao\Model;

/**
 * @method static \Contao\Model\Collection|CategoryModel[]|CategoryModel|null findByIds(array $ids, array $opt=array())
 */
class CategoryModel extends Model
{
    protected static $strTable = 'tl_category';
}
