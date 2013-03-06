<?php

class sampleEntryController extends sampleController {

	public function execute(sampleRequest $request, sampleResponse $response) {
		if ($request->getValue('user')) {
			$response->username = $request->getValue('user')->username;
		}
		$response->action = $request->getValue('action');
		switch ($request->getValue('action')) {
			case 'comment':
				//kommentar speichern
				if ($request->getValue('name') == '' || $request->getValue('comment') == '') {
					$response->error = true;
					$response->action = 'view';
				}

				$db = $this->factory->getDatabase(DSN);
				$res = $db->query('INSERT INTO blog_entry_comments (entry_id, name, email, url, comment, date) VALUES (%d, "%s", "%s", "%s", "%s", NOW())', array((int) $request->getValue('id'),
						$request->getValue('name'),
						$request->getValue('email'),
						$request->getValue('url'),
						$request->getValue('comment')
								)
				);
			case 'view':
				$db = $this->factory->getDatabase(DSN);
				$res = $db->query('select blog_entries.*, blog_users.username
														FROM blog_entries
														JOIN blog_users ON blog_entries.user_id = blog_users.id
														WHERE blog_entries.id=%d', array((int) $request->getValue('id'))
				);
				$response->entry = $res->fetch_object();

				$res = $db->query('select * FROM blog_entry_comments WHERE entry_id=%d', array((int) $request->getValue('id'))
				);
				$response->entry_comments = $res->fetch_all(MYSQLI_ASSOC);
				return new sampleStaticView(__DIR__ . '/../pages/viewEntry.xhtml');
				break;
			default:
			case 'write':
				if (!$request->getValue('user')->id) {
					header('/?page=login');
					exit;
				}
				if ($request->getValue('title') && $request->getValue('text')) {
					$db = $this->factory->getDatabase(DSN);
					$res = $db->query(
							'insert into blog_entries (user_id,title,text,`date`) values ("%s","%s","%s",NOW())', array($request->getValue('user')->id,
							$request->getValue('title'),
							$request->getValue('text'))
					);
					header('location: /blog/entry?action=view&id=' . $res->insertId());
					exit;
				}
				return new sampleStaticView(__DIR__ . '/../pages/newEntry.xhtml');
				break;
		}
	}

}