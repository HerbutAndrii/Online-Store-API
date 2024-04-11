<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;

class TagController extends Controller
{
    public function index() {
        $tags = Tag::orderByDesc('updated_at')->get();

        return TagResource::collection($tags);
    }

    public function store(StoreTagRequest $request) {
        $tag = new Tag($request->validated());
        $tag->user()->associate($request->user());
        $tag->save();

        return response()->json([
            'message' => 'Tag was created successfully',
            'tag' => new TagResource($tag)
        ]);
    }

    public function update(UpdateTagRequest $request, Tag $tag) {
        $this->authorize('update', $tag);

        $tag->update(['name' => $request->name ?? $tag->name]);

        return response()->json([
            'message' => 'Tag was updated successfully',
            'tag' => new TagResource($tag)
        ]);
    }

    public function destroy(Tag $tag) {
        $this->authorize('delete', $tag);
        
        $tag->delete();

        return response()->json(['message' => 'Tag was deleted successfully']);
    }
}
