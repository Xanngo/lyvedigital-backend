<?php  
// tests/Simplex/Tests/FrameworkTest.php
namespace Simplex\Tests;

use PHPUnit\Framework\TestCase;
use App\Service\ChecklistService;

class ChecklistServiceTest extends TestCase
{
    public function testNotEnoughWords()
    {
        $checklistService = new ChecklistService(['banana'], 100);

        $content = "show message";

        $analizedContent = $checklistService->analize($content);

        $this->assertFalse($analizedContent);
    }

    public function testEnoughWords()
    {
        $checklistService = new ChecklistService(['banana', 'APPLE'], 10);

        $content = "fruits are really good for your health. You should eat at least 1 banana per day and 1 green apple.";

        $analizedContent = $checklistService->analize($content);        

        $expectedContent = [
          "content" => $content,
          "keywords used" => 2,
          "average keywords density" => 0.10
        ];
        $this->assertTrue(is_array($analizedContent));

        $this->assertArrayHasKey('content', $analizedContent);
        $this->assertEquals($analizedContent['content'], $expectedContent['content']);

        $this->assertArrayHasKey('keywords used', $analizedContent);
        $this->assertEquals($analizedContent['keywords used'], $expectedContent['keywords used']);

        $this->assertArrayHasKey('average keywords density', $analizedContent);
        $this->assertEquals($analizedContent['average keywords density'], $expectedContent['average keywords density']);
    }

    public function testEnoughWords2()
    {
        $checklistService = new ChecklistService(['banana per day', 'APPLE'], 10);

        $content = "fruits are really good for your health. You should eat at least 1 banana per day and 1 green apple.";

        $analizedContent = $checklistService->analize($content);        

        $expectedContent = [
          "content" => $content,
          "keywords used" => 2,
          "average keywords density" => 0.10
        ];
        $this->assertTrue(is_array($analizedContent));

        $this->assertArrayHasKey('content', $analizedContent);
        $this->assertEquals($analizedContent['content'], $expectedContent['content']);

        $this->assertArrayHasKey('keywords used', $analizedContent);
        $this->assertEquals($analizedContent['keywords used'], $expectedContent['keywords used']);

        $this->assertArrayHasKey('average keywords density', $analizedContent);
        $this->assertEquals($analizedContent['average keywords density'], $expectedContent['average keywords density']);
    }
}