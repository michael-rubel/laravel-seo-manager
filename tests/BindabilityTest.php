<?php

namespace MichaelRubel\SeoManager\Tests;

use Illuminate\View\ViewException;
use MichaelRubel\SeoManager\Models\SeoTag;
use MichaelRubel\SeoManager\Tests\Stubs\TestServiceProvider;

class BindabilityTest extends TestCase
{
    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        SeoTag::create([
            'url'  => '/',
            'tags' => json_decode('{"title":"TestTitle"}'),
        ]);

        app()->register(TestServiceProvider::class);
    }

    /** @test */
    public function testCanBindUrlColumnNameMethod()
    {
        $this->expectException(ViewException::class);

        bind(SeoTag::class)->method('getUrlColumnName', function ($model) {
            return $model->getUrlColumnName() . '_applied_wrong_column_name';
        });

        $view = $this->view('test-seo-manager::test-view');

        $view->assertSee('TestTitle');
    }

    /** @test */
    public function testCanBindTagsColumnNameMethod()
    {
        $this->expectException(ViewException::class);

        bind(SeoTag::class)->method('getTagsColumnName', function ($model) {
            return $model->getTagsColumnName() . '_applied_wrong_column_name';
        });

        $view = $this->view('test-seo-manager::test-view');

        $view->assertSee('TestTitle');
    }
}
