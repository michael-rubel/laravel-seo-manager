<?php

namespace MichaelRubel\SeoManager\Composers;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\View;
use MichaelRubel\SeoManager\Exceptions\ShouldImplementSeoTagInterfaceException;
use MichaelRubel\SeoManager\Models\SeoTag;
use MichaelRubel\SeoManager\Models\SeoTagContract;

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
     * Prepare the SEO tags for the view.
     *
     * @return Collection|null
     * @throws ShouldImplementSeoTagInterfaceException
     */
    protected function getSeoTags(): ?Collection
    {
        $url = Str::start(
            request()->path(),
            '/'
        );

        $wildcardUrls = $this->wildcard($url);

        $configuredModel = config('seo-manager.model');

        $model = app(
            is_string($configuredModel) && class_exists($configuredModel)
                ? $configuredModel
                : SeoTag::class
        );

        if (! $model instanceof SeoTagContract) {
            throw new ShouldImplementSeoTagInterfaceException();
        }

        $instance = $model::firstWhere($model->getUrlColumnName(), $url);

        if (is_null($instance)) {
            $instance = $model::whereIn($model->getUrlColumnName(), $wildcardUrls)
                ->limit($this->getMaxWildcardLevels())
                ->get()
                ->sortByDesc(
                    fn ($entry) => strlen(
                        $entry->{$model->getUrlColumnName()}
                    )
                )->first();
        }

        return $instance?->{$model->getTagsColumnName()};
    }

    /**
     * Make the possible wildcards for the given path.
     *
     * @param string $url
     *
     * @return array
     */
    protected function wildcard(string $url): array
    {
        $separated = explode('/', $url);

        return collect($separated)
            ->pipe(
                fn ($parts) => $parts->map(function ($value, $key) use ($parts) {
                    $wildcard = clone $parts->reject(
                        fn ($value, $rejection) => $key < $rejection
                    )->put($key, '*');

                    return $wildcard->implode('/');
                })
            )->toArray();
    }

    /**
     * Gets the levels to limit the query.
     *
     * @return int
     */
    private function getMaxWildcardLevels(): int
    {
        $levels = config('seo-manager.max_wildcard_levels');

        return is_int($levels)
            ? $levels
            : 3;
    }
}
