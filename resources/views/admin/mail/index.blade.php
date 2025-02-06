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
          <h1 class="m-0">Рассылки</h1>
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
        <div class="col-lg-2 col-6 mb-3">
          <a href="{{ route('admin.mail.create') }}" class="btn btn-block btn-primary">Создать рассылку</a>
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
                    <th>Текст рассылки</th>
                    <th>Количество получателей</th>
                    <th>Дата рассылки</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($mailing_histories as $mailing_history)
                    <tr>
                      <td>{{ $mailing_history->id }}</td>
                      <td>{!! $mailing_history->message !!}</td>
                      <td>{{ $mailing_history->recipients_count }}</td>
                      <td>{{ $mailing_history->created_at }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          <div class="m-auto">
            {{$mailing_histories->links()}}
          </div>
        </div>
      </div>
      <!-- /.row -->
      
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
@endsection