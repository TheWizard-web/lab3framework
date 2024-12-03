<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NoRestrictedWords implements ValidationRule
{
    // Lista de cuvinte interzise
    protected $restrictedWords = ['lorem', 'voluptate', 'velit'];

    /**
     * Validează dacă valoarea conține cuvinte interzise.
     *
     * @param string $attribute
     * @param mixed $value
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Parcurge lista de cuvinte interzise și verifică dacă vreunul apare în valoare
        foreach ($this->restrictedWords as $word) {
            if (stripos($value, $word) !== false) { // Verifică dacă $word există în $value (case-insensitive)
                $fail("Câmpul $attribute conține cuvântul interzis: $word.");
                return; // Oprește verificarea după primul cuvânt interzis găsit
            }
        }
    }
}
