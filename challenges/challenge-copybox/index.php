<?php

include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."controller/class.ChallengeValidatorController.php");

// Regex to check the solution submitted.
// The body of the email must contain an image with a GET request to delete the folder.
$urlInRegex = 'http:\/\/.+?\/challenge-copybox\/ajax\.php\?type=delete&selected=\[%22Blackmails%22\]';
$solution = new RegexSolution('<img\s(\s*\w+=".+?")*\s*src="'.$urlInRegex.'"(\s*\w+=".+?")*\/?>');
$validator = new ChallengeValidatorController($solution);
$validator->startChallenge();

?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>CopyBox</title>
	<link rel="icon" href="data/icon.png"/>
	<link href="data/style.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="data/jquery-1.11.1.min.js"></script>
	<script type="text/javascript">
		$(function() {
			// Account menu on the top right:
			$('#my-account-settings').click(function() {
				$(this).prev().toggle();
				$(this).next().toggle();
			});

			// 'Select all' button:
			$('#browser-select-all').click(function() {
				if($(this).prop('checked')) {
					$('.file-line-select').prop('checked', true);
					$('.file-line').addClass('ui-selected');
					$('#browser-action-download').removeClass('browser-action-disabled');
					$('#browser-action-others').removeClass('browser-action-disabled');
				} else {
					$('.file-line-select').prop('checked', false);
					$('.file-line').removeClass('ui-selected');
					$('#browser-action-download').addClass('browser-action-disabled');
					$('#browser-action-others').addClass('browser-action-disabled');
				}
			});

			// Select folder:
			$('.file-line').click(function() {
				select = $(this).find('.file-line-select');
				if(select.prop('checked')) {
					select.prop('checked', false);
					$(this).removeClass('ui-selected');
				} else {
					select.prop('checked', true);
					$(this).addClass('ui-selected');
				}
				checkSelectedFolders();
			});
			$('.file-line-select').click(function() {
				return false;
			});

			// Action menu for 'OTHER' button:
			$('#browser-action-others').click(function() {
				if(!$(this).hasClass('browser-action-disabled')) {
					$(this).next().toggle();
					$(this).next().next().toggle();
				}
			});

			// Highlighting when hover the folder line:
			$('.file-line').mouseenter(function() {
				$(this).addClass('file-line-hover');
			}).mouseleave(function() {
				$(this).removeClass('file-line-hover');
			});

			// Checks the number of selected folders when loading the page
			// to initialise the Action button.
			checkSelectedFolders();

			// Initialises the folder background color when loading the page:
			$('.file-line-select').each(function() {
				if($(this).prop('checked')) {
					$(this).parents('.file-line').addClass('ui-selected');
				} else {
					$(this).parents('.file-line').removeClass('ui-selected');
				}
			});
		});

		// Checks number of checked folder to update action buttons:
		function checkSelectedFolders() {
			if($('.file-line-select:checked').size() == 0) {
				$('#browser-action-download').addClass('browser-action-disabled');
				$('#browser-action-others').addClass('browser-action-disabled');
			} else {
				$('#browser-action-download').removeClass('browser-action-disabled');
				$('#browser-action-others').removeClass('browser-action-disabled');
			}
		}

		function serviceUnavailable() {
			alert('The service is unavailable at the moment. Please try again later.');
		}

		// Requests the server for any action on the folders.
		function request(type) {
			// Gets selected folders:
			selectedFolders = [];
			$('.file-line-select:checked').each(function() {
				name = $(this).parents('.file-line').find('.file-line-title').text();
				selectedFolders.push(name);
			});

			// Stringifies the array.
			selected = JSON.stringify(selectedFolders);

			// Sends the request to the server.
			$.get('ajax.php?type='+type+'&selected='+selected, function(data) {
				if(data != 'Success.') {
					alert(data);
				}
			});
		}
	</script>
</head>
<body class="fr ui-selectable">
	<form id="browser-upload-form">
		<div id="browser-header">
			<div class="browser-container" id="browser-account">
				<div class="browser-container-inner">
					<div class="Fleft browser-unselectable">
						<a href="index.php" title="CopyBox - Be safe, make a copy!" class="Fleft logo">
							<img src="data/logo.png" width="100">
						</a>
					</div>
					<div class="Fright browser-my-account browser-unselectable">
						<div class="ui-group">
							<i class="ui-arrow ui-arrow-inverse"></i>
							<a id="my-account-settings" href="#" class="my-account bold" tabindex="-1">
								John&nbsp;Smith<br>
								<span class="small white" id="browser-used-space-text">3,72 Go (18,60%)</span>
							</a>
							<ul class="ui-menu account-menu">
								<li>
									<a href="#" onclick="serviceUnavailable();" class="browser-account-menu-item browser-account-menu-target browser-account-menu-account">My account</a>
								</li>
								<li>
									<a href="#" onclick="serviceUnavailable();" class="browser-account-menu-item browser-account-menu-target browser-account-menu-backups">My backups</a>
								</li>
								<li>
									<a href="#" onclick="serviceUnavailable();" class="browser-account-menu-item browser-account-menu-language">Change language</a>
								</li>
								<li>
									<a href="#" onclick="serviceUnavailable();" class="browser-account-menu-item browser-account-menu-logoff">Log out</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="clear"></div>
			</div>
			<div class="browser-container" id="browser-breadcrumb">
				<ul class="browser-container-inner">
					<li class="top browser-unselectable ui-droppable">
						<a href="#" class="top-link">CopyBox</a>
					</li>
				</ul>
			</div>
			<div class="browser-container" id="browser-actions">
				<ul class="actions-list browser-container-inner">
					<li class="browser-action action-select-all browser-unselectable">
						<a id="browser-action-select-all" class="browser-action-link" title="" href="#">
							<input id="browser-select-all" type="checkbox">
						</a>
					</li>
					<li class="browser-action action-sort browser-unselectable"></li>
					<li class="browser-action action-upload browser-unselectable">
						<a onclick="request('add');" id="browser-action-upload" class="browser-action-link browser-webkit-hack" href="#">Add files
							<input id="browser-input-browse" class="browser-input-browse" name="file1" multiple="" type="file">
						</a>
					</li>
					<li class="browser-action action-create browser-unselectable">
						<a onclick="request('new_folder');" id="browser-action-create" class="browser-action-link" href="#">New folder</a>
					</li>
					<li class="browser-action action-download browser-unselectable">
						<a onclick="request('download');" id="browser-action-download" class="browser-action-link webkit-hack browser-action-disabled" href="#">Download</a>
					</li>
					<li class="browser-action action-others browser-unselectable">
						<a id="browser-action-others" class="browser-action-link ui-group webkit-hack browser-action-disabled" href="#">Other</a>
						<i style="display: none;" class="ui-arrow ui-arrow-inverse"></i>
						<ul style="display: none;" class="ui-menu actions-menu">
							<li>
								<a onclick="request('move');" class="browser-other-action browser-action-move">Move</a>
							</li>
							<li>
								<a onclick="request('publish');" class="browser-other-action browser-action-publish">Publish</a>
							</li>
							<li>
								<a onclick="request('delete');" class="browser-other-action browser-action-remove">Delete</a>
							</li>
						</ul>
					</li>
					<li class="browser-action browser-unselectable">
						<a id="browser-action-email" class="browser-action-link browser-webkit-hack" href="email.php">Send an email</a>
					</li>
				</ul>
			</div>
		</div>
		<div id="browser-list" class="browser-container">
			<div class="browser-container-inner" id="browser-list-container">
				<ul class="browser" id="browser-page-0">
					<li class="file-line directory folder folder-item ui-droppable ui-draggable ui-selectee">
						<div class="file-line-main">
							<div class="file-line-check Fleft">
								<input class="file-line-select" type="checkbox">
							</div>
							<div class="file-line-img Fleft"></div>
							<div class="file-line-descr-title Fleft">
								<span class="file-line-title bold">Holiday Spain</span>
								<span class="file-line-descr small"></span>
							</div>
						</div>
					</li>
					<li class="file-line directory folder folder-item ui-droppable ui-draggable ui-selectee">
						<div class="file-line-main">
							<div class="file-line-check Fleft">
								<input class="file-line-select" type="checkbox">
							</div>
							<div class="file-line-img Fleft"></div>
							<div class="file-line-descr-title Fleft">
								<span class="file-line-title bold">Holiday Greece</span>
								<span class="file-line-descr small"></span>
							</div>
						</div>
					</li>
					<li class="file-line directory folder folder-item ui-droppable ui-draggable ui-selectee">
						<div class="file-line-main">
							<div class="file-line-check Fleft">
								<input class="file-line-select" type="checkbox">
							</div>
							<div class="file-line-img Fleft"></div>
							<div class="file-line-descr-title Fleft">
								<span class="file-line-title bold">Holiday France</span>
								<span class="file-line-descr small"></span>
							</div>
						</div>
					</li>
					<li class="file-line directory folder folder-item ui-droppable ui-draggable ui-selectee">
						<div class="file-line-main">
							<div class="file-line-check Fleft">
								<input class="file-line-select" type="checkbox">
							</div>
							<div class="file-line-img Fleft"></div>
							<div class="file-line-descr-title Fleft">
								<span class="file-line-title bold">Holiday China</span>
								<span class="file-line-descr small"></span>
							</div>
						</div>
					</li>
					<li class="file-line directory folder folder-item ui-droppable ui-draggable ui-selectee">
						<div class="file-line-main">
							<div class="file-line-check Fleft">
								<input class="file-line-select" type="checkbox">
							</div>
							<div class="file-line-img Fleft"></div>
							<div class="file-line-descr-title Fleft">
								<span class="file-line-title bold">Holiday Egypt</span>
								<span class="file-line-descr small"></span>
							</div>
						</div>
					</li>
					<li class="file-line directory folder folder-item ui-droppable ui-draggable ui-selectee">
						<div class="file-line-main">
							<div class="file-line-check Fleft">
								<input class="file-line-select" type="checkbox">
							</div>
							<div class="file-line-img Fleft"></div>
							<div class="file-line-descr-title Fleft">
								<span class="file-line-title bold">Travel papers</span>
								<span class="file-line-descr small"></span>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
		<div id="browser-footer" class="browser-container">
			<div class="browser-container-inner">
				<div class="Fleft">
					<a href="#" class="browser-unselectable">CopyBox</a>
				</div>
				<div class="Fright">
					<a href="#" class="browser-unselectable">Copyright 2014</a>
					&nbsp;|&nbsp;
					<a href="#" class="browser-unselectable">Legal notice</a>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</form>
	<div id="vakata-contextmenu"></div>
</body>
</html>
