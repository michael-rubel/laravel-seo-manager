<?php

declare(strict_types=1);

namespace MichaelRubel\SeoManager\Composers;

use Illuminate\Support\Str;
use Illuminate\View\View;
use MichaelRubel\EnhancedContainer\Call;
use MichaelRubel\SeoManager\Contracts\SeoTagContract;
use MichaelRubel\SeoManager\Exceptions\ShouldImplementSeoTagInterfaceException;
use MichaelRubel\SeoManager\Models\SeoTag;

class SeoComposer
{
    /**
     * SeoComposer constructor.
     *
     * @throws ShouldImplementSeoTagInterfaceException
     */
    public function __construct(protected mixed $seo_manager = null)
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
     * @return mixed
     * @throws ShouldImplementSeoTagInterfaceException
     */
    protected function getSeoTags(): mixed
    {
        $model = call(
            config('seo-manager.model', SeoTag::class)
        );

        if (! $model->getInternal(Call::INSTANCE) instanceof SeoTagContract) {
            throw new ShouldImplementSeoTagInterfaceException();
        }

        $nonPrefixedUrl = request()->path();
        $url = Str::start($nonPrefixedUrl, '/');

        $instance = $model->where($model->getUrlColumnName(), $url)
            ->orWhere($model->getUrlColumnName(), $nonPrefixedUrl)
            ->first();

        if (is_null($instance)) {
            $instance = $model->whereIn($model->getUrlColumnName(), $this->wildcard($url))
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
     * @return mixed
     */
    private function getMaxWildcardLevels(): mixed
    {
        return config('seo-manager.max_wildcard_levels', 3);
    }
}
