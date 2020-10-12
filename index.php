<?php
// VALIDARE CNP

function validareCNP($CNP)
{
    // CNP must have 13 characters
    if (strlen($CNP) != 13) {
        return false;
    }
    //transform numarul in array
    $cnp = str_split($CNP);
    

    $tabelControl = array(2, 7, 9, 1, 4, 6, 3, 5, 8, 2, 7, 9); // numarul de control
    $cifraControl = 0; // declar cifra de control ca variabila

    // All characters must be numeric
    for ($i = 0; $i < 13; $i++) {
        if (!is_numeric($cnp[$i])) {
            return false;
        }
        $cnp[$i] = (int) $cnp[$i];
        if ($i < 12) {
            $cifraControl += (int) $cnp[$i] * (int) $tabelControl[$i];
        }
    }

    $cifraControl = $cifraControl % 11;
    if ($cifraControl == 10) {
        $cifraControl = 1;
    }
    //declar $sex
    $sex = $cnp[0];
    $sex == 9 ? ($sex = 'strain') : ($sex % 2 ? $sex = 'masculin' : $sex = 'feminin'); // schimb valoarea $sex din numar

    
    $an = ($cnp[1] * 10) + $cnp[2]; // anul in care s-au nascut
    switch ($cnp[0]) {
        case 1:
        case 2: {
                $an += 1900;
            }
            break; // cetateni romani nascuti intre 1 ian 1900 si 31 dec 1999
        case 3:
        case 4: {
                $an += 1800;
            }
            break; // cetateni romani nascuti intre 1 ian 1800 si 31 dec 1899
        case 5:
        case 6: {
                $an += 2000;
            }
            break; // cetateni romani nascuti intre 1 ian 2000 si 31 dec 2099
        case 7:
        case 8:
        case 9: {
                $an += 1900;
            }
            break; // rezidenti si Cetateni Straini

    }
    $ziuaNasterii= $cnp[4][5].'/'.$cnp[6][7].'/'.$an ; //ziua de nastere

    ($an > 1800 && $an < 2099 && $cnp[12] == $cifraControl) ? true : false; // am validat cnp
}