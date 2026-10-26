<?php
// *	@copyright	OPENCART.PRO 2011 - 2015.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

final class Encryption {
	const CIPHER = 'aes-256-cbc';

	private $key;

	public function __construct($key) {
		$this->key = hash('sha256', $key, true);
	}

	public function encrypt($value) {
		$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(self::CIPHER));

		return strtr(base64_encode($iv . openssl_encrypt((string)$value, self::CIPHER, $this->key, OPENSSL_RAW_DATA, $iv)), '+/=', '-_,');
	}

	public function decrypt($value) {
		$data = base64_decode(strtr((string)$value, '-_,', '+/='));
		$iv_length = openssl_cipher_iv_length(self::CIPHER);

		if ($data === false || strlen($data) <= $iv_length) {
			return '';
		}

		return trim((string)openssl_decrypt(substr($data, $iv_length), self::CIPHER, $this->key, OPENSSL_RAW_DATA, substr($data, 0, $iv_length)));
	}
}
