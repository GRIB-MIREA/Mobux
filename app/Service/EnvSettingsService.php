<?php

namespace App\Service;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use RuntimeException;

class EnvSettingsService
{
    public function groups(): array
    {
        return [
            [
                'title' => 'Приложение',
                'icon' => 'fas fa-sliders-h',
                'description' => 'Базовые параметры сайта и режима работы.',
                'settings' => [
                    $this->text('APP_NAME', 'Название сайта', 'Отображается в конфигурации Laravel.'),
                    $this->select('APP_ENV', 'Окружение', ['local', 'staging', 'production']),
                    $this->boolean('APP_DEBUG', 'Debug-режим', 'На production должен быть выключен.'),
                    $this->url('APP_URL', 'URL сайта'),
                    $this->select('LOG_LEVEL', 'Уровень логирования', ['debug', 'info', 'notice', 'warning', 'error', 'critical']),
                ],
            ],
            [
                'title' => 'Telegram',
                'icon' => 'fab fa-telegram-plane',
                'description' => 'Бот, webhook и плавность рассылок.',
                'settings' => [
                    $this->secret('TELEGRAM_BOT_TOKEN', 'Токен бота'),
                    $this->url('TELEGRAM_WEBHOOK_URL', 'Webhook URL'),
                    $this->secret('TELEGRAM_WEBHOOK_SECRET', 'Webhook secret'),
                    $this->text('TELEGRAM_TEST_CHAT_ID', 'Тестовый chat ID'),
                    $this->number('TELEGRAM_MAILING_DELAY_SECONDS', 'Пауза между сообщениями, сек.', 0, 3600),
                ],
            ],
            [
                'title' => 'Perfluence',
                'icon' => 'fas fa-sync-alt',
                'description' => 'Автоимпорт магазинов и промокодов.',
                'settings' => [
                    $this->url('PERFLUENCE_PROMOCODE_API_URL', 'URL API промокодов'),
                    $this->secret('PERFLUENCE_PROMOCODE_API_KEY', 'API ключ'),
                ],
            ],
            [
                'title' => 'Очереди и хранилище',
                'icon' => 'fas fa-server',
                'description' => 'Параметры фоновых задач, кеша и файлов.',
                'settings' => [
                    $this->select('QUEUE_CONNECTION', 'Драйвер очередей', ['sync', 'database', 'redis']),
                    $this->select('CACHE_DRIVER', 'Драйвер кеша', ['file', 'database', 'redis', 'array']),
                    $this->select('FILESYSTEM_DISK', 'Диск файлов', ['local', 'public', 's3']),
                ],
            ],
            [
                'title' => 'Почта',
                'icon' => 'fas fa-envelope',
                'description' => 'SMTP и адрес отправителя.',
                'settings' => [
                    $this->select('MAIL_MAILER', 'Mailer', ['smtp', 'sendmail', 'log', 'array']),
                    $this->text('MAIL_HOST', 'SMTP host'),
                    $this->number('MAIL_PORT', 'SMTP port', 0, 65535),
                    $this->text('MAIL_USERNAME', 'SMTP login'),
                    $this->secret('MAIL_PASSWORD', 'SMTP password'),
                    $this->select('MAIL_ENCRYPTION', 'Шифрование', ['null', 'tls', 'ssl']),
                    $this->text('MAIL_FROM_ADDRESS', 'Email отправителя'),
                    $this->text('MAIL_FROM_NAME', 'Имя отправителя'),
                ],
            ],
        ];
    }

    public function flatSettings(): array
    {
        return collect($this->groups())
            ->flatMap(fn (array $group) => $group['settings'])
            ->keyBy('key')
            ->all();
    }

    public function currentValues(): array
    {
        $envValues = $this->readEnvValues();

        return collect($this->flatSettings())
            ->mapWithKeys(fn (array $setting, string $key) => [
                $key => Arr::get($envValues, $key, env($key, '')),
            ])
            ->all();
    }

    public function validationRules(): array
    {
        return collect($this->flatSettings())
            ->mapWithKeys(function (array $setting, string $key) {
                $rules = ['nullable'];

                if ($setting['type'] === 'select') {
                    $rules[] = 'in:' . implode(',', $setting['options']);
                } elseif ($setting['type'] === 'number') {
                    $rules[] = 'integer';
                    $rules[] = 'min:' . $setting['min'];
                    $rules[] = 'max:' . $setting['max'];
                } elseif ($setting['type'] === 'url') {
                    $rules[] = 'url';
                    $rules[] = 'max:2048';
                } else {
                    $rules[] = 'string';
                    $rules[] = 'max:4096';
                }

                return [$key => $rules];
            })
            ->all();
    }

    public function update(array $data): void
    {
        $settings = $this->flatSettings();
        $updates = [];

        foreach ($settings as $key => $setting) {
            if (!array_key_exists($key, $data)) {
                continue;
            }

            $value = $data[$key];

            if (($setting['secret'] ?? false) && ($value === null || $value === '')) {
                continue;
            }

            $updates[$key] = (string) ($value ?? '');
        }

        if ($updates === []) {
            return;
        }

        $this->writeEnvValues($updates);
        Artisan::call('config:clear');
    }

    private function readEnvValues(): array
    {
        $path = $this->envPath();

        if (!is_file($path)) {
            return [];
        }

        $values = [];
        $lines = file($path, FILE_IGNORE_NEW_LINES);

        foreach ($lines as $line) {
            $trimmed = trim($line);

            if ($trimmed === '' || Str::startsWith($trimmed, '#') || !str_contains($line, '=')) {
                continue;
            }

            [$key, $value] = explode('=', $line, 2);
            $values[trim($key)] = $this->unquoteEnvValue(trim($value));
        }

        return $values;
    }

    private function writeEnvValues(array $updates): void
    {
        $path = $this->envPath();

        if (!is_file($path) || !is_writable($path)) {
            throw new RuntimeException('Файл .env недоступен для записи.');
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES);
        $written = [];

        foreach ($lines as $index => $line) {
            if (!str_contains($line, '=')) {
                continue;
            }

            [$key] = explode('=', $line, 2);
            $key = trim($key);

            if (!array_key_exists($key, $updates)) {
                continue;
            }

            $lines[$index] = $key . '=' . $this->formatEnvValue($updates[$key]);
            $written[$key] = true;
        }

        foreach (array_diff_key($updates, $written) as $key => $value) {
            $lines[] = $key . '=' . $this->formatEnvValue($value);
        }

        file_put_contents($path, implode(PHP_EOL, $lines) . PHP_EOL, LOCK_EX);
    }

    private function envPath(): string
    {
        return base_path('.env');
    }

    private function unquoteEnvValue(string $value): string
    {
        if (
            (Str::startsWith($value, '"') && Str::endsWith($value, '"')) ||
            (Str::startsWith($value, "'") && Str::endsWith($value, "'"))
        ) {
            $value = substr($value, 1, -1);
        }

        return str_replace(['\\"', '\\\\'], ['"', '\\'], $value);
    }

    private function formatEnvValue(string $value): string
    {
        if ($value === '') {
            return '';
        }

        if (preg_match('/\s|#|"|=/', $value) === 1) {
            return '"' . str_replace(['\\', '"'], ['\\\\', '\\"'], $value) . '"';
        }

        return $value;
    }

    private function text(string $key, string $label, ?string $help = null): array
    {
        return compact('key', 'label', 'help') + ['type' => 'text'];
    }

    private function url(string $key, string $label, ?string $help = null): array
    {
        return compact('key', 'label', 'help') + ['type' => 'url'];
    }

    private function secret(string $key, string $label, ?string $help = null): array
    {
        return compact('key', 'label', 'help') + ['type' => 'password', 'secret' => true];
    }

    private function number(string $key, string $label, int $min, int $max): array
    {
        return compact('key', 'label', 'min', 'max') + ['type' => 'number'];
    }

    private function select(string $key, string $label, array $options, ?string $help = null): array
    {
        return compact('key', 'label', 'options', 'help') + ['type' => 'select'];
    }

    private function boolean(string $key, string $label, ?string $help = null): array
    {
        return $this->select($key, $label, ['true', 'false'], $help);
    }
}
