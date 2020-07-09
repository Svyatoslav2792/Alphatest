@extends('testviews.index')
@section('content')

    <br>
    <div id="errors"></div>
    <div class="container">
        <div class="border" style="padding: 10px">
            <h3 id="id">Изменение журнала № {{$data->id}}</h3>
            <hr>
            <form id="magazineEditForm" onsubmit="editMagazine({{$data->id}})" enctype="multipart/form-data"
                  action="javascript:void(null);">
                @csrf
                @method('PUT')
                <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Название</label>
                    <div class="col-sm-10">
                        <input class="form-control" id="title" name="title" value="{{$data->title}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="description" class="col-sm-2 col-form-label">Описание</label>
                    <div class="col-sm-10">
                        <input class="form-control" id="description" name="description" value="{{$data->description}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="image" class="col-sm-2 col-form-label">Изображение</label>
                    <div class="col-sm-10">
                        <img src="/storage/img/{{ $data->image }}" width="120px" height="80px">
                        <input class='filestyle' type="file" name="image" value="{{$data->image}}"
                               data-text='Выберите изображение' data-btnClass='btn-primary'/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="authors"

                           class="col-sm-2 col-form-label">Авторы
                        </label>
                    <div class="col-sm-10">

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
                                               @if(in_array($author->id,$data->authors()->get()->pluck('id')->toArray())==true)
                                               checked
                                               @endif
                                               value="{{$author->id}}"/>{{$author->surname}} {{$author->name}}</label>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
