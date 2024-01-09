<?php

if (!function_exists('formatDate')) {
    function formatDate($data, $format)
    {
        $date = \Carbon\Carbon::parse($data)->locale('id');

        $date->settings(['formatFunction' => 'translatedFormat']);

        return $date->format($format);
        // $date->format('l, j F Y ; h:i a'); // Selasa, 16 Maret 2021 ; 08:27 pagi
    }
}

if (!function_exists('calculateTotal')) {
    function calculateTotal($items)
    {
        $total = 0;
        
        foreach ($items as $item) {
            $total += $item['selling_price'];
        }

        return $total;
    }
}
