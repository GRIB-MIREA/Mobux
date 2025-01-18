@extends('admin.layouts.main')

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6 d-flex align-items-center">
          <h1 class="m-0 mr-2">Баннер, ID: {{ $banner->id }}</h1>
          <a href="{{route('admin.banner.edit', $banner->id)}}"><i class="fas fa-pen"></i></a>
          <form action="{{route('admin.banner.delete', $banner->id)}}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="border-0 bg-transparent"><i class="fas fa-trash text-danger" role="button"></i></button>
          </form>  
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body table-responsive p-0">
              <table class="table table-hover">
                <tbody>
                    <tr>
                      <td>ID</td>
                      <td>{{ $banner->id }}</td>
                    </tr>
                    <tr>
                      <td>Изображение</td>
                      <td><img src="{{url('storage/' . $banner->image)}}" alt="image" class="w-50"></td>
                    </tr>
                    <tr>
                      <td>Ссылка</td>
                      <td>{{ $banner->link }}</td>
                    </tr>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
        </div>
      </div>
      <!-- /.row -->
      
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
@endsection