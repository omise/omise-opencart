# omise-opencart

## OpenCart Version Compatible
- OpenCart 1.5.6.4

## Dependencies
- [omise-php](https://github.com/omise/omise-php) (v2.1.2)
- [Jquery](https://github.com/jquery/jquery) (v1.7.1 from OpenCart (v1.5.6.4)'s dependency)
- [vQmod](https://github.com/vqmod/vqmod) (v2.5.1 with OpenCart integration edition)

## Installation
The steps for installing **omise-opencart** are as follows:

1. Download this repository and unzip it into your `local machine`(or directly to your server)

Download links:

[omise.zip](https://github.com/omise/omise-opencart/archive/master.zip) or 
[omise.tar.gz](https://github.com/omise/omise-opencart/archive/master.tar.gz)

![omise-opencart Folder Structure](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-01.png)

  
2. Go to `/omise-opencart/src` and copy **all files** into your **OpenCart Project**  

3. Open your **OpenCart website**, then go to `/admin` page  

4. Go to `Extensions` > `Payments` (from menu on the top of the page), in payment extension list page
![Payments Menu](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-02.png)
  
5. Look for `Omise Payment Gateway` and click **Install**  
![Install Omise Payment Gateway extension menu](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-03.png)

If the `Omise` menu has appeared on the right top menu of your admin page, it's done.  
![Omise Menu](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-04.png)

#### Frequently Problems
**omise-opencart** need to overwrite your files like below
- `your-opencart(root)/index.php`
- `your-opencart(root)/admin/index.php`

and create new folders and files on your `your-opencart(root)/` directory when it install in the first time.  
So, please make sure these 2 files and 1 folder have appropriate `write` permissions (usually `755` or `777`, but not suggested to set permission to `777` [for some security risk reason](https://www.google.co.th/webhp?sourceid=chrome-instant&ion=1&espv=2&ie=UTF-8#q=security+risk+on+permission+777))

## Setup Omise Keys
For configuring your *Omise account* with your *OpenCart site*, you need to add your credentials:

1. Go to `Omise` > `Setting` (from Omise menu on the right top of the page)  
![Omise Menu](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-05.png)

2. In this page you will see a form to save your `Omise Keys`, they are stored on the database. If you want to test Omise service integration with your test keys, you can enable the test mode by clicking `Enable test mode`. Your OpenCart will process orders with in Omise test mode (don't forget to setup your test keys before).  
![Omise Payment Gateway Form](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-06.png)

3. In this **Module config** section of this page, choose `enable` for enabling Omise Payment Gateway module  
![Module Config Section](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-07.png)

## Checkout with Omise Payment Gateway
After your *Omise keys* are setup correctly, you can checkout your order in your site with *Omise Payment Gateway*. Let's try to do it (Note that test mode is better than live when you want to perform a test checkout :wink: )

1. In your site add something to cart.

2. Go to your cart and checkout (Actually, this is basically steps from OpenCart, let focus on step 5 **Payment Method**)  
![Checkout Steps](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-08.png)

3. In this step (step #5 in opencart) you will see **Credit Card (Powered by Omise)** choice is available, select it and click accept the terms & conditions  
![Payment Method](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-09.png)

4. You will see in the form that you can to input your card information here. Fill it with a test card first (please check [document](https://docs.omise.co/api/tests/))  
![Collect a Customer Card](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-10.png)

5. After you filled your card information, submit your form with `Confirm Order` button (for more information about how we processing for collecting your card information and charging it please check our document: [Collecting Cards](https://docs.omise.co/collecting-card-information/) and [Charging Cards](https://docs.omise.co/charging-cards/))

6. In previous step, after you checkout your order, we will send the card data to Omise server for authorization and charge. When it's completed, it will redirect the checkout directly your website `processed page`. That means all steps are completed: `collected card info`, `tokenized the card`, `charged the card` and `saved order to OpenCart database`
![Checkout processed done](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-11.png)

7. Go back to your **admin dashboard** you will see your order with `Processed` status.  
![Admin Dashboard](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-12.png)  
Note: During the short period of authorization, the status will be marked as `Processing`

## Uninstalling Omise

Because we can not automatically check that `vQmod` library is used on other extension (some extensions of OpenCart required vQmod library too), it will required you to manually remove Omise Payment Gateway extension from your server source code. Follow the next steps:

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
*For this step, please make sure you are not using `vQmod` library in other extensions. If you not sure, you can leave it there, it will not have any effect on your site.

1. In your OpenCart directory you will see `vqmod` folder, remove it  
![vQmod folder](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-14.png)  

2. Go to `omise-opencart/backup`, restore back the backup files before installation. You will see the files as shown below:  
![Backup folder](https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-15.png)  
Just copy and replace it into your OpenCart site  
  - `omise-opencart/backup/index.php` to `your-opencart(root)/index.php`  
  - `omise-opencart/backup/admin/index.php` to `your-opencart(root)/admin/index.php`  
