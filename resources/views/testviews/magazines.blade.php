@extends('testviews.index')
@section('content')

    <br>
    <div id="errors"></div>
    <div class="container">
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Название</th>
                <th scope="col">Описание</th>
                <th scope="col">Изображение</th>
                <th scope="col">Дата создания</th>
                <th scope="col">Авторы</th>
                <th scope="col">Действие</th>
            </tr>
            </thead>
            <tbody>
            @foreach($magazines as $magazine)
                <tr>
                    <th scope="row">{{$magazine->id}}</th>
                    <td>{{$magazine->title}}</td>
                    <td>{{$magazine->description}}</td>
                    <td><img src="/storage/img/{{ $magazine->image }}" width="120px" height="80px"></td>
                    <td>{{$magazine->created_at}}</td>
                    <td>{{$magazine->authors()->pluck('surname')->implode(', ')}}</td>
                    <td><a href="magazine/{{$magazine->id}}">Редактировать </a>/
                        <a href="#" onclick="deleteMagazine({{$magazine->id}})">Удалить</a>
                    </td>
                </tr>
            @endforeach

            <tr>
                <th scope="row">Add</th>

                <form id="magazineAddForm" onsubmit="addMagazine()" enctype="multipart/form-data"
                      action="javascript:void(null);">
                    @csrf
                    @method('POST')
                    <td><input class="form-control" id="title" name="title" placeholder="Введите название"></td>
                    <td><input class="form-control" id="description" name="description" placeholder="Введите описание">
                    </td>
                    <td><input class='filestyle' type="file" name="image" data-placeholder="Изображение не выбрано"
                               data-text='Выберите изображение' data-btnClass='btn-primary'/></td>
                    <td></td>
                    <td>

                        <div class="multiselect">
                            <div class="selectBox" onclick="showCheckboxes()">
                                <select>
                                    <option>Выберите автора</option>
                                </select>
                                <div class="overSelect"></div>
                            </div>
                            <div id="checkboxes">
                                @foreach($authors as $author)
                                    <label for="{{$author->id}}">
                                        <input type="checkbox" name="authors[]" id="{{$author->id}}"
                                               value="{{$author->id}}"/>{{$author->surname}}</label>
                                @endforeach
                            </div>
                        </div>


                    </td>
                    <td>
                        <button type="submit" class="btn btn-primary">Добавить</button>
                    </td>
                </form>

            </tr>
            </tbody>
        </table>
        {{$magazines->links()}}
    </div>

@endsection

