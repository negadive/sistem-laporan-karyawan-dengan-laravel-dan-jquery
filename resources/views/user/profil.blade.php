@extends('layouts.app')

@section('title')
  Edit Profil
@endsection

@section('breadcrumb')
   @parent
   <li>user</li>
   <li>edit profil</li>
@endsection

@section('control')
    @include('layouts.control')
    <div class="control-sidebar-bg"></div>
@endsection

@section('content')     
<div class="row">
  <div class="col-xs-12">
    <div class="box">

 <form class="form form-horizontal" data-toggle="validator" method="post" enctype="multipart/form-data">
   {{ csrf_field() }} {{ method_field('PATCH') }}
   <div class="box-body">

  <div class="alert alert-info alert-dismissible" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-check"></i>
    Perubahan berhasil disimpan.
  </div>

 <div class="form-group">
    <label for="foto" class="col-md-2 control-label">Foto Profil</label>
    <div class="col-md-4">
      <input id="foto" type="file"  class="form-control" name="foto" accept=".bmp,.jpg">
      <br><div class="tampil-foto"> <img src="{{ asset('public/foto/300/'.Auth::user()->foto) }}" width="200"></div>
    </div>
  </div>

  <div class="form-group">
      <label for="passwordlama" class="col-md-2 control-label">Password Lama</label>
      <div class="col-md-6">
         <input id="passwordlama" type="password" class="form-control" name="passwordlama" autocomplete="off" value="">
         <span class="help-block with-errors"></span>
      </div>
   </div>

  <div class="form-group">
      <label for="password" class="col-md-2 control-label">Password</label>
      <div class="col-md-6">
         <input id="password" type="password" class="form-control" name="password" value="" autocomplete="off">
         <span class="help-block with-errors"></span>
      </div>
   </div>

   <div class="form-group">
      <label for="password1" class="col-md-2 control-label">Ulang Password</label>
      <div class="col-md-6">
         <input id="password1" type="password" class="form-control" data-match="#password" name="password1" autocomplete="off">
         <span class="help-block with-errors"></span>
      </div>
   </div>

  </div>
  <div class="box-footer">
    <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Simpan Perubahan1</button>
    <a  class="btn btn-success" data-toggle="control-sidebar"><i class="fa fa-gears"></i> Setting</a>
    
  </div>
</form>
    </div>
  </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
$(function(){

    $('#passwordlama').keyup(function(){
      if($(this).val() != "") $('#password, #password1').attr('required', true);
      else $('#password, #password1').attr('required', false);
    });

   $('.form').validator().on('submit', function(e){
      if(!e.isDefaultPrevented()){ 

         $.ajax({
           url : "{{ Auth::user()->id }}/change",
           type : "POST",
           data : new FormData($(".form")[0]),
           dataType: 'JSON',
           async: false,
           processData: false,
           contentType: false,
           success : function(data){
             if(data.msg == "error"){
               alert('Password lama salah!');
               $('#passwordlama').focus().select();
             }else{
               d = new Date();
               $('.alert').css('display', 'block').delay(3000).fadeOut();
               $('.tampil-foto img, .user-image, .user-header img').attr('src', data.url+'?'+d.getTime());
             }
           },
           error : function(){
             alert("Tidak dapat menyimpan data!");
           }   
         });
         return false;
     }
   });

});

</script>
@endsection