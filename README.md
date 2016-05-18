![Omise-OpenCart](https://cdn.omise.co/artwork/opencart_omise_bodered.png)

## OpenCart Version Compatibility
- OpenCart 2.0.x

## Dependencies (already included in Omise-OpenCart)
- [omise-php](https://github.com/omise/omise-php) (v2.4.0)
- [Jquery](https://github.com/jquery/jquery) (v2.1.1 from OpenCart (v2.0.0)'s dependency)

## Installation
Follow these steps to install **Omise-OpenCart**:

1. Download Omise-OpenCart from this repository (or [OpenCart Store](http://www.opencart.com/index.php?route=extension/extension/info&extension_id=22942)) and unzip it into your `local machine` (or directly to your server)

  Download links: 
  [omise-opencart-v1.5.0.2.zip](https://github.com/omise/omise-opencart/archive/v1.5.0.2.zip) or
  [omise-opencart-v1.5.0.2.tar.gz](https://github.com/omise/omise-opencart/archive/v1.5.0.2.tar.gz)

  When opening the zip file, the following files and folders will be visible:
  ![omise-opencart Folder Structure](https://cdn.omise.co/assets/omise-opencart/omise-opencart-2x-install-01.png)
  
2. From the picture above, go to the `src` and copy **all files** into your **OpenCart Project**.

3. Open your **OpenCart website**, then enter the `/admin` page.

4. From the left side of your admin screen, go to `Extensions` > `Payments`. You will see the OpenCart's payment extension list page.
![Payments Menu](https://cdn.omise.co/assets/omise-opencart/omise-opencart-2x-install-02.png)
  
5. `Omise Payment Gateway` will be there, find and click **Install** button  
![Install Omise Payment Gateway extension menu](https://cdn.omise.co/assets/omise-opencart/omise-opencart-2x-install-03.png)

If the everything went fine, you will see the red button appears on the screen next to `Omise Payment Gateway` title
![Omise Menu](https://cdn.omise.co/assets/omise-opencart/omise-opencart-2x-install-04.png)

## Omise Keys Setup
In order to use **Omise-OpenCart** you have to link it to your *Omise account* using your credentials:

1. At the same page, enter the `Extension Edit` page from the button on the right side
![Omise Menu](https://cdn.omise.co/assets/omise-opencart/omise-opencart-2x-install-05.png)

2. You will see the Omise Dashboard page that cannot show your information because this plugin is disabled. Then, enter the `Setting` page from the setting tab
![Omise Menu](https://cdn.omise.co/assets/omise-opencart/omise-opencart-2x-install-06.png)

3. The page that opens allows you to save your `Omise Keys`. If you want to test Omise service integration, you can enable *test mode* by clicking `Enable test mode`. Your OpenCart will then process orders with your test keys. 
![Omise Payment Gateway Form](https://cdn.omise.co/assets/omise-opencart/omise-opencart-2x-install-07.png)

4. The **Module config** allows you to enable or disable Omise Payment on your OpenCart site.
![Module Config Section](https://cdn.omise.co/assets/omise-opencart/omise-opencart-2x-install-08.png)

## Checkout with Omise Payment Gateway
After setting up your *Omise keys*, you can checkout with *Omise Payment Gateway*. In order to test it, make sure you set up your test keys and enabled test mode.

1. Visit your website and add something to your cart.

2. Go to your cart and checkout (regular OpenCart process until now. Let's focus on step 5 **Payment Method**)  
![Checkout Steps](https://cdn.omise.co/assets/omise-opencart/omise-opencart-2x-install-09.png)

3. In this step (step #5 in opencart)  the **Credit Card (Powered by Omise)** choice will be available. Select it and accept the terms & conditions. 
![Payment Method](https://cdn.omise.co/assets/omise-opencart/omise-opencart-2x-install-10.png)

4. The form allows you to fill in your credit card details. You can use a test credit card number from [our documentation](https://docs.omise.co/api/tests/).)  
![Collect a Customer Card](https://cdn.omise.co/assets/omise-opencart/omise-opencart-2x-install-11.png)

5. Once done, submit your order with the `Confirm Order` button. If you want to know how we collect and process your card, please check our documentation: [Collecting Cards](https://docs.omise.co/collecting-card-information/) and [Charging Cards](https://docs.omise.co/charging-cards/))

6. Once completed, you get redirected your website `processed page`.
![Checkout processed done](https://cdn.omise.co/assets/omise-opencart/omise-opencart-2x-install-12.png)

7. If you go back to your **admin dashboard** you will see your order with `Processed` status.  
![Admin Dashboard](https://cdn.omise.co/assets/omise-opencart/omise-opencart-2x-install-13.png)  
Note: During the short period of authorization, the status will be marked as `Processing`

## Uninstalling Omise
1. Open your **OpenCart website**, then go to `/admin` page  

2. Go to `Extensions` > `Payments` (from the left menu)  
![Payments Menu](https://cdn.omise.co/assets/omise-opencart/omise-opencart-2x-install-02.png)
 
3. Look for `Omise Payment Gateway` row and click **Uninstall**  
![Uninstall Omise Payment Gateway extension menu](https://cdn.omise.co/assets/omise-opencart/omise-opencart-2x-install-14.png)

Once uninstalled, `Omise` payment method will not appear in the checkout form anymore.
