<?php

namespace App\Orchid\Presenters;

use Orchid\Support\Presenter;
use App\Models\Task;

class TaskPresenter extends Presenter
{
    private const INDIVIDUAL = 'app:cnt:searchForm:dateSelectOpt2';

    private const FROM_AREA = "app:cnt:searchForm:fromSelectOpt3";

    private const TO_COUNTRY = "app:cnt:searchForm:toSelectOpt2";

    private const FREIGHT_LIMIT = "app:cnt:searchForm:freightSelectOpt2";

    public const FROM_TYPES = [
        self::FROM_AREA => "Area search"
    ];
    public const TO_TYPES = [
        self::TO_COUNTRY => "Country selection"
    ];
    public const FREIGHT_TYPES = [
        self::FREIGHT_LIMIT => "Limit the search"
    ];
    public const DATE_TYPES = [
        self::INDIVIDUAL => "Individual days",
    ];

    public const EMPTY_COUNTRY = "-- is empty --";

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

    public static function countriesSelectOptions() {
        $data = [self::EMPTY_COUNTRY] + self::COUNTRIES;

        return array_combine($data,$data);
    }

    public function getCarPriceExtraPoints() {
        return ($this->entity->car_price_extra_points - 1) * 100;
    }

    public function getDesctinations() {
        return json_decode($this->entity->toSelectOptArray ?? "[]", true);
    }

    public function getCrossBorder() {
        return json_decode($this->entity->cross_border ?? "[]", true);
    }

    public function getFromType() {
        return self::FROM_TYPES[$this->entity->fromSelectOpt];
    }

    public function getToType() {
        return self::TO_TYPES[$this->entity->toSelectOpt];
    }

    public function getCountriesList() {
        $task_to_countries = array_reduce($this->getDesctinations(), function ($accumulator, $item) {
            if ($item['as_country_to'] !== self::EMPTY_COUNTRY) {
                $countries = explode(' ', $item['as_country_to']);
                array_push($accumulator, array_shift($countries));
            }
            return $accumulator;
        },[]);

        return implode(", ", $task_to_countries);
    }

    public function getDateType() {
        return self::DATE_TYPES[$this->entity->dateSelectOpt];
    }

    public function cantStart() {
        return $this->entity->status_job == Task::STATUS_START;
    }

    public function cantTest() {
        return $this->entity->status_job == Task::STATUS_TEST;
    }

    public function cantStop() {
        return $this->entity->status_job == Task::STATUS_STOP;
    }

    public function getActionMessage() {
        if($this->entity->status_job == TASK::STATUS_START) return 'Task was started!';
        if($this->entity->status_job == TASK::STATUS_TEST) return 'Task was started in testing mode!';
        return 'Task was stoped!';
    }

    public function getStatusTitle() {
        if($this->entity->status_job == TASK::STATUS_START) return 'Started';
        if($this->entity->status_job == TASK::STATUS_TEST) return 'In testing';
        return 'Stoped';
    }

    public function getSpecialPrice() {
        return json_decode($this->entity->status_job, true);
    }
}
