<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Poll option vote model
 *
 * @package openzula/kohana-oz-poll
 * @author Alex Cartwright <alex@openzula.org>
 * @copyright (C) 2011 OpenZula
 */
class Model_Oz_Poll_Option_Vote extends ORM {

	protected $_belongs_to = array(
		'option' => array(
			'model'       => 'poll_option',
			'foreign_key' => 'option_id',
		)
	);

	public function rules()
	{
		return array(
			'option_id' => array(array('not_empty'), array('digit')),
			'ip'        => array(array('not_empty')),
		);
	}

}