<?php
if (! class_exists('OmisePluginHelperTransfer')) {
	class OmisePluginHelperTransfer {
		/**
		 * Format the transfer amount into the appropriate format for each currency.
		 * Now, only Thai Baht (THB) that need to format.
		 *
		 * Example for THB:
		 * 100    => 10000
		 * 100.25 => 10025
		 * 100.50 => 10050
		 * 100.1  => 10010
		 *
		 * @param string  $currency
		 * @param integer $amount
		 * @return string
		 */
		public static function amount($currency, $amount) {
			switch (strtoupper($currency)) {
				case 'THB':
					$amount = $amount * 100;
					break;
			}

			return $amount;
		}
	}
}