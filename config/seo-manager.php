<?php

return [

    /*
     *--------------------------------------------------------------------------
     * SEO Manager Configuration
     *--------------------------------------------------------------------------
     *
     * Model to use by the package.
     *
     */

    'model' => \MichaelRubel\SeoManager\Models\SeoTag::class,

    /*
     * Variable you expect in the views.
     */

    'variable_name' => 'seo_manager',

    /*
     * Defines how deep the package will look at the wildcards.
     *
     * Default: 3 is optimal value for most use cases.
     *
     * This will serve three levels:
     * - /*
     * - /url/*
     * - /url/next-part/*
     *
     * If you need to go even further, you can raise this parameter
     * but be careful, since it can affect performance.
     */

    'max_wildcard_levels' => 3,

];
