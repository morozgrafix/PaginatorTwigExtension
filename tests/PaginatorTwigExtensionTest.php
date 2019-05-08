<?php
namespace Morozgrafix\Twig\Extension;

require __DIR__ . '/../src/PaginatorTwigExtension.php';
use Morozgrafix\Twig\Extension\PaginatorTwigExtension;
use PHPUnit\Framework\TestCase;

final class PaginatorTwigExtensionTest extends TestCase {

	private $extension;

	public function setUp(): void {
		$this->extension = new PaginatorTwigExtension();
	}

	/**
	 * @testdox Extension name is returned
	 */
	public function testExtensionName(): void {
		$this->assertEquals(
			'paginator',
			$this->extension->getName()
		);
	}

	/**
	 * @testdox Minimum Number of items is set to 7
	 */
	public function testSetsMinNumItems(): void {
		$pagination = $this->extension->generatePaginationData(1, 10, 5);
		$this->assertEquals(
			$pagination['num_items'],
			7
		);
	}

	/**
	 * @testdox Number of items is even number
	 */
	public function testNumItemsIsEven(): void {
		$pagination = $this->extension->generatePaginationData(1, 10, 8);
		$this->assertEquals(
			$pagination['num_items'],
			9
		);
	}

	/**
	 * @testdox Pagination returned when Last Page is lower than Number of Items
	 */
	public function testLastPageLowerThanNumItems(): void {
		$pagination = $this->extension->generatePaginationData(1, 10, 11);
		$expected = array(
			'curr_page' => 1,
			'last_page' => 10,
			'num_items' => 11,
			'separator' => '...',
			'pagination' => range(1, 10)
		);
		$this->assertEquals(
			$pagination,
			$expected
		);
	}

	/**
	 * @testdox Pagination returned when Last Page equals Number of Items
	 */
	public function testLastPageEqualsNumItems(): void {
		$pagination = $this->extension->generatePaginationData(1, 11, 11);
		$expected = array(
			'curr_page' => 1,
			'last_page' => 11,
			'num_items' => 11,
			'separator' => '...',
			'pagination' => range(1, 11)
		);
		$this->assertEquals(
			$pagination,
			$expected
		);
	}

	/**
	 * @testdox Pagination returned with front separator
	 */
	public function testPaginationWithFrontSeparator(): void {
		$pagination = $this->extension->generatePaginationData(7, 8, 7);
		$expected = array(
			'curr_page' => 7,
			'last_page' => 8,
			'num_items' => 7,
			'separator' => '...',
			'pagination' => array(1, '...', 4, 5, 6, 7, 8)
		);
		$this->assertEquals(
			$pagination,
			$expected
		);
	}


	/**
	 * @testdox Pagination returned with end separator
	 */
	public function testPaginationWithEndSeparator(): void {
		$pagination = $this->extension->generatePaginationData(1, 8, 7);
		$expected = array(
			'curr_page' => 1,
			'last_page' => 8,
			'num_items' => 7,
			'separator' => '...',
			'pagination' => array(1, 2, 3, 4, 5, '...', 8)
		);
		$this->assertEquals(
			$pagination,
			$expected
		);
	}

	/**
	 * @testdox Pagination returned with both front and end separator
	 */
	public function testPaginationWithBothSeparators(): void {
		$pagination = $this->extension->generatePaginationData(5, 10, 7);
		$expected = array(
			'curr_page' => 5,
			'last_page' => 10,
			'num_items' => 7,
			'separator' => '...',
			'pagination' => array(1, '...', 4, 5, 6, '...', 10)
		);
		$this->assertEquals(
			$pagination,
			$expected
		);
	}

	/**
	 * @testdox Pagination returned with custom separator
	 */
	public function testPaginationWithCustomSeparator(): void {
		$pagination = $this->extension->generatePaginationData(1, 10, 11, '---');
		$expected = array(
			'curr_page' => 1,
			'last_page' => 10,
			'num_items' => 11,
			'separator' => '---',
			'pagination' => range(1, 10)
		);
		$this->assertEquals(
			$pagination,
			$expected
		);
	}
}
