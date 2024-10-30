<?php

/*
Plugin Name: Maximum Image Size
Description: When extremely large images are uploaded to the Media Library, replace it with the Large size image, configured in Settings >> Media.
Version: 1.0
Author: Toao.net
Author URI: http://toao.net/623
License: GPLv2 or later
*/

function maximum_image_size($metadata) {
 // If ['large'] doesn't exist, then the image uploaded was smaller than the maximum.  So, we do nothing.
 if (!isset($metadata['sizes']['large'])) return $metadata;
 // If we're here, the image has been resized.  Find out the file names of the original and large image.
 $wp_upload_dir = wp_upload_dir();
 $original = "{$wp_upload_dir['basedir']}/{$metadata['file']}";
 $large = "{$wp_upload_dir['path']}/{$metadata['sizes']['large']['file']}";
 // Delete the original image and rename the large image so that it becomes the original.
 unlink($original);
 rename($large, $original);
 $metadata['width'] = $metadata['sizes']['large']['width'];
 $metadata['height'] = $metadata['sizes']['large']['height'];
 unset($metadata['sizes']['large']);
 // All done!
 return $metadata;
 }
add_filter('wp_generate_attachment_metadata', 'maximum_image_size');

?>