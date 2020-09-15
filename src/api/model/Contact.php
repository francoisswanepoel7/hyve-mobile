<?php
namespace hyvemobile\api\model;

class Contact extends Model
{
    function process() : void {
        foreach ($this->params as $param) {
            if (!$this->dbo->checkContactExists($param['email'])) {
                $this->dbo->insertContact($param);
            }
            $tz_struct = explode("/", $param['tz']);

            if (!$this->dbo->checkTimeZoneExists($param['tz'])) {
                $this->dbo->insertTimeZone($tz_struct[0], $tz_struct[1], $param['tz']);
            }
            $tz_id = $this->dbo->checkTimeZoneExists($param['tz']);

            if (!$this->dbo->checkContactTimeZoneExists($param['id'])) {
                $this->dbo->insertContactTimeZone($param, $tz_id);
            }

        }
    }
}
