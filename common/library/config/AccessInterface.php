<?php

namespace common\library\config;

/**
 * Interface AccessInterface
 * @package common\library\config
 */

interface AccessInterface
{

    /**
     * returns a unique identifier
     * @return int|string
     */
    public function getUId();

    /**
     * returns an type grup|user
     * @return int
     */
    public function getUType();

    /**
     * returns the unique identifier of the parent
     * @return AccessInterface
     */
    public function getUParent();

}