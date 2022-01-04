<?php

namespace MichaelRubel\SeoManager\Tests;

use MichaelRubel\SeoManager\Exceptions\ShouldImplementSeoTagInterfaceException;
use MichaelRubel\SeoManager\Tests\Stubs\FakeModel;
use MichaelRubel\SeoManager\Tests\Stubs\TestServiceProvider;

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
            'url'  => '/*',
            'tags' => json_decode('{"title":"TestStar*"}'),
        ]);

        $model::create([
            'url'  => '/test/wildcard/third',
            'tags' => json_decode('{"title":"TestTitle3"}'),
        ]);

        $model::create([
            'url'  => '/test/wildcard/*',
            'tags' => json_decode('{"title":"TestTitle4"}'),
        ]);

        app()->register(TestServiceProvider::class);
    }

    /** @test */
    public function testSeoManagerIsAvailableForView()
    {
        $view = $this->view('test-seo-manager::test-view');

        $view->assertSee('TestTitle');
    }

    /** @test */
    public function testCanGetWithNonPrefixedUrl()
    {
        $this->mockRequest('test/wildcard/third');
        $view = $this->view('test-seo-manager::test-view');
        $view->assertSee('TestTitle3');
    }

    /** @test */
    public function testWildcardIsWorkingAndPriorityIsCorrect()
    {
        $this->mockRequest('/test/wildcard/fourth');
        $view = $this->view('test-seo-manager::test-view');
        $view->assertSee('TestTitle4');
    }

    /** @test */
    public function testFindsGlobalWildcard()
    {
        $this->mockRequest('/foobar');
        $view = $this->view('test-seo-manager::test-view');
        $view->assertSee('TestStar*');
    }

    /** @test */
    public function testExplicitEntryIsPreferredOverWildcard()
    {
        // entry that exists
        $this->mockRequest('/test/wildcard/third');
        $view = $this->view('test-seo-manager::test-view');
        $view->assertSee('TestTitle3');

        // entry that goes wildcard
        $this->mockRequest('/test/wildcard/fourth');
        $view = $this->view('test-seo-manager::test-view');
        $this->assertStringContainsString('/test/wildcard/fourth', request()->path());

        // this returns the same, since the singleton is bound already
        $view->assertSee('TestTitle3');
    }

    /** @test */
    public function testCanOverrideVariableName()
    {
        config(['seo-manager.variable_name' => 'testVariable']);

        $view = $this->view('test-seo-manager::test-view');

        $view->assertSee('testVariable');
        $view->assertSee('TestTitle');
    }

    /** @test */
    public function testThrowsShouldImplementInterface()
    {
        $this->expectException(ShouldImplementSeoTagInterfaceException::class);

        config(['seo-manager.model' => FakeModel::class]);

        $this->view('test-seo-manager::test-view');
    }
}
