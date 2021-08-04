<?php

namespace Violinist\CommitMessageCreator\Tests;

use eiriksm\ViolinistMessages\UpdateListItem;
use PHPUnit\Framework\TestCase;
use Violinist\CommitMessageCreator\Creator;

class CreatorTest extends TestCase
{
    public function testConventional()
    {
        $item = new UpdateListItem('psr/log', '1.1.0', '1.0.0');
        $creator = new Creator();
        $msg = $creator->generateMessage($item);
        self::assertEquals('build(deps): Update psr/log from 1.0.0 to 1.1.0', $msg);
    }
}
