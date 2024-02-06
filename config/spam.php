<?php

return [
    /**
     * Email domains or TLDs to systematically mark as spam
     * Comma-separated
     */
    'email_blacklist' => env('SPAM_EMAIL_BLACKLIST', 'ru'),

    /**
     * Words to systematically mark as spam
     * Comma-separated
     */
    'words_blacklist' => env('SPAM_WORDS', 'hedge fund,capital financing,business insights,business investment'),

    /**
     * Automatically flag all messages containing URLs as spam unless they use the domains listed in the next setting
     */
    'flag_all_urls' => env('SPAM_FLAG_ALL_URLS', true),

    /**
     *  Domain names or TLDs that will not trip the URL detection
     *  Comma-separated
     */
    'trusted_tlds' => env('SPAM_TRUSTED_TLDS', 'ch'),

    /**
     * Whether to send the regular notification email for spam submissions
     */
    'send_notification_for_spam' => env('SPAM_SEND_NOTIFICATION', false),

    /**
     * Whether to send the regular confirmation email to the submitted for spam submissions
     */
    'send_confirmation_for_spam' => env('SPAM_SEND_CONFIRMATION', false),
];
