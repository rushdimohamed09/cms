<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    public function index() {
        $pages = Page::all();
        return response()->json($pages);
    }

    public function show($id) {
        $page = Page::find($id);

        if (!$page) {
            return response()->json(['message' => 'Page not found'], 404);
        }

        return response()->json($page);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'slug' => 'required',
            'title' => 'required',
            'content' => 'required',
            'parent_id' => 'nullable|exists:pages,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $page = Page::create($request->all());

        return response()->json(['message' => 'Page created successfully', 'data' => $page], 201);
    }

    public function update(Request $request, $id) {
        $page = Page::find($id);

        if (!$page) {
            return response()->json(['message' => 'Page not found'], 404);
        }

        // Check if at least one of the fields is present in the request
        if (!$request->hasAny(['slug', 'title', 'content', 'parent_id'])) {
            return response()->json(['message' => 'No fields to update'], 400);
        }

        $validator = Validator::make($request->all(), [
            'slug' => 'sometimes|required',
            'title' => 'sometimes|required',
            'content' => 'sometimes|required',
            'parent_id' => 'sometimes|nullable|exists:pages,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $page->update($request->all());

        return response()->json(['message' => 'Page updated successfully', 'data' => $page]);
    }

    public function destroy($id) {
        $page = Page::find($id);

        if (!$page) {
            return response()->json(['message' => 'Page not found'], 404);
        }

        $page->delete();

        return response()->json(['message' => 'Page deleted successfully']);
    }
}
