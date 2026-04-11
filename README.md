# Tijus - Portable WordPress Playground

A self-contained, portable WordPress environment that runs locally using PHP's built-in server and SQLite — no MySQL, Apache, or Docker required.

## Quick Start

```bash
# Start the server
./start.sh

# Open in browser
open http://localhost:8000

# Stop the server
./stop.sh
```

## How It Works

- **PHP built-in server** serves WordPress on `localhost:8000`
- **SQLite** replaces MySQL via the [SQLite Database Integration](https://wordpress.org/plugins/sqlite-database-integration/) plugin — zero database setup
- **Custom router** (`router.php`) handles permalink rewriting for the built-in server

## Project Structure

```
├── start.sh                 # Start the local server
├── stop.sh                  # Stop the local server
├── router.php               # URL rewriting for PHP built-in server
├── tweak.php                # Plugin: cleans up the WP admin dashboard
├── wp-config.php            # WordPress configuration
├── wp-content/
│   ├── plugins/
│   │   ├── classic-editor/          # Classic Editor plugin
│   │   ├── elementor/               # Elementor page builder
│   │   └── sqlite-database-integration/  # SQLite database driver
│   └── themes/
│       └── tijus-theme/             # Custom theme (see below)
└── ...                      # Standard WordPress core files
```

## Custom Theme — `tijus-theme`

A custom WordPress theme built from the Edule static template, designed for an education/course platform.

### Features

- Elementor page builder support
- Custom Theme Options admin page (logo, social links, header top bar, footer)
- 4 registered nav menus: main nav, header buttons, footer category, footer quick links
- Admin seeders for quickly scaffolding the Home and About pages with Elementor content
- Static fallback templates for Home and About pages when Elementor isn't active

### Theme Options

Accessible via **Appearance > Theme Options** in the WordPress admin:

- **Logo** — custom logo URL
- **Header Top Bar** — announcement text, link URL, phone, email
- **Social Media Links** — configurable labels, Flaticon classes, and URLs
- **Footer** — address lines and copyright text

## Plugins

| Plugin | Purpose |
|--------|---------|
| **SQLite Database Integration** | Replaces MySQL with a SQLite file — makes the site fully portable |
| **Classic Editor** | Restores the classic WordPress editor |
| **Elementor** | Drag-and-drop page builder for the front-end |
| **Dashboard Tweaks** (`tweak.php`) | Removes dashboard widgets, Welcome Panel, and other admin clutter |

## Requirements

- PHP 7.4+
- No web server, database server, or containerization needed

## License

GPL-2.0-or-later
