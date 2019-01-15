# ParsiCoin Plugin for WooCommerce

ParsiCoin Plugin for WooCommerce is a Wordpress plugin that allows merchants to accept ParsiCoin (PARS) at WooCommerce-powered online stores.

Contributors: KittyCatTech, gesman

Requires at least: 3.0.1

Tested up to: 5.0.3

## Description

Your online store must use WooCommerce platform (free wordpress plugin).
Once you have installed and activated WooCommerce, you may install and activate ParsiCoin for WooCommerce.

### Benefits 

* Fully automatic operation.
* Can be used with view only wallet so only the view private key is on the server and none of the spend private keys are required to be kept anywhere on your online store server.
* Accept payments in ParsiCoin directly into your ParsiCoin wallet.
* ParsiCoin wallet payment option completely removes dependency on any third party service and middlemen.
* Accept payment in ParsiCoin for physical and digital downloadable products.
* Add ParsiCoin option to your existing online store with alternative main currency.
* Flexible exchange rate calculations fully managed via administrative settings.
* Zero fees and no commissions for ParsiCoin processing from any third party.
* Set main currency of your store in USD, PARS or BTC.
* Automatic conversion to ParsiCoin via realtime exchange rate feed and calculations.
* Ability to set exchange rate calculation multiplier to compensate for any possible losses due to bank conversions and funds transfer fees.


## Installation 


1.  Install WooCommerce plugin and configure your store (if you haven't done so already - http://wordpress.org/plugins/woocommerce/).
2.  Install and Activate "ParsiCoin for WooCommerce" wordpress plugin just like any other Wordpress plugin.
3.  Download and install ParsiCoin Wallet from : https://parsicoin.net/
4.  Copy and setup your wallet on the server. Change permission to executable. Run parsicoind as a service.
5.  Generate Container (optionally reset containter to view only container and add view only address). Run walletd as a service.
6.  Get your wallet address from walletd.
7.  Within your site's Wordpress admin, navigate to:
	    WooCommerce -> Settings -> Checkout -> ParsiCoin
	    and paste your wallet address into "Wallet Address" field.
8.  Select "ParsiCoin service provider" = "Local Wallet" and fill-in other settings at ParsiCoin management panel.
9. Press [Save changes]
10. If you do not see any errors - your store is ready for operation and to access payments in ParsiCoin!


## Remove plugin

1. Deactivate plugin through the 'Plugins' menu in WordPress
2. Delete plugin through the 'Plugins' menu in WordPress


## Credit

https://github.com/seredat/karbo-woocommerce
