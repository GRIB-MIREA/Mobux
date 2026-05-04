@extends('admin.layouts.main')

@section('content')
<style>
  .settings-help {
    color: #6c757d;
    font-size: .875rem;
  }
  .settings-key {
    color: #6c757d;
    font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
    font-size: .78rem;
  }
  .settings-secret-note {
    min-height: 21px;
  }
</style>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-8">
          <h1 class="m-0">Настройки проекта</h1>
        </div>
        <div class="col-sm-4">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Админ-панель</a></li>
            <li class="breadcrumb-item active">Настройки</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="icon fas fa-check"></i>
          {{ session('success') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @endif

      @if ($errors->any())
        <div class="alert alert-danger">
          <i class="icon fas fa-exclamation-triangle"></i>
          Проверьте значения в форме.
          @error('settings')
            <div>{{ $message }}</div>
          @enderror
        </div>
      @endif

      <div class="callout callout-warning">
        <h5>Редактируются только безопасные ключи</h5>
        <p class="mb-0">
          Критичные параметры вроде <code>APP_KEY</code>, <code>DB_PASSWORD</code> и доступов к Redis/AWS не выводятся в админке.
          Секретные поля оставьте пустыми, если текущее значение менять не нужно.
        </p>
      </div>

      <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="row">
          @foreach ($groups as $group)
            <div class="col-xl-6">
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h3 class="card-title">
                    <i class="{{ $group['icon'] }} mr-2"></i>
                    {{ $group['title'] }}
                  </h3>
                </div>
                <div class="card-body">
                  <p class="settings-help mb-4">{{ $group['description'] }}</p>

                  @foreach ($group['settings'] as $setting)
                    @php
                      $key = $setting['key'];
                      $value = old($key, $values[$key] ?? '');
                      $hasError = $errors->has($key);
                    @endphp

                    <div class="form-group">
                      <label for="{{ $key }}" class="mb-1">{{ $setting['label'] }}</label>
                      <div class="settings-key mb-2">{{ $key }}</div>

                      @if ($setting['type'] === 'select')
                        <select
                          name="{{ $key }}"
                          id="{{ $key }}"
                          class="form-control select2 @if($hasError) is-invalid @endif"
                          style="width: 100%;"
                        >
                          @foreach ($setting['options'] as $option)
                            <option value="{{ $option }}" @selected((string) $value === (string) $option)>{{ $option }}</option>
                          @endforeach
                        </select>
                      @else
                        <input
                          type="{{ $setting['type'] }}"
                          name="{{ $key }}"
                          id="{{ $key }}"
                          class="form-control @if($hasError) is-invalid @endif"
                          value="{{ ($setting['secret'] ?? false) ? '' : $value }}"
                          @if(($setting['secret'] ?? false)) placeholder="Оставьте пустым, чтобы не менять" autocomplete="new-password" @endif
                          @if($setting['type'] === 'number') min="{{ $setting['min'] }}" max="{{ $setting['max'] }}" @endif
                        >
                      @endif

                      @error($key)
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                      @enderror

                      @if (($setting['secret'] ?? false) && !empty($values[$key]))
                        <div class="settings-help settings-secret-note mt-1">
                          Текущее значение сохранено и скрыто.
                        </div>
                      @elseif (!empty($setting['help']))
                        <div class="settings-help mt-1">{{ $setting['help'] }}</div>
                      @endif
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <div class="card">
          <div class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-between">
            <div class="settings-help mb-3 mb-md-0">
              После сохранения Laravel очистит кеш конфигурации, чтобы новые значения применились сразу.
            </div>
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save mr-1"></i>
              Сохранить настройки
            </button>
          </div>
        </div>
      </form>
    </div>
  </section>
</div>
@endsection
