<?php

namespace MichaelRubel\SeoManager\Contracts;

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
