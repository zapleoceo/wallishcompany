<?php
// *	@copyright	OPENCART.PRO 2011 - 2015.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class Pagination {
	public $total = 0;
	public $page = 1;
	public $limit = 20;
	public $num_links = 8;
	public $url = '';
	public $text_first = '|&lt;';
	public $text_last = '&gt;|';
	public $text_next = '&gt;';
	public $text_prev = '&lt;';

	private function viewPage($page) {
	    $pageint = (int)$page;

	    if (empty($pageint))
	        return $page;

	    if ($pageint > 9)
	        return $page;

        return '0' . $pageint;
	}

	public function render() {
		$total = $this->total;

		if ($this->page < 1) {
			$page = 1;
		} else {
			$page = $this->page;
		}
		$page = (int) $page;

		if (!(int)$this->limit) {
			$limit = 10;
		} else {
			$limit = $this->limit;
		}

		$num_links = $this->num_links;
		$num_pages = ceil($total / $limit);

		$this->url = str_replace('%7Bpage%7D', '{page}', $this->url);

		$output = '<ul class="pagination">';

		if ($page > 1) {
			$url = $this->url;
			if ($page == 2){
				$url = preg_replace('#[\?\&]page=\{page\}#', '', $url);
			}

			$output .= '<li class="pagination__item" ><a class="pagination__link" href="' . str_replace('{page}', $page - 1, $url) . '"></a></li>';
			//$output .= '<li class="pagination__item" ><a href="' . str_replace('{page}', 1, $this->url) . '"></a></li>';
		} else {
			$output .= '<li style="display: none;" class="pagination__item disabled" ><a href="#"></a></li>';
		}

		if ($num_pages > 1) {
			if ($num_pages <= $num_links) {
				$start = 1;
				$end = $num_pages;
			} else {
				$start = $page - floor($num_links / 2);
				$end = $page + floor($num_links / 2);

				if ($start < 1) {
					$end += abs($start) + 1;
					$start = 1;
				}

				if ($end > $num_pages) {
					$start -= ($end - $num_pages);
					$end = $num_pages;
				}
			}

			for ($i = $start; $i <= $end; $i++) {
				$url = $this->url;
				if ($i == 0 || $i == 1){
					$url = preg_replace('#[\?\&]page=\{page\}#', '', $url);
				}
				if ($page == $i) {
					$output .= '<li class="pagination__item"><a class="pagination__link active" href="' . str_replace('{page}', $i, $url) . '">' . $this->viewPage($i) . '</a></li>';
				} else {
					$output .= '<li class="pagination__item"><a class="pagination__link" href="' . str_replace('{page}', $i, $url) . '">' . $this->viewPage($i) . '</a></li>';
				}
			}
		}

		if ($page < $num_pages) {
			//$output .= '<li class="pagination__item"><a class="pagination__link" href="' . str_replace('{page}', $num_pages, $this->url) . '"></a></li>';
			$output .= '<li class="pagination__item"><a class="pagination__link" href="' . str_replace('{page}', $page + 1, $this->url) . '"></a></li>';
		} else {
			$output .= '<li style="display: none;" class="pagination__item disable"><a class="pagination__link" href="#"></a></li>';
		}

		$output .= '</ul>';

		if ($num_pages > 1) {
			return $output;
		} else {
			return '';
		}
	}
}