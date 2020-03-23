<?php
if (!class_exists('OmisePluginHelperCurrency')) {
    class OmisePluginHelperCurrency
    {
        /**
         * @param string $currency_code
         * @return boolean
         */
        public static function isSupport($currency_code)
        {
            switch (strtoupper($currency_code)) {
                case 'AUD':
                case 'CAD':
                case 'CHF':
                case 'CNY':
                case 'DKK':
                case 'EUR':
                case 'GBP':
                case 'HKD':
                case 'MYR':
                case 'USD':
                case 'THB':
                case 'IDR':
                case 'JPY':
                case 'SGD':
                    return true;
                    break;
            }

            return false;
        }

        /**
         * @param string  $currency
         * @param integer $amount
         * @return string
         */
        public static function format($currency, $amount)
        {
            switch (strtoupper($currency)) {
                case 'AUD':
                    $amount = "A$" . number_format(($amount / 100), 2);
                    $amount = OmisePluginHelperCurrency::_strip_zero_decimal($amount);
                    break;

                case 'CAD':
                    $amount = "C$" . number_format(($amount / 100), 2);
                    $amount = OmisePluginHelperCurrency::_strip_zero_decimal($amount);
                    break;

                case 'CHF':
                    $amount = "CNF" . number_format(($amount / 100), 2);
                    $amount = OmisePluginHelperCurrency::_strip_zero_decimal($amount);
                    break;

                case 'CNY':
                    $amount = "元" . number_format(($amount / 100), 2);
                    $amount = OmisePluginHelperCurrency::_strip_zero_decimal($amount);
                    break;

                case 'DKK':
                    $amount = "DKK" . number_format(($amount / 100), 2);
                    $amount = OmisePluginHelperCurrency::_strip_zero_decimal($amount);
                    break;

                case 'EUR':
                    $amount = "€" . number_format(($amount / 100), 2);
                    $amount = OmisePluginHelperCurrency::_strip_zero_decimal($amount);
                    break;

                case 'GBP':
                    $amount = "£" . number_format(($amount / 100), 2);
                    $amount = OmisePluginHelperCurrency::_strip_zero_decimal($amount);
                    break;

                case 'HKD':
                    $amount = "HK$" . number_format(($amount / 100), 2);
                    $amount = OmisePluginHelperCurrency::_strip_zero_decimal($amount);
                    break;

                case 'MYR':
                    $amount = "RM" . number_format(($amount / 100), 2);
                    $amount = OmisePluginHelperCurrency::_strip_zero_decimal($amount);
                    break;

                case 'THB':
                    $amount = "฿" . number_format(($amount / 100), 2);
                    $amount = OmisePluginHelperCurrency::_strip_zero_decimal($amount);
                    break;

                case 'IDR':
                    $amount = "Rp" . number_format(($amount / 100), 2);
                    $amount = OmisePluginHelperCurrency::_strip_zero_decimal($amount);
                    break;

                case 'JPY':
                    $amount = number_format($amount) . "円";
                    break;

                case 'SGD':
                    $amount = "S$" . number_format(($amount / 100), 2);
                    $amount = OmisePluginHelperCurrency::_strip_zero_decimal($amount);
                    break;

                case 'USD':
                    $amount = "$" . number_format(($amount / 100), 2);
                    $amount = OmisePluginHelperCurrency::_strip_zero_decimal($amount);
                    break;
            }

            return $amount;
        }

        function _strip_zero_decimal($amount)
        {
            if (preg_match('/\.00$/', $amount)) {
                $amount = substr($amount, 0, -3);
            }

            return $amount;
        }
    }
}
