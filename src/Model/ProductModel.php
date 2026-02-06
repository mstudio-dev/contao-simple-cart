<?php

declare(strict_types=1);

namespace Mstudio\ContaoSimpleCart\Model;

use Contao\Model;

/**
 * @method static \Contao\Model\Collection|ProductModel[]|ProductModel|null findByIds(array $ids, array $opt=array())
 */
class ProductModel extends Model
{
    protected static $strTable = 'tl_product';
}
