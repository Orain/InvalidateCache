<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'author' => 'Kudu',
	'descriptionmsg' => 'invalidatecache-desc',
	'name' => 'InvalidateCache',
	'path' => __FILE__,
	'url' => '//github.com/Orain/InvalidateCache'
);

$wgAutoloadClasses['SpecialInvalidateCache'] = dirname( __FILE__ ) . '/SpecialInvalidateCache.php';
$wgExtensionMessagesFiles['InvalidateCache'] = dirname( __FILE__ ) . '/InvalidateCache.i18n.php';
$wgExtensionMessagesFiles['InvalidateCacheAlias'] = dirname( __FILE__ ) . '/InvalidateCache.alias.php';
$wgSpecialPages['InvalidateCache'] = 'SpecialInvalidateCache';

$wgAvailableRights[] = 'invalidatecache';
$wgLogTypes[] = 'invalidatecache';
$wgLogActionsHandlers['invalidatecache/invalidate'] = 'LogFormatter';

