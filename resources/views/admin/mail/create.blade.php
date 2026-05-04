@extends('admin.layouts.main')

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Создание рассылки</h1>
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
        <div class="col-12">
          <form action="{{ route('admin.mail.send') }}" method="POST" class="w-100">
            @csrf
            <div class="form-group">
              <label>Напишите текст рассылки</label>
              <textarea
                name="message"
                rows="10"
                class="form-control"
                maxlength="4096"
                placeholder="Введите текст для Telegram. Можно использовать Markdown: *жирный*, _курсив_, [ссылка](https://example.com). HTML-теги будут удалены."
              >{{ old('message') }}</textarea>
              <small class="form-text text-muted">
                Сообщение отправляется через очередь. Для красивого форматирования используйте Markdown, а не HTML.
              </small>
              @error('message')
                <div class="text-danger">Это поле необходимо заполнить</div>
              @enderror
            </div>
            <div class="form-group">
              <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="test" name="test" value="1">
                  <label class="form-check-label" for="test">Отправить как тестовое сообщение</label>
                  @error('test')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
              </div>
            </div>
            <input type="submit" class="btn btn-primary" value="Создать рассылку">
          </form>
        </div>
      </div>
      <!-- /.row -->
      
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
@endsection
