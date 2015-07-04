<?php

namespace Symforce\PageBundle\Form\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @author loong
 */
class BankCardValidator extends ConstraintValidator {

    /**
     * {@inheritDoc}
     */
    public function validate($value, Constraint $constraint) {
        if (null === $value || '' === $value) {
            return;
        }
        if ($value === $constraint->bypass_code) {
            return;
        }
        $len = strlen($value);
        if (!$this->isCreditNo($value)) { //($len !== 19 && $len !==16) || !$this->isCreditNo($value) 
            $this->context->addViolation(sprintf($constraint->message, $value));
        }
    }

    private function isCreditNo($str) {
        $valid = false;
        $cardNumber = trim($str);
        $cardNumber = str_replace(' ', '', $cardNumber);
        $cardNumber = str_replace('-', '', $cardNumber);
        $numDigits = strlen($cardNumber);
        if ($numDigits >= 16 && $numDigits <= 19) {
            $sum = 0;
            $i = $numDigits - 1;
            $pos = 1;
            $digit;
            $luhn = '';
            do {
                $digit = intval(substr($cardNumber, $i, 1));
                $luhn .= ($pos++ % 2 === 0) ? $digit * 2 : $digit;
            } while (--$i >= 0);
            for ($i = 0; $i < strlen($luhn); $i++) {
                $sum += intval(substr($luhn, $i, 1));
            }
            $valid = $sum % 10 == 0;
        }
        return $valid;

//        $n = 0;
//        for($i=strlen($s)-1; $i>=0; $i--) {
//          if($i % 2) {
//              $n += $s[$i];
//          } else {
//            $t = $s[$i] * 2;
//            if($t > 9) $t = $t[0] + $t[1];
//            $n += $t;
//          }
//        }
//        return ($n % 10) == 0;
    }

}
