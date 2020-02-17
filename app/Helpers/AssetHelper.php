<?php

namespace App\Helpers;

use Config;

/**
 * AssetHelper
 *
 * @author Virendra Jadeja <virendrajadeja84@gmail.com>
 */
class AssetHelper {

    static function cdn( $asset ){

        // Verify if KeyCDN URLs are present in the config file
        if( !Config::get('app.cdn') )
            return asset( $asset );

        // Get file name incl extension and CDN URLs
        $cdns = Config::get('app.cdn');
        $assetName = basename( $asset );

        // Remove query string
        $assetName = explode("?", $assetName);
        $assetName = $assetName[0];

        // Select the CDN URL based on the extension
        foreach( $cdns as $cdn => $types ) {
            if( preg_match('/^.*\.(' . $types . ')$/i', $assetName) )
                return "//" . rtrim($cdn, "/") . "/" . ltrim( $asset, "/");
        }

        // In case of no match use the last in the array
        end($cdns);
        return  "//" . rtrim(key( $cdns ), "/") . "/" . ltrim( $asset, "/");

    }

}
