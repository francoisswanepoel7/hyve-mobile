<?php


namespace hyvemobile\api\model;


use Nette\Database\Connection;
use Nette\Database\ConnectionException;
use Nette\Database\DriverException;

class DBO
{
    protected $db_conn;

    /**
     * DBO constructor.
     * @param string $dsn
     * @param string $db_user
     * @param string $db_pass
     */
    function __construct(string $dsn, string $db_user, string $db_pass) {
        try {
            $this->db_conn = new Connection($dsn, $db_user, $db_pass);
        } catch (ConnectionException $e) {
            echo $e->getMessage();
        } catch (DriverException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @param array $data
     */
    function insertContact(array $data) {
        try {
            $this->db_conn->query('INSERT INTO contact', [
                'id' => $data['id'],
                'title' => $data['title'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'note' => $data['note'],
                'card' => $data['card'],
                'ip' => $data['ip']
            ]);
        } catch (ConnectionException $e) {
            echo $e->getMessage();
        } catch (DriverException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @param string $email
     * @return false|mixed
     */
    function checkContactExists(string $email) {
        try {
            $result = $this->db_conn->fetchField('SELECT id FROM contact WHERE email=?', $email);
            if ($result) {
                return $result;
            }
        } catch (ConnectionException $e) {
            echo $e->getMessage();
        } catch (DriverException $e) {
            echo $e->getMessage();
        }
        return false;
    }

    /**
     * @param string $contact_id
     * @return mixed
     */
    function checkContactTimeZoneExists(string $contact_id) {
        try {
            $result = $this->db_conn->fetchField('SELECT id FROM contact_timezone WHERE contact_id=?', $contact_id);
            return $result;
        } catch (ConnectionException $e) {
            echo $e->getMessage();
        } catch (DriverException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @param array $data
     * @param $tz_id
     */
    function insertContactTimeZone(array $data, $tz_id) {
        try {
            $this->db_conn->query('INSERT INTO contact_timezone', [
                'tstamp_local' => $data['datetime_local'],
                'tstamp_utc' => $data['datetime_utc'],
                'contact_id' => $data['id'],
                'timezone_id' => $tz_id
            ]);
        } catch (ConnectionException $e) {
            echo $e->getMessage();
        } catch (DriverException $e) {
            echo $e->getMessage();
        }

    }

    /**
     * @return int|mixed
     */
    function getContactCount() {
        try {
            $result = $this->db_conn->fetchField('SELECT count(*) FROM contact');
            return $result;
        } catch (ConnectionException $e) {
            echo $e->getMessage();
        } catch (DriverException $e) {
            echo $e->getMessage();
        }
        return 0;
    }

    function getContactCountByTz(string $country, string $region) {
        $sql = "SELECT count(contact_id) FROM contact_timezone WHERE timezone_id = (SELECT id FROM timezone WHERE country = '$country' AND region = '$region')";
        try {
            $result = $this->db_conn->fetchField($sql);
            return $result;
        } catch (ConnectionException $e) {
            echo $e->getMessage();
        } catch (DriverException $e) {
            echo $e->getMessage();
        }
        return 0;
    }

    /**
     * @param string $country
     * @param string $region
     * @return array
     */
    function getContactsByTz(string $country, string $region) {
        $sql = "SELECT c.id as id, c.title, c.first_name, c.last_name, c.email, c.note, c.card, c.ip, " .
            "t.tz, ct.tstamp_local, ct.tstamp_utc " .
            "FROM contact c " .
            "INNER JOIN contact_timezone ct ON ct.contact_id = c.id " .
            "INNER JOIN timezone t ON t.id = ct.timezone_id " .
            "WHERE t.country = '$country' AND t.region = '$region' ";

        $datum = [];
        try {
            $rows = $this->db_conn->fetchAll($sql);
            foreach ($rows as $r) {
                $data = [];
                $data['id'] = $r->id;
                $data['title'] = $r->title;
                $data['first_name'] = $r->first_name;
                $data['last_name'] = $r->last_name;
                $data['email'] = $r['email'];
                $data['note'] = ($r['note']);
//                $data['card'] = $r['card'];
                $data['ip'] = $r['ip'];
                $data['tz'] = $r['tz'];
                $data['tstamp_local'] = $r['tstamp_local'];
                $data['tstamp_utc'] = $r['tstamp_utc'];
                $datum[] = $data;
            }
        } catch (ConnectionException $e) {
            echo $e->getMessage();
        } catch (DriverException $e) {
            echo $e->getMessage();
        }
        return $datum;
    }

    /**
     * @param string $limit
     * @param string $offset
     * @return array
     */
    function getContacts(string $limit, string $offset) {
        $datum = [];
        try {
            $sql = "SELECT c.id as id, c.title, c.first_name, c.last_name, c.email, c.note, c.card, c.ip, " .
                "t.tz, ct.tstamp_local, ct.tstamp_utc " .
                "FROM contact c " .
                "INNER JOIN contact_timezone ct ON ct.contact_id = c.id " .
                "INNER JOIN timezone t ON t.id = ct.timezone_id " .
                "ORDER BY c.id ASC LIMIT $limit OFFSET $offset";
            $rows = $this->db_conn->fetchAll($sql);

            foreach ($rows as $r) {
                $data = [];
                $data['id'] = $r->id;
                $data['title'] = $r->title;
                $data['first_name'] = $r->first_name;
                $data['last_name'] = $r->last_name;
                $data['email'] = $r['email'];
                $data['note'] = ($r['note']);
//                $data['card'] = $r['card'];
                $data['ip'] = $r['ip'];
                $data['tz'] = $r['tz'];
                $data['tstamp_local'] = $r['tstamp_local'];
                $data['tstamp_utc'] = $r['tstamp_utc'];
                $datum[] = $data;
            }
        } catch (ConnectionException $e) {
            echo $e->getMessage();
        } catch (DriverException $e) {
            echo $e->getMessage();
        }

        $output = ['records' => count($datum), 'data' => $datum];
        return $output;
    }

    /**
     * @param string $tz
     * @return false|mixed
     */
    function checkTimeZoneExists(string $tz) {
        try {
            $result = $this->db_conn->fetchField('SELECT id FROM timezone WHERE tz=?', $tz);
            if ($result) {
                return $result;
            }
        } catch (ConnectionException $e) {
            echo $e->getMessage();
        } catch (DriverException $e) {
            echo $e->getMessage();
        }
        return false;
    }

    /**
     * @param string $country
     * @param string $region
     * @param string $tz
     */
    function insertTimeZone(string $country, string $region, string $tz) {
        try {
            $this->db_conn->query('INSERT INTO timezone', [
                'country' => $country,
                'region' => $region,
                'tz' => $tz
            ]);
        } catch (ConnectionException $e) {
            echo $e->getMessage();
        } catch (DriverException $e) {
            echo $e->getMessage();
        }
    }

}
