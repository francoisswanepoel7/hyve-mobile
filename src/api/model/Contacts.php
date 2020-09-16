<?php
namespace hyvemobile\api\model;

use hyvemobile\api\controller\RequestController;
use hyvemobile\utils\Offset;

class Contacts extends Model
{
    public static string $key = "page";
    protected int $filter = FILTER_SANITIZE_NUMBER_INT;

    function process() {
	    $page = array_key_exists(0, $this->params) ? intval($this->params[0]) : 0;
	    $rec_count = $this->dbo->getContactCount();
	    $offset = Offset::getOffset($_ENV['OFFSET'], $page, $this->dbo->getContactCount());
	    $data = [
		    'pagination' => [
		    	'total_records' => $rec_count,
			'offset' => $offset
		    ],
		'data' => $this->dbo->getContacts($_ENV['OFFSET'], $offset)
	    ];
	    return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

}
