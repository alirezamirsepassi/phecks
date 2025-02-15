<?php

namespace Juampi92\Phecks\Tests\Sources;

use Juampi92\Phecks\Domain\Sources\GrepSource;
use Juampi92\Phecks\Tests\TestCase;

class GrepSourceTest extends TestCase
{
    public function test_should_work(): void
    {
        $result = resolve(GrepSource::class)
            ->files('./tests/Sources/stubs')
            ->pattern('extends')
            ->run();

        $this->assertEquals(1, $result->count());
        $this->assertEquals('class SubclassC extends ClassA', $result->getItems()->first()->value->context);
    }
}
