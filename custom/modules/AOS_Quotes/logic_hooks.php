<?php

$hook_version = 1;
$hook_array = array();
$hook_array['before_save'] = array();
$hook_array['before_save'][] = array(
    1,
    'Unique Oustanding Quote',
    'custom/udd/hooks/modules/AOS_Quotes/QuotesHooks.php',
    'QuotesHooks',
    'before_save'
);

$hook_array['after_save'] = array();
$hook_array['after_save'][] = array(
    1,
    'Unique Oustanding Quote',
    'custom/udd/hooks/modules/AOS_Quotes/QuotesHooks.php',
    'QuotesHooks',
    'after_save'
);

?>