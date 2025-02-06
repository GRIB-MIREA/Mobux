@extends('admin.layouts.main')

@section('content')
<style>
  .fixed-alert {
    position: fixed;
    top: 77px;
    right: 20px;
    z-index: 50;
    transition: opacity 0.5s ease-in-out;
}
</style>
@if (session('success'))
    <div id="alert" class="fixed-alert alert alert-success flex items-center p-2 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
        <span>{{ session('success') }}</span>
    </div>
    <script>
        setTimeout(() => {
            const alert = document.getElementById('alert');
            if (alert) {
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500); // Удаляем элемент после исчезновения
            }
        }, 4000); // Время в миллисекундах до исчезновения (3 секунды)
    </script>
@endif
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Баннеры</h1>
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
        <div class="col-lg-1 col-3 mb-3">
          <a href="{{ route('admin.banner.create') }}" class="btn btn-block btn-primary">Добавить</a>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Изображение</th>
                    <th colspan="3" class="text-center">Действия</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($banners as $banner)
                    <tr>
                      <td>{{ $banner->id }}</td>
                      <td><img src="{{url('storage/' . $banner->image)}}" alt="image" class="w-50"></td>
                      <td class="text-center">
                        <a href="{{route('admin.banner.show', $banner->id)}}"><i class="far fa-eye"></i></a>
                      </td>
                      <td class="text-center">
                        <a href="{{route('admin.banner.edit', $banner->id)}}" class="text-success"><i class="fas fa-pen"></i></a>
                      </td>
                      <td class="text-center">
                        <form action="{{route('admin.banner.delete', $banner->id)}}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="border-0 bg-transparent"><i class="fas fa-trash text-danger" role="button"></i></button>
                        </form>  
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          <div class="m-auto">
            {{$banners->links()}}
          </div>
        </div>
      </div>
      <!-- /.row -->
      
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
@endsection