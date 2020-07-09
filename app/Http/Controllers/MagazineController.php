<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Magazine;
use App\Author;
use Validator;

class MagazineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $magazines = Magazine::paginate(15);
        $authors = Author::all();
        return view('testviews.magazines', compact('magazines', 'authors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->except('_token');
        if ($request->hasFile('image')) {
            $validator = Validator::make($request->all(), [
                'image' => 'mimes:png,jpeg|file|max:2000',
            ]);
            if ($validator->fails()) {
                $response = 'Ошибка:';
                foreach ($validator->errors()->all() as $error) {
                    $response .= $error;
                }
                return response(['message' => $response]);
            }
            $file = $request->file('image');
            $input['image'] = $file->getClientOriginalName();
            $file->move(public_path() . '/storage/img', $input['image']);
        }
        $validator = Validator::make($input, [
            'title' => 'required',
            'image' => 'required|unique:magazines',
            'authors' => 'required'
        ]);
        if ($validator->fails()) {
            $response = 'Ошибка:';
            foreach ($validator->errors()->all() as $error) {
                $response .= $error;
            }
            return response(['message' => $response]);
        }
        try {
            $magazine = new Magazine;
            $magazine->image = $input['image'];
            $magazine->title = $input['title'];
            $magazine->description = $input['description'];
            $magazine->save();
            if ($input['authors']) {
                $magazine->authors()->attach($input['authors']);
            }
        } catch
        (\Throwable $e) {
            return response()->json(['error' => '']);
        }
        return response(['message' => 'Запись успешно добавлена!', 'redirect' => 1]);
    }


    public function show($id)
    {
        $data = Magazine::find($id);
        $authors = Author::all();
        return view('testviews.edit_magazine', compact('data', 'authors'));
    }


    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $input = $request->except('_token');
        if ($request->hasFile('image')) {
            $validator = Validator::make($request->all(), [
                'image' => 'mimes:png,jpeg|file|max:2000',
            ]);
            if ($validator->fails()) {
                $response = 'Ошибка:';
                foreach ($validator->errors()->all() as $error) {
                    $response .= $error;
                }
                return response(['message' => $response]);
            }
            $file = $request->file('image');
            $input['image'] = $file->getClientOriginalName();
            $file->move(public_path() . '/storage/img', $input['image']);

            $validator = Validator::make($input, [
                'title' => 'required',
                'image' => 'required|unique:magazines',
                'authors' => 'required'
            ]);

        } else {
            $validator = Validator::make($input, [
                'title' => 'required',
                'authors' => 'required'
            ]);
        }
        if ($validator->fails()) {
            $response = 'Ошибка:';
            foreach ($validator->errors()->all() as $error) {
                $response .= $error;
            }
            return response(['message' => $response]);
        }
        try {
            $magazine = Magazine::find($id);
            if ($request->hasFile('image')) {
                $magazine->image = $input['image'];
            }
            $magazine->title = $input['title'];
            $magazine->description = $input['description'];
            $magazine->save();
            if ($input['authors']) {
                $magazine->authors()->detach();
                $magazine->authors()->attach($input['authors']);
            }
        } catch
        (\Throwable $e) {
            return response()->json(['error' => '']);
        }
        return response(['message' => 'Запись успешно отредактирована!', 'redirect' => 1]);
    }

    public
    function destroy($id)
    {
        $result = Magazine::where('id', $id)->delete();
        if ($result) {
            return response(['message' => 'Запись успешно удалена!', 'redirect' => 1]);
        } else {
            return response()->json(['error' => '']);
        }
    }
}
