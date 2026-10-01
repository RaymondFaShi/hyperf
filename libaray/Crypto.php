<?php
/**
 * Crypto 加密类
 * @Version 1.0.0
 */
declare( strict_types = 1 );
namespace Libaray;

use Exception;

/**
 * 加密类
 */
final class Crypto {
    /** 加密方式 */
    private readonly string $algorithm;

    /** 初始向量长度 */
    private readonly int $ivLength;

    /** 认证标签长度 */
    private readonly int $tagLength;

    /** 短语口令长度 */
    private readonly int $passphraseLength;

    /**
     * construct
     * @param string $algorithm 加密方式
     * @param int $ivLength 初始向量长度
     * @param int $tagLength 认证标签长度
     * @param int $passphraseLength 短语口令长度
     */
    public function __construct( string $algorithm, int $ivLength, int $tagLength, int $passphraseLength ) {
        // 加密方式
        $this->algorithm = $algorithm;
        
        // 初始向量长度
        $this->ivLength = $ivLength;

        // 认证标签长度
        $this->tagLength = $tagLength;

        // 短语口令长度
        $this->passphraseLength = $passphraseLength;
    }

    /**
     * 加密
     * @param string $plaintext 明文
     * @param string $passphrase 短语口令
     */
    public function encrypt( string $plaintext, string $passphrase ): string {
        // 随机生成iv
        $ivLength = $this->ivLength?: openssl_cipher_iv_length( $this->algorithm );
        if( $ivLength === false ) {
            throw new CryptoException( CryptoErrorCode::UNSUPPORTED_CIPHER );
        }
        $iv = $ivLength > 0? random_bytes( $ivLength ): '';

        // 加密key
        if( strlen( $passphrase ) !== $this->passphraseLength ) {
            throw new CryptoException( CryptoErrorCode::INVALID_PASSPHRASE );
        }

        // 加密数据
        $tag = '';  // 初始化tag
        $ciphertext = openssl_encrypt( $plaintext, $this->algorithm, $passphrase, OPENSSL_RAW_DATA, $iv, $tag, '', $this->tagLength );
        if( $ciphertext === false ) {
            throw new CryptoException( CryptoErrorCode::ENCRYPTION_FAILED );
        }

        // 返回base64
        $payload = json_encode( [
            'iv' => base64_encode( $iv ),
            'tag' => base64_encode( $tag ),
            'ciphertext' => base64_encode( $ciphertext )
        ] );
        if( $payload === false ) {
            throw new CryptoException( CryptoErrorCode::ENCODEING_FAILED );
        }
        return base64_encode( $payload );
    }

    /**
     * 加密
     * @param string $encrypted 密文
     * @param string $passphrase 短语口令
     */
    public function decrypt( $encrypted, string $passphrase ) {
        // 解码数据
        $decodeData = base64_decode( $encrypted, true );    // 第一步，先base64解码
        if( $decodeData === false ) {
            throw new CryptoException( CryptoErrorCode::INVALID_ENCRYPTED_DATA );
        }

        $data = json_decode( $decodeData, true );   // 第二步，json解码转数组
        if( $data === false || array_diff( [ 'iv', 'tag', 'ciphertext' ], array_keys( $data ) ) ) {
            throw new CryptoException( CryptoErrorCode::INVALID_ENCRYPTED_DATA );
        }

        // 获取加密项
        [ 'iv' => $iv, 'tag' => $tag, 'ciphertext' => $ciphertext ] = $data;    // 第三步，获取参与解密的数据
        $iv = base64_decode( $iv, true );
        $tag = base64_decode( $tag, true );
        $ciphertext = base64_decode( $ciphertext, true );
        if( in_array( false, [ $iv, $tag, $ciphertext ], true ) ) {
            throw new CryptoException( CryptoErrorCode::INVALID_ENCRYPTED_DATA );
        }

        // 解密数据
        $plaintext = openssl_decrypt( $ciphertext, $this->algorithm, $passphrase, OPENSSL_RAW_DATA, $iv, $tag );
        if( $plaintext === false ) {
            throw new CryptoException( CryptoErrorCode::DECRYPTION_FAILED );
        }
        return $plaintext;
    }
}

/** 加密错误码 */
final class CryptoErrorCode {
    /** 错误的密码口令 */
    public const int INVALID_PASSPHRASE     = 10001;

    /** 错误的iv长度 */
    public const int UNSUPPORTED_CIPHER     = 10002;

    /** 加密失败 */
    public const int ENCRYPTION_FAILED      = 10003;

    /** 编码失败 */
    public const int ENCODEING_FAILED       = 10004;

    /** 解码失败 */
    public const int INVALID_ENCRYPTED_DATA = 10005;

    /** 解密失败 */
    public const int DECRYPTION_FAILED      = 10006;
}

/** 加密异常 */
class CryptoException extends Exception {
    /**
     * 异常代码
     */
    public const array ERROR_MESSAGES = [
        10001 => 'invalid passphrase',
        10002 => 'unsupported cipher',
        10003 => 'encryption failed',
        10004 => 'encoding failed',
        10005 => 'invalid encrypted data',
        10006 => 'decryption failed',
    ];

    public function __construct( int $code ) {
        $errorMessage = self::ERROR_MESSAGES[ $code ];

        parent::__construct( $errorMessage, $code, null );
    }
}