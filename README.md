# London Map Plugin

Displays a map of London with locations (e.g., dog-friendly baby toilets) using Google Maps. Supports both shortcode and Gutenberg block.

## Installation
1. Copy the `london-map-plugin` folder to your `wp-content/plugins` directory.
2. Activate the plugin in the WordPress admin.
3. Edit `london-map-plugin.php` and replace `YOUR_GOOGLE_MAPS_API_KEY` with your actual Google Maps API key.

## Usage
- **Shortcode:** Add `[london_map]` to any post or page (Classic Editor).
- **Gutenberg Block:** Add the "London Map" block in the Block Editor.

## Adding Locations
- Go to **Locations** in the WordPress admin menu.
- Add a new location with title, description, and set `lat` and `lng` custom fields for coordinates.

## Notes
- The map will only display locations with valid latitude and longitude.
- No styling is included by default. 