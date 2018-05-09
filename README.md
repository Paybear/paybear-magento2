
<h3>PayBear.io Integration for Magento 2.x</h3>
This extension allows to accept <b>Ethereum</b>, <b>Bitcoin</b>, <b>Bitcoin Cash</b>, <b>Bitcoin Gold</b>, <b>Litecoin</b>, <b>Dash</b> and <b>Ethereum Classic</b> payments in a Magento shop. More details can be found on our website: https://www.paybear.io

<h3>API Keys</h3>
In order to use the system you need an API key. Getting a key is free and easy, sign up here:
https://www.paybear.io

<h3>Multiple Currencies</h3>
Once registered, you can manage the currencies you want to integrate in the Membership area / Currencies. Please enable the currencies there before using this integration.

<h3>Install ready-to-paste package</h3>

 
 1. Download the latest version of the integration: https://github.com/Paybear/paybear-magento2/releases/download/v0.2-alpha/paybear-magento2.zip
 2. Extract the package and connect to your server using SFTP Clients. Then upload the app folder to Magento 2 root folder.
 3. To complete the installation process you need to run following commands:
    php bin/magento setup:upgrade
    php bin/magento cache:clean
 4. Log in to your Magento Administration page as administrator 
 5. Go to Stores → Configuration → Sales → Payment Methods → PayBear Payments
 6. Select Enabled -> Yes and add you Api Key (Secret)

### What to use as a payout address?
You will need payout addresses for all crypto currencies you want to accept. Only you will have access to your payout wallets.
You can use any online wallet, service or exchange of your choice.
If you don't have one, consider reading our [Wallet Guide](https://www.paybear.io/wallets)