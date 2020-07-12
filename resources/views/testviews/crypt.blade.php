@extends('testviews.index')
@section('content')

    <br>
    <div id="errors"></div>
    <div class="container">
        <form action="javascript:void(null);">
        <div class="form-group">
            <label for="cryptoTextarea">Input URL (поддерживаемые символы в токенах a-z)</label>
            <textarea class="form-control" id="cryptoTextarea" name="url" rows="4" >
                </textarea>
        </div>
        <button type="submit" class="btn btn-primary" onclick="encrypt()">Шифровать</button>
        <button type="submit" class="btn btn-primary" onclick="decrypt()">Дешифровать</button>
        </form>
        <br>
        <div class="form-group">
            <label for="cryptoTextarea">Output URL</label>
            <textarea class="form-control" id="cryptoTextarea2" name="url" rows="4" >
                </textarea>
        </div>
    </div>

@endsection

