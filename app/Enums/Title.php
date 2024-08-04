<?php

namespace App\Enums;
//Tytuły: lic., inż., mgr, mgr inż., dr, dr hab., prof. dr hab.
enum Title :String
{
    case LIC = 'lic.';
    case INZ = 'inż.';
    case MGR = 'mgr';
    case MGR_INZ = 'mgr inż.';
    case DR = 'dr';
    case DR_HAB = 'dr hab.';
    case PROF = 'prof. dr hab.';
}