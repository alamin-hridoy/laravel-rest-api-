<?php

namespace Task\Transformers;

use Task\User;
use Task\Transformers\PostTransformer;

class UserTransformer extends \League\Fractal\TransformerAbstract {

    protected $availableIncludes = ['posts'];

    public function transform(User $user) {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'created_at' => $user->created_at->toDateTimeString()
        ];
    }

    public function includePosts(User $user) {
        return $this->collection($user->posts, new PostTransformer);
    }
}