<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Poll model
 *
 * @package openzula/kohana-oz-poll
 * @author Alex Cartwright <alex@openzula.org>
 * @copyright (C) 2011 OpenZula
 */
class Model_Oz_Poll extends ORM {

	protected $_has_many = array(
		'options' => array(
			'model' => 'poll_option'
		)
	);

	public function rules()
	{
		return array(
			'status'     => array(
				array('in_array', array(':value', array('active', 'closed')))
			),
			'name'       => array(array('not_empty')),
		);
	}

	public function filters()
	{
		return array(
			'name' => array(array('trim')),
		);
	}

	/**
	 * Attempts to find the option that the provided ip voted on
	 *
	 * @param string $ip
	 * @return NULL|Model_Poll_Option
	 */
	public function option_by_vote_ip($ip)
	{
		if ($this->loaded())
		{
			foreach ($this->options->find_all() as $option)
			{
				if ($option->has_voted($ip))
					return $option;
			}
		}
	}

	/**
	 * Override the save() method to provide some default value for columns
	 *
	 * @return mixed
	 */
	public function save(Validation $validation = NULL)
	{
		if ( ! $this->loaded())
		{
			$this->start_date = Db::expr('UTC_TIMESTAMP()');
		}

		return parent::save($validation);
	}

}