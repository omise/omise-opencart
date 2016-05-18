Change Log
==========

An [unreleased] version is not available on `master` branch and is subject to changes and must not be considered final. Elements of unreleased list may be edited or removed at any time.

[unreleased]
------------
- *`Added`* Support `JPY` currency
- *`Improved`* Code Refactoring
- *`Updated`* Updated README.md file
- *`Updated`* Changed compatible version number from `1.5.x` to `2.0.x`
- *`Updated`* Updated Opencart2.0 interface images
- *`Updated`* Updated interface to use bootstrap 3
- *`Fixed`* Fixed vQmod overwrited files becasue Opencart 2.0 change main interface

[1.5.0.2] 2015-11-16
----------------------
#### Updates
- *`Added`* Added `OMISE_USER_AGENT_SUFFIX` and `OMISE_API_VERSION` into the `user-agent` when request to the OMISE APIs
- *`Updated`* Updated checkout display, add `secured by Omise` logo into checkout form.
- *`Updated`* Upgrade `omise-php` library from 2.3.1 to 2.4.0.
- *`Fixed`* Improved the checkout process.

[1.5.0.1] 2015-08-03
----------------------
#### Updates
- *`Updated`* Updated the omise-opencart version number to `1.5.0.1`.
- *`Updated`* Updated `omise-php` library from 2.1.2 to 2.3.1.

[1.5.0.0] 2015-07-06
----------------------
#### Updates
- *`Updated`* Updated the omise-opencart version number to `1.5.0.0`.

[1.0] 2015-05-18
------------------
#### Featured
Implemented the Omise services into OpenCart 1.5.x, The features are as follows:
- *`Added`* Implemented **Omise Dashboard** into OpenCart's admin page.
  - Show current account status (live or test) depends on that you configured in *Omise Keys Setting page*.
  - Show total account balance, transferable balance.
  - Show history of transfers.
  - Admin was able to transfer their *Omise Balance* to their *Bank account*.
- *`Added`* Implemented **Omise Keys Setting page** into OpenCart's admin page.
- *`Added`* Added **Omise menu** into top bar menu of OpenCart's admin page.
- *`Added`* Added **Omise Payment Gateway Module Configuration** into OpenCart's admin page in Extensions > Payments page.
- *`Added`* Implemented **Omise Charge API** (supported for `Authorize & Capture` method only).
- *`Added`* Added **Omise Checkout Form** into OpenCart's checkout page.
- *`Added`* Added [omise-php](https://github.com/omise/omise-php) library *(v2.1.2)* into this extension.
- *`Added`* Added **README.md** file.