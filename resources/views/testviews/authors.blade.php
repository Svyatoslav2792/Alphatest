@extends('testviews.index')
@section('content')

    <br>
    <div id="errors"></div>
    <div class="container">
        <table class="table" id="authorTable">
            <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">
                    <div>
                        Фамилия
                        <input type="checkbox" id="stateInput" onclick="sortTable(0)">
                        <label for="stateInput" class="arrows" style="margin: auto"></label>
                    </div>
                </th>

                <th scope="col">Имя</th>
                <th scope="col">Отчество</th>
                <th scope="col">Журналы</th>
                <th scope="col">Действие</th>
            </tr>
            </thead>
            <tbody>
            @foreach($authors as $author)
                <tr>
                    <th scope="row">{{$author->id}}</th>
                    <td>{{$author->surname}}</td>
                    <td>{{$author->name}}</td>
                    <td>{{$author->middlename}}</td>
                    {{--<td>{{$author->magazines()->pluck('title')->implode(', ')}}</td>--}}
                    <td>
                        @if($author->magazines()->first()!=null)

                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle"
                                        style="background-color: white; border: white; color: black" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                    Просмотреть журналы
                                </button>
                                {{--{{dd($author->magazines()->pluck('title'))}}--}}

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @foreach($author->magazines()->get() as $magazine)
                                        <a class="dropdown-item"
                                           href="/magazine/{{$magazine->id}}">{{$magazine->title}}</a>
                                    @endforeach
                                </div>

                            </div>
                        @else
                            <div class="dropdown">
                                <div class="btn btn-secondary"
                                     style="background-color: white; border: white; color: red" type="button"
                                     id="dropdownMenuButton" aria-haspopup="true"
                                     aria-expanded="false">
                                    У автора нет журналов
                                </div>
                            </div>
                        @endif
                    </td>
                    <td><a href="author/{{$author->id}}">Редактировать </a>/
                        <a href="#" onclick="deleteAuthor({{$author->id}})">Удалить</a>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
        <table class="table">

            <tbody>
            <tr>
                <th scope="row">Add</th>
                <form id="authorAddForm" onsubmit="addAuthor()" enctype="multipart/form-data"
                      action="javascript:void(null);">
                    @csrf
                    @method('POST')
                    <td><input class="form-control" id="surname" name="surname" placeholder="Фамилия"></td>
                    <td><input class="form-control" id=name" name="name" placeholder="Имя"></td>
                    <td><input class="form-control" id="middlename" name="middlename" placeholder="Отчество"></td>
                    <td>
                        <button type="submit" class="btn btn-primary">Добавить</button>
                    </td>
                </form>

            </tr>
            </tbody>
        </table>
        {{$authors->links()}}
    </div>

@endsection

