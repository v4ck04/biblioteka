<?php

/**
 * Serbian pluralization helpers.
 *
 * pluralizeSr(int $n, array $forms): string
 *   $forms = [singular (1, 21…), paucal (2–4, 22–24…), plural (0, 5–20…)]
 *   Examples:
 *     pluralizeSr(1,  ['dan',      'dana',     'dana'     ]) → "1 dan"
 *     pluralizeSr(21, ['dan',      'dana',     'dana'     ]) → "21 dan"
 *     pluralizeSr(3,  ['dan',      'dana',     'dana'     ]) → "3 dana"
 *     pluralizeSr(11, ['dan',      'dana',     'dana'     ]) → "11 dana"
 *     pluralizeSr(2,  ['primerak', 'primerka', 'primeraka']) → "2 primerka"
 *     pluralizeSr(5,  ['zahtev',   'zahteva',  'zahteva'  ]) → "5 zahteva"
 */
if (! function_exists('pluralizeSr')) {
    function pluralizeSr(int $n, array $forms): string
    {
        $abs    = abs($n);
        $mod100 = $abs % 100;
        $mod10  = $abs % 10;

        // 11–14 are always plural (the "teen" exception: 11, 12, 13, 14)
        if ($mod100 >= 11 && $mod100 <= 14) {
            $word = $forms[2];
        } elseif ($mod10 === 1) {
            $word = $forms[0]; // 1, 21, 31, 101…
        } elseif ($mod10 >= 2 && $mod10 <= 4) {
            $word = $forms[1]; // 2–4, 22–24, 32–34…
        } else {
            $word = $forms[2]; // 0, 5–20, 25–30…
        }

        return $n . ' ' . $word;
    }
}

if (! function_exists('pluralizeDan')) {
    function pluralizeDan(int $n): string
    {
        return pluralizeSr($n, ['dan', 'dana', 'dana']);
    }
}
