<?php

/**
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 * @since 1.25
 *
 * @ingroup Site
 * @ingroup Test
 *
 * @covers SiteListFileCacheBuilder
 * @group Site
 *
 * @licence GNU GPL v2+
 * @author Katie Filbert < aude.wiki@gmail.com >
 */
class SiteListFileCacheBuilderTest extends PHPUnit_Framework_TestCase {

	public function testBuild() {
		$cacheFile = $this->getCacheFile();

		$cacheBuilder = $this->newSiteListFileCacheBuilder( $this->getSites(), $cacheFile );
		$cacheBuilder->build();

		$contents = file_get_contents( $cacheFile );
		$this->assertEquals( json_encode( $this->getExpectedData() ), $contents );
	}

	private function getExpectedData() {
		return array(
			'sites' => array(
				'foobar' => array(
					'globalid' => 'foobar',
					'type' => 'unknown',
					'group' => 'none',
					'source' => 'local',
					'language' => null,
					'localids' => array(),
					'config' => array(),
					'data' => array(),
					'forward' => false,
					'internalid' => null,
					'identifiers' => array()
				),
				'enwiktionary' => array(
					'globalid' => 'enwiktionary',
					'type' => 'mediawiki',
					'group' => 'wiktionary',
					'source' => 'local',
					'language' => 'en',
					'localids' => array(
						'equivalent' => array( 'enwiktionary' )
					),
					'config' => array(),
					'data' => array(
						'paths' => array(
							'page_path' => 'https://en.wiktionary.org/wiki/$1',
							'file_path' => 'https://en.wiktionary.org/w/$1'
						)
					),
					'forward' => false,
					'internalid' => null,
					'identifiers' => array(
						array(
							'type' => 'equivalent',
							'key' => 'enwiktionary'
						)
					)
				)
			)
		);
	}

	private function newSiteListFileCacheBuilder( SiteList $sites, $cacheFile ) {
		return new SiteListFileCacheBuilder(
			$this->getSiteSQLStore( $sites ),
			$cacheFile
		);
	}

	private function getSiteSQLStore( SiteList $sites ) {
		$siteSQLStore = $this->getMockBuilder( 'SiteSQLStore' )
			->disableOriginalConstructor()
			->getMock();

		$siteSQLStore->expects( $this->any() )
			->method( 'getSites' )
			->will( $this->returnValue( $sites ) );

		return $siteSQLStore;
	}

	private function getSites() {
		$sites = array();

		$site = new Site();
		$site->setGlobalId( 'foobar' );
		$sites[] = $site;

		$site = new MediaWikiSite();
		$site->setGlobalId( 'enwiktionary' );
		$site->setGroup( 'wiktionary' );
		$site->setLanguageCode( 'en' );
		$site->addNavigationId( 'enwiktionary' );
		$site->setPath( MediaWikiSite::PATH_PAGE, "https://en.wiktionary.org/wiki/$1" );
		$site->setPath( MediaWikiSite::PATH_FILE, "https://en.wiktionary.org/w/$1" );
		$sites[] = $site;

		return new SiteList( $sites );
	}

	private function getCacheFile() {
		return sys_get_temp_dir() . '/sites-' . time() . '.json';
	}

}
