<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Magazine;
use App\Author;
use Validator;
class AuthorController extends Controller
{
    public function index($sortStatus = NULL)
    {
        $authors = Author::paginate(15);
        $sort='stateInput2';
        return view('testviews.authors', compact('authors','sort'));
    }

    public
    function create()
    {
        //
    }

    public
    function store(Request $request)
    {
        $input = $request->except('_token');
        $validator = Validator::make($input, [
            'surname' => 'required|min:3',
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            $response = 'Ошибка:';
            foreach ($validator->errors()->all() as $error) {
                $response .= $error;
            }
            return response(['message' => $response]);
        }
        try {
            $author = new Author;
            $author->surname = $input['surname'];
            $author->name = $input['name'];
            $author->middlename = $input['middlename'];
            $author->save();
        } catch
        (\Throwable $e) {
            return response()->json(['error' => '']);
        }
        return response(['message' => 'Запись успешно добавлена!', 'redirect' => 1]);
    }


    public
    function show($id)
    {
        $data = Author::find($id);
        return view('testviews.edit_author', compact('data'));
    }


    public
    function edit($id)
    {
        //
    }

    public
    function update(Request $request, $id)
    {
        $input = $request->except('_token');
        $validator = Validator::make($input, [
            'surname' => 'required|min:3',
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            $response = 'Ошибка:';
            foreach ($validator->errors()->all() as $error) {
                $response .= $error;
            }
            return response(['message' => $response]);
        }
        try {
            $author = Author::find($id);
            $author->surname = $input['surname'];
            $author->name = $input['name'];
            $author->middlename = $input['middlename'];
            $author->save();

        } catch
        (\Throwable $e) {
            return response()->json(['error' => '']);
        }
        return response(['message' => 'Запись успешно отредактирована!', 'redirect' => 1]);

    }

    public
    function destroy($id)
    {
        $result = Author::where('id', $id)->delete();
        if ($result) {
            return response(['message' => 'Запись успешно удалена!', 'redirect' => 1]);
        } else {
            return response()->json(['error' => '']);
        }
    }
}

