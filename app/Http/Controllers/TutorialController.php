<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tutorial;

class TutorialController extends Controller
{

    public function index(Request $request)
    {
      return Tutorial::all();
    }

    public function show($id)
    {
      $tutorial = Tutorial::find($id);

      if(!$tutorial)
      return response()->json(['error' => ' id Data tidak ditemukan'], 404);

      return $tutorial;
    }

    public function store(Request $request)
    {
      $this->validate($request, [
        'title' => 'required',
        'body'  => 'required',
      ]);

      $tutorial = $request->user()->tutorials()->create([
        'title'     => $request->json('title'),
        'slug'      => str_slug($request->json('slug ')),
        'body'      => $request->json('body'),
      ]);

      return $tutorial;
    }
}
