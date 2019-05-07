<?php

namespace Morozgrafix\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Twig extension to help generate simple paginations.
 */
class PaginatorTwigExtension extends AbstractExtension {

	public function getName() {
			return 'paginator';
	}

	public function getFunctions() {
			return [
					new TwigFunction('paginator', [$this, 'generatePaginationData']),
			];
	}

	public function generatePaginationData(int $curr_page, int $last_page, int $num_items = 7, string $separator = '...') {
		// number of items needs to be an even number for better layout
		// rounding to nearest even number
		if ($num_items % 2 == 0) {
			$num_items++;
		}

		$pagination = [];
		// if total number of pages less or equal to number of items
		if ($last_page <= $num_items) {
			$pagination = range(1, $last_page);
		// otherwise calculate pagination array
		} else {
			// minimum number of items is 7
			if ($num_items < 7) {
				$num_items = 7;
			}
			// if current page is in the beginning return pagination with added end separator and last page
			if ($curr_page < ($num_items - 2)) {
				$pagination = array_merge($pagination, range(1, $num_items - 2));
				$pagination[] = $separator;
				$pagination[] = $last_page;
			// if current page in the middle return first page, front separator, pagination, end separator, last page
			} elseif(($curr_page > ($num_items - 3)) && ($curr_page < ($last_page - 3))) {
				$pagination[] = 1;
				$pagination[] = $separator;
				$pagination = array_merge($pagination, range($curr_page - ($num_items - 5) / 2, $curr_page + ($num_items - 5) / 2));
				$pagination[] = $separator;
				$pagination[] = $last_page;
			// if current page at the end return first page, front separator and rest of pagination
			} else {
				$pagination[] = 1;
				$pagination[] = $separator;
				$pagination = array_merge($pagination, range($last_page - $num_items + 3, $last_page));
			}
		}
		return array('curr_page' => $curr_page, 'last_page' => $last_page, 'num_items' => $num_items, 'separator' => $separator, 'pagination' => $pagination);
	}
}
