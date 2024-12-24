@extends('admin.layouts.main')

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6 d-flex align-items-center">
          <h1 class="m-0 mr-2">{{ $card->title }}</h1>
          <a href="{{route('admin.card.edit', $card->id)}}"><i class="fas fa-pen"></i></a>
          <form action="{{route('admin.card.delete', $card->id)}}" method="POST">
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
        <div class="col-6">
          <div class="card">
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap">
                <tbody>
                    <tr>
                      <td>ID</td>
                      <td>{{ $card->id }}</td>
                    </tr>
                    <tr>
                      <td>Название магазина</td>
                      <td>{{ $card->title }}</td>
                    </tr>
                    <tr>
                      <td>Описание магазина</td>
                      <td>{{ $card->description }}</td>
                    </tr>
                    <tr>
                      <td>Изображение</td>
                      <td><img src="{{url('storage/' . $card->image)}}" alt="image" class="w-50"></td>
                    </tr>
                    <tr>
                      <td>Правила акции</td>
                      <td>{{ $card->rules }}</td>
                    </tr>
                    <tr>
                      <td>Промокод</td>
                      <td>{{ $card->promocode }}</td>
                    </tr>
                    <tr>
                      <td>Награда</td>
                      <td>{{ $card->reward }}</td>
                    </tr>
                    <tr>
                      <td>Ссылка</td>
                      <td>{{ $card->link }}</td>
                    </tr>
                    <tr>
                      <td>Позиция</td>
                      <td>{{ $card->position }}</td>
                    </tr>
                    <tr>
                      <td>Пометка</td>
                      <td>{{ $card->stamp }}</td>
                    </tr>
                    <tr>
                      <td>Категория</td>
                      <td>{{ $card->category->title }}</td>
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