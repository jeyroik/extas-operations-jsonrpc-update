<?php
namespace tests\jsonrpc;

use Dotenv\Dotenv;
use extas\components\api\jsonrpc\operations\OperationRunner;
use extas\components\http\TSnuffHttp;
use extas\components\items\SnuffItem;
use extas\components\operations\jsonrpc\Update;
use extas\components\operations\JsonRpcOperation;
use extas\components\plugins\PluginEmpty;
use extas\components\plugins\TSnuffPlugins;
use extas\components\repositories\TSnuffRepositoryDynamic;
use extas\components\THasMagicClass;
use extas\interfaces\http\IHasHttpIO;
use extas\interfaces\samples\parameters\ISampleParameter;
use PHPUnit\Framework\TestCase;

/**
 * Class UpdateTest
 *
 * @package tests\jsonrpc
 * @author jeyroik <jeyroik@gmail.com>
 */
class UpdateTest extends TestCase
{
    use TSnuffHttp;
    use TSnuffRepositoryDynamic;
    use TSnuffPlugins;
    use THasMagicClass;

    protected function setUp(): void
    {
        parent::setUp();
        $env = Dotenv::create(getcwd() . '/tests/');
        $env->load();
        $this->createSnuffDynamicRepositories([
            ['snuffRepo', 'name', SnuffItem::class]
        ]);
        $this->getMagicClass('snuffRepo')->create(new SnuffItem([
            'name' => 'test',
            'description' => 'failed',
            'value' => 'true'
        ]));
    }

    protected function tearDown(): void
    {
        $this->deleteSnuffDynamicRepositories();
    }

    public function testUpdateOperation()
    {
        $operation = $this->getOperation();

        $result = $operation([
            IHasHttpIO::FIELD__PSR_REQUEST => $this->getPsrRequest(),
            IHasHttpIO::FIELD__PSR_RESPONSE => $this->getPsrResponse(),
            IHasHttpIO::FIELD__ARGUMENTS => ['version' => 0]
        ]);

        $this->assertEquals(
            [[
                'name' => 'test',
                'description' => 'is ok'
            ]],
            $result,
            'Incorrect result: ' . print_r($result, true)
        );
    }

    public function testMissedPkMethod()
    {
        $operation = $this->getOperation(PluginEmpty::class);

        $this->expectExceptionMessage('Missed or unknown primary key method "getName"');
        $operation([
            IHasHttpIO::FIELD__PSR_REQUEST => $this->getPsrRequest(),
            IHasHttpIO::FIELD__PSR_RESPONSE => $this->getPsrResponse(),
            IHasHttpIO::FIELD__ARGUMENTS => ['version' => 0]
        ]);
    }

    public function testMissedAnItem()
    {
        $operation = $this->getOperation();

        $this->expectExceptionMessage('Missed or unknown snuff.item');
        $operation([
            IHasHttpIO::FIELD__PSR_REQUEST => $this->getPsrRequest('.unknown'),
            IHasHttpIO::FIELD__PSR_RESPONSE => $this->getPsrResponse(),
            IHasHttpIO::FIELD__ARGUMENTS => ['version' => 0]
        ]);
    }

    /**
     * @param string $itemClass
     * @return OperationRunner
     */
    protected function getOperation(string $itemClass = SnuffItem::class): OperationRunner
    {
        return new Update([
            Update::FIELD__OPERATION => new JsonRpcOperation([
                JsonRpcOperation::FIELD__PARAMETERS => [
                    JsonRpcOperation::PARAM__ITEM_REPOSITORY => [
                        ISampleParameter::FIELD__NAME => JsonRpcOperation::PARAM__ITEM_REPOSITORY,
                        ISampleParameter::FIELD__VALUE => 'snuffRepo'
                    ],
                    JsonRpcOperation::PARAM__ITEM_CLASS => [
                        ISampleParameter::FIELD__NAME => JsonRpcOperation::PARAM__ITEM_CLASS,
                        ISampleParameter::FIELD__VALUE => $itemClass
                    ],
                    JsonRpcOperation::PARAM__ITEM_NAME => [
                        ISampleParameter::FIELD__NAME => JsonRpcOperation::PARAM__ITEM_NAME,
                        ISampleParameter::FIELD__VALUE => 'snuff.item'
                    ],
                    JsonRpcOperation::PARAM__METHOD => [
                        ISampleParameter::FIELD__NAME => JsonRpcOperation::PARAM__METHOD,
                        ISampleParameter::FIELD__VALUE => 'create'
                    ]
                ]
            ])
        ]);
    }
}
