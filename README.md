# omise-opencart

## OpenCart Version Compatibility
- OpenCart 1.5.6.4

## Dependencies
- [omise-php](https://github.com/omise/omise-php) (v2.1.2)
- [Jquery](https://github.com/jquery/jquery) (v1.7.1 from OpenCart (v1.5.6.4)'s dependency)
- [vQmod](https://github.com/vqmod/vqmod) (v2.5.1 with OpenCart integration edition)

## Installation
Follow these steps to install **omise-opencart**:

1. Download this repository and unzip it into your `local machine` (or directly to your server)

  Download links: 
  [omise-opencart-v1.0.zip](https://github.com/omise/omise-opencart/archive/v1.0.zip) or 
  [omise-opencart-v1.0.tar.gz](https://github.com/omise/omise-opencart/archive/v1.0.tar.gz)

  ![omise-opencart Folder Structure](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-01.png)

  
2. Go to `/omise-opencart/src` and copy **all files** into your **OpenCart Project**  

3. Open your **OpenCart website**, then go to `/admin` page  

4. Go to `Extensions` > `Payments` (from the top menu), in the payment extension list page
![Payments Menu](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-02.png)
  
5. Look for `Omise Payment Gateway` and click **Install**  
![Install Omise Payment Gateway extension menu](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-03.png)

If the everything went fine, the `Omise` menu will appear on the right side of your admin page.
![Omise Menu](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-04.png)

#### Frequent Problems

Permissions must be set so that **omise-opencart** can overwrite the following files:
- `your-opencart(root)/index.php`
- `your-opencart(root)/admin/index.php`

It also creates new folders and files on your `your-opencart(root)/` directory for the first installation.  
Ensure these 2 files and folder have appropriate `write` permissions (usually `755`).

## Omise Keys Setup
In order to use **omise-opencart** you have to link it to your *Omise account* using your credentials:

1. Go to `Omise` > `Settings` (from Omise menu on the top right of the page)  
![Omise Menu](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-05.png)

2. The page that opens allows you to save your `Omise Keys`. If you want to test Omise service integration, you can enable *test mode* by clicking `Enable test mode`. Your OpenCart will then process orders with your test keys. 
![Omise Payment Gateway Form](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-06.png)

3. The **Module config** allows you to enable or disable Omise Payment on your OpenCart site.
![Module Config Section](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-07.png)

## Checkout with Omise Payment Gateway
After setting up your *Omise keys*, you can checkout with *Omise Payment Gateway*. In order to test it, make sure you set up your test keys and enabled test mode.

1. Visit your website and add something to your cart.

2. Go to your cart and checkout (regular OpenCart process until now. Let's focus on step 5 **Payment Method**)  
![Checkout Steps](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-08.png)

3. In this step (step #5 in opencart)  the **Credit Card (Powered by Omise)** choice will be available. Select it and accept the terms & conditions. 
![Payment Method](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-09.png)

4. The form allows you to fill in your credit card details. You can use a test credit card number from [our documentation](https://docs.omise.co/api/tests/).)  
![Collect a Customer Card](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-10.png)

5. Once done, submit your order with the `Confirm Order` button. If you want to know how we collect and process your card, please check our documentation: [Collecting Cards](https://docs.omise.co/collecting-card-information/) and [Charging Cards](https://docs.omise.co/charging-cards/))

6. Once completed, you get redirected your website `processed page`.
![Checkout processed done](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-11.png)

7. If you go back to your **admin dashboard** you will see your order with `Processed` status.  
![Admin Dashboard](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-12.png)  
Note: During the short period of authorization, the status will be marked as `Processing`

## Uninstalling Omise

Because we can not automatically check that `vQmod` library is used by other extensions, we require you to manually remove Omise Payment Gateway from your server source code. Follow the next steps:

- Uninstall extension via extension list page of OpenCart
- Remove vQmod folder from your OpenCart directory

#### 1. Uninstall Omise Payment Gateway extension
1. Open your **OpenCart website**, then go to `/admin` page  

2. Go to `Extensions` > `Payments` (from the top menu)  
![Payments menu](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-02.png)
 
3. Look for `Omise Payment Gateway` row and click **Uninstall**  
![Uninstall Omise Payment Gateway extension menu](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-13.png)

Once uninstalled, `Omise` will not appear in the top right menu of your admin page anymore.

#### 2. Removed vQmod library
*For this step, please make sure you are not using `vQmod` library in other extensions. If you are unsure, you can leave it there. It will not have any effect on your site.

1. In your OpenCart directory you will see the `vqmod` folder. Remove it  
![vQmod folder](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-14.png)  

2. Go to `omise-opencart/backup`, restore the backup files. You will see them here:  
![Backup folder](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-15.png)  
Copy and past them into your OpenCart site  
  - `omise-opencart/backup/index.php` to `your-opencart(root)/index.php`  
  - `omise-opencart/backup/admin/index.php` to `your-opencart(root)/admin/index.php`  
