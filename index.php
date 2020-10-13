<?php

############################################################
#############       Validate CNP Number        #############
############################################################

# COMENTARII IN SCOP INFORMATIV SAU DIDACTIC

/**
 * Validate CNP || Give out info about the person
 * @param numeric $CNP CNP number that is going to get validated
 * @param string $options null by default | 
 * @return bool|mixed
*/

function is_cnp($CNP, $options = null)
{

    // CNP trebuie sa aibe 13 caractere numerice
    if (strlen($CNP) != 13 && !is_numeric($CNP)) {
        return false;
    }

    //transform numarul primit in array
    $cnp = str_split($CNP);

    ### SEXUL reprezentat de prima pozitie

    $sex = $cnp[0];
    (int) $sex == 9 ? ($sex = 'strain') : ($sex % 2 ? $sex = 'masculin' : $sex = 'feminin'); // schimb valoarea $sex din numar

    ### Anul Nasterii

    $an = ($cnp[1] * 10) + $cnp[2]; // anul in care s-au nascut
    switch ($cnp[0]) {
        case 1:
        case 2:{
                $an += 1900;
            }
            break; // cetateni romani nascuti intre 1900-1999
        case 3:
        case 4:{
                $an += 1800;
            }
            break; // cetateni romani nascuti intre 1800-1899
        case 5:
        case 6:{
                $an += 2000;
            }
            break; // cetateni romani nascuti intre 2000-2099
        case 7:
        case 8:
        case 9:{
                $an += 1900;
            }
            break; // Rezidenti pentru 7-8 si Cetateni Straini totii intre 1900-1999
        
        default: return false; // Daca nr este 0 spre exemplu
            
    }

    $ziuaNasterii = $cnp[4][5] . '/' . $cnp[6][7] . '/' . $an; //ziua de nastere

    
    ####

    ### JUDETUL  reprezentat de cnp[8][9]  ####
    
    //TODO find out the location from array

        
    ### Numarul NNN  ####

    
    ####
   

    ###  ALGORITMUL DE VALIDARE  --  CIFRA_CONTROL_FINALA === CNP_13  ####

    $tabelControl = array(2, 7, 9, 1, 4, 6, 3, 5, 8, 2, 7, 9); // numarul de control
    $cifraControl = 0; // declar cifra de control

    #Cifra de Control devine suma realizata din inmultirea a fiecarui element din tabelControl cu fiecare cifra din CNP de la 1-12
    
    for ($i = 0; $i < 13; $i++) {
        
        if (!is_numeric($cnp[$i])) {
            
            // Verific ca fiecare element din array cnp sa reprezinte un numar
            return false;
        }

        $cnp[$i] = (int) $cnp[$i]; // ne asiguram ca avem numai int
        
        if ($i < 12) {
            
            // Adaugam la cifraControl 
            $cifraControl += $cnp[$i] * $tabelControl[$i];
        }
    }
    
    #cifraControl devine Restul impartirii cifraControl cu 11

    $cifraControl = $cifraControl % 11;
    if ($cifraControl == 10) {
        
        // Daca Cifra de Control este 10 reprezinta 1 pentru pozitia CNP_13
        $cifraControl = 1; 
    }


    if ($cnp[12] === $cifraControl) {
        
        # Daca al 13-lea numar din CNP este egal cu cifra de Control rezultata din algoritm
        # atunci avem un CNP Valid
        
        return true;
   
    } else { return false;}

    #####
}
