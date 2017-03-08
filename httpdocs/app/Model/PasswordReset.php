<?php
/**
 * パスワードリセット、バリデーションチェック
 *
 * @since 2016-12-15
 * @author y-oishi@netyear.net
 */
class PasswordReset extends AppModel {

	public $validate = array(
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
		)
	);

}
?>
