<?php

namespace Sourceboat\LaravelClockifyApi\Reports\Traits;

trait HasTags
{

    protected $tagIds = null;

    protected $tagsContainedInTimeentry = 'CONTAINS';

    public function containsTags(array $tagIds)
    {
        $this->tagIds = $tagIds;
        $this->tagsContainedInTimeentry = 'CONTAINS';
        return $this;
    }

    public function containsOnlyTags(array $tagIds)
    {
        $this->tagIds = $tagIds;
        $this->tagsContainedInTimeentry = 'CONTAINS_ONLY';
        return $this;
    }

    public function doesNotContainTags(array $tagIds)
    {
        $this->tagIds = $tagIds;
        $this->tagsContainedInTimeentry = 'DOES_NOT_CONTAIN';
        return $this;
    }

}
