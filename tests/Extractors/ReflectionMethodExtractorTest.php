<?php

namespace Juampi92\Phecks\Tests\Extractors;

use Juampi92\Phecks\Domain\Extractors\ReflectionMethodExtractor;
use Juampi92\Phecks\Tests\Extractors\stubs\SimpleClassForReflection;
use Juampi92\Phecks\Tests\TestCase;
use ReflectionClass;
use ReflectionMethod;

class ReflectionMethodExtractorTest extends TestCase
{
    public function test_it_should_work(): void
    {
        // Arrange
        $reflectionClass = new ReflectionClass(SimpleClassForReflection::class);

        $extractor = new ReflectionMethodExtractor();

        // Act
        $result = $extractor->extract($reflectionClass);

        // Assert
        $this->assertEquals(2, $result->count());

        /** @var ReflectionMethod $methodFoo */
        $methodFoo = $result->first();
        /** @var ReflectionMethod $methodBar */
        $methodBar = $result->last();

        $this->assertInstanceOf(ReflectionMethod::class, $methodFoo);
        $this->assertInstanceOf(ReflectionMethod::class, $methodBar);

        $this->assertEquals('foo', $methodFoo->getName());
        $this->assertEquals(true, $methodFoo->isPublic());

        $this->assertEquals('bar', $methodBar->getName());
        $this->assertEquals(true, $methodBar->isPrivate());
    }

    /**
     *
     * @dataProvider methodFilterDataProvider
     */
    public function test_it_should_filter_methods(ReflectionMethodExtractor $extractor, array $matches): void
    {
        // Arrange
        $reflectionClass = new ReflectionClass(SimpleClassForReflection::class);

        // Act
        $result = $extractor->extract($reflectionClass);

        // Assert
        $this->assertEquals(count($matches), $result->count());

        /** @var ReflectionMethod $method */
        $this->assertEqualsCanonicalizing(
            $matches,
            $result->map->getName()->all()
        );
    }

    public function methodFilterDataProvider(): array
    {
        return [
            'private' => [
                'extractor' => new ReflectionMethodExtractor(ReflectionMethod::IS_PRIVATE),
                'matches' => [
                    'bar',
                ],
            ],
            'public' => [
                'extractor' => new ReflectionMethodExtractor(ReflectionMethod::IS_PUBLIC),
                'matches' => [
                    'foo',
                ],
            ],
            'static' => [
                'extractor' => new ReflectionMethodExtractor(ReflectionMethod::IS_STATIC),
                'matches' => [],
            ],
        ];
    }
}
