<?php
/**
 * Vain Framework
 *
 * PHP Version 7
 *
 * @package   vain-mongo
 * @license   https://opensource.org/licenses/MIT MIT License
 * @link      https://github.com/allflame/vain-mongo
 */
declare(strict_types = 1);

namespace Vain\Mongo\Collection\Key\Storage;

use Vain\Mongo\Collection\Key\CollectionKeyInterface;
use Vain\Mongo\Exception\DuplicateKeyGeneratorException;
use Vain\Mongo\Exception\UnknownKeyGeneratorException;

/**
 * Class CollectionKeyStorage
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class CollectionKeyStorage implements CollectionKeyStorageInterface
{
    private $generators = [];

    /**
     * CollectionKeyGeneratorStorage constructor.
     *
     * @param array $generators
     */
    public function __construct(array $generators = [])
    {
        foreach ($generators as $generator) {
            $this->addKey($generator);
        }
    }

    /**
     * @inheritDoc
     */
    public function addKey(CollectionKeyInterface $generator) : CollectionKeyStorageInterface
    {
        $collectionName = $generator->getName();
        if (array_key_exists($collectionName, $this->generators)) {
            throw new DuplicateKeyGeneratorException(
                $this,
                $collectionName,
                $generator,
                $this->generators[$collectionName]
            );
        }
        $this->generators[$collectionName] = $generator;

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function getKey(string $collectionName) : CollectionKeyInterface
    {
        if (false === array_key_exists($collectionName, $this->generators)) {
            throw new UnknownKeyGeneratorException($this, $collectionName);
        }

        return $this->generators[$collectionName];
    }
}