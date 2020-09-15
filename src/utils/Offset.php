<?php


namespace hyvemobile\utils;


class Offset {

    public static function getOffset(string $offset_base, int $page, string $recordCount) {
        $recordCount = intval($recordCount);
        $offset_base = intval($offset_base);
        $page = intval($page) + 1;
        $offset = $offset_base * $page;
        if ($offset > $recordCount) {
            $offset = $recordCount - $offset_base;
        }
        return $offset;
    }

}
