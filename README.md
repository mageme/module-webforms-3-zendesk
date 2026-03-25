# MageMe WebForms 3 — Zendesk Integration

Free add-on for [MageMe WebForms for Magento 2](https://mageme.com/magento-2-form-builder.html) that integrates form submissions with Zendesk.

## Features

- Automatically create Zendesk support tickets from form submissions
- Map form fields to ticket properties (type, priority, group, agent, custom fields)
- Built-in connection testing from the admin panel
- Custom form field types for Zendesk ticket attributes (group, priority, type)

## Requirements

- Magento 2.4.x
- [MageMe WebForms 3](https://mageme.com/magento-2-form-builder.html) version 3.5.0 or higher
- `zendesk/zendesk_api_client_php` ^2.2

## Installation

### Via Composer

```
composer require mageme/module-webforms-3-zendesk
bin/magento setup:upgrade
bin/magento cache:flush
```

### Manual Installation

1. Download and extract to `app/code/MageMe/WebFormsZendesk/`
2. Run `bin/magento setup:upgrade`
3. Run `bin/magento cache:flush`

## Configuration

1. Navigate to **Stores > Configuration > MageMe > WebForms > Zendesk** and enter your Zendesk subdomain, email, and API token. Use the "Test Connection" button to verify.
2. Open a form in the admin panel and configure the Zendesk integration tab to map form fields to ticket properties.

## About MageMe WebForms

[MageMe WebForms](https://mageme.com/magento-2-form-builder.html) is a powerful form builder for Magento 2 that allows you to create any type of form — contact forms, surveys, registration forms, order forms, and more — with a drag-and-drop interface, conditional logic, file uploads, and CRM integrations.

[Get MageMe WebForms](https://mageme.com/magento-2-form-builder.html)

## Support

- Documentation: [mageme.com](https://mageme.com)
- Issue Tracker: [GitHub Issues](https://github.com/mageme/module-webforms-3-zendesk/issues)

## License

Proprietary. See [License](https://mageme.com/license/) for details.
