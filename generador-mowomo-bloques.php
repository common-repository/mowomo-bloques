<?php
/**
 * Plugin Name: mowomo bloques
 * Plugin URI: https://mowomo.com/
 * Description: mowomo-bloques is a plugin created by mowomo.com for WordPress that brings you various types of blocks with unique configurations to the new editor, Gutenberg
 * Version: 1.1
 * Author: mowomo
 * Author URI: https://mowomo.com/sobre-mowomo
 * Text Domain: mowomo-bloques
 * Domain Path: /languages/
 * License: GPLv2 or later.
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * @package mowomo-bloques
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class mowomo_bloques {
    private static $instance;
    private $slug;
    private $blockNames;
    private $wordpressPackages;
    private $version;

    public static function mwm_bloques__init() {
        if (!self::$instance) {
            self::$instance = new mowomo_bloques();
        } else {
            echo 'There is already a created instance of this class.';
        }
    }

    private function __construct() {
        // CONFIGURAR ESTAS VARIABLES -----------------------------------------------
        $this->slug              = 'mowomo-bloques';
        $this->blockNames        = array('bloque-alerta','bloque-cabecera','bloque-descripcion-boton','bloque-gist','bloque-google-maps','imagen-parallax');//Array
        $this->wordpressPackages = array('wp-blocks', 'wp-element', 'wp-editor', 'wp-i18n', 'wp-components');
        $this->version           = '1.1';
        //---------------------------------------------------------------------------

        add_filter( 'block_categories', function( $categories, $post ) {
            return array_merge(
                $categories,
                array(
                    array(
                        'slug' => 'mowomo-bloques',
                        'title' => __( 'mowomo bloques', 'mowomo-bloques' ),
                    ),
                )
            );
        }, 10, 2 );
        add_action( 'init', array( $this, 'mwm_bloques_register_dynamic_editor_assets' ) );
    }

    public function mwm_bloques_register_dynamic_editor_assets() {
        $slug              = $this->slug;
        $blockNames        = $this->blockNames;
        $wordpressPackages = $this->wordpressPackages;
        $version           = $this->version;

        wp_register_script(
            $slug .'/editor-script',
            plugins_url('./build/block.build.js', __FILE__),
            $wordpressPackages,
            $version
        );
        wp_register_style(
            $slug .'/editor-style',
            plugins_url('./build/block.editor.build.css', __FILE__),
            array(),
            filemtime( plugin_dir_path( __FILE__ ) . './build/block.editor.build.css' )
        );
        wp_register_style(
            $slug .'/style',
            plugins_url('./build/block.style.build.css', __FILE__),
            array(),
            filemtime( plugin_dir_path( __FILE__ ) . './build/block.style.build.css' )
        );

        wp_register_style("mwm_bloques_aos_css", plugins_url("build/assets/mwm_bloques_aos.css", __FILE__));
        wp_register_script("mwm_bloques_aos_js", plugins_url("build/assets/mwm_bloques_aos.js", __FILE__), ["jquery"]);
        wp_register_script("mwm_bloques_configuration_js", plugins_url("build/assets/mwm_bloques_script.js", __FILE__), ["mwm_bloques_aos_js","jquery"]);
        
        wp_enqueue_style("mwm_bloques_aos_css");
        wp_enqueue_script("mwm_bloques_aos_js");
		wp_enqueue_script("mwm_bloques_configuration_js");

        for ($i=0; $i < count($blockNames); $i++) {
            register_block_type(
                $slug .'/'. $blockNames[$i],
                array(
                    'editor_script' => $slug .'/editor-script',
                    'editor_style'  => $slug .'/editor-style',
                    'style'         => $slug .'/style'
                ) );
        }
    }
}

mowomo_bloques::mwm_bloques__init();
