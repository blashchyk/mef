<?php

namespace common\library\config;

/**
 * Filters {@link ModuleIterator} to contain proper module root folder and can be filtered by name
 *
 * @author Artem Hryhorenko
 * @package ModuleManager
 */
class ModuleFilterIterator extends \FilterIterator implements ModuleFilterIteratorInterface
{
    private $filter = null;

    /**
     * Filters {@see \common\library\config\ModuleIterator} to contain proper module root folder and can be filtered by name
     * @param \common\library\config\ModuleIteratorInterface $iterator
     * @param string|null $filter
     */
    public function __construct(ModuleIteratorInterface $iterator, $filter)
    {
        parent::__construct($iterator);
        $this->filter = $filter;
    }

    /**
     * @inheritdoc
     */
    public function accept()
    {
        $module = $this->getInnerIterator()->current();
        return $module->isDir() && ($this->filter === null || strcasecmp($module->getFilename(), $this->filter) === 0);
    }

}
