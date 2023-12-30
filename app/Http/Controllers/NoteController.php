<?php

namespace App\Http\Controllers;

use App\Http\Resources\NoteResource;
use App\Models\NoteModel;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NoteController extends Controller
{

    protected function response($data, $message, $status)
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
        ], $status);
    }
    public function index()
    {
        return $this->response(
            NoteResource::collection(NoteModel::all()),
            'found',
            Response::HTTP_OK,
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $post = NoteModel::create($request->all());

        return $this->response(
            new NoteResource($post),
            'created',
            Response::HTTP_CREATED
        );
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $post = NoteModel::findOrFail($id);
        $post->update($request->all());

        return $this->response(
            new NoteResource($post),
            "updated",
            Response::HTTP_OK
        );
    }

    public function destroy($id)
    {

        $post = NoteModel::findOrFail($id);
        $post->delete();

        return $this->response(
            new NoteResource($post),
            "deleted",
            Response::HTTP_OK
        );
    }

    public function show($id)
    {
        $note = NoteModel::find($id);
        return $this->response(
            new NoteResource($note),
            'found',
            Response::HTTP_OK,
        );
    }

}
