<?php


namespace Composer;

use Composer\Semver\VersionParser;


class InstalledVersions {
	private static $installed = array(
		'root'     =>
			array(
				'pretty_version' => '1.0.0+no-version-set',
				'version'        => '1.0.0.0',
				'aliases'        =>
					array(),
				'reference'      => null,
				'name'           => '__root__',
			),
		'versions' =>
			array(
				'__root__'      =>
					array(
						'pretty_version' => '1.0.0+no-version-set',
						'version'        => '1.0.0.0',
						'aliases'        =>
							array(),
						'reference'      => null,
					),
				'pimple/pimple' =>
					array(
						'pretty_version' => 'v3.4.0',
						'version'        => '3.4.0.0',
						'aliases'        =>
							array(),
						'reference'      => '86406047271859ffc13424a048541f4531f53601',
					),
				'psr/container' =>
					array(
						'pretty_version' => '1.1.1',
						'version'        => '1.1.1.0',
						'aliases'        =>
							array(),
						'reference'      => '8622567409010282b7aeebe4bb841fe98b58dcaf',
					),
			),
	);


	public static function getInstalledPackages() {
		return array_keys( self::$installed['versions'] );
	}


	public static function isInstalled( $packageName ) {
		return isset( self::$installed['versions'][ $packageName ] );
	}


	public static function satisfies( VersionParser $parser, $packageName, $constraint ) {
		$constraint = $parser->parseConstraints( $constraint );
		$provided   = $parser->parseConstraints( self::getVersionRanges( $packageName ) );

		return $provided->matches( $constraint );
	}


	public static function getVersionRanges( $packageName ) {
		if ( ! isset( self::$installed['versions'][ $packageName ] ) ) {
			throw new \OutOfBoundsException( 'Package "' . $packageName . '" is not installed' );
		}

		$ranges = array();
		if ( isset( self::$installed['versions'][ $packageName ]['pretty_version'] ) ) {
			$ranges[] = self::$installed['versions'][ $packageName ]['pretty_version'];
		}
		if ( array_key_exists( 'aliases', self::$installed['versions'][ $packageName ] ) ) {
			$ranges = array_merge( $ranges, self::$installed['versions'][ $packageName ]['aliases'] );
		}
		if ( array_key_exists( 'replaced', self::$installed['versions'][ $packageName ] ) ) {
			$ranges = array_merge( $ranges, self::$installed['versions'][ $packageName ]['replaced'] );
		}
		if ( array_key_exists( 'provided', self::$installed['versions'][ $packageName ] ) ) {
			$ranges = array_merge( $ranges, self::$installed['versions'][ $packageName ]['provided'] );
		}

		return implode( ' || ', $ranges );
	}


	public static function getVersion( $packageName ) {
		if ( ! isset( self::$installed['versions'][ $packageName ] ) ) {
			throw new \OutOfBoundsException( 'Package "' . $packageName . '" is not installed' );
		}

		if ( ! isset( self::$installed['versions'][ $packageName ]['version'] ) ) {
			return null;
		}

		return self::$installed['versions'][ $packageName ]['version'];
	}


	public static function getPrettyVersion( $packageName ) {
		if ( ! isset( self::$installed['versions'][ $packageName ] ) ) {
			throw new \OutOfBoundsException( 'Package "' . $packageName . '" is not installed' );
		}

		if ( ! isset( self::$installed['versions'][ $packageName ]['pretty_version'] ) ) {
			return null;
		}

		return self::$installed['versions'][ $packageName ]['pretty_version'];
	}


	public static function getReference( $packageName ) {
		if ( ! isset( self::$installed['versions'][ $packageName ] ) ) {
			throw new \OutOfBoundsException( 'Package "' . $packageName . '" is not installed' );
		}

		if ( ! isset( self::$installed['versions'][ $packageName ]['reference'] ) ) {
			return null;
		}

		return self::$installed['versions'][ $packageName ]['reference'];
	}


	public static function getRootPackage() {
		return self::$installed['root'];
	}


	public static function getRawData() {
		return self::$installed;
	}


	public static function reload( $data ) {
		self::$installed = $data;
	}
}
