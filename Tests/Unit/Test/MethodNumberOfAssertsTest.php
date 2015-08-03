<?php

namespace MS\PHPMD\Tests\Unit\Test;

use MS\PHPMD\Rule\Test\MethodNumberOfAsserts;
use MS\PHPMD\Tests\Unit\AbstractApplyTest;

/**
 * Class MethodNumberOfAssertsTest
 *
 * @package MS\PHPMD\Tests\Unit\Test
 */
class MethodNumberOfAssertsTest extends AbstractApplyTest
{
    const CLASS_NAME = 'FooControllerTest';

    /**
     * @covers MS\PHPMD\Rule\Test\MethodNumberOfAsserts
     * @covers MS\PHPMD\Rule\Test\AbstractMethodNumberOf
     * @covers MS\PHPMD\Rule\Test\AbstractTestRule
     */
    public function testApplyNoClassNode()
    {
        $node = \Mockery::mock('PHPMD\Node\MethodNode');

        $this->assertRule($node, 0);
    }

    /**
     * @covers MS\PHPMD\Rule\Test\MethodNumberOfAsserts
     * @covers MS\PHPMD\Rule\Test\AbstractMethodNumberOf
     * @covers MS\PHPMD\Rule\Test\AbstractTestRule
     */
    public function testClassIsNoTest()
    {
        $node = \Mockery::mock('PHPMD\Node\ClassNode');
        $node->shouldReceive('getImage')->andReturn('FooController');

        $this->assertRule($node, 0);
    }

    /**
     * @covers MS\PHPMD\Rule\Test\MethodNumberOfAsserts
     * @covers MS\PHPMD\Rule\Test\AbstractMethodNumberOf
     * @covers MS\PHPMD\Rule\Test\AbstractTestRule
     */
    public function testLessAsserts()
    {
        $methodNode = $this->getMethodNode(
            self::CLASS_NAME,
            'testBar',
            ['MethodPostfix' => array_merge(
                array_fill(0, 3, $this->getNode('assertTrue')),
                array_fill(0, 5, $this->getNode('if'))
            )]
        );

        $node = \Mockery::mock('PHPMD\Node\ClassNode');
        $node->shouldReceive('getImage')->andReturn('FooControllerTest');
        $node->shouldReceive('getMethods')->andReturn([$methodNode]);

        $this->assertRule($node, 0);
    }

    /**
     * @covers MS\PHPMD\Rule\Test\MethodNumberOfAsserts
     * @covers MS\PHPMD\Rule\Test\AbstractMethodNumberOf
     * @covers MS\PHPMD\Rule\Test\AbstractTestRule
     */
    public function testMoreAsserts()
    {
        $methodNode = $this->getMethodNode(
            self::CLASS_NAME,
            'testBar',
            ['MethodPostfix' => array_fill(0, 4, $this->getNode('assertContains'))]
        );

        $node = \Mockery::mock('PHPMD\Node\ClassNode');
        $node->shouldReceive('getImage')->andReturn('FooControllerTest');
        $node->shouldReceive('getMethods')->andReturn([$methodNode]);

        $this->assertRule($node, 1);
    }

    /**
     * @return MethodNumberOfAsserts
     */
    protected function getRule()
    {
        $rule =  new MethodNumberOfAsserts();
        $rule->addProperty('number', '3');
        $rule->addProperty('names', 'assert');
        $rule->addProperty('delimiter', ',');
        $rule->addProperty('match', '0');

        return $rule;
    }
}
