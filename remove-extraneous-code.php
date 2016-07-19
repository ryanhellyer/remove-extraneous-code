<?php
/*
Plugin Name: Remove Extraneous Code
Plugin URI: https://geek.hellyer.kiwi/
Description: Removes extraneous unwanted code added to posts.
Version: 1.1
Author: Ryan Hellyer
Author URI: https://geek.hellyer.kiwi/
License: GPL2

------------------------------------------------------------------------
Copyright Ryan Hellyer

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA

*/



/**
 * Do not continue processing since file was called directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Eh! What you doin in here?' );
}


/**
 * Remove Extraneous Code on saving a post.
 *
 * @copyright Copyright (c), Ryan Hellyer
 * @license http://www.gnu.org/licenses/gpl.html GPL
 * @author Ryan Hellyer <ryanhellyer@gmail.com>
 */
class Remove_Extraneous_Code {

	/**
	 * Set the HTML to be allowed.
	 */
	private $allowed_html = array(
		'address' => array(),
		'a' => array(
			'id' => true,
			'href' => true,
			'rel' => true,
			'rev' => true,
			'name' => true,
			'target' => true,
		),
		'abbr' => array(),
		'acronym' => array(),
		'audio' => array(
			'autoplay' => true,
			'controls' => true,
			'loop' => true,
			'muted' => true,
			'preload' => true,
			'src' => true,
		),
		'b' => array(),
		'bdo' => array(
			'dir' => true,
		),
		'big' => array(),
		'blockquote' => array(
			'cite' => true,
			'lang' => true,
			'xml:lang' => true,
		),
		'br' => array(),
		'button' => array(
			'disabled' => true,
			'name' => true,
			'type' => true,
			'value' => true,
		),
		'caption' => array(),
		'cite' => array(
			'dir' => true,
			'lang' => true,
		),
		'code' => array(),
		'col' => array(
			'char' => true,
			'charoff' => true,
			'span' => true,
			'dir' => true,
			'valign' => true,
			'width' => true,
		),
		'colgroup' => array(
			'char' => true,
			'charoff' => true,
			'span' => true,
			'valign' => true,
			'width' => true,
		),
		'del' => array(
			'datetime' => true,
		),
		'dd' => array(),
		'dfn' => array(),
		'details' => array(
			'dir' => true,
			'lang' => true,
			'open' => true,
			'xml:lang' => true,
		),
		'dl' => array(
			'id' => true,
		),
		'dt' => array(
			'id' => true,
		),
		'em' => array(),
		'fieldset' => array(),
		'figure' => array(
			'dir' => true,
			'lang' => true,
			'xml:lang' => true,
		),
		'figcaption' => array(
			'dir' => true,
			'lang' => true,
			'xml:lang' => true,
		),
		'form' => array(
			'action' => true,
			'accept' => true,
			'accept-charset' => true,
			'enctype' => true,
			'method' => true,
			'name' => true,
			'target' => true,
		),
		'h1' => array(
			'id' => true,
		),
		'h2' => array(
			'id' => true,
		),
		'h3' => array(
			'id' => true,
		),
		'h4' => array(
			'id' => true,
		),
		'h5' => array(
			'id' => true,
		),
		'h6' => array(
			'id' => true,
		),
		'hr' => array(
			'id' => true,
		),
		'i' => array(),
		'img' => array(
			'id' => true,
			'alt' => true,
			'class' => true,
			'height' => true,
			'src' => true,
			'width' => true,
		),
		'ins' => array(
			'datetime' => true,
			'cite' => true,
		),
		'kbd' => array(),
		'label' => array(
			'for' => true,
		),
		'legend' => array(),
		'li' => array(
			'id' => true,
		),
		'p' => array(
			'id' => true,
			'dir' => true,
			'lang' => true,
			'xml:lang' => true,
			'style' => true,
		),
		'pre' => array(),
		'q' => array(
			'cite' => true,
		),
		's' => array(),
		'samp' => array(),
		'small' => array(),
		'strike' => array(),
		'strong' => array(),
		'sub' => array(),
		'summary' => array(
			'dir' => true,
			'lang' => true,
			'xml:lang' => true,
		),
		'sup' => array(),
		'table' => array(
			'id' => true,
			'dir' => true,
			'rules' => true,
			'summary' => true,
		),
		'tbody' => array(
			'char' => true,
			'charoff' => true,
		),
		'td' => array(
			'abbr' => true,
			'axis' => true,
			'char' => true,
			'charoff' => true,
			'colspan' => true,
			'dir' => true,
			'headers' => true,
			'nowrap' => true,
			'rowspan' => true,
			'scope' => true,
		),
		'textarea' => array(
			'cols' => true,
			'rows' => true,
			'disabled' => true,
			'name' => true,
			'readonly' => true,
		),
		'tfoot' => array(
			'char' => true,
			'charoff' => true,
		),
		'th' => array(
			'abbr' => true,
			'axis' => true,
			'char' => true,
			'charoff' => true,
			'colspan' => true,
			'headers' => true,
			'height' => true,
			'nowrap' => true,
			'rowspan' => true,
			'scope' => true,
		),
		'thead' => array(
			'char' => true,
			'charoff' => true,
		),
		'title' => array(),
		'tr' => array(
			'char' => true,
			'charoff' => true,
		),
		'track' => array(
			'default' => true,
			'kind' => true,
			'label' => true,
			'src' => true,
			'srclang' => true,
		),
		'tt' => array(),
		'u' => array(),
		'ul' => array(
			'type' => true,
		),
		'ol' => array(
			'start' => true,
			'type' => true,
			'reversed' => true,
		),
		'var' => array(),
		'video' => array(
			'id' => true,
			'autoplay' => true,
			'controls' => true,
			'height' => true,
			'loop' => true,
			'muted' => true,
			'poster' => true,
			'preload' => true,
			'src' => true,
			'width' => true,
		),
	);

	/**
	 * Class constructor
	 * Adds methods to appropriate hooks
	 */
	public function __construct() {
		add_filter( 'content_save_pre', array( $this, 'modify_post_content' ) );
	}

	/**
	 * Modifying the post content.
	 *
	 * @param  string  $content  The initial post content
	 * @param  string  The modified post content
	 */
	public function modify_post_content( $content ) {

		$content = wp_kses( $content, $this->allowed_html );

		return $content;
	}

}
new Remove_Extraneous_Code;
