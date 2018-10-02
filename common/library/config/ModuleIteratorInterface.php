<?php

namespace common\library\config;

/**
 * Specialized iterator for modules
 *
 * @author Artem Hryhorenko
 * @package ModuleManager
 */
interface ModuleIteratorInterface extends \SeekableIterator
{

    const MODULE_CONFIG_PATH = '@common/config/config.ini';

}
