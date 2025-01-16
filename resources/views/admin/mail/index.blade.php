@extends('admin.layouts.main')

@section('content')
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
                      <td>{{ $mailing_history->message }}</td>
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