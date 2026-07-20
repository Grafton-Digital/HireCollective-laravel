<?php

namespace App;

use Filament\Support\Contracts\HasLabel;

enum County: string implements HasLabel
{
    case CARLOW = 'Carlow';
    case CAVAN = 'Cavan';
    case CLARE = 'Clare';
    case CORK = 'Cork';
    case DONEGAL = 'Donegal';
    case DUBLIN = 'Dublin';
    case GALWAY = 'Galway';
    case KERRY = 'Kerry';
    case KILDARE = 'Kildare';
    case KILKENNY = 'Kilkenny';
    case LAOIS = 'Laois';
    case LEITRIM = 'Leitrim';
    case LIMERICK = 'Limerick';
    case LONGFORD = 'Longford';
    case LOUTH = 'Louth';
    case MAYO = 'Mayo';
    case MEATH = 'Meath';
    case MONAGHAN = 'Monaghan';
    case OFFALY = 'Offaly';
    case ROSCOMMON = 'Roscommon';
    case SLIGO = 'Sligo';
    case TIPPERARY = 'Tipperary';
    case WATERFORD = 'Waterford';
    case WESTMEATH = 'Westmeath';
    case WEXFORD = 'Wexford';
    case WICKLOW = 'Wicklow';

    public function getLabel(): string
    {
        return $this->value;
    }
}
