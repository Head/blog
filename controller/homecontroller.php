<?php

class sampleHomeController extends sampleController {

	public function execute(sampleRequest $request, sampleResponse $response) {
		if ($request->getValue('user')) { //assign logged in user
			$response->username = $request->getValue('user')->username;
		}

		$startId = $request->getValue('start') ? $request->getValue('start') : 4294967295; //pagination
		$perPage = 4; //+1 to show "next Page"-Link

		$addQueryWhere = '';
		$queryParams = array();
		$queryParams[] = $startId;


		//add filter by clicked author
		if ($request->getValue('filterAuthor')) {
			$addQueryWhere = ' AND username = "%s"';
			$queryParams[] = $request->getValue('filterAuthor');
		}

		//add filter by search param
		if ($request->getValue('search')) {
			$addQueryWhere = ' AND (text LIKE "%%%s%%" OR title LIKE "%%%s%%") ';
			$queryParams[] = $request->getValue('search');
			$queryParams[] = $request->getValue('search');
		}

		$queryParams[] = $perPage;

		$db = $this->factory->getDatabase(DSN);
		$res = $db->query('select blog_entries.*, blog_users.username, count(blog_entry_comments.id) as commentCount 
                    FROM blog_entries 
                    JOIN blog_users ON blog_entries.user_id = blog_users.id 
                    LEFT OUTER JOIN blog_entry_comments ON blog_entries.id = blog_entry_comments.entry_id
                    WHERE blog_entries.id<=%d
                    ' . $addQueryWhere . '
                    GROUP BY blog_entries.id
                    ORDER BY date 
                    DESC LIMIT %d', $queryParams
		);

		$entries = array();
		while ($entry = $res->fetch_object()) {
			$entries[] = $entry;
		}
		if ($request->getValue('search') && count($entries) == 0) {
			header('location: /blog/search?notfound=true&search=' . urlencode($request->getValue('search')));
		}
		$response->entries = $entries;

		return new sampleStaticView(__DIR__ . '/../pages/homepage.xhtml');
	}

}