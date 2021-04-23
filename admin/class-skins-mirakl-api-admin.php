<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.crestinfosystems.com
 * @since      1.0.0
 *
 * @package    Skins_Mirakl_Api
 * @subpackage Skins_Mirakl_Api/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Skins_Mirakl_Api
 * @subpackage Skins_Mirakl_Api/admin
 * @author     Crest Infosystem Pvt Ltd <chirag.parmar@crestinsosystems.com>
 */
class Skins_Mirakl_Api_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	private $endpoint;

	private $shopkey;

	private $import_product;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->endpoint = 'https://marketplace-decathlon-eu.mirakl.net';
		$this->shopkey = '8323110b-fde6-4aed-8c58-e8c64499c0f4';
		$this->import_product = '/api/products/imports';

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Skins_Mirakl_Api_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Skins_Mirakl_Api_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/skins-mirakl-api-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Skins_Mirakl_Api_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Skins_Mirakl_Api_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/skins-mirakl-api-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function skins_export_products(){
        if($_REQUEST['run']!='cronjob'){
            return 0;
        }
        // pr(get_all_active_sites(),0);
        
        // $blog_id = 14;//production site
        $blog_id = 5;//staging site
        
        switch_to_blog( $blog_id );
        
        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => 2
        );
    
        $loop = new WP_Query( $args );
        echo $loop->post_count;
		// pr($this->plugin_name,0);
		// pr($this->endpoint,0);
		// pr($this->shopkey,0);
		// pr($this->import_product);
		$cnt = 0;
        $all_product = array();
        while ( $loop->have_posts() ) : $loop->the_post();
			$cnt++;
            global $product;
            $product_id = get_the_ID();
			
            $product = wc_get_product($product_id);
            $stock = $product->get_stock_quantity();
            $child_products = $product->get_children();
			
			$custom_fields = get_fields($product_id);
			$brand = 'SKINS';
            $product_title = get_the_title($product_id);
			$product_desc = get_the_content($product_id);
			$ean_code = $custom_fields['ean_code'];
			
			$gender = wp_get_post_terms( $product->get_id(), 'gender', array( 'fields' => 'names' ) );
			$product_cat = wp_get_post_terms( $product->get_id(), 'product_cat', array( 'fields' => 'names' ) );
			
			// pr(get_option('active_plugins'),0);
			// pr(get_option('fs_active_plugins'),0);
			
			// $gender = wp_get_post_terms( $product->get_id(), 'gender', array( 'fields' => 'names' ) );
			
			$description_de_de = $custom_fields['description_de-de'];
			$description_es_es = $custom_fields['description_es-es'];
			$description_fr_be = $custom_fields['description_fr-be'];
			$description_fr_fr = $custom_fields['description_fr-fr'];
			$description_it_it = $custom_fields['description_it-it'];
			$description_nl_be = $custom_fields['description_nl-be'];
			$description_nl_nl = $custom_fields['description_nl-nl'];
			$description_pl_pl = $custom_fields['description_pl-pl'];
			$description_pt_pt = $custom_fields['description_pt-pt'];
            $product_identifier = $product->get_sku();
			$product_title_de_de = $custom_fields['product_title_de-de'];
			$product_title_en_gb = $custom_fields['product_title_en-gb'];
			$product_title_es_es = $custom_fields['product_title_es-es'];
			$product_title_fr_be = $custom_fields['product_title_fr-be'];
			$product_title_fr_fr = $custom_fields['product_title_fr-fr'];
			$product_title_it_it = $custom_fields['product_title_it-it'];
			$product_title_nl_be = $custom_fields['product_title_nl-be'];
			$product_title_nl_nl = $custom_fields['product_title_nl-nl'];
			$product_title_pl_pl = $custom_fields['product_title-pl-pl'];
			$product_title_pt_pt = $custom_fields['product_title_pt-pt'];
			
			$featured_image = '';
			if ( has_post_thumbnail( $product_id ) ) {
                $attachment_ids[0] = get_post_thumbnail_id( $product_id );
                $featured_image = wp_get_attachment_image_src($attachment_ids[0], 'full' )[0];
			}
			
			$attachment_ids = $product->get_gallery_attachment_ids();
			
		    $image_1 = 'not available';
			if($attachment_ids[0]){
			    $image_1 = wp_get_attachment_url( $attachment_ids[0] );
			}
			
		    $image_2 = 'not available';
			if($attachment_ids[1]){
			    $image_2 = wp_get_attachment_url( $attachment_ids[1] );
			}
			
		    $image_3 = 'not available';
			if($attachment_ids[2]){
			    $image_3 = wp_get_attachment_url( $attachment_ids[2] );
			}
			
		    $image_4 = 'not available';
			if($attachment_ids[3]){
			    $image_4 = wp_get_attachment_url( $attachment_ids[3] );
			}
			
// 			if($cnt == 1)
// 			{
// 				pr($product_title,0);
// 				pr($brand,0);
// 				pr($product_desc,0);
// 				pr($ean_code,0);
// 				pr($product_cat,0);
// 				pr($gender,0);
// 				pr($custom_fields,0);
// 				pr($featured_image,0);
// 				pr($attachment_ids,0);
// 				pr($image_1,0);
// 				pr($image_2,0);
// 				pr($image_3,0);
// 				pr($image_4,0);
// 			}
                
			$products= array('Category',$brand,$ean_code,$description_de_de,$product_desc,$description_es_es,$description_fr_be,$description_fr_fr,$description_it_it,$description_nl_be,$description_nl_nl,$description_pl_pl,$description_pt_pt,'gender',$image_1,$image_2,$image_3,$image_4,$featured_image,$product_title,'parent_sku',$product_identifier,$product_title_de_de,$product_title_en_gb,$product_title_es_es,$product_title_fr_be,$product_title_fr_fr,$product_title_it_it,$product_title_nl_be,$product_title_nl_nl,$product_title_pl_pl,$product_title_pt_pt);
			
			$all_product[] = $products;
// 			echo '<br/><a href="'.get_permalink().'">'.get_the_title().'</a>';
			// pr($meta,0);
			// pr($current_products,0);
			if(!empty($child_products))
			{
				foreach($child_products as $key => $child_product_id){
					$cnt++;
					$child_product_title = get_the_title($child_product_id);
					$child_product = wc_get_product($child_product_id);
					$child_meta = get_post_meta($child_product_id);
					$child_stock = $child_product->get_stock_quantity();
					$child_sku = $child_product->get_sku();
					$child_custom_fields = get_fields($child_product_id);

				// 	if($cnt == 2)
				// 	{
				// 		pr($child_custom_fields);
				// 	}
					
				// 	echo '<br/><a href="'.get_permalink($child_product_id).'">'.get_the_title($child_product_id).'</a>';
					// pr($child_meta,0);
                
        			$products= array('Category',$brand,$ean_code,$description_de_de,$product_desc,$description_es_es,$description_fr_be,$description_fr_fr,$description_it_it,$description_nl_be,$description_nl_nl,$description_pl_pl,$description_pt_pt,'gender',$image_1,$image_2,$image_3,$image_4,$featured_image,$child_product_title,'parent_sku',$product_identifier,$product_title_de_de,$product_title_en_gb,$product_title_es_es,$product_title_fr_be,$product_title_fr_fr,$product_title_it_it,$product_title_nl_be,$product_title_nl_nl,$product_title_pl_pl,$product_title_pt_pt);
					$all_product[] = $products;
				}
			}
        endwhile;

        pr($cnt,0);
        //skins-mirakl-files
        //Write CSV file for import call
        $upload_dir   = wp_upload_dir();
        
        $dir = $upload_dir['basedir'].'/skins-mirakl-files/';
        
        $csv_filename = "import_product_".date("Y-m-d_H-i",time()).".csv";
        $filename = $dir.$csv_filename;

		pr($filename,0);
        // open the file for writing
        $export_product_file = fopen($filename, 'w');
        
        // save the column headers
        fputcsv($export_product_file, array('Category','Brand','codes EAN','Description de-de','Description en-GB','Description es-ES','Description fr-be','Description fr-FR','Description it-IT','Description nl-be','Description nl-NL','Description pl-PL','Description pt-PT','gender','Image 2','Image 3','Image 4','Image 5','Main Image','Main Title','Parent Product ID','Product Identifier','Product Title de-de','Product Title en-GB','Product Title es-ES','Product Title fr-be','Product Title fr-FR','Product Title it-IT','Product Title nl-be','Product Title nl-NL','Product Title pl-PL','Product Title pt-PT'));
        pr($export_product_file,0);
        // save each row of the data
        foreach ($all_product as $row)
        {
            fputcsv($export_product_file, $row);
        }
        
        // Close the file
        fclose($export_product_file);
    
        wp_reset_query();
        
        restore_current_blog();
        
		die('Success!');
	}

}
