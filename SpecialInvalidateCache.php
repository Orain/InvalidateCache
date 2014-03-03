<?php
/**
 * Copyright (C) 2013 Orain, Kudu and contributors
 *
 * This file is part of InvalidateCache.
 *
 * InvalidateCache is free software: you can redistribute it and/or modify it
 * under the terms of the GNU Affero General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.
 *
 * InvalidateCache is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License
 * for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with InvalidateCache.  If not, see <http://www.gnu.org/licenses/>.
 */

require 'vendor/autoload.php';
use Aws\CloudFront\CloudFrontClient;

class SpecialInvalidateCache extends SpecialPage {
	function __construct() {
		parent::__construct( 'InvalidateCache', 'invalidatecache' );
	}

	function execute( $par ) {
		$this->checkPermissions();
		$this->setHeaders();

		$form = new HTMLForm( array(
			'paths' => array(
					'cols' => 120,
					'label-message' => 'invalidatecache-label-paths',
					'required' => true,
					'rows' => 4,
					'type' => 'textarea',
			 	),
				'comment' => array(
					'label-message' => 'invalidatecache-label-comment',
					'maxlength' => 79,
					'size' => 79,
					'type' => 'text',
			 	),
			)
		);
		$form->setSubmitTextMsg( 'invalidatecache-label-invalidate' );
		$form->setTitle( $this->getTitle() );
		$form->setSubmitCallback( array( 'SpecialInvalidateCache', 'processInput' ) );
		$form->show();
	}

	static function processInput( $formData, $form ) {
		global $wmgHostname, $wgInvalidateCacheAccessKey, $wgInvalidateCacheSecretKey, $wgInvalidateCacheDistributionID;

		$pathText = $formData['paths'];
		$paths = explode( PHP_EOL, $pathText );
		$paths = array_filter( array_map( "trim", $paths ) );

		$notprefixed = false;
		$prefix = '/' . $wmgHostname . '/';
		foreach ( $paths as $path ) {
			if ( substr( $path, 0, strlen( $prefix ) ) !== $prefix ) {
				$notprefixed = true;
				break;
			}
		}

		if ( $notprefixed ) {
			return wfMessage( 'invalidatecache-error-notprefixed' )->plain();
		}

		$pathLine = implode( ',', $paths );

		$logEntry = new ManualLogEntry( 'invalidatecache', 'invalidate' );
		$logEntry->setPerformer( $form->getUser() );
		$logEntry->setTarget( $form->getTitle() );
		$logEntry->setComment( $formData['comment'] );
		$logEntry->setParameters( array(
				'4::paths' => $pathLine,
			)
		);
		$logID = $logEntry->insert();
		$logEntry->publish( $logID );

		$client = CloudFrontClient::factory( array(
			'key'    => $wgInvalidateCacheAccessKey,
			'secret' => $wgInvalidateCacheSecretKey,
		) );

		// Something could be done with the result
		$client->createInvalidation( array(
			'DistributionId' => $wgInvalidateCacheDistributionID,
			'Paths' => array(
				'Quantity' => count( $paths ),
				'Items' => $paths,
			),
			// Invalidation request ID
			'CallerReference' => md5( $pathLine . time() ),
		) );
	}
}

