<?php

/**
 * It gets relationship data and return just ids
 * @param array $relationWithIds
 * @return array
 */
function pluckIds(array $relationWithIds): array
{
    return collect($relationWithIds)->pluck('id')->toArray();
}
