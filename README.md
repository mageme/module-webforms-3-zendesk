# Magento 2 Zendesk Integration — MageMe WebForms

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mageme/module-webforms-3-zendesk.svg)](https://packagist.org/packages/mageme/module-webforms-3-zendesk)
[![Packagist Downloads](https://img.shields.io/packagist/dt/mageme/module-webforms-3-zendesk.svg)](https://packagist.org/packages/mageme/module-webforms-3-zendesk)
[![License](https://img.shields.io/packagist/l/mageme/module-webforms-3-zendesk.svg)](https://mageme.com/license/)

Create Zendesk tickets from Magento 2 form submissions. This free add-on for [MageMe WebForms](https://mageme.com/magento-2-form-builder.html) bridges your storefront forms with Zendesk support — including custom field types, file attachments, and connection testing from the admin panel.

## Features

- Create Zendesk support tickets automatically when customers submit a form
- Map form fields to ticket properties (group, priority, type, custom fields)
- Add collaborators and followers to tickets for team visibility
- Attach uploaded files and gallery images via Zendesk upload tokens
- Custom form field types that pull options from Zendesk (Group, Priority, Type selects)
- Built-in connection testing to verify Zendesk credentials from the admin panel
- Apply tags to tickets for routing and reporting
- Multi-store support with per-store Zendesk configuration

## Requirements

- Magento 2.4.x
- [MageMe WebForms 3](https://mageme.com/magento-2-form-builder.html) version 3.5.0 or higher
- `zendesk/zendesk_api_client_php` ^2.2
- Zendesk account with API access

## Installation

```
composer require mageme/module-webforms-3-zendesk
bin/magento setup:upgrade
bin/magento cache:flush
```

## Configuration

1. Go to **Stores > Configuration > MageMe > WebForms > Zendesk** and enter your Zendesk subdomain, email, and API token. Click **Test Connection** to verify.
2. Open any form in the admin panel and configure the Zendesk integration tab to map fields and set ticket properties.

## Other MageMe WebForms Integrations

Handle every customer touchpoint with the right platform:

- [Freshdesk](https://github.com/mageme/module-webforms-3-freshdesk) — create Freshdesk tickets with agent and group routing
- [HubSpot](https://github.com/mageme/module-webforms-3-hubspot) — sync contacts, companies, and tickets
- [Salesforce](https://github.com/mageme/module-webforms-3-salesforce) — create leads from form submissions
- [Zoho CRM & Desk](https://github.com/mageme/module-webforms-3-zoho) — create leads and support tickets
- [Klaviyo](https://github.com/mageme/module-webforms-3-klaviyo) — build profiles and grow your email lists
- [Mailchimp](https://github.com/mageme/module-webforms-3-mailchimp) — subscribe customers to audiences
- [Zapier](https://github.com/mageme/module-webforms-3-zapier) — connect forms to 7000+ apps

## About MageMe WebForms

[MageMe WebForms](https://mageme.com/magento-2-form-builder.html) is a Magento 2 form builder that helps store owners collect and manage customer data. Build support request forms, product inquiry forms, return forms, and feedback surveys with conditional logic, file uploads, email notifications, and helpdesk integrations — without custom development.

[Get MageMe WebForms for Magento 2](https://mageme.com/magento-2-form-builder.html)

## Support

- Documentation: [docs.mageme.com](https://docs.mageme.com)
- Issue Tracker: [GitHub Issues](https://github.com/mageme/module-webforms-3-zendesk/issues)

## License

Proprietary. See [License](https://mageme.com/license/) for details.
