<?php

namespace MichaelRubel\SeoManager\Tests;

class SeoManagerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $model = config('seo-manager.model');

        $model::create([
            'url'  => '/',
            'tags' => json_decode('{"title":"TestTitle"}'),
        ]);

        $model::create([
            'url'  => '/test/second',
            'tags' => json_decode('{"title":"TestTitle2"}'),
        ]);

        $model::create([
            'url'  => '/test/wildcard/third',
            'tags' => json_decode('{"title":"TestTitle3"}'),
        ]);

        $model::create([
            'url'  => '/test/wildcard/*',
            'tags' => json_decode('{"title":"TestTitle4"}'),
        ]);
    }

    /** @test */
    public function testViewHasSeoManagerVariable()
    {
        $view = $this->view('seo-manager::test-view');

        $view->assertSee('TestTitle');
    }

    /** @test */
    public function testViewWithMockedUrl()
    {
        $this->mockRequest('/test/second');

        $view = $this->view('seo-manager::test-view');

        $view->assertSee('TestTitle2');
    }

    /** @test */
    public function testExplicitEntryIsPreferredOverWildcard()
    {
        // entry that exists
        $this->mockRequest('/test/wildcard/third');
        $view = $this->view('seo-manager::test-view');
        $view->assertSee('TestTitle3');

        // entry that goes wildcard
        $this->mockRequest('/test/wildcard/fourth');
        $view = $this->view('seo-manager::test-view');
        $this->assertStringContainsString('/test/wildcard/fourth', request()->path());

        // this returns the same, since the singleton is bound already
        $view->assertSee('TestTitle3');
    }

    /** @test */
    public function testWildcardIsWorking()
    {
        $this->mockRequest('/test/wildcard/fourth');
        $view = $this->view('seo-manager::test-view');
        $view->assertSee('TestTitle4');
    }
}
