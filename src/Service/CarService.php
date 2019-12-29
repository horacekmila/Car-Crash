<?php


namespace App\Service;


class CarService
{
    public function generateRandomLicencePlate(): string
    {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(7/strlen($x)) )),1, 7);
    }
}