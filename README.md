<p align="center"><a href='https://www.omise.co'><img src='https://assets.omise.co/assets/omise-logo-ed530feda8c7bf8b0c990d5e4cf8080a0f23d406fa4049a523ae715252d0dc54.svg' height='60'></a></p>

**Omise OpenCart** is the official payment extension which provides support for Omise payment gateway for store builders working on the OpenCart platform.

## Supported Versions

Our aim is to support as many versions of OpenCart as we can.  

**Here's the list of versions we tested on:**

- OpenCart 2.0.3.1, PHP 5.6.28 and 7.0.15

**Can't find the version you're looking for?**  
Submit your requirement as an issue to [GitHub's issue channel](https://github.com/omise/omise-opencart/issues).

## Getting Started

### Installation Instructions

#### Manually

The steps below are the method to install the extension manually. This method requires the privilege to access your OpenCart file on your site.

1. Download the [Omise OpenCart latest version](https://github.com/omise/omise-opencart/archive/master.zip).
2. Extract the file that you downloaded. After extracted the file, you will found a directory, **src**. Copy **all directories** that inside the directory, src, and place it into the root directory of your OpenCart site.
<p align="center"><img width="652" alt="Omise OpenCart src directory" src="https://cloud.githubusercontent.com/assets/4145121/24198843/1c14c870-0f3a-11e7-83a2-5969fe04a839.png"></p>

3. Login to your administration side. Go to **Extensions** > **Payments**.
<p align="center"><img alt="Payments menu" src="https://cloud.githubusercontent.com/assets/4145121/24200437/a4e0bdd0-0f3f-11e7-9fa5-770d082548b3.png"></p>

4. Look for **Omise Payment Gateway** and click **green plus sign button** to install the extension.
<p align="center"><img alt="Install Omise Payment Gateway extension" src="https://cloud.githubusercontent.com/assets/4145121/24198864/2d0c8050-0f3a-11e7-83dd-be2fd99319c7.png"></p>

### First Time Setup

After the installation, you can configure the extension by:

1. Login to your administration side. Go to **Extensions** > **Payments**.
<p align="center"><img alt="Payments menu" src="https://cloud.githubusercontent.com/assets/4145121/24200437/a4e0bdd0-0f3f-11e7-9fa5-770d082548b3.png"></p>

2. Look for **Omise Payment Gateway** and click **blue pencil sign button** to configure the extension.
<p align="center"><img alt="Configure Omise Payment Gateway extension" src="https://cloud.githubusercontent.com/assets/4145121/24198878/3c5bb12a-0f3a-11e7-8b69-beb805fbcb7e.png"></p>

3. The system will display the Omise Payment Gateway dashboard page. Go to **Setting** page.
<p align="center"><img alt="Omise Payment Gateway dashboard page" src="https://cloud.githubusercontent.com/assets/4145121/24198879/3c5d0f02-0f3a-11e7-8c68-7a8f589103ea.png"></p>

The system will display the setting page.
<p align="center"><img alt="Omise Payment Gateway setting page" src="https://cloud.githubusercontent.com/assets/4145121/24198880/3c5d8360-0f3a-11e7-9b5b-b076504ff838.png"></p>

The table below is the settings for the extension and the description for each setting.

| Setting              | Description                                                                              |
| -------------------- | -----------------------------------------------------------------------------------------|
| Module Status        | Enables or disables the extension.                                                       |
| Payment method title | Title of Omise payment gateway shown at checkout.                                        |
| Enable test mode     | If selected, all transactions will be performed in TEST mode and TEST keys will be used. |
| Enable live mode     | If selected, all transactions will be performed in LIVE mode and LIVE keys will be used. |
| Public Key for test  | Your TEST public key can be found in your Omise dashboard.                               |
| Secret Key for test  | Your TEST secret key can be found in your Omise dashboard.                               |
| Public Key           | Your LIVE public key can be found in your Omise dashboard.                               |
| Secret Key           | Your LIVE secret key can be found in your Omise dashboard.                               |
| Enable 3D-Secure     | Enables or disables 3D-Secure payment.                                                   |
| Payment Action       | Whether or not the Omise charge to be captured after authorized.                         |

- To enable the extension, select the setting for `Module Status` to `Enabled`.

**Note:**

If the setting for `Payment Action` is set to `Auto Capture`, the Omise charge will be automatically captured after authorized. If the setting for `Payment Action` is set to `Manual Capture`, the Omise charge will be authorized only.

## Contributing

Thanks for your interest in contributing to Omise OpenCart. We're looking forward to hearing your thoughts and willing to review your changes.

The following subjects are instructions for contributors who consider to submit changes and/or issues.

### Submit the changes

You're all welcome to submit a pull request. Please consider the [pull request template](https://github.com/omise/omise-opencart/blob/master/.github/PULL_REQUEST_TEMPLATE.md) and fill the form when you submit a new pull request.

Learn more about [pull request](https://help.github.com/articles/about-pull-requests).

### Submit the issue

To report problems, feel free to submit the issue through [GitHub's issue channel](https://github.com/omise/omise-opencart/issues) by following the [Create an Issue Guideline](https://guides.github.com/activities/contributing-to-open-source/#contributing).

Learn more about [issue](https://guides.github.com/features/issues).

## License

Omise OpenCart is open source software released under the [MIT License](https://github.com/omise/omise-opencart/blob/master/LICENSE).
