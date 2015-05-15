# omise-opencart

## OpenCart Version Compatible
- OpenCart 1.5.6.4

## Dependencies
- [omise-php](https://github.com/omise/omise-php) (v2.1.2)
- [Jquery](https://github.com/jquery/jquery) (v1.7.1 from OpenCart (v1.5.6.4)'s dependency)
- [vQmod](https://github.com/vqmod/vqmod) (v2.5.1 with OpenCart integration edition)

## Installation
The steps for installing **omise-opencart** is as follows:

1. Download this repository and unzip it into your `local machine`  
![omise-opencart Folder Structure](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-01.png)
  
2. Go to `/omise-opencart/src` and copy **all of files** into your **OpenCart Project**  

3. Open your **OpenCart website**, then go to `/admin` page  

4. Go to `Extensions` > `Payments` (from menu on the top of the page), it is payment extension list page
![Payments Menu](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-02.png)
  
5. Looking for `Omise Payment Gateway` and click **Install**  
![Install Omise Payment Gateway extension menu](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-03.png)

If it has `Omise` menu append on the right top menu of your admin page, it's done.  
![Omise Menu](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-04.png)

#### Frequently Problems
**omise-opencart** need to overwrite your files like below
- `your-opencart(root)/index.php`
- `your-opencart(root)/admin/index.php`

and create new folders and files on your `your-opencart(root)/` directory when it install in the first time.  
So, please make sure this 2 files and 1 folder have a permission for `write` it (maybe, `755` or `777` but not suggested to set your file permission to `777` [for some security risk reason](https://www.google.co.th/webhp?sourceid=chrome-instant&ion=1&espv=2&ie=UTF-8#q=security+risk+on+permission+777))

## Setup Omise Keys
For configuring your *Omise account* with your *OpenCart site*, you need to do something as follows:

1. Go to `Omise` > `Setting` (from Omise menu on the right top of the page)  
![Omise Menu](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-05.png)

2. You will see the form for input your `Omise Keys` in this page. So, you can type your `keys` to this form. So, if you want to test Omise service integration with your test key you can enable the test mode by click `Enable test mode` for enable your OpenCart to check out an order with Omise test key (don't forget to setup your test keys before).  
![Omise Payment Gateway Form](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-06.png)

3. In this **Module config** section of this page, choose `enable` for enable Omise Payment Gateway module  
![Module Config Section](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-07.png)

## Checkout with Omise Payment Gateway
After *set-your-key-up*, now you can check out your order in your site with *Omise Payment Gateway*. Let's try to do it (Noted, the test mode is better than live when you want to test check out your order in the first time :D)

1. Go to your site and shopping with your cart!

2. Go to your cart and check it out (Actually, this is basically steps from OpenCart, let focus on step 5 **Payment Method**)  
![Checkout Steps](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-08.png)

3. In this step (step 5) you will see **Credit Card (Powered by Omise)** choice was appended already, select it and click accept the terms & conditions  
![Payment Method](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-09.png)

4. You will see the form that you need to input your card information here, fill the field with your card (for test, please check [document](https://docs.omise.co/api/tests/))  
![Collect a Customer Card](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-10.png)

5. After you filled your card information already, submit your form with `Confirm Order` button (for more information about how we processing for collecting your card information and charging it please check our document: [Collecting Cards](https://docs.omise.co/collecting-card-information/) and [Charging Cards](https://docs.omise.co/charging-cards/))

6. In previous step, after you check out your order, we will send your information to Omise server for charging your card. If it done, it will redirect you to `processed page`. That means everything fine, It finished to `collected your card info`, `tokenized a card`, `charged this card` and `save your order to OpenCart database`
![Checkout processed done](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-11.png)

7. Go back to your **admin dashboard** you will see your order here with `Processed` status.  
![Admin Dashboard](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-12.png)


## Uninstallation
Because we can not automatically check that you use `vQmod` library for only Omise Payment Gatway extension or not for you (maybe, some extensions of OpenCart required vQmod library too). Thus, if you need to completely removed Omise Payment Gateway extension you will need to do in 2 part.
- Uninstall extension via extension list page of OpenCart
- Removed vQmod folder from your OpenCart directory

#### 1. Uninstall Omise Payment Gateway extension
1. Open your **OpenCart website**, then go to `/admin` page  

2. Go to `Extensions` > `Payments` (from menu on the top of the page)  
![Payments menu](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-02.png)
 
3. Looking for `Omise Payment Gateway` row and click **Uninstall**  
![Uninstall Omise Payment Gateway extension menu](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-13.png)

If you don't see `Omise` menu on the right top of your admin page anymore, it's removed.

#### 2. Removed vQmod library
*For this step, please make sure you are not use `vQmod` library in other extensions of your OpenCart site (if you not sure, you can leave it there. It don't have any effect with your site)*

1. In your OpenCart directory you will see `vqmod` folder, remove it  
![vQmod folder](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-14.png)  

2. Go to `omise-opencart/backup`, you will see 2 files like below    
![Backup folder](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-15.png)  
Just copy and replace it into your OpenCart site  
  - `omise-opencart/backup/index.php` to `your-opencart(root)/index.php`  
  - `omise-opencart/backup/admin/index.php` to `your-opencart(root)/admin/index.php`  