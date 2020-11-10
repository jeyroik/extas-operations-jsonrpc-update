<?php
namespace extas\components\operations\jsonrpc;

use extas\components\api\jsonrpc\operations\OperationRunner;
use extas\components\exceptions\MissedOrUnknown;
use extas\interfaces\IHasName;
use extas\interfaces\IItem;
use extas\interfaces\operations\IJsonRpcOperation;

/**
 * Class Update
 *
 * @package extas\components\operations\jsonrpc
 * @author jeyroik@gmail.com
 */
class Update extends OperationRunner
{
    /**
     * @return array
     * @throws MissedOrUnknown
     */
    public function run(): array
    {
        /**
         * @var IJsonRpcOperation $op
         */
        $op = $this->getOperation();
        $repo = $op->getItemRepository();
        $item = $this->getItem();
        $pkMethod = 'get' . ucfirst($repo->getPk());

        if (!method_exists($item, $pkMethod)) {
            throw new MissedOrUnknown('primary key method "' . $pkMethod . '"', 500);
        }

        $exist = $repo->one([$repo->getPk() => $item->$pkMethod()]);

        if (!$exist) {
            throw new MissedOrUnknown($op->getItemName(), 404);
        }

        $this->updateItemFields($item, $exist);
        $repo->update($item);

        return [$item->__toArray()];
    }

    /**
     * @return IItem
     */
    protected function getItem(): IItem
    {
        $request = $this->getJsonRpcRequest();
        $itemClass = $this->getOperation()->getItemClass();

        return new $itemClass($request->getData());
    }

    /**
     * @param IItem $item
     * @param IItem $updateWith
     */
    protected function updateItemFields(IItem &$item, IItem $updateWith): void
    {
        foreach ($updateWith as $field => $value) {
            if (!isset($item[$field])) {
                $item[$field] = $value;
            }
        }
    }

    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return 'extas.operations.jsonrpc.update';
    }
}
