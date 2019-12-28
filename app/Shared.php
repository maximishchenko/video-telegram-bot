<?php


namespace App;


class Shared
{
    /**
     * Статус "Активен"
     */
    const STATUS_ACTIVE = 1;

    /**
     * Статус "Заблокирован"
     */
    const STATUS_BLOCKED = 0;

    /**
     * Статус "Ожидает подтверждения"
     */
    const STATUS_WAIT = 2;

    /**
     * Значение сортировки по-умолчанию
     */
    const DEFAULT_SORT = 500;
}
