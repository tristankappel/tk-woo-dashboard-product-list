<?php
/* ADD PRODUCT LIST PAGE TO WP DASHBOARD */
if ( class_exists( 'WooCommerce' ) ):
	add_action( 'admin_menu', 'tk_wp_dashboard_products_new_page', 9999 );
	
	function tk_wp_dashboard_products_new_page() {
		add_submenu_page( 
			'edit.php?post_type=product', 
			__("Product List", "tk"), 
			__("Product List", "tk"), 
			'edit_products', 
			'product-list', 
			'tk_wp_dashboard_products_new_page_callback', 
			9999 );
	}
	
	function tk_wp_dashboard_products_new_page_callback() {
		$query = new WC_Product_Query( array(
			'orderby' => 'title',
			'order' => 'ASC',
		) );
		$products = $query->get_products();
		echo '<div class="wrap"><h1>' . __("Product List", "tk") . '</h1>';
			if($products):
				echo '<table>';
					echo '<tr>';
						echo '<th>' . __("Name", "tk") . '</th>';
						echo '<th>' . __("ID", "tk") . '</th>';
						echo '<th>' . __("Parent ID", "tk") . '</th>';
						echo '<th>' . __("Type", "tk") . '</th>';
						echo '<th>' . __("SKU", "tk") . '</th>';
						echo '<th>' . __("Price", "tk") . '</th>';
						echo '<th>' . __("Stock Quantity", "tk") . '</th>';
					echo '</tr>';
					foreach( $products as $product ):
						echo '<tr>';
							echo '<td>' . $product->get_name() . '</td>';
							echo '<td>' . $product->get_ID()  . '</td>';
							echo '<td>' . $product->get_parent_ID()  . '</td>';
							echo '<td>' . $product->get_type()  . '</td>';
							echo '<td>' . $product->get_sku()  . '</td>';
							echo '<td>' . $product->get_price()  . '</td>';
							echo '<td>' . $product->get_stock_quantity()  . '</td>';
						echo '</tr>';
						if( $product->get_type() == 'variable'):
							$variationIDs = $product->get_children();
							foreach( $variationIDs as $variationID ):
								$variation = wc_get_product( $variationID  );
								echo '<tr class="child">';
									echo '<td>' . $variation->get_name() . '</td>';
									echo '<td>' . $variation->get_ID()  . '</td>';
									echo '<td>' . $variation->get_parent_ID()  . '</td>';
									echo '<td>' . $variation->get_type()  . '</td>';
									echo '<td>' . $variation->get_sku()  . '</td>';
									echo '<td>' . $variation->get_price()  . '</td>';
									echo '<td>' . $variation->get_stock_quantity()  . '</td>';
								echo '</tr>';
							endforeach;							
						endif;
					endforeach;
				echo '</table>';
			endif;
		echo '</div>';
		echo '
		<style>
			table {
				border-collapse: collapse;
			}
			table, th, td {
				border: 1px solid black;
				text-align: left;
				padding: 5px;
			}
			tr.child > td:first-child {
				padding-left: 30px;
			}
		</style>
		';
	}
endif;