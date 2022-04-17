<?php

namespace App\Orchid\Presenters;

use Orchid\Support\Presenter;

class TaskPresenter extends Presenter
{
    public const COUNTRIES = ["AF Afghanistan", "AL Albania", "AM Armenia", "AT Austria",
        "AZ Azerbaijan", "BA Bosnia-Herzegovina", "BE Belgium", "BG Bulgaria", "BH Bahrain",
        "BY Belarus", "CH Switzerland", "CN China", "CY Cyprus", "CZ Czech Republic", "DE Germany",
        "DK Denmark", "DZ Algeria", "EE Estonia", "EG Egyp", "ER Eritrea", "ES Spain", "ET Ethiopia",
        "FI Finland", "FO Faroe Islands", "FR France", "GB United Kingdom", "GE Georgia", "GI Gibraltar",
        "GR Greece", "HR Croatia", "HU Hungary", "IE Ireland", "IL Israel", "IN India", "IQ Iraq",
        "IR Iran", "IS Iceland", "IT Italy", "JO Jordan", "KG Kyrgyzstan", "KW Kuwait", "KZ Kazakhstan",
        "LB Lebanon", "LI Liechtenstein", "LT Lithuania", "LU Luxembourg", "LV Latvia", "LY Libya",
        "MA Morocco", "MC Monaco", "MD Moldavia", "ME Montenegro", "MK Macedonia", "MN Mongolia",
        "MT Malta", "NL Netherlands", "NO Norway", "NP Nepal", "OM Oman", "PK Pakistan", "PL Poland",
        "PT Portugal", "QA Qatar", "RO Romania", "RS Serbia", "RU Russia", "SA Saudi Arabia", "SE Sweden",
        "SI Slovenia", "SK Slovakia", "SM San Marino" , "SY Syria", "TJ Tajikistan","TM Turkmenistan",
        "TN Tunisia", "TR Turkey", "UA Ukraine", "UZ Uzbekistan", "VA Vatican City", "YE Yemen"
    ];

    public function countriesSelectOptions() {
        return ['-- is empty --'] + self::COUNTRIES;
    }
}
