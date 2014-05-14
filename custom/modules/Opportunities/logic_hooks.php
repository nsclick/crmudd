<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['before_save'] = Array(); 
$hook_array['before_save'][] = Array(77, 'updateGeocodeInfo', 'custom/modules/Opportunities/OpportunitiesJjwg_MapsLogicHook.php','OpportunitiesJjwg_MapsLogicHook', 'updateGeocodeInfo'); 
$hook_array['before_save'][] = Array(1, 'Opportunities push feed', 'modules/Opportunities/SugarFeeds/OppFeed.php','OppFeed', 'pushFeed'); 
$hook_array['before_save'][] = Array(1, 'Unique Oustanding Quote Opportunity Update', 'custom/udd/hooks/modules/Opportunities/OpportunitiesHooks.php','OpportunitiesHooks', 'before_save'); 
$hook_array['after_ui_frame'] = Array(); 
$hook_array['after_save'] = Array(); 
$hook_array['after_save'][] = Array(77, 'updateRelatedMeetingsGeocodeInfo', 'custom/modules/Opportunities/OpportunitiesJjwg_MapsLogicHook.php','OpportunitiesJjwg_MapsLogicHook', 'updateRelatedMeetingsGeocodeInfo'); 
$hook_array['after_save'][] = Array(78, 'updateRelatedProjectGeocodeInfo', 'custom/modules/Opportunities/OpportunitiesJjwg_MapsLogicHook.php','OpportunitiesJjwg_MapsLogicHook', 'updateRelatedProjectGeocodeInfo'); 
$hook_array['after_save'][] = Array(1, 'Unique Oustanding Quote Opportunity Update', 'custom/udd/hooks/modules/Opportunities/OpportunitiesHooks.php','OpportunitiesHooks', 'after_save'); 
$hook_array['after_relationship_add'] = Array(); 
$hook_array['after_relationship_add'][] = Array(77, 'addRelationship', 'custom/modules/Opportunities/OpportunitiesJjwg_MapsLogicHook.php','OpportunitiesJjwg_MapsLogicHook', 'addRelationship'); 
$hook_array['after_relationship_delete'] = Array(); 
$hook_array['after_relationship_delete'][] = Array(77, 'deleteRelationship', 'custom/modules/Opportunities/OpportunitiesJjwg_MapsLogicHook.php','OpportunitiesJjwg_MapsLogicHook', 'deleteRelationship'); 

$hook_array['before_save'][] = array(
	1,
    'Unique Oustanding Quote Opportunity Update',
    'custom/udd/hooks/modules/Opportunities/OpportunitiesHooks.php',
    'OpportunitiesHooks',
    'before_save'
);

$hook_array['after_save'][] = array(
	1,
    'Unique Oustanding Quote Opportunity Update',
    'custom/udd/hooks/modules/Opportunities/OpportunitiesHooks.php',
    'OpportunitiesHooks',
    'after_save'
);

?>