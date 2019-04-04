<?php

namespace PaginatorTwigExtension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Twig extension to help generate simple paginations.
 */
class PaginatorTwigExtension extends AbstractExtension {

        public function getFunctions(){
                return [
                        new TwigFunction('paginator', [$this, 'generatePaginationData']),
                ];
        }

        public function generatePaginationData(int $curr_page, int $last_page, int $num_items) {
                return 'Done!';
        }
}