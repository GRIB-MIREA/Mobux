@extends('admin.layouts.main')

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Промокоды</h1>
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
          <a href="{{ route('admin.promocode.create') }}" class="btn btn-block btn-primary">Добавить</a>
        </div>
        <form method="GET" action="{{ route('admin.promocode.index') }}" class="d-flex mb-4">
          <input type="text" name="search" class="form-control me-2" placeholder="Поиск" value="{{ request('search') }}">
          <button type="submit" class="btn btn-primary mx-2">Поиск</button>
        </form>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Магазин</th>
                    <th>Действует до</th>
                    <th colspan="3" class="text-center">Действия</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($promocodes as $promocode)
                    <tr>
                      <td>{{ $promocode->id }}</td>
                      <td>{{ $promocode->title }}</td>
                      <td>{{ $promocode->card->title }}</td>
                      <td>{{ Carbon\Carbon::parse($promocode->expiration_date)->translatedFormat('d F Y') }}</td>
                      <td class="text-center">
                        <a href="{{route('admin.promocode.show', $promocode->id)}}"><i class="far fa-eye"></i></a>
                      </td>
                      <td class="text-center">
                        <a href="{{route('admin.promocode.edit', $promocode->id)}}" class="text-success"><i class="fas fa-pen"></i></a>
                      </td>
                      <td class="text-center">
                        <form action="{{route('admin.promocode.delete', $promocode->id)}}" method="POST">
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
            {{$promocodes->links()}}
          </div>
        </div>
      </div>
      <!-- /.row -->
      
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
@endsection