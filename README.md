# MageMe WebForms Zendesk for Magento 2

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mageme/module-webforms-3-zendesk.svg?style=flat-square)](https://packagist.org/packages/mageme/module-webforms-3-zendesk)
[![Packagist Downloads](https://img.shields.io/packagist/dt/mageme/module-webforms-3-zendesk.svg?style=flat-square)](https://packagist.org/packages/mageme/module-webforms-3-zendesk)
[![Magento](https://img.shields.io/badge/Magento-2.4.x-EE672F.svg?style=flat-square)](https://magento.com)
[![PHP](https://img.shields.io/badge/PHP-7.4%20–%208.5-777BB4.svg?style=flat-square)](https://php.net)
[![License](https://img.shields.io/badge/license-MageMe%20EULA-blue.svg?style=flat-square)](https://mageme.com/license/)

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

## Custom Magento development

Need a feature an extension doesn't cover, or a bespoke Magento build? MageMe takes on custom extension development and integration work.

→ **[Custom Magento development](https://mageme.com/magento-services/custom-development)**

## Support

- Documentation: [docs.mageme.com](https://docs.mageme.com)
- Bug reports and feature requests: [GitHub Issues](https://github.com/mageme/module-webforms-3-zendesk/issues)

## License

Governed by the **MageMe End User License Agreement** ([mageme.com/license](https://mageme.com/license/)). This add-on is distributed free of charge.

---

**MageMe WebForms** is a no-code form builder for Magento 2 — conditional logic, multi-step forms, file uploads, and CRM integrations. → [Get WebForms](https://mageme.com/magento-2-form-builder.html)