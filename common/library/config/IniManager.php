<?php
namespace common\library\config;

use common\library\exceptions\FileWriteException;
use common\library\exceptions\RequiredParamException;
use common\library\exceptions\ParseIniFileException;
use common\library\exceptions\FileNotExistException;
use common\library\exceptions\DataNotFoundException;
use common\library\exceptions\ModuleNotFoundException;

class IniManager implements ManagerInterface, ModuleManagerInterface
{
    /** @var null|array */
    private $data;

    /** @var null|string */
    private $filePath;

    /**
     * Config source options
     * @var int
     */
    private $fileMode;

    /**
     * Instance of iterator specialized on system modules
     * @var ModuleIteratorInterface
     */
    private $modulesIterator = null;

    /**
     * @inheritdoc
     * @throws RequiredParamException
     */
    public function __construct(ModuleIteratorInterface $moduleIterator, $filePath, $mode = ManagerInterface::STRICT)
    {
        if (empty($filePath)) {
            throw new RequiredParamException('Config file name not specified.');
        }

        $this->modulesIterator = $moduleIterator;
        $this->filePath = $filePath;
        $this->fileMode = $mode;
    }

    /**
     * Actual read source function
     * @throws FileNotExistException
     * @throws ParseIniFileException
     */
    public function load()
    {
        if ($this->data !== null && ($this->fileMode & ManagerInterface::ALLOW_RELOAD) !== ManagerInterface::ALLOW_RELOAD) {
            return;
        }
        $fileInfo = new \SplFileInfo($this->filePath);

        if ($fileInfo->isLink()) {
            throw new FileNotExistException("Config file cannot be a link");
        }
        if ($fileInfo->isDir()) {
            throw new FileNotExistException("Config file cannot be a directory");
        }

        if ($fileInfo->isFile() === false) {
            $canCreate = ($this->fileMode & ManagerInterface::ALLOW_CREATE) === ManagerInterface::ALLOW_CREATE;
            if (!$canCreate) {
                throw new FileNotExistException('The file does not exist.');
            }
            if ($fileInfo->getPathInfo()->isDir() === false && mkdir($fileInfo->getPath(), 0775, true) === false) {
                throw new FileNotExistException('Could not create file');
            }
            $this->writeFile($fileInfo, '[' . self::SECTION_MODULES . ']' . PHP_EOL, $canCreate);
        }

        $data = parse_ini_file($this->filePath, true);
        if ($data === false || empty($data[self::SECTION_MODULES]) || !is_array($data[self::SECTION_MODULES])) {
            if (($this->fileMode & ManagerInterface::ALLOW_EMPTY) !== ManagerInterface::ALLOW_EMPTY) {
                throw new ParseIniFileException('Can not read file.');
            }
            $data = [
                self::SECTION_MODULES => []
            ];
        }

        $this->data = $data;
    }

    /**
     * Actual file writer
     * @param \SplFileInfo $fileInfo File object
     * @param string $data data to be written
     * @param bool $allowEmpty if allowed then will not check for file to be writtable, such as uncreated file
     * @throws FileWriteException
     * @throws \RuntimeException
     */
    protected function writeFile(\SplFileInfo $fileInfo, $data, $allowEmpty = false)
    {
        if (!($allowEmpty || $fileInfo->isWritable())) {
            throw new FileWriteException("File not writable");
        }

        $file = $fileInfo->openFile("w");
        $bytesWritten = $file->fwrite($data);
        $file = null;

        if ($bytesWritten === 0) {
            throw new FileWriteException("Couldn't write to file");
        }
    }

    /**
     * @return array
     * @throws FileNotExistException
     * @throws ParseIniFileException
     */
    protected function getData()
    {
        if ($this->data === null) {
            $this->load();
        }

        return $this->data;
    }

    /**
     * Internal data set to preserve module statuses
     * @param array $data
     */
    protected function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param string $key
     * @return mixed
     * @throws DataNotFoundException
     * @throws FileNotExistException
     * @throws ParseIniFileException
     */
    public function get($section, $key)
    {
        $data = $this->getData();

        if (!array_key_exists($section, $data) || !is_array($data[$section]) || !array_key_exists($key, $data[$section])) {
            throw new DataNotFoundException();
        }

        return $data[$section][$key];
    }

    /**
     * @param string $moduleName
     * @return bool
     * @throws FileWriteException
     */
    public function enableModule($moduleName)
    {
        if (!$this->haveModule($moduleName)) {
            throw new ModuleNotFoundException("Module '{$moduleName}' couldn't be found");
        }
        return $this->set(self::SECTION_MODULES, $moduleName, self::STATUS_ENABLED);
    }

    /**
     * @param string $moduleName
     * @return bool
     * @throws FileWriteException
     */
    public function disableModule($moduleName)
    {
        if (!$this->haveModule($moduleName)) {
            throw new ModuleNotFoundException("Module '{$moduleName}' couldn't be found");
        }
        return $this->set(self::SECTION_MODULES, $moduleName, self::STATUS_DISABLED);
    }

    /**
     * @param string $section
     * @param string $key
     * @param int $value
     * @return bool
     * @throws FileWriteException
     */
    public function set($section, $key, $value)
    {
        $data = $this->getData();
        $data[$section][$key] = $value;
        $this->setData($data);

        $this->writeFile(new \SplFileInfo($this->filePath), $this->arrToIni($data));

        return true;
    }

    /**
     * @param array $array
     * @param array $parent
     * @return string
     */
    protected function arrToIni(array $array, array $parent = [])
    {
        $out = '';
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $section = array_merge((array)$parent, (array)$key);
                $out .= '[' . join('.', $section) . ']' . PHP_EOL;
                $out .= $this->arrToIni($value, $section);
            } else {
                $out .= $key . ' = ' . $value . PHP_EOL;
            }
        }
        return $out;
    }

    /**
     * @inheritdoc
     */
    public function haveModule($moduleName)
    {
        return iterator_count(new ModuleFilterIterator($this->modulesIterator, $moduleName)) > 0;
    }

    /**
     * @inheritdoc
     */
    public function availableModules($moduleName, $status)
    {
        // If there is no $moduleName than there is no module!
        if (empty($moduleName)) {
            throw new ModuleNotFoundException("Module '{$moduleName}' couldn't be found");
        }

        //Get the modules
        if ($moduleName === 'all') {
            $available = $this->allAvailable();
        } else {
            $available = $this->fileIteratorToArray(new ModuleFilterIterator($this->modulesIterator, $moduleName));
        }

        // If no modules found than the wrong name was supplied
        if (count($available) === 0) {
            throw new ModuleNotFoundException("Module '{$moduleName}' couldn't be found");
        }

        // Make compare for requested module status
        if ($status === self::STATUS_DISABLED) {
            return array_diff($available, $this->allActive());
        } else {
            return array_intersect($available, $this->allActive());
        }
    }

    /**
     * @inheritdoc
     */
    public function allAvailable()
    {
        return $this->fileIteratorToArray(new ModuleFilterIterator($this->modulesIterator, null));
    }

    /**
     * @inheritdoc
     */
    public function allActive()
    {
        $data = $this->getData();
        $active = [];
        foreach ($data[self::SECTION_MODULES] as $module => $activeStatus) {
            if ((int)$activeStatus !== self::STATUS_ENABLED) {
                continue;
            }
            $active[] = $module;
        }
        return $active;
    }

    /**
     * @inheritdoc
     */
    public function moduleStatus($moduleName = null)
    {
        $active = array_flip($this->allActive());
        $modules = $this->fileIteratorToArray(new ModuleFilterIterator($this->modulesIterator, $moduleName));
        if ($moduleName !== null && count($modules) === 0) {
            throw new ModuleNotFoundException("Module '{$moduleName}' couldn't be found");
        }
        $status = [];
        foreach ($modules as $module) {
            $status[$module] = isset($active[$module]) ? 'enabled' : 'disabled';
        }
        return $status;
    }

    /**
     * Return iterator values as array
     * @param ModuleFilterIteratorInterface $iterator
     * @return array
     */
    private function fileIteratorToArray(ModuleFilterIteratorInterface $iterator)
    {
        $array = [];
        foreach ($iterator as $file) {
            $array[] = $file->getFilename();
        }
        return $array;
    }

}
