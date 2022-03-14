<?php

namespace App\Application\Transaction;

interface EntityManagerInterface
{
    public function beginTransaction();
    public function commit();
    public function rollback();
}