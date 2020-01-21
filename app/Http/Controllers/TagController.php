<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function __invoke()
    {
        return Tag::all()->map(function ($tag) {
            return ['id' => $tag->id, 'name' => $tag->name];
        });
    }
}
