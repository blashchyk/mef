<?php

namespace common\library\config;

/**
 * Interface AccessInterface
 * @package common\library\config
 */

class AccessApplicant implements AccessInterface
{


    /**
     * @var int $type
     */
    protected $type;

    /**
     * @var int|string $name
     */
    protected $name;

    /**
     * AccessApplicant constructor.
     * @param int|string $name
     * @param int $type
     */
    public function __construct($name, $type)
    {
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * returns a unique identifier
     * @return int|string
     */
    public function getUId()
    {
        return $this->name;
    }

    /**
     * returns an object class
     * @return int
     */
    public function getUType()
    {
        return $this->type;
    }

    /**
     * returns the unique identifier of the parent object
     * @return AccessInterface
     */
    public function getUParent()
    {
        return null;
    }

}