<?php

namespace App\Contracts;

interface PaymeContract
{
    public function  CheckPerformTransaction();
    public function CreateTransaction();
    public function PerformTransaction();
    public function CancelTransaction();
    public function CheckTransaction();
}
