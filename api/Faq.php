<?php
class Faq extends api {
	
	protected function reserve()
	{
		$categories = Core::get_db()->Query('select * from main.faq_categories');

		return
		[
			'design' => 'main/pages/faq/index',
			'data' => 
			[
				'categories' => $categories,
			]
		];
	}

	protected function info($id)
	{
		return
		[
			'data' => Core::get_db()->Query('select * from main.faq_pages where id = $1', [$id], true),
		];
	}

	protected function category_pages($id)
	{
		$pages = Core::get_db()->Query('select * from main.faq_pages where category = $1', [$id]);
		return
		[
			'design' => 'main/pages/faq/category_pages',
			'data' => [
				'pages' => $pages,
			],
		];		
	}

	protected function page($id)
	{
		$page = Core::get_db()->Query('select * from main.faq_pages where id = $1', [$id], true);
		$category = Core::get_db()->Query('select * from main.faq_categories where id = $1', [$id], true);
		return
		[
			'design' => 'main/pages/faq/page',
			'data' => 
			[
				'page' => $page,
				'category_info' => $category
			],
		];
	}

}