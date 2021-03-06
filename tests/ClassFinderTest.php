<?php

namespace WSNYC\ClassFinder\Tests;

use PHPUnit\Framework\TestCase;
use WSNYC\ClassFinder\ClassFinder;
use WSNYC\Tests\Fixtures\DummyClass;
use WSNYC\Tests\Fixtures\DummyClassTwo;
use WSNYC\Tests\Fixtures\Nested\DummyClassNested;

/**
 * @covers \WSNYC\ClassFinder\ClassFinder::<!public>
 *
 * @group class-finder-tests
 */
class ClassFinderTest extends TestCase
{
    /**
     * @covers \WSNYC\ClassFinder\ClassFinder::findClasses
     *
     * @test
     */
    public function it_finds_all_classes_in_directory()
    {
        $classes = ClassFinder::findClasses(__DIR__ . '/Fixtures');

        $this->assertContains(DummyClass::class, $classes);
        $this->assertContains(DummyClassTwo::class, $classes);
    }

    /**
     * @covers \WSNYC\ClassFinder\ClassFinder::findClasses
     *
     * @test
     */
    public function it_finds_all_nested_classes_in_directory()
    {
        $classes = ClassFinder::findClasses(__DIR__ . '/Fixtures');

        $this->assertContains(DummyClassNested::class, $classes);
    }

    /**
     * @covers \WSNYC\ClassFinder\ClassFinder::findClasses
     *
     * @test
     */
    public function it_sorts_the_results_alphabetically()
    {
        $classes = ClassFinder::findClasses(__DIR__ . '/Fixtures');

        $this->assertEquals(DummyClass::class, array_shift($classes));
    }

    /**
     * @covers \WSNYC\ClassFinder\ClassFinder::findClassesSafely
     *
     * @test
     */
    public function it_suppresses_non_existent_directory_exceptions()
    {
        $classes = ClassFinder::findClassesSafely(__DIR__ . '/FixturesThatDoNotExist');

        $this->assertEquals([], $classes);
    }

    /**
     * @covers \WSNYC\ClassFinder\ClassFinder::findClassesSafely
     *
     * @test
     */
    public function it_finds_classes_like_normal_if_directory_exists()
    {
        $classes = ClassFinder::findClassesSafely(__DIR__ . '/Fixtures');

        $this->assertContains(DummyClassNested::class, $classes);
    }

    /**
     * @covers \WSNYC\ClassFinder\ClassFinder::findClasses
     *
     * @test
     */
    public function it_matches_all_classes_in_directory_with_specified_pattern()
    {
        $classes = ClassFinder::findClasses(__DIR__ . '/Fixtures', '*Two.php');

        $this->assertContains(DummyClassTwo::class, $classes);
        $this->assertNotContains(DummyClass::class, $classes);
    }

    /**
     * @covers \WSNYC\ClassFinder\ClassFinder::findClass
     *
     * @test
     */
    public function it_gets_fully_qualified_class_name_of_class()
    {
        $class = ClassFinder::findClass(__DIR__ . '/Fixtures/DummyClass.php');

        $this->assertEquals(DummyClass::class, $class);
    }

    /**
     * @covers \WSNYC\ClassFinder\ClassFinder::findClass
     *
     * @test
     */
    public function it_returns_null_for_non_classes()
    {
        $class = ClassFinder::findClass(__DIR__ . '/Fixtures/not_a_class.php');

        $this->assertNull($class);
    }
}
