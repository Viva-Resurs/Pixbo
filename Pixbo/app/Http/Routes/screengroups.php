<?php

Route::get('admin/screengroups/{screengroup}/screens',
	'Admin\ScreenGroupsController@screens');
Route::get('admin/screengroups/{screengroup}/screens/{screens}/remove_screens_association',
	'Admin\ScreenGroupsController@remove_screen_association');
Route::get('admin/screengroups/{screengroup}/tickers/{tickers}/remove_tickers_association',
	'Admin\ScreenGroupsController@remove_ticker_association');

Route::post('admin/screengroups/{screengroups}/addphoto', 'Admin\ScreenGroupsController@addScreenFromPhoto');