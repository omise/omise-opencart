<p align="center"><a href='https://www.omise.co'><img src='https://assets.omise.co/assets/omise-logo-ed530feda8c7bf8b0c990d5e4cf8080a0f23d406fa4049a523ae715252d0dc54.svg' height='60'></a></p>

**Omise OpenCart** is the official payment extension which provides support for Omise payment gateway for store builders working on the OpenCart platform.

## Supported Versions

Our aim is to support as many versions of OpenCart as we can.  

**Here's the list of versions we tested on:**

- OpenCart 1.5.6.4, PHP 5.5.9

**Can't find the version you're looking for?**  
Submit your requirement as an issue to [GitHub's issue channel](https://github.com/omise/omise-opencart/issues).

## Getting Started

### Installation Instructions

#### Manually

The steps below are the method to install the extension manually. This method requires the privilege to access your OpenCart file on your site.

1. Download the [Omise OpenCart latest version](https://github.com/omise/omise-opencart/archive/1-stable.zip).
2. Extract the file that you downloaded. After extracted the file, you will found a directory, **src**. Copy **all directories** that inside the directory, src, and place it into the root directory of your OpenCart site.
<p align="center"><img width="762" alt="Omise OpenCart src directory" src="https://cloud.githubusercontent.com/assets/4145121/24155742/3b75c40c-0e87-11e7-86f5-83e9746320f0.png"></p>

3. Login to your administration side. From the top menu, go to **Extensions** > **Payments**.
<p align="center"><img alt="Payments menu" src="https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-02.png"></p>

4. Look for **Omise Payment Gateway** and click **Install**.
<p align="center"><img alt="Install Omise Payment Gateway extension menu" src="https://cloud.githubusercontent.com/assets/245383/24483141/43460fda-1520-11e7-80ec-326343a4e12e.png"></p>

### First Time Setup

After the installation, you can configure the extension by:

Login to your administration side. From the top right menu, go to **Omise** > **Setting**.
<p align="center"><img alt="Omise menu" src="https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-05.png"></p>

The system will display the setting page.
<p align="center"><img alt="Omise payment gateway setting page" src="https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-06.png"></p>

The table below is the settings for the extension and the description for each setting.

| Setting             | Description                                                                              |
| ------------------- | -----------------------------------------------------------------------------------------|
| Public Key for test | Your TEST public key can be found in your Omise dashboard.                               |
| Secret Key for test | Your TEST secret key can be found in your Omise dashboard.                               |
| Enable test mode    | If selected, all transactions will be performed in TEST mode and TEST keys will be used. |
| Public Key          | Your LIVE public key can be found in your Omise dashboard.                               |
| Secret Key          | Your LIVE secret key can be found in your Omise dashboard.                               |
| Module Status       | Enables or disables the extension.                                              |

- To enable the extension, select the setting for `Module Status` to `Enabled`.

**Note:**

If the setting for `Enable test mode` has been checked, the `Test Keys` will be used. If the setting for `Enable test mode` has not been checked, the `Live Keys` will be used.

**Internet Banking**

1. Login to your administration side. From the top menu, go to **Extensions** > **Payments**.
<p align="center"><img alt="Payments menu" src="https://omise-cdn.s3.amazonaws.com/assets/omise-opencart/omise-opencart-install-02.png"></p>

2. Look for **Omise Payment Gateway - Internet Banking**, click **Edit** link.
<p align="center"><img alt="Edit Omise Payment Gateway - Internet Banking" src="https://cloud.githubusercontent.com/assets/245383/24483149/4ac72b7c-1520-11e7-8f57-2a9ba6cda6d6.png"></p>

3. In **Omise Payment Gateway - Internet Banking** setting page, enable the module by changing **Module Status** to **Enabled**

4. Click **Save**.
<p align="center"><img alt="Enable Omise Payment Gateway Internet Banking" src="https://cloud.githubusercontent.com/assets/245383/24483153/4d05dfa0-1520-11e7-8f4d-cad88778a4b0.png"></p>

> In order to enable **Omise Payment Gateway - Internet Banking**, **Omise Payment Gateway** must be installed and enabled.

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
