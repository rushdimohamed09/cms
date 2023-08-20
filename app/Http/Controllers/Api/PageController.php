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

    public function getPages(Request $request) {
        $limit = $request->input('limit', 10); // Default limit is 10 if not provided
        $offset = $request->input('offset', 0); // Default offset is 0 if not provided

        $pages = Page::skip($offset)->take($limit)->get();
        $pageCount = Page::count();

        // Modify the pages to include the link
        foreach ($pages as &$page) {
            $link = $page->slug;
            $parentId = $page->parent_id;

            // Iterate up the hierarchy to build the link
            while (!is_null($parentId)) {
                $parent = Page::find($parentId);
                if (!$parent) {
                    break;
                }
                $link = $parent->slug . '/' . $link;
                $parentId = $parent->parent_id;
            }

            $page->link = $link;
        }

        return response()->json([
            'data' => $pages,
            'count' => $pageCount,
        ]);
        return response()->json($pages);
    }

    public function getContentByLink(Request $request) {
        $link = $request->query('link');

        if (!$link) {
            return response()->json(['error' => 'Link parameter is missing'], 400);
        }

        $slugs = explode('/', $link);

        $parentId = null;

        $pages = Page::all();
        $data = $pages->toArray();

        foreach ($slugs as $slug) {
            $matchingSlug = collect($data)->first(function ($item) use ($slug, $parentId) {
                return $item['slug'] === $slug && $item['parent_id'] === $parentId;
            });

            if (!$matchingSlug) {
                return response()->json(['error' => 'Content not found'], 404);
            }

            $parentId = $matchingSlug['id'];
        }

        return response()->json(['content' => $matchingSlug]);
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
