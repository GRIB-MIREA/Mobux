<?php

if (!function_exists('truncate_text')) {
    /**
     * Сокращает текст до указанного количества слов.
     *
     * @param string $text Исходный текст.
     * @param int $wordLimit Максимальное количество слов.
     * @return string Сокращенный текст.
     */
    function truncate_text($text, $wordLimit) {
        $words = explode(' ', $text);
        if (count($words) > $wordLimit) {
            return implode(' ', array_slice($words, 0, $wordLimit)) . '...';
        }
        return $text;
    }
}