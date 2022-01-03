<?php

namespace MichaelRubel\SeoManager\Composers;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\View;
use MichaelRubel\SeoManager\Models\SeoTag;

class SeoComposer
{
    /**
     * @var Collection|null
     */
    protected ?Collection $seo_manager;

    /**
     * SeoComposer constructor.
     */
    public function __construct()
    {
        $this->seo_manager = $this->getSeoTags();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view): void
    {
        $variable = config('seo-manager.variable_name');

        $view->with(
            is_string($variable)
                ? $variable
                : 'seo_manager',
            $this->seo_manager
        );
    }

    /**
     * @return Collection|null
     */
    protected function getSeoTags(): ?Collection
    {
        $url = Str::start(
            request()->path(),
            '/'
        );

        $wildcardUrl = $this->wildcard($url);

        $configuredModel = config('seo-manager.model');

        $model = app(
            is_string($configuredModel) && class_exists($configuredModel)
                ? $configuredModel
                : SeoTag::class
        );

        return $model::where('url', $url)
            ->orWhere('url', $wildcardUrl)
            ->first()
            ?->tags;
    }

    /**
     * @param string $url
     *
     * @return string
     */
    protected function wildcard(string $url): string
    {
        $array = explode('/', $url);

        array_pop($array);
        array_push($array, '*');

        return implode('/', $array);
    }
}
