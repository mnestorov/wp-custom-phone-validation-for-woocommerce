<p align="center"><a href="https://wordpress.org" target="_blank"><img src="https://raw.githubusercontent.com/github/explore/80688e429a7d4ef2fca1e82350fe8e3517d3494d/topics/wordpress/wordpress.png" width="100" alt="WordPress Logo"></a></p>

# WordPress - Custom Phone Validation for WooCommerce

[![Licence](https://img.shields.io/github/license/Ileriayo/markdown-badges?style=for-the-badge)](./LICENSE)

## Overview

Adds custom phone number validation for Germany, Austria, and Luxembourg in WooCommerce checkout.

## Features

- **Country-Specific Validation**: Tailored validation for phone numbers from Germany, Austria, and Luxembourg.
- **Dynamic Flag Display**: Automatically displays the flag of the selected country for easy identification.
- **CDN Integration**: Utilizes CDN for faster loading of `intl-tel-input` library, improving site performance.
- **User-Friendly Error Messages**: Displays inline validation errors for immediate user feedback.

## Installation

1. Download the plugin zip file.
2. Navigate to your WordPress dashboard, go to Plugins > Add New, and click on 'Upload Plugin'.
3. Upload the zip file and click on 'Install Now'.
4. After installation, activate the plugin through the 'Plugins' menu in WordPress.

## Usage

Once activated, the plugin automatically initializes on the WooCommerce checkout page. Users can select their country, and the phone number will be validated accordingly.

## Frequently Asked Questions

### Is it possible to add more countries for validation?

Yes, additional countries can be added by modifying the plugin's JavaScript validation rules.

### Does this plugin affect site performance?

The plugin uses CDN for script loading to minimize impact on site performance.

## Changelog

For a detailed list of changes and updates made to this project, please refer to our [Changelog](./CHANGELOG.md).

---

## License

This project is released under the MIT License.