<?php
if (! class_exists('OmisePluginHelperTransfer')) {
	class OmisePluginHelperTransfer {
		/**
		 * Format the transfer amount into the appropriate format for each currency.
		 * Note, no specific format for JPY currency.
		 *
		 * @param  string  $currency
		 * @param  integer $amount
		 *
		 * @return string
		 */
		public static function amount($currency, $amount) {
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