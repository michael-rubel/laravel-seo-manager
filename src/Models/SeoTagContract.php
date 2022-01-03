<?php

namespace MichaelRubel\SeoManager\Models;

interface SeoTagContract
{
    /**
     * @return string
     */
    public function getUrlColumnName(): string;

    /**
     * @return string
     */
    public function getTagsColumnName(): string;
}
