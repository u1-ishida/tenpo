<?php
/**
 * 会員情報、バリデーションチェック
 *
 * @since 2016-12-15
 * @author y-oishi@netyear.net
 */
class Account extends AppModel {

	public $validate = array(
		'name1' => array(
			'rule1' => array(
				'rule'    => 'notEmpty',
				'message' => 'Please enter your name.'
			),
			'rule2' => array(
				'rule'    => array('maxLength', 80),
				'message' => 'Name must be 80 characters or less.'
			),
		),
		'name2' => array(
			'rule1' => array(
				'rule'    => 'notEmpty',
				'message' => 'Please enter your name.'
			),
			'rule2' => array(
				'rule'    => array('maxLength', 80),
				'message' => 'Name must be 80 characters or less.'
			),
		),
		'email' => array(
			'rule1' => array(
				'rule'    => 'notEmpty',
				'message' => 'Please enter Email.'
			),
			'rule2' => array(
				'rule'    => array('maxLength', 80),
				'message' => 'Email must be 80 characters or less.'
			),
			'rule3' => array(
				'rule'    => 'email',
				'message' => 'Please enter in the format of the Email address.'
			),
		),
		'password' => array(
			'rule1' => array(
				'rule'    => 'notEmpty',
				'message' => 'Please enter Password.'
			),
			'rule2' => array(
				'rule'    => array('minLength', '8'),
				'message' => 'Password must be 8 characters or more.'
			),
			'rule3' => array(
				'rule'    => array('maxLength', 30),
				'message' => 'PASSWORD must be 30 characters or less.'
			),
			'rule4' => array(
				'rule'    => '/^[a-zA-Z0-9!#$%_=+<>\-]+$/',
				'message' => 'The usable character type of password is alphabet, number, and symbol (!#$%-_=+<>)'
			),
		),
		'password2' => array(
			'rule1' => array(
				'rule'    => 'notEmpty',
				'message' => 'Please re-enter Password.'
			),
			'rule2' => array(
				'rule'    => array('minLength', '8'),
				'message' => 'Re-enter PASSWORD must be 8 characters or more.'
			),
			'rule3' => array(
				'rule'    => array('maxLength', 30),
				'message' => 'Re-enter PASSWORD must be 30 characters or less.'
			),
			'rule4' => array(
				'rule'    => '/^[a-zA-Z0-9!#$%_=+<>\-]+$/',
				'message' => 'The usable character type of password is alphabet, number, and symbol (!#$%-_=+<>)'
			),
		),
		'company' => array(
			'rule1' => array(
				'rule'    => 'notEmpty',
				'message' => 'Please enter your company name.'
			),
			'rule2' => array(
				'rule'    => array('maxLength', 80),
				'message' => 'Company must be 80 characters or less.'
			),
		),
		'position' => array(
			'rule'    => array('maxLength', 80),
			'message' => 'Position must be 80 characters or less.'
		),
		'tel' => array(
			'rule1' => array(
				'rule'    => 'notEmpty',
				'message' => 'Please enter your phone number.'
			),
			'rule2' => array(
				'rule'    => array('maxLength', 80),
				'message' => 'Telephone must be 80 characters or less.'
			),
		),

	);

}
?>
