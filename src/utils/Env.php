<?php
namespace hyvemobile\utils;
use Dotenv\Dotenv;

final class Env
{
    public static function loadEnv() {
        (Dotenv::createImmutable(__DIR__))->load();
    }

}
