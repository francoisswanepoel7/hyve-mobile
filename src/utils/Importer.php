<?php
namespace hyvemobile\utils;
use League\Csv\Reader;

final class Importer
{
    private Reader $csv_reader;
    private Card $card;

    public function __construct(string $csv_filepath) {
        $this->csv_reader = Reader::createFromPath($csv_filepath, 'r');
        $this->csv_reader->setHeaderOffset(0);
        $this->card = new Card();
    }

    public function process() : void {
        $input_bom = $this->csv_reader->getInputBOM();
        $data = [];


        if ($input_bom === Reader::BOM_UTF16_LE || $input_bom === Reader::BOM_UTF16_BE) {
            $this->csv_reader->addStreamFilter('convert.iconv.UTF-16/UTF-8');
        }
        foreach ($this->csv_reader as $record) {
            $record['datetime_local'] = Timezone::getLocalDateTime($record['date'], $record['time'], $record['tz']);
            $record['datetime_utc'] = Timezone::getUTCDateTime($record['datetime_local'], $record['tz']);
            unset($record['date']);
            unset($record['time']);
            $record['note'] = (mb_detect_encoding($record['note']) === 'ASCII') ? htmlspecialchars($record['note']) : utf8_encode($record['note']);
            $record['card'] = $this->card->getBase64EncodedImage($this->card->make($record['first_name'], $record['last_name'], $record['email']));
            $data[] = $record;
        }
        $result = Request::post($_ENV['IMPORTER_ENDPOINT'], $data);
        print_r($result, true);
    }
}
