<?php

namespace Swaggest\JsonSchema\Tests\Helper;

use Swaggest\JsonSchema\Constraint\Properties;
use Swaggest\JsonSchema\Schema;
use Swaggest\JsonSchema\Structure\ClassStructure;

/**
 * @property int $quantity PHPDoc defined dynamic properties will be validated on every set
 */
class User extends ClassStructure
{
    /* Native (public) properties will be validated only on import and export of structure data */

    /** @var int */
    public $id;
    public $name;
    /** @var Order[] */
    public $orders;

    /** @var UserInfo */
    public $info;

    /**
     * @param Properties|static $properties
     * @param Schema $ownerSchema
     */
    public static function setUpProperties($properties, Schema $ownerSchema)
    {
        // Setup property schemas
        $properties->id = Schema::integer();
        $properties->name = Schema::string();

        // You can embed structures to main level with nested schemas
        $properties->info = UserInfo::schema()->nested();

        // Dynamic (phpdoc-defined) properties can be used as well
        $properties->quantity = Schema::integer();
        $properties->quantity->minimum = 0;

        // Property can be any complex structure
        $properties->orders = Schema::create();
        $properties->orders->items = Order::schema();

        $ownerSchema->required = array(self::names()->id);
    }
}