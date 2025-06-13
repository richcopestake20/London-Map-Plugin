import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps } from '@wordpress/block-editor';

registerBlockType('london-map-plugin/map', {
    edit() {
        return (
            <div {...useBlockProps()}>
                <strong>London Map</strong>
                <div>Map will appear here on the site.</div>
            </div>
        );
    },
    save() {
        return <div id="lmp-map"></div>;
    }
}); 