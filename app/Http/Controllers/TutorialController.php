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
        'slug'      => str_slug($request->json('title')),
        'body'      => $request->json('body'),
      ]);

      return $tutorial;
    }

    public function update(Request $request,$id)
    {
      $this->validate($request, [
        'title' => 'required',
        'body'  => 'required',
      ]);

      $tutor = Tutorial::find($id);

      //menguji ownership
      if($request->user()->id != $tutor->user->id){
        return response()->json(['error' => 'tidak boleh mengedit tutorial ini'], 401);
      }

      $tutor->title = $request->title;
      $tutor->body = $request->body;
      $tutor->save();

      return $tutor;

    }

    public function destroy(Request $request,$id)
    {

      $tutor = Tutorial::find($id);

      //menguji ownership
      if($request->user()->id != $tutor->user->id){
        return response()->json(['error' => 'tidak boleh menghapus tutorial ini'], 401);
      }

      $tutor->delete();

      return response()->json([
        'success' => true,
        'message' => 'berhasil menghapus tutor ini'], 200
      );

    }
}
