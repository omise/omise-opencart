![Omise-OpenCart](https://cdn.omise.co/artwork/opencart_omise_bodered.png)

## OpenCart Version Compatibility
- OpenCart 2.0.x

## Dependencies (already included in Omise-OpenCart)
- [omise-php](https://github.com/omise/omise-php) (v2.4.0)
- [Jquery](https://github.com/jquery/jquery) (v2.1.1 from OpenCart (v2.0.0)'s dependency)

## Installation
Follow these steps to install **Omise-OpenCart**:

1. Download Omise-OpenCart from this repository (or [OpenCart Store](http://www.opencart.com/index.php?route=extension/extension/info&extension_id=22942)) and unzip it to your `local machine` (or directly to your server).

  Download links: 
  [omise-opencart-v2.0.0.0.zip](https://github.com/omise/omise-opencart/archive/v2.0.0.0.zip) or
  [omise-opencart-v2.0.0.0.tar.gz](https://github.com/omise/omise-opencart/archive/v2.0.0.0.tar.gz)

  Open the zip file. You'll find the following files and folders:
  ![omise-opencart Folder Structure](https://cdn.omise.co/assets/omise-opencart/omise-opencart-2x-install-01.png)
  
2. Copy **all files** from `src` to your **Open Cart Project**

3. Open your **OpenCart website**, then enter the `/admin` page.

4. Go to `Extensions` > `Payments`. You'll find a list of payment extensions.
![Payments Menu](https://cdn.omise.co/assets/omise-opencart/omise-opencart-2x-install-02.png)
  
5. Find `Omise Payment Gateway` and click **Install**
![Install Omise Payment Gateway extension menu](https://cdn.omise.co/assets/omise-opencart/omise-opencart-2x-install-03.png)

Once installation is complete, a red button will appear next to `Omise Payment Gateway`  
![Omise Menu](https://cdn.omise.co/assets/omise-opencart/omise-opencart-2x-install-04.png)

## Omise Keys Setup
In order to use **Omise-OpenCart** you have to link it to your *Omise account* using your credentials:

1. Click on `Extension Edit` (the blue button on the right)
![Omise Menu](https://cdn.omise.co/assets/omise-opencart/omise-opencart-2x-install-05.png)

2. The Omise Dashboard will appear but no information will be shown. This is because the puglin is still disabled. Go to `Setting`
![Omise Menu](https://cdn.omise.co/assets/omise-opencart/omise-opencart-2x-install-06.png)

3. You can save your `Omise Keys` here. If you'd like, you could test the integration by enabing *test mode*. OpenCart will process orders with your test keys.
![Omise Payment Gateway Form](https://cdn.omise.co/assets/omise-opencart/omise-opencart-2x-install-07.png)

4. You can enable or disable Omise on your OpenCart site under **Module config**
![Module Config Section](https://cdn.omise.co/assets/omise-opencart/omise-opencart-2x-install-08.png)

## Checkingout with Omise Payment Gateway
Once you've set up with *Omise Keys*, you're now ready to start accepting payment. To test the service make sure you've set up your test keys and enabled test mode.

1. Go to your website and add an item to your cart.

2. Go to your shopping cart and go through the normal OpenCart checkout process. The option to pay by credit card using Omise will be on Step 5 **Payment method**  
![Checkout Steps](https://cdn.omise.co/assets/omise-opencart/omise-opencart-2x-install-09.png)

3. You'll find **Credit Card (Powered by Omise)**. Select it and after reading the Terms & Conditions, check the box `I have read and accept the terms & conditions`. 
![Payment Method](https://cdn.omise.co/assets/omise-opencart/omise-opencart-2x-install-10.png)

4. Fill out the form with card details. If you're testing, you can get a test card from [our documentation](https://docs.omise.co/api/tests/).  
![Collect a Customer Card](https://cdn.omise.co/assets/omise-opencart/omise-opencart-2x-install-11.png)

5. Review the details before clicking `Confirm Order`. Learn more on how we collect and process credit cards by checking out our documentation: [Collecting Cards](https://docs.omise.co/collecting-card-information/) and [Charging Cards](https://docs.omise.co/charging-cards/)

6. Once done, you'll be directed to your website's `processed page`.
![Checkout processed done](https://cdn.omise.co/assets/omise-opencart/omise-opencart-2x-install-12.png)

7. On your admin dashboard, you'll find the transaction with status marked `Processed`.  
![Admin Dashboard](https://cdn.omise.co/assets/omise-opencart/omise-opencart-2x-install-13.png)  
Note: During authorization (a very short period), the transaction's status will be marked `Processing`.  

## Uninstalling Omise
1. Open your **OpenCart website** and go to `/admin` page  

2. Go to `Extensions` > `Payments`  
![Payments Menu](https://cdn.omise.co/assets/omise-opencart/omise-opencart-2x-install-02.png)
 
3. Look for `Omise Payment Gateway` and click **Uninstall**  
![Uninstall Omise Payment Gateway extension menu](https://cdn.omise.co/assets/omise-opencart/omise-opencart-2x-install-14.png)

That's it! Omise has been uninstalled and will no longer appear in your website's checkout process.
