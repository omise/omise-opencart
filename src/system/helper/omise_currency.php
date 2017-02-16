<?php
if (! function_exists('isSupport')) {
    /**
     * @param  string $currency
     *
     * @return boolean
     */
    function isSupport($currency)
    {
        switch (strtoupper($currency)) {
            case 'THB':
            case 'IDR':
            case 'JPY':
            case 'SGD':
                return true;
                break;
        }

        return false;
    }
}

if (! function_exists('formatDisplayPrice')) {
    /**
     * Format an amount to display along with the currency's sign correctly.
     *
     * @param  string          $currency
     * @param  integer | float $amount
     *
     * @return integer
     */
    function formatDisplayPrice($currency, $amount)
    {
        switch (strtoupper($currency)) {
            case 'THB':
                $amount = "฿" . number_format(($amount / 100), 2);
                if (preg_match('/\.00$/', $amount)) {
                    $amount = substr($amount, 0, -3);
                }
                break;

            case 'IDR':
                $amount = "Rp" . number_format(($amount / 100), 2);
                if (preg_match('/\.00$/', $amount)) {
                    $amount = substr($amount, 0, -3);
                }
                break;

            case 'SGD':
                $amount = "S$" . number_format(($amount / 100), 2);
                if (preg_match('/\.00$/', $amount)) {
                    $amount = substr($amount, 0, -3);
                }
                break;

            case 'JPY':
                $amount = number_format($amount) . "円";
                break;
        }

        return $amount;
    }
}


if (! function_exists('formatChargeAmount')) {
    /**
     * Format an order amount to be a small-unit that Omise's API accept.
     * Note, no specific format for JPY currency.
     *
     * @param  string          $currency
     * @param  integer | float $amount
     *
     * @return integer
     */
    function formatChargeAmount($currency, $amount)
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
