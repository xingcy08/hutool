<?php


namespace Xcy\Hutool;


class NumberUtil
{
    /**
     * 人民币金额转大写
     *
     * -e.g: phpunit("Tools::convertCurrency", ["-10.00"]);
     * -e.g: phpunit("Tools::convertCurrency", [23.12]);
     * -e.g: phpunit("Tools::convertCurrency", [2223.12]);
     * -e.g: phpunit("Tools::convertCurrency", ['2,023.12']);
     * -e.g: phpunit("Tools::convertCurrency", ['2,023.12392']);
     * -e.g: phpunit("Tools::convertCurrency", ['100,232,023.12392']);
     * -e.g: phpunit("Tools::convertCurrency", ['2s3.12']);
     *
     * @param integer $currencyDigits
     * @return string
     * @throws \Exception
     */
    static function convertCurrency($currencyDigits = 0): string
    {
        // Constants:
        $MAXIMUM_NUMBER = 99999999999.99;
        // Predefine the radix characters and currency symbols for output:
        $CN_ZERO = "零";
        $CN_ONE = "壹";
        $CN_TWO = "贰";
        $CN_THREE = "叁";
        $CN_FOUR = "肆";
        $CN_FIVE = "伍";
        $CN_SIX = "陆";
        $CN_SEVEN = "柒";
        $CN_EIGHT = "捌";
        $CN_NINE = "玖";
        $CN_TEN = "拾";
        $CN_HUNDRED = "佰";
        $CN_THOUSAND = "仟";
        $CN_TEN_THOUSAND = "万";
        $CN_HUNDRED_MILLION = "亿";
        $CN_SYMBOL = "";
        $CN_DOLLAR = "元";
        $CN_TEN_CENT = "角";
        $CN_CENT = "分";
        $CN_INTEGER = "整";

        $currencyDigits = trim(strval($currencyDigits));
        if ($currencyDigits == "") {
            throw new \Exception("请输入金额!");
        }
        $currencyDigits = str_replace([",", "，", " ", "-"], '', $currencyDigits);
        if (preg_match("/[^\.\d]/", $currencyDigits)) {
            throw new \Exception("无效的金额输入!");
        }
        // if (($currencyDigits).match(/^((\d{1,3}(,\d{3})*(.((\d{3},)*\d{1,3}))?)|(\d+(.\d+)?))$/) == null) {
        //     alert("非法的字符，请输入数字!");
        //     return "";
        // }
        if (($currencyDigits * 1) > $MAXIMUM_NUMBER) {
            throw new \Exception("仅支持转换千亿以下金额");
        }
        // Process the coversion from currency digits to characters:
        // Separate integral and decimal parts before processing coversion:
        $parts = explode('.', strval($currencyDigits));
        if (count($parts) > 1) {
            $integral = $parts[0];
            $decimal = substr(str_pad($parts[1], 2, "0"), 0, 2);
        } else {
            $integral = $parts[0];
            $decimal = "";
        }
        // Prepare the characters corresponding to the digits:
        $digits = [$CN_ZERO, $CN_ONE, $CN_TWO, $CN_THREE, $CN_FOUR, $CN_FIVE, $CN_SIX, $CN_SEVEN, $CN_EIGHT, $CN_NINE];
        $radices = ["", $CN_TEN, $CN_HUNDRED, $CN_THOUSAND];
        $bigRadices = ["", $CN_TEN_THOUSAND, $CN_HUNDRED_MILLION];
        $decimals = [$CN_TEN_CENT, $CN_CENT];
        // Start processing:
        $outputCharacters = "";
        // Process integral part if it is larger than 0:
        if ($integral * 1 > 0) {
            $zeroCount = 0;
            $integral = strval($integral);
            for ($i = 0; $i < strlen($integral); $i++) {
                $p = strlen($integral) - $i - 1;
                $d = substr($integral, $i, 1);
                $quotient = $p / 4;
                $modulus = $p % 4;
                if ($d == "0") {
                    $zeroCount++;
                } else {
                    if ($zeroCount > 0) {
                        $outputCharacters .= $digits[0];
                    }
                    $zeroCount = 0;
                    $outputCharacters .= $digits[($d * 1)] . $radices[$modulus];
                }
                if ($modulus == 0 && $zeroCount < 4) {
                    $outputCharacters .= $bigRadices[$quotient];
                }
            }
            $outputCharacters .= $CN_DOLLAR;
        }
        // Process decimal part if there is:
        if ($decimal != "") {
            for ($i = 0; $i < strlen($decimal); $i++) {
                $d = substr($decimal, $i, 1);
                if ($d != "0") {
                    $outputCharacters .= $digits[($d * 1)] . $decimals[$i];
                }
            }
        }
        // Confirm and return the final output string:
        if ($outputCharacters == "") {
            $outputCharacters = $CN_ZERO . $CN_DOLLAR;
        }
        if ($decimal == "") {
            $outputCharacters .= $CN_INTEGER;
        }
        return $CN_SYMBOL . $outputCharacters;
    }
}
