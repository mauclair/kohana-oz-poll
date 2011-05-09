<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Poll option model
 *
 * @package openzula/kohana-oz-poll
 * @author Alex Cartwright <alex@openzula.org>
 * @copyright (C) 2011 OpenZula
 */
class Model_Oz_Poll_Option extends ORM {

	protected $_belongs_to = array(
		'poll' => array()
	);

	protected $_has_many = array(
		'votes' => array(
			'model'       => 'poll_option_vote',
			'foreign_key' => 'option_id'
		)
	);

	public function rules()
	{
		return array(
			'poll_id' => array(array('not_empty'), array('digit')),
			'name'    => array(array('not_empty')),
		);
	}

	public function filters()
	{
		return array(
			'name' => array(array('trim')),
		);
	}

	/**
	 * Checks the given IP address to see if it has voted on this option
	 *
	 * @param string $ip
	 * @return bool
	 */
	public function has_voted($ip)
	{
		return (bool) $this->votes->where('ip', '=', $ip)->count_all();
	}

	/**
	 * Add a new vote for this poll option from the provided IP address
	 *
	 * @param string $ip
	 * @return bool
	 */
	public function add_vote($ip)
	{
		if ( ! $this->loaded())
			return FALSE;

		$vote = ORM::factory('poll_option_vote');
		$vote->option_id = $this->id;
		$vote->ip = $ip;
		$vote->save();
		return TRUE;
	}

}
