<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NumeroTelephoneTogolais implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value)) {
            $fail('Le numéro de téléphone doit être une chaîne de caractères.');
            return;
        }

        // 1. Nettoyer le numéro : enlever espaces, tirets, et le préfixe '+' s'il existe
        $numeroNettoye = str_replace([' ', '-'], '', $value);
        $numeroNettoye = ltrim($numeroNettoye, '+');

        // 2. Vérifier les formats possibles pour le Togo (+228 suivi de 8 chiffres OU juste 8 chiffres)

        // Format international : commence par 228 et a 11 chiffres au total (228 + 8 chiffres)
        $formatInternationalValide = strlen($numeroNettoye) === 11 && str_starts_with($numeroNettoye, '228') && ctype_digit(substr($numeroNettoye, 3));

        // Format national : a exactement 8 chiffres
        $formatNationalValide = strlen($numeroNettoye) === 8 && ctype_digit($numeroNettoye);

        // 3. Échouer si aucun des formats n'est valide
        if (!$formatInternationalValide && !$formatNationalValide) {
            // Message d'erreur personnalisable
            $fail('Le numéro de téléphone fourni ne semble pas être un numéro de téléphone togolais valide (ex: +228XXXXXXXX ou XXXXXXXX).');
        }

        // Optionnel : Vérifier les préfixes mobiles/fixes si nécessaire (plus complexe)
        $prefixesMobiles = ['90', '91', '92', '93', '96', '97', '98', '99'];
        $prefixe = substr($numeroNettoye, -8, 2); // Prend les 2 premiers chiffres des 8 derniers
        if ($formatNationalValide || $formatInternationalValide) {
            $numeroPrincipal = substr($numeroNettoye, -8); // Prend les 8 chiffres principaux
            $prefixe = substr($numeroPrincipal, 0, 2);
            if (!in_array($prefixe, $prefixesMobiles)) { // Ajouter d'autres préfixes valides si besoin
                $fail('Le préfixe du numéro de téléphone ne semble pas valide pour le Togo. Veuillez verifier le numéro de téléphone.');
            }
        }
    }
}