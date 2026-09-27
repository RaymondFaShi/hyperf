<?php
declare(strict_types=1);

/**
 * 国际化(i18n)配置
 */
return [
    // 默认语言
    'locale' => 'zhCN',

    // 回退语言，当默认语言的语言文本没有提供时，就会使用回退语言的对应语言文本
    'fallback_locale' => 'zhCN',

    // 语言文件存放的文件夹
    'path' => BASE_PATH . 'app/i18n/locales',
];