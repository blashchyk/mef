<?php

namespace common\library\config;

interface ManagerInterface
{
    const SECTION_MODULES = 'modules_enabled';

    const STRICT = 0;
    // Should be used with ALLOW_EMPTY simultaneously, or fill trigger could not read from file Exception
    const ALLOW_CREATE = 1;
    const ALLOW_EMPTY  = 2;
    const ALLOW_RELOAD = 4;

    /**
     * @return array
     * @param string $section
     * @param string $key
     */
    public function get($section, $key);

    /**
     * @param string $section
     * @param string $key
     * @param mixed $value
     */
    public function set($section, $key, $value);
}
