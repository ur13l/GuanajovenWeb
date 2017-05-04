@extends('layout.app')

@section('title')
    Video
@endsection

@section('head')
    <script type="text/javascript" src="{{url('/js/video.js')}}"> </script>
@endsection

@section('cabecera')
    Video
@endsection

@section('contenedor')
    <div class="row">
        <h5>Video de activación actual</h5>

        <video style="width: 70%; margin-left:15%" controls autoplay>
            <source src="../../res/video/video.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <form id="upload_form" enctype="multipart/form-data" method="post">

            <div class="row">
                <div class="file-field input-field class col s5 offset-s3">
                    <div class="btn accent-color">
                        <span>Examinar</span>
                        <input type="file" value="EXAMINAR"  name="file1" id="file1">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text">
                    </div>
                </div>
            </div>

            <div>
                <a class="waves-effect accent-color waves-light btn col s3 offset-s4" onclick="uploadFile()"><i class="material-icons left">cloud</i>Subir video</a>
            </div>

            <div class="progress">
                <div class="determinate" style="width: 0%"></div>
            </div>
        </form>
    </div>
@endsection
