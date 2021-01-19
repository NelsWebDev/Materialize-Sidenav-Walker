<?php

/**
 * Author: Nels
 * Site: https://nels.app
 * Class: Materialize Sidenav Walker
 * Description: WordPress walker for a Materialize Sidenav menu (not affiliated)
 * Version 1.0
 */

 

class Materialize_Sidenav_Walker extends Walker_Nav_Menu {



	/**
	 * Check if item has children
	 *
	 * @param WP_POST $item Menu item object to check
	 * @return boolean
	 */
	function has_children( $item ) {
		return ( in_array( 'menu-item-has-children', $item->classes ) );
	}

	/**
	 * Called when item is a child or has no parent
	 *
	 * @param string  $output menu output string
	 * @param WP_POST $item Item to output formatted string
	 * @return void
	 */
	private function start_standard_el( &$output, $item ) {
		$output .= sprintf(
			'<li class="%s">
                                  <a href="%s">%s</a>
                            </li>',
			implode( ' ', $item->classes ),
			$item->url,
			$item->title
		);
	}

	/**
	 * Initilize menu item that has a parent. (Ignores parent link)
	 *
	 * Defaults to include arrow_drop_down icon.
	 * Feel free to change it or leave blank to remove completely
	 *
	 * @param $output menu output string
	 * @param WP_POST                   $item Item to output formatted string
	 * @param stdClass                  $args walker args
	 * @return void
	 */
	private function start_parent_el( &$output, $item, $args ) {

		$output .= sprintf(
			'<li class="%s no-padding"></li>
        
                <ul class="collapsible collapsible-accordion">
                    <li>
                <a class="collapsible-header">%s',
			implode( ' ', $item->classes ),
			$item->title
		);

		if ( ! isset( $args->dropdown_icon ) || $args->dropdown_icon === true ) {
			 $args->dropdown_icon = 'arrow_drop_down';
		}
		if ( $args->dropdown_icon ) {
			$output .= '<i class="material-icons">' . $args->dropdown_icon . '</i>';
		}
		$output .= '</a>';
	}

	/**
	 * @see Walker_Nav_Menu::start_el()
	 */
	function start_el( &$output, $item, $depth = null, $args = null, $id = 0 ) {

		if ( $this->has_children( $item ) ) {
			$this->start_parent_el( $output, $item, $args );
		} else {
			$this->start_standard_el( $output, $item );
		}
	}

	 /**
	  * @see Walker_Nav_Menu::end_el()
	  */

	function end_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {

		if ( $this->has_children( $item ) ) {
			$output .= '</li></ul></li>';
		} else {
			$output .= '</li>';
		}
	}
	 /**
	  * @see Walker_Nav_Menu::start_lvl()
	  */
	function start_lvl( &$output, $depth = null, $args = null ) {

		$output .= '<div class="collapsible-body">
            <ul>';
	}
	 /**
	  * @see Walker_Nav_Menu::end_lvl()
	  */
	function end_lvl( &$output, $depth = 0, $args = null ) {

		$output .= '</ul></div>';
	}
}
