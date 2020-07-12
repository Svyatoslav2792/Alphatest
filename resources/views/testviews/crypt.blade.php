@extends('testviews.index')
@section('content')

    <br>
    <div id="errors"></div>
    <div class="container">

        <div class="form-group">
            <label for="cryptoTextarea">URL</label>
            <textarea class="form-control" id="cryptoTextarea" name="url" rows="4">http://google.com?gclid={gclid}&placement={placement}&adposition={adposition}&campid={campaignid}&device={device}&devicemodel={devicemodel}&creative={creative}&adid={adid}&target={targetid}&keyword={keyword}&matchtype={matchtype}
                </textarea>
        </div>
        <button type="submit" class="btn btn-primary" onclick="encrypt()">Шифровать</button>
        <button type="submit" class="btn btn-primary" onclick="decrypt()">Дешифровать</button>


    </div>

@endsection

