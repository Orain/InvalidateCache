<?php
/**
 * Internationalisation file for the InvalidateCache extension
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Kudu
 */
$messages['en'] = array(
	'invalidatecache'                     => 'Invalidate the cache',
	'invalidatecache-desc'                => 'Invalidate the cache',
	'invalidatecache-label-comment'       => 'Comment',
	'invalidatecache-label-invalidate'    => 'Invalidate',
	'invalidatecache-label-paths'         => 'Paths',
	'invalidatecache-error-notprefixed'   => 'All paths must begin with the website\'s hostname.',
	'invalidatecache-success'             => 'The paths were successfully invalidated.',
	'log-description-invalidatecache'     => 'This is a log of cache invalidations.',
	'log-name-invalidatecache'            => 'Cache invalidation log',
	'logentry-invalidatecache-invalidate' => '$1 invalidated the paths: $4',
);

/** Message documentation (Message documentation)
 * @author Kudu
 */
$messages['qqq'] = array(
	'invalidatecache'                     => 'The title of Special:InvalidateCache.',
	'invalidatecache-desc'                => 'The description of the extension.',
	'invalidatecache-label-comment'       => 'The label for the Comment field.',
	'invalidatecache-label-invalidate'    => 'The label for the Invalidate button.',
	'invalidatecache-label-paths'         => 'The label for the Paths field.'
	'invalidatecache-error-notprefixed'   => 'The error message displayed when a path does not begin with the website\'s hostname.',
	'invalidatecache-success'             => 'The message displayed when the paths were successfully invalidated.',
	'log-description-invalidatecache'     => 'The description of the cache invalidation log.',
	'log-name-invalidatecache'            => 'The name of the cache invalidation log.',
	'logentry-invalidatecache-invalidate' => 'The format of the log entry for cache invalidation. Parameters:
* $1 = user who invalidated the cache
* $4 = invalidated paths',
);

