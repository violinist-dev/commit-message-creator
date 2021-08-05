<?php

namespace Violinist\CommitMessageCreator\Tests;

use eiriksm\ViolinistMessages\UpdateListItem;
use PHPUnit\Framework\TestCase;
use Violinist\CommitMessageCreator\Constant\Type;
use Violinist\CommitMessageCreator\Creator;

class CreatorTest extends TestCase
{
    public function testUsesConventionalByDefault()
    {
        list($item, $creator) = $this->getRequirements();
        $msg = $creator->generateMessage($item);
        self::assertEquals('build(deps): Update psr/log from 1.0.0 to 1.1.0', $msg);
    }

    public function testUsesConventional()
    {
        list($item, $creator) = $this->getRequirements();
        $creator->setType(Type::CONVENTIONAL);
        $msg = $creator->generateMessage($item);
        self::assertEquals('build(deps): Update psr/log from 1.0.0 to 1.1.0', $msg);
    }

    public function testThrowsInvalidArgumentExceptionIfTypeDoesNotExists()
    {
        $fakeType = 'random-type';

        list($item, $creator) = $this->getRequirements();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageRegExp('/'.$fakeType.'/');

        $creator->setType($fakeType);
        $msg = $creator->generateMessage($item);

        self::assertEquals('build(deps): Update psr/log from 1.0.0 to 1.1.0', $msg);
    }

    public function testUsesAnyFormat()
    {
        list($item, $creator) = $this->getRequirements();
        $creator->setType(Type::NONE);
        $msg = $creator->generateMessage($item);
        self::assertEquals('Update psr/log', $msg);
    }

    public function testCanSetScopeAsDepsDev()
    {
        list($item, $creator) = $this->getRequirements();
        $msg = $creator->generateMessage($item, true);
        self::assertEquals('build(deps-dev): Update psr/log from 1.0.0 to 1.1.0', $msg);
    }

    private function getRequirements()
    {
        $item = new UpdateListItem('psr/log', '1.1.0', '1.0.0');
        $creator = new Creator();

        return [$item, $creator];
    }
}
