<?php
if (! class_exists('OmisePluginHelperCharge')) {
    class OmisePluginHelperCharge
    {
        /**
         * Format a Magento's amount to be a small-unit that Omise's API requires.
         * Note, no specific format for JPY currency.
         *
         * @param  string  $currency
         * @param  integer $amount
         *
         * @return string
         */
        public static function amount($currency, $amount)
        {
            switch (strtoupper($currency)) {
                case 'THB':
                case 'IDR':
                case 'SGD':
                    // Convert to a small unit
                    $amount = $amount * 100;
                    break;
            }

            return $amount;
        }
    }
}