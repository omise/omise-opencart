Change Log
==========

[2.3] 2017-04-20
---
- *`Added`* Support [internet banking](https://www.omise.co/offsite-payment) payment
- *`Fixed`* Generate the SSL URL, if the merchant configure SSL for their web site

[2.2] 2017-03-22
---
- *`Added`* Support `IDR` and `SGD` currencies

[2.0.0.1] 2016-07-01
---
- *`Added`* A configuration for manual capture
- *`Fixed`* An invalid format of transfer amount when setup a transfer that currency is Thai Baht
- *`Removed`* Remove a column, No., from charge and transfer list

[2.0.0.0] 2016-05-24
------------
- *`Added`* Support `JPY` currency
- *`Added`* JA (Japanese language) Translation
- *`Added`* Implement `version checker` feature. That it will request to the Github api to check the latest version of Omise-OpenCart repository
- *`Added`* Implement 3D-Secure feature
- *`Added`* Omise-Plugin
- *`Improved`* Code refactoring
- *`Improved`* Code styling
- *`Improved`* Better error messages
- *`Improved`* Re-design & re-implement Omise dashboard for support OpenCart 2.0.x (Admin page)
- *`Improved`* Re-design & re-implement Omise setting page for support OpenCart 2.0.x (Admin page)
- *`Improved`* Re-design & re-implement Omise Checkout form (frontend)
- *`Updated`* Admin be able to change the payment method title from `Credit Card (Powered by Omise)` to another word by themselve from the Omise Setting page
- *`Updated`* Updated README.md file
- *`Updated`* Changed compatible version number from `1.5.x` to `2.0.x`
- *`Updated`* Updated OpenCart2.0 interface images
- *`Updated`* Updated interface to use bootstrap 3
- *`Removed`* Remove vQmod library

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