<?php

use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

if (!function_exists('formatDate')) {
    function formatDate(string $date, string $fromFormat = 'Y-m-d', $toFormat = 'd/m/Y'): string
    {
        $data = Carbon::createFromFormat($fromFormat, $date);
        return $data->format($toFormat);
    }
}

if (!function_exists('formatToBRDate')) {
    function formatToFullBRDate(string $date, string $fromFormat = 'Y-m-d', $toFormat = 'd/m/Y'): string
    {
        return formatDate($date, 'Y-m-d H:i:s', 'd/m/Y H:i:s');
    }
}

if (!function_exists('removeSpaces')) {
    function removeSpaces(string $string): string
    {
        return str_replace(' ', '', $string);
    }
}


if (!function_exists('onlyNumbers')) {
    function onlyNumbers(string $value): string
    {
        $locale = 'pt_BR'; // Specify the desired locale
        $currencyCode = 'BRL'; // Specify the desired locale
        $formatter = numfmt_create($locale, \NumberFormatter::CURRENCY); // Create a NumberFormatter for the specified locale
        $numericValue = numfmt_parse_currency($formatter, $value, $currencyCode); // Parse the currency string

        return $numericValue; // Converte o val
    }
}


