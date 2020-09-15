<?php
namespace hyvemobile\utils;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\ItemInterface;


final class Mail
{
    private $cache;
    public function __construct(Cache $cache) {
        $this->cache = $cache->getCache();
    }

    public function isValid(string $email) {
        $key = str_replace('@','_', $email);
        $valid = false;
        try {
            $valid = $this->cache->get($key, function (ItemInterface $item) use ($email) {
                $item->expiresAfter(84600);
                $validator = new EmailValidator();
                $multipleValidations = new MultipleValidationWithAnd([
                    new RFCValidation(),
                    new DNSCheckValidation()
                ]);
                return $validator->isValid($email, $multipleValidations);
            });
        } catch (InvalidArgumentException $e) {
        }
        return $valid;
    }

//    public static function isValid(string $email) {
//
//
//
//        $validator = new EmailValidator();
//        $multipleValidations = new MultipleValidationWithAnd([
//            new RFCValidation(),
//            new DNSCheckValidation()
//        ]);
//        return $validator->isValid($email, $multipleValidations); //true
//    }

    public static function getDomain(string $email) {
        return explode('@', $email)[1];
    }

}
