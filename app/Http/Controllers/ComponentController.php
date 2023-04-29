<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComponentController\Search;
use App\Http\Requests\ComponentController\Store;
use App\Http\Resources\ComponentResource;
use App\Models\Component;
use App\Models\Interaction;

class ComponentController extends Controller
{
    public function popular()
    {
        $components = Component::query()
        ->with('user')
        ->orderByRaw('upvotes - downvotes DESC')
        ->paginate(15);

        return ComponentResource::collection($components);
    }

    public function newest()
    {
        $components = Component::query()->with('user')->orderByDesc('created_at')->paginate(15);

        return ComponentResource::collection($components);
    }

    public function search(Search $request)
    {
        $components = Component::query()
            ->where(function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->input('needle')}%")
                    ->orWhere('description', 'like', "%{$request->input('needle')}%");
            })
            ->when($request->input('front_end_type'), function ($query) use ($request) {
                $query->where('front_end_type', $request->input('front_end_type'));
            })
            ->when($request->input('style_type'), function ($query) use ($request) {
                $query->where('style_type', $request->input('style_type'));
            })
            ->when($request->input('order') === 'popular', function ($query) {
                $query->orderByRaw('upvotes - downvotes DESC');
            })
            ->when($request->input('order') === 'newest', function ($query) {
                $query->orderByDesc('created_at');
            })
            ->with('user')
            ->paginate(15);

        return ComponentResource::collection($components);
    }

    public function show(Component $component)
    {
        return ComponentResource::make($component);
    }

    public function store(Store $request)
    {
        $component = auth()->user()->components()->create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'front_end_type' => $request->input('front_end_type'),
            'style_type' => $request->input('style_type'),
            'image' => $request->file('image')->storePublicly('components', ['disk' => 'public']),
            'code' => $request->input('code'),
            'upvotes' => 0,
            'downvotes' => 0,
        ]);

        $component->load('user');

        return ComponentResource::make($component);
    }

    public function upvote(Component $component)
{
    $user = auth()->user();

    $existingVote = Interaction::where('component_id', $component->id)
                                  ->where('user_id', $user->id)
                                  ->first();

    if ($existingVote) {
        if ($existingVote->type === 'upvote') {
            $existingVote->delete();
            $component->decrement('upvotes');
        } else {
            $existingVote->update([
                'type' => 'upvote',
            ]);

            $component->increment('upvotes');
            $component->decrement('downvotes');
        }

        $component->load('user');
    
        return ComponentResource::make($component);
    }
    else{
        $component->increment('upvotes');

        Interaction::create([
            'component_id' => $component->id,
            'user_id' => $user->id,
            'type' => 'upvote',
        ]);
    
        $component->load('user');
    
        return ComponentResource::make($component);
    }
}

    public function downvote(Component $component)
    {
        $user = auth()->user();

    $existingVote = Interaction::where('component_id', $component->id)
                                  ->where('user_id', $user->id)
                                  ->first();

    if ($existingVote) {
        if ($existingVote->type === 'downvote') {
            $existingVote->delete();
            $component->decrement('downvotes');
        } else {
            $existingVote->update([
                'type' => 'downvote',
            ]);

            $component->increment('downvotes');
            $component->decrement('upvotes');
        }

        $component->load('user');
    
        return ComponentResource::make($component);
    }
    else{
        $component->increment('downvotes');

        Interaction::create([
            'component_id' => $component->id,
            'user_id' => $user->id,
            'type' => 'downvote',
        ]);
    
        $component->load('user');
    
        return ComponentResource::make($component);
    }
    }
}
