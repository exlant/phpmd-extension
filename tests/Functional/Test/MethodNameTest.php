<?php

namespace MS\PHPMD\Tests\Functional\Test;

use MS\PHPMD\Tests\Functional\AbstractProcessTest;

class MethodNameTest extends AbstractProcessTest
{
    public function testMethodNameUnderstandableRule()
    {
        $output = $this
            ->runPhpmd('Tests/Test.php', 'test.xml')
            ->getOutput();

        $this->assertNotContains('Test.php:13', $output);
        $this->assertNotContains('Test.php:25', $output);

        $this->assertContains('Test.php:37	Only 1 words are found in the method name. Try to describe your code as good as you can with 3 or more words.', $output);
        $this->assertContains('Test.php:52	Only 1 words are found in the method name. Try to describe your code as good as you can with 3 or more words.', $output);
    }
}