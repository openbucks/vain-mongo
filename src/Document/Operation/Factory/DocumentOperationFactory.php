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

namespace Vain\Mongo\Document\Operation\Factory;

use Vain\Core\Operation\Factory\Decorator\AbstractOperationFactoryDecorator;
use Vain\Mongo\Database\PhongoDatabase;
use Vain\Mongo\Document\Collection\DocumentCollectionInterface;
use Vain\Mongo\Document\DocumentInterface;
use Vain\Mongo\Document\Operation\DocumentDeleteOperation;
use Vain\Mongo\Document\Operation\DocumentInsertOperation;
use Vain\Mongo\Document\Operation\DocumentUpdateOperation;
use Vain\Mongo\Document\Operation\DocumentUpsertOperation;
use Vain\Core\Operation\Factory\OperationFactoryInterface;
use Vain\Core\Operation\OperationInterface;

/**
 * Class CollectionOperationFactory
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class DocumentOperationFactory extends AbstractOperationFactoryDecorator implements
    DocumentOperationFactoryInterface
{

    private $mongodb;

    /**
     * OperationCollectionFactory constructor.
     *
     * @param OperationFactoryInterface $operationFactory
     * @param PhongoDatabase            $mongodb
     */
    public function __construct(
        OperationFactoryInterface $operationFactory,
        PhongoDatabase $mongodb
    ) {
        $this->mongodb = $mongodb;
        parent::__construct($operationFactory);
    }

    /**
     * @inheritDoc
     */
    public function createDocument(
        DocumentCollectionInterface $collection,
        DocumentInterface $document
    ) : OperationInterface
    {
        return $this->decorate(new DocumentInsertOperation($this->mongodb, $collection, $document));
    }

    /**
     * @inheritDoc
     */
    public function deleteDocument(
        DocumentCollectionInterface $collection,
        DocumentInterface $document
    ) : OperationInterface
    {
        return $this->decorate(new DocumentDeleteOperation($this->mongodb, $collection, $document));
    }

    /**
     * @inheritDoc
     */
    public function updateDocument(
        DocumentCollectionInterface $collection,
        DocumentInterface $newDocument,
        DocumentInterface $oldDocument
    ) : OperationInterface
    {
        return $this->decorate(new DocumentUpdateOperation($this->mongodb, $collection, $newDocument));
    }

    /**
     * @inheritDoc
     */
    public function upsertDocument(
        DocumentCollectionInterface $collection,
        DocumentInterface $document
    ) : OperationInterface
    {
        return $this->decorate(new DocumentUpsertOperation($this->mongodb, $collection, $document));
    }
}
