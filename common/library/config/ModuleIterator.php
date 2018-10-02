<?php

namespace common\library\config;

/**
 * Specialized iterator for modules
 *
 * @author Artem Hryhorenko
 * @package ModuleManager
 */
class ModuleIterator extends \FilesystemIterator implements ModuleIteratorInterface
{

    /**
     * Create ModuleIterator from specified directory
     * @param string $path
     */
    public function __construct($path)
    {
        parent::__construct($path, \FilesystemIterator::NEW_CURRENT_AND_KEY | \FilesystemIterator::SKIP_DOTS);
    }

}
