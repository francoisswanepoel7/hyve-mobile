<?php


namespace hyvemobile\api\model;


class Timezone extends Model
{
    public static string $key = "timezone";
    protected int $filter = FILTER_SANITIZE_STRING;

    function process() {
        if (count($this->params) == 1) {
            if (stripos($this->params[0], '/') !== false) {
                $this->params = explode('/', $this->params[0]);
            }
        }
        $tz = (count($this->params) >= 2) ? $this->params : ['Asia', 'Jakarta'];
        $contact_count = $this->dbo->getContactCountByTz($tz[0], $tz[1]);
        $contacts = $this->dbo->getContactsByTz($tz[0], $tz[1]);
        $output = [
            'timezone' => implode('/', $tz),
            'contact_count' => $contact_count,
            'contacts' => $contacts
        ];
        return json_encode($output, JSON_UNESCAPED_UNICODE);
    }

}
