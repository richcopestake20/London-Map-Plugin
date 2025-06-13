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

---

## Plugin Functions

### Custom Post Type: `lmp_location`
- Stores curated locations for the map.
- Fields:
  - `google_place_id`: Google Place unique identifier
  - `address`: Location address
  - `lat`, `lng`: Coordinates
  - `type`: Place type (e.g., train station, park, etc.)
  - `accessible`: Accessibility info (yes/no)
  - `toilets`: Toilets available (yes/no)
  - `baby_changing`: Baby changing available (yes/no)
  - `opening_hours`: Opening hours (text)
  - `show_on_map`: Only locations with `yes` are shown on the map
  - `notes`: Admin notes (not shown on frontend)
  - `tags`: Comma-separated tags for filtering

### Google Maps Data
- The plugin is designed to sync with Google Maps Places API.
- Each location can be linked to a Google Place via `google_place_id`.
- You can extend the plugin to auto-import or update locations from Google Places (see `google_place_id` field for mapping).
- **Customisation:**
  - You can add or edit any field in the admin UI.
  - Only locations with `show_on_map` set to `yes` are displayed.
  - You can override Google data (e.g., change name, add notes, hide a place).

### Frontend Map
- Renders all approved locations as markers on a Google Map of London.
- Clicking a marker shows all available details (name, description, type, accessibility, toilets, baby changing, opening hours, tags).
- Supports both shortcode and block output.
- Map is interactive and supports clustering for many markers.

### Filters & Customisation
- The plugin is structured to allow for easy extension of filters (e.g., by type, accessibility, tags).
- To add new filters, extend the frontend JS and update the `get_locations()` function in the PHP.
- You can add new fields to the custom post type and display them in the map popups as needed.

### Admin Curation
- All locations are managed in the WordPress admin under **Locations**.
- You can approve, hide, or edit any location.
- Use the `show_on_map` field to control visibility.
- Use `notes` for internal comments (not shown to users).

---

## Extending the Plugin
- To sync with Google Places API, add a script or WP-CLI command to fetch places and create/update `lmp_location` posts.
- To add new filters or fields, update the custom post type registration, meta box, and frontend JS.
- For advanced customisation, hook into the plugin's actions/filters or extend the JS logic.

---

## Practical Use Cases & Technical Flexibility

The plugin is designed to support highly specific and practical location queries, such as:

- **Dog-friendly pubs with baby toilets and a ramp**
- **Accessible train stations with baby changing facilities**
- **Cafés open after 8pm with toilets and step-free access**

### How This Works
- **Data Curation:**
  - When locations are imported from Google Maps, you (the admin) can review and enrich each entry in the WordPress admin.
  - You can add custom tags (e.g., `dog-friendly`, `pub`, `ramp`), set accessibility, toilets, baby changing, and opening hours fields.
  - You can override or supplement Google data to ensure accuracy and relevance.
- **Filtering:**
  - The frontend map can be extended to allow users to filter by any combination of fields (e.g., only show locations where `type = pub`, `tags` include `dog-friendly`, `toilets = yes`, `baby_changing = yes`, `accessible = yes`).
  - Filters can be combined for complex queries.
- **Custom Fields:**
  - You can add new fields (e.g., `has_ramp`) to the custom post type and expose them in both the admin and frontend.
- **User Experience:**
  - Users can search for exactly what they need (e.g., "dog-friendly pubs with baby toilets and a ramp within 1 mile of my postcode").
  - The map will update to show only locations matching all selected criteria.

### Example Workflow
1. **Import or create a location** (e.g., "The Friendly Dog Pub")
2. **Set fields:**
   - `type`: pub
   - `tags`: dog-friendly, ramp
   - `toilets`: yes
   - `baby_changing`: yes
   - `accessible`: yes
3. **Approve and show on map**
4. **User filters** for pubs that are dog-friendly, have baby toilets, and a ramp — only matching locations are shown.

This approach gives you full control over what appears on the map and enables highly targeted, user-friendly search experiences. 
