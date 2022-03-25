<?php

namespace App\Services;

use App\Models\Node;

class NodeService
{
    public function store(array $attributes)
    {
        $node = new Node();
        $node->name = $attributes['name'];
        $node->type = $attributes['type'];
        $node->parent_id = $attributes['parent_id'];
        $node->model = $attributes['model'] ?? null;
        $node->save();
    }
}
